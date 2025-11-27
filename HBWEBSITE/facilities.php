<?php
$pageTitle = 'Facilities';
require_once 'inc/header.php';

// Get all facilities
$facilities = select("SELECT * FROM facilities");
$features = select("SELECT * FROM features");
?>

<div class="container py-5">
  <h1 class="section-title text-center">Hotel Facilities</h1>
  <p class="text-center text-muted mb-5">Discover our world-class amenities designed for your comfort</p>

  <!-- Facilities Section -->
  <div class="row g-4 mb-5">
    <?php while ($facility = mysqli_fetch_assoc($facilities)): ?>
      <div class="col-md-4 col-lg-3">
        <div class="facility-card h-100">
          <i class="bi <?php echo $facility['icon']; ?>"></i>
          <h5><?php echo htmlspecialchars($facility['name']); ?></h5>
          <p class="text-muted small mb-0"><?php echo htmlspecialchars($facility['description']); ?></p>
        </div>
      </div>
    <?php endwhile; ?>
  </div>

  <!-- Features Section -->
  <h2 class="section-title text-center">Room Features</h2>
  <p class="text-center text-muted mb-5">All our rooms come equipped with modern amenities</p>

  <div class="row g-4">
    <?php while ($feature = mysqli_fetch_assoc($features)): ?>
      <div class="col-md-4 col-lg-3">
        <div class="card h-100 text-center p-3">
          <div class="card-body">
            <i class="bi bi-check-circle-fill text-success fs-2 mb-2"></i>
            <h6><?php echo htmlspecialchars($feature['name']); ?></h6>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<!-- CTA Section -->
<section class="py-5 bg-primary text-white text-center">
  <div class="container">
    <h3 class="mb-3">Ready to Experience Our Facilities?</h3>
    <p class="mb-4">Book your stay now and enjoy our premium amenities</p>
    <a href="rooms.php" class="btn btn-light btn-lg">View Rooms</a>
  </div>
</section>

<?php require_once 'inc/footer.php'; ?>