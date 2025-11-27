<?php
$pageTitle = 'Rooms';
require_once 'inc/header.php';

// Get filter parameters
$checkIn = isset($_GET['check_in']) ? sanitize($_GET['check_in']) : '';
$checkOut = isset($_GET['check_out']) ? sanitize($_GET['check_out']) : '';
$adults = isset($_GET['adults']) ? (int)$_GET['adults'] : 0;
$children = isset($_GET['children']) ? (int)$_GET['children'] : 0;

// Build query based on filters
$query = "SELECT * FROM rooms WHERE status = 1";
$params = [];

if ($adults > 0) {
  $query .= " AND adults >= $adults";
}
if ($children > 0) {
  $query .= " AND children >= $children";
}

$rooms = select($query);
?>

<div class="container py-5">
  <h1 class="section-title text-center">Our Rooms</h1>

  <!-- Filter Box -->
  <div class="card mb-4">
    <div class="card-body">
      <form method="GET" class="row g-3 align-items-end">
        <div class="col-md-3">
          <label class="form-label">Check-in Date</label>
          <input type="date" name="check_in" class="form-control"
            value="<?php echo $checkIn; ?>" min="<?php echo date('Y-m-d'); ?>">
        </div>
        <div class="col-md-3">
          <label class="form-label">Check-out Date</label>
          <input type="date" name="check_out" class="form-control"
            value="<?php echo $checkOut; ?>" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
        </div>
        <div class="col-md-2">
          <label class="form-label">Adults</label>
          <select name="adults" class="form-select">
            <option value="0">Any</option>
            <?php for ($i = 1; $i <= 6; $i++): ?>
              <option value="<?php echo $i; ?>" <?php echo $adults == $i ? 'selected' : ''; ?>><?php echo $i; ?></option>
            <?php endfor; ?>
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label">Children</label>
          <select name="children" class="form-select">
            <option value="0">Any</option>
            <?php for ($i = 0; $i <= 4; $i++): ?>
              <option value="<?php echo $i; ?>" <?php echo $children == $i && $children > 0 ? 'selected' : ''; ?>><?php echo $i; ?></option>
            <?php endfor; ?>
          </select>
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn btn-primary w-100">
            <i class="bi bi-filter"></i> Filter
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Rooms Grid -->
  <div class="row g-4">
    <?php if (mysqli_num_rows($rooms) > 0): ?>
      <?php while ($room = mysqli_fetch_assoc($rooms)): ?>
        <?php
        $imgSrc = 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=400';
        if (!empty($room['image'])) {
          if (strpos($room['image'], 'http') === 0) {
            $imgSrc = $room['image'];
          } else {
            $imgSrc = 'uploads/rooms/' . $room['image'];
          }
        }
        ?>
        <div class="col-md-6 col-lg-4">
          <div class="card room-card h-100">
            <img src="<?php echo $imgSrc; ?>"
              class="card-img-top" alt="<?php echo htmlspecialchars($room['name']); ?>"
              style="height: 220px; object-fit: cover;">
            <div class="card-body">
              <h5 class="card-title"><?php echo htmlspecialchars($room['name']); ?></h5>
              <p class="room-price">€<?php echo number_format($room['price'], 2); ?> <small class="text-muted">/night</small></p>
              <p class="card-text text-muted small mb-3">
                <?php echo substr(htmlspecialchars($room['description']), 0, 100); ?>...
              </p>
              <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="badge bg-secondary"><i class="bi bi-people"></i> <?php echo $room['adults']; ?> Adults</span>
                <span class="badge bg-secondary"><i class="bi bi-person"></i> <?php echo $room['children']; ?> Children</span>
                <span class="badge bg-secondary"><i class="bi bi-arrows-fullscreen"></i> <?php echo $room['area']; ?> m²</span>
              </div>
              <a href="room_details.php?id=<?php echo $room['id']; ?><?php echo $checkIn ? '&check_in=' . $checkIn : ''; ?><?php echo $checkOut ? '&check_out=' . $checkOut : ''; ?>"
                class="btn btn-outline-primary w-100">View Details</a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="col-12">
        <div class="alert alert-info text-center">
          <i class="bi bi-info-circle"></i> No rooms found matching your criteria.
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php require_once 'inc/footer.php'; ?>