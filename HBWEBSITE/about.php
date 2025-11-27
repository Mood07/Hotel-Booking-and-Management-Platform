<?php
$pageTitle = 'About Us';
require_once 'inc/header.php';
?>

<!-- Hero Section -->
<section class="py-5 text-white text-center" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);">
  <div class="container">
    <h1 class="display-5 fw-bold" style="font-family: 'Playfair Display', serif;">About <?php echo $settings['site_title']; ?></h1>
    <p class="lead">Discover our story and commitment to excellence</p>
  </div>
</section>

<div class="container py-5">
  <!-- About Content -->
  <div class="row align-items-center mb-5">
    <div class="col-lg-6 mb-4 mb-lg-0">
      <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600"
        class="img-fluid rounded shadow" alt="Hotel">
    </div>
    <div class="col-lg-6">
      <h2 class="section-title">Our Story</h2>
      <p class="lead"><?php echo $settings['site_about']; ?></p>
      <p>Founded with a passion for hospitality, our hotel has been providing exceptional experiences to guests from around the world. We believe in creating memorable moments through outstanding service, luxurious accommodations, and attention to every detail.</p>
      <p>Our dedicated team works tirelessly to ensure that every guest feels welcome and comfortable during their stay with us.</p>
    </div>
  </div>

  <!-- Stats Section -->
  <div class="row g-4 mb-5 text-center">
    <div class="col-md-3">
      <div class="card h-100" style="background: linear-gradient(135deg, #1a1a2e, #16213e);">
        <div class="card-body py-4 text-white">
          <i class="bi bi-door-open fs-1 mb-2" style="color: #c9a227;"></i>
          <h2 class="mb-0">50+</h2>
          <p class="mb-0">Luxury Rooms</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card h-100" style="background: linear-gradient(135deg, #1a1a2e, #16213e);">
        <div class="card-body py-4 text-white">
          <i class="bi bi-people fs-1 mb-2" style="color: #c9a227;"></i>
          <h2 class="mb-0">10K+</h2>
          <p class="mb-0">Happy Guests</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card h-100" style="background: linear-gradient(135deg, #1a1a2e, #16213e);">
        <div class="card-body py-4 text-white">
          <i class="bi bi-star fs-1 mb-2" style="color: #c9a227;"></i>
          <h2 class="mb-0">15+</h2>
          <p class="mb-0">Years Experience</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card h-100" style="background: linear-gradient(135deg, #1a1a2e, #16213e);">
        <div class="card-body py-4 text-white">
          <i class="bi bi-award fs-1 mb-2" style="color: #c9a227;"></i>
          <h2 class="mb-0">25+</h2>
          <p class="mb-0">Awards Won</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Why Choose Us -->
  <h2 class="section-title text-center">Why Choose Us?</h2>
  <div class="row g-4 mb-5">
    <div class="col-md-4">
      <div class="card h-100 text-center p-4">
        <div class="card-body">
          <i class="bi bi-geo-alt fs-1 text-primary mb-3"></i>
          <h5>Prime Location</h5>
          <p class="text-muted">Located in the heart of the city, close to major attractions, shopping centers, and business districts.</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card h-100 text-center p-4">
        <div class="card-body">
          <i class="bi bi-shield-check fs-1 text-primary mb-3"></i>
          <h5>Safety First</h5>
          <p class="text-muted">Your safety is our priority with 24/7 security, CCTV surveillance, and trained staff.</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card h-100 text-center p-4">
        <div class="card-body">
          <i class="bi bi-heart fs-1 text-primary mb-3"></i>
          <h5>Exceptional Service</h5>
          <p class="text-muted">Our dedicated team ensures personalized attention to make your stay memorable.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Team Section -->
  <h2 class="section-title text-center">Our Team</h2>
  <p class="text-center text-muted mb-4">Meet the legends behind our exceptional service</p>
  <div class="row g-4 justify-content-center">
    <div class="col-md-4 col-lg-3">
      <div class="card text-center h-100">
        <img src="https://tr.web.img2.acsta.net/c_310_420/pictures/20/12/28/09/07/1817655.jpg"
          class="card-img-top" alt="Aleyna Tilki" style="height: 250px; object-fit: cover;">
        <div class="card-body">
          <h5 class="card-title mb-1">Aleyna Tilki</h5>
          <p class="text-primary mb-2">Chief Vibes Officer</p>
          <p class="small text-muted mb-2">"Cevapsız Çınlama? No, we always answer at Grand Hotel!" 🎤</p>
          <div class="d-flex justify-content-center gap-2">
            <a href="#" class="text-muted"><i class="bi bi-instagram"></i></a>
            <a href="#" class="text-muted"><i class="bi bi-spotify"></i></a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-lg-3">
      <div class="card text-center h-100 border-primary">
        <img src="https://media.licdn.com/dms/image/v2/D4D03AQGal88Li0YluA/profile-displayphoto-shrink_200_200/B4DZoDZJuVGsAY-/0/1760993519905?e=1766016000&v=beta&t=g5zLPbTZ5Y0hTzETjrtUyiLFMC2voyEqA8gIpWh7SQM"
          class="card-img-top" alt="Berke Arda Türk" style="height: 250px; object-fit: cover;">
        <div class="card-body">
          <h5 class="card-title mb-1">Berke Arda Türk</h5>
          <p class="text-primary mb-2">CEO & Founder</p>
          <p class="small text-muted mb-2">"I don't always test my code, but when I do, I do it in production." 🚀</p>
          <div class="d-flex justify-content-center gap-2">
            <a href="https://www.linkedin.com/in/berke-arda-turk/" target="_blank" class="text-muted"><i class="bi bi-linkedin"></i></a>
            <a href="https://github.com/Mood07" target="_blank" class="text-muted"><i class="bi bi-github"></i></a>
            <a href="https://berke-turk.web.app/" target="_blank" class="text-muted"><i class="bi bi-globe"></i></a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-lg-3">
      <div class="card text-center h-100">
        <img src="https://avatars.githubusercontent.com/u/205462525?v=4"
          class="card-img-top" alt="Mood Star" style="height: 250px; object-fit: cover;">
        <div class="card-body">
          <h5 class="card-title mb-1">Mood Star ⭐</h5>
          <p class="text-primary mb-2">Chief Happiness Officer</p>
          <p class="small text-muted mb-2">"404 Bad Mood Not Found - we only serve good vibes here!" 😺</p>
          <div class="d-flex justify-content-center gap-2">
            <a href="https://github.com/Mood07" target="_blank" class="text-muted"><i class="bi bi-github"></i></a>
            <a href="#" class="text-muted"><i class="bi bi-heart-fill"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- CTA Section -->
<section class="py-5 bg-light text-center">
  <div class="container">
    <h3 class="mb-3">Ready to Experience Our Hospitality?</h3>
    <p class="mb-4">Book your stay now and create unforgettable memories</p>
    <a href="rooms.php" class="btn btn-primary btn-lg me-2">View Rooms</a>
    <a href="contact.php" class="btn btn-outline-primary btn-lg">Contact Us</a>
  </div>
</section>

<?php require_once 'inc/footer.php'; ?>