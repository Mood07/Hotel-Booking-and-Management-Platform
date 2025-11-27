<?php
$pageTitle = 'Room Details';
require_once 'inc/header.php';

// Get room ID
$roomId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($roomId == 0) {
  redirect('rooms.php');
}

// Get room details
$roomResult = select("SELECT * FROM rooms WHERE id = $roomId AND status = 1");

if (mysqli_num_rows($roomResult) == 0) {
  redirect('rooms.php');
}

$room = mysqli_fetch_assoc($roomResult);

// Get room features
$features = select("SELECT f.* FROM features f 
                    INNER JOIN room_features rf ON f.id = rf.feature_id 
                    WHERE rf.room_id = $roomId");

// Get room facilities
$facilities = select("SELECT fa.* FROM facilities fa 
                      INNER JOIN room_facilities rfa ON fa.id = rfa.facility_id 
                      WHERE rfa.room_id = $roomId");

// Get dates from URL
$checkIn = isset($_GET['check_in']) ? sanitize($_GET['check_in']) : '';
$checkOut = isset($_GET['check_out']) ? sanitize($_GET['check_out']) : '';

// Handle booking form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $userName = sanitize($_POST['user_name']);
  $userEmail = sanitize($_POST['user_email']);
  $userPhone = sanitize($_POST['user_phone']);
  $checkInDate = sanitize($_POST['check_in']);
  $checkOutDate = sanitize($_POST['check_out']);

  // Calculate total days and amount
  $date1 = new DateTime($checkInDate);
  $date2 = new DateTime($checkOutDate);
  $diff = $date1->diff($date2);
  $totalDays = $diff->days;
  $totalAmount = $totalDays * $room['price'];

  // Check availability
  $availCheck = select("SELECT id FROM reservations 
                          WHERE room_id = $roomId 
                          AND status != 'cancelled'
                          AND ((check_in <= '$checkInDate' AND check_out > '$checkInDate')
                          OR (check_in < '$checkOutDate' AND check_out >= '$checkOutDate')
                          OR (check_in >= '$checkInDate' AND check_out <= '$checkOutDate'))");

  if (mysqli_num_rows($availCheck) > 0) {
    alert('error', 'Sorry, this room is not available for the selected dates.');
  } else {
    // Insert reservation
    $query = "INSERT INTO reservations (room_id, user_name, user_email, user_phone, check_in, check_out, total_amount) 
                  VALUES ($roomId, '$userName', '$userEmail', '$userPhone', '$checkInDate', '$checkOutDate', $totalAmount)";

    if (execute($query)) {
      alert('success', 'Reservation successful! We will contact you shortly.');
      header("Location: rooms.php");
      exit;
    } else {
      alert('error', 'Failed to make reservation. Please try again.');
    }
  }
}
?>

<div class="container py-5">
  <?php showAlert(); ?>

  <div class="row">
    <!-- Room Images and Details -->
    <div class="col-lg-8 mb-4">
      <?php
      $imgSrc = 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800';
      if (!empty($room['image'])) {
        if (strpos($room['image'], 'http') === 0) {
          $imgSrc = $room['image'];
        } else {
          $imgSrc = 'uploads/rooms/' . $room['image'];
        }
      }
      ?>
      <div class="card">
        <img src="<?php echo $imgSrc; ?>"
          class="card-img-top" alt="<?php echo htmlspecialchars($room['name']); ?>"
          style="height: 400px; object-fit: cover;">
        <div class="card-body">
          <h2><?php echo htmlspecialchars($room['name']); ?></h2>
          <h4 class="text-primary">€<?php echo number_format($room['price'], 2); ?> <small class="text-muted">/night</small></h4>

          <hr>

          <div class="row mb-4">
            <div class="col-md-4 text-center">
              <i class="bi bi-people fs-3 text-primary"></i>
              <p class="mb-0"><?php echo $room['adults']; ?> Adults</p>
            </div>
            <div class="col-md-4 text-center">
              <i class="bi bi-person fs-3 text-primary"></i>
              <p class="mb-0"><?php echo $room['children']; ?> Children</p>
            </div>
            <div class="col-md-4 text-center">
              <i class="bi bi-arrows-fullscreen fs-3 text-primary"></i>
              <p class="mb-0"><?php echo $room['area']; ?> m²</p>
            </div>
          </div>

          <h5>Description</h5>
          <p><?php echo nl2br(htmlspecialchars($room['description'])); ?></p>

          <?php if (mysqli_num_rows($features) > 0): ?>
            <h5>Features</h5>
            <div class="row mb-3">
              <?php while ($feature = mysqli_fetch_assoc($features)): ?>
                <div class="col-md-6 col-lg-4 mb-2">
                  <i class="bi bi-check-circle text-success me-2"></i>
                  <?php echo htmlspecialchars($feature['name']); ?>
                </div>
              <?php endwhile; ?>
            </div>
          <?php endif; ?>

          <?php if (mysqli_num_rows($facilities) > 0): ?>
            <h5>Facilities</h5>
            <div class="row">
              <?php while ($facility = mysqli_fetch_assoc($facilities)): ?>
                <div class="col-md-6 col-lg-4 mb-2">
                  <i class="bi <?php echo $facility['icon']; ?> text-primary me-2"></i>
                  <?php echo htmlspecialchars($facility['name']); ?>
                </div>
              <?php endwhile; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Booking Form -->
    <div class="col-lg-4">
      <div class="card sticky-top" style="top: 20px;">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0"><i class="bi bi-calendar-check"></i> Book This Room</h5>
        </div>
        <div class="card-body">
          <form method="POST" id="bookingForm">
            <div class="mb-3">
              <label class="form-label">Your Name *</label>
              <input type="text" name="user_name" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Email Address *</label>
              <input type="email" name="user_email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Phone Number *</label>
              <input type="tel" name="user_phone" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Check-in Date *</label>
              <input type="date" name="check_in" id="checkIn" class="form-control" required
                value="<?php echo $checkIn; ?>" min="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Check-out Date *</label>
              <input type="date" name="check_out" id="checkOut" class="form-control" required
                value="<?php echo $checkOut; ?>" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
            </div>

            <div class="alert alert-info mb-3" id="priceCalculation" style="display: none;">
              <strong>Total:</strong> <span id="totalPrice">$0.00</span>
              <br><small><span id="totalNights">0</span> nights × $<?php echo number_format($room['price'], 2); ?></small>
            </div>

            <button type="submit" class="btn btn-primary w-100">
              <i class="bi bi-check-circle"></i> Book Now
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  const pricePerNight = <?php echo $room['price']; ?>;
  const checkInInput = document.getElementById('checkIn');
  const checkOutInput = document.getElementById('checkOut');
  const priceCalc = document.getElementById('priceCalculation');
  const totalPriceSpan = document.getElementById('totalPrice');
  const totalNightsSpan = document.getElementById('totalNights');

  function calculatePrice() {
    const checkIn = new Date(checkInInput.value);
    const checkOut = new Date(checkOutInput.value);

    if (checkInInput.value && checkOutInput.value && checkOut > checkIn) {
      const diffTime = Math.abs(checkOut - checkIn);
      const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
      const total = diffDays * pricePerNight;

      totalNightsSpan.textContent = diffDays;
      totalPriceSpan.textContent = '$' + total.toFixed(2);
      priceCalc.style.display = 'block';
    } else {
      priceCalc.style.display = 'none';
    }
  }

  checkInInput.addEventListener('change', function() {
    const checkInDate = new Date(this.value);
    checkInDate.setDate(checkInDate.getDate() + 1);
    checkOutInput.min = checkInDate.toISOString().split('T')[0];
    calculatePrice();
  });

  checkOutInput.addEventListener('change', calculatePrice);

  // Initial calculation if dates are preset
  calculatePrice();
</script>

<?php require_once 'inc/footer.php'; ?>