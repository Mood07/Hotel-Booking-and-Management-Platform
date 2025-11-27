<?php
$pageTitle = 'Home';
require_once 'inc/header.php';

// Get rooms for display
$rooms = select("SELECT * FROM rooms WHERE status = 1 LIMIT 4");
$facilities = select("SELECT * FROM facilities LIMIT 6");
?>

<!-- Hero Section -->
<section class="hero-section text-center">
  <div class="container">
    <h1 class="display-4 fw-bold mb-4">Welcome to <?php echo $settings['site_title']; ?></h1>
    <p class="lead mb-4">Experience luxury and comfort at its finest</p>
    <a href="rooms.php" class="btn btn-light btn-lg px-5">View Rooms</a>
  </div>
</section>

<!-- Search Box -->
<div class="container">
  <div class="search-box">
    <form action="rooms.php" method="GET">
      <div class="row g-3 align-items-end">
        <div class="col-md-3">
          <label class="form-label">Check-in Date</label>
          <input type="date" name="check_in" class="form-control" required
            min="<?php echo date('Y-m-d'); ?>">
        </div>
        <div class="col-md-3">
          <label class="form-label">Check-out Date</label>
          <input type="date" name="check_out" class="form-control" required
            min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
        </div>
        <div class="col-md-2">
          <label class="form-label">Adults</label>
          <select name="adults" class="form-select">
            <?php for ($i = 1; $i <= 6; $i++): ?>
              <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php endfor; ?>
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label">Children</label>
          <select name="children" class="form-select">
            <?php for ($i = 0; $i <= 4; $i++): ?>
              <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php endfor; ?>
          </select>
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn btn-primary w-100">
            <i class="bi bi-search"></i> Search
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Rooms Section -->
<section class="py-5">
  <div class="container">
    <h2 class="section-title text-center">Our Rooms</h2>
    <div class="row g-4">
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
        <div class="col-md-6 col-lg-3">
          <div class="card room-card h-100">
            <img src="<?php echo $imgSrc; ?>"
              class="card-img-top" alt="<?php echo htmlspecialchars($room['name']); ?>"
              style="height: 200px; object-fit: cover;">
            <div class="card-body">
              <h5 class="card-title"><?php echo htmlspecialchars($room['name']); ?></h5>
              <p class="room-price">€<?php echo number_format($room['price'], 2); ?> <small class="text-muted">/night</small></p>
              <p class="card-text text-muted small">
                <i class="bi bi-people"></i> <?php echo $room['adults']; ?> Adults, <?php echo $room['children']; ?> Children
                <br>
                <i class="bi bi-arrows-fullscreen"></i> <?php echo $room['area']; ?> m²
              </p>
              <a href="room_details.php?id=<?php echo $room['id']; ?>" class="btn btn-outline-primary w-100">View Details</a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
    <div class="text-center mt-4">
      <a href="rooms.php" class="btn btn-primary btn-lg">View All Rooms</a>
    </div>
  </div>
</section>

<!-- Facilities Section -->
<section class="py-5 bg-light">
  <div class="container">
    <h2 class="section-title text-center">Our Facilities</h2>
    <div class="row g-4">
      <?php while ($facility = mysqli_fetch_assoc($facilities)): ?>
        <div class="col-md-4 col-lg-2">
          <div class="facility-card">
            <i class="bi <?php echo $facility['icon']; ?>"></i>
            <h6><?php echo htmlspecialchars($facility['name']); ?></h6>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>

<!-- About Section -->
<section class="py-5">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 mb-4 mb-lg-0">
        <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600"
          class="img-fluid rounded shadow" alt="Hotel">
      </div>
      <div class="col-lg-6">
        <h2 class="section-title">About Our Hotel</h2>
        <p class="lead"><?php echo $settings['site_about']; ?></p>
        <ul class="list-unstyled">
          <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Luxury Rooms</li>
          <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> 24/7 Room Service</li>
          <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Free WiFi</li>
          <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Swimming Pool & Spa</li>
        </ul>
        <a href="about.php" class="btn btn-primary">Learn More</a>
      </div>
    </div>
  </div>
</section>

<?php require_once 'inc/footer.php'; ?>