<?php
session_start();
require_once __DIR__ . '/config.php';
$settings = getSettings();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $settings['site_title'] ?? 'Grand Hotel'; ?> - <?php echo $pageTitle ?? 'Home'; ?></title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?php echo SITE_URL; ?>css/style.css">
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
    <div class="container">
      <a class="navbar-brand fw-bold" href="<?php echo SITE_URL; ?>">
        <i class="bi bi-building"></i> <?php echo $settings['site_title'] ?? 'Grand Hotel'; ?>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto align-items-center">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo SITE_URL; ?>">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo SITE_URL; ?>rooms.php">Rooms</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo SITE_URL; ?>facilities.php">Facilities</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo SITE_URL; ?>contact.php">Contact</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo SITE_URL; ?>about.php">About</a>
          </li>
          <li class="nav-item ms-2">
            <a class="btn btn-outline-primary btn-sm" href="<?php echo SITE_URL; ?>admin/">
              <i class="bi bi-person-lock"></i> Admin
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main>