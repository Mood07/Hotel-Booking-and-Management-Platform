<?php
session_start();
require_once '../inc/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged'])) {
  header("Location: index.php");
  exit;
}

// Get stats
$totalRooms = mysqli_fetch_assoc(select("SELECT COUNT(*) as count FROM rooms"))['count'];
$activeRooms = mysqli_fetch_assoc(select("SELECT COUNT(*) as count FROM rooms WHERE status = 1"))['count'];
$totalReservations = mysqli_fetch_assoc(select("SELECT COUNT(*) as count FROM reservations"))['count'];
$pendingReservations = mysqli_fetch_assoc(select("SELECT COUNT(*) as count FROM reservations WHERE status = 'pending'"))['count'];
$totalMessages = mysqli_fetch_assoc(select("SELECT COUNT(*) as count FROM contact_messages"))['count'];
$unreadMessages = mysqli_fetch_assoc(select("SELECT COUNT(*) as count FROM contact_messages WHERE is_read = 0"))['count'];

// Get recent reservations
$recentReservations = select("SELECT r.*, rm.name as room_name 
                              FROM reservations r 
                              LEFT JOIN rooms rm ON r.room_id = rm.id 
                              ORDER BY r.created_at DESC LIMIT 5");

// Get recent messages
$recentMessages = select("SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <style>
    :root {
      --sidebar-width: 250px;
    }

    body {
      background: #f4f6f9;
    }

    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: var(--sidebar-width);
      height: 100vh;
      background: #212529;
      padding-top: 20px;
      z-index: 1000;
    }

    .sidebar .nav-link {
      color: #adb5bd;
      padding: 12px 20px;
      border-left: 3px solid transparent;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      color: #fff;
      background: rgba(255, 255, 255, 0.1);
      border-left-color: #0d6efd;
    }

    .sidebar .nav-link i {
      margin-right: 10px;
      width: 20px;
    }

    .main-content {
      margin-left: var(--sidebar-width);
      padding: 20px;
    }

    .stat-card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .stat-card .icon {
      width: 60px;
      height: 60px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
    }

    .brand-logo {
      color: #fff;
      font-size: 1.3rem;
      font-weight: bold;
      padding: 0 20px 20px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      margin-bottom: 20px;
    }

    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
      }

      .main-content {
        margin-left: 0;
      }
    }
  </style>
</head>

<body>
  <!-- Sidebar -->
  <nav class="sidebar">
    <div class="brand-logo">
      <i class="bi bi-building"></i> Hotel Admin
    </div>
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link active" href="dashboard.php">
          <i class="bi bi-speedometer2"></i> Dashboard
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="rooms.php">
          <i class="bi bi-door-open"></i> Rooms
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="reservations.php">
          <i class="bi bi-calendar-check"></i> Reservations
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="messages.php">
          <i class="bi bi-envelope"></i> Messages
          <?php if ($unreadMessages > 0): ?>
            <span class="badge bg-danger"><?php echo $unreadMessages; ?></span>
          <?php endif; ?>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="settings.php">
          <i class="bi bi-gear"></i> Settings
        </a>
      </li>
      <li class="nav-item mt-4">
        <a class="nav-link" href="../index.php" target="_blank">
          <i class="bi bi-globe"></i> View Website
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-danger" href="logout.php">
          <i class="bi bi-box-arrow-left"></i> Logout
        </a>
      </li>
    </ul>
  </nav>

  <!-- Main Content -->
  <div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="mb-0">Dashboard</h4>
      <span class="text-muted">Welcome, <?php echo $_SESSION['admin_name']; ?></span>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
      <div class="col-md-6 col-lg-3">
        <div class="card stat-card">
          <div class="card-body d-flex align-items-center">
            <div class="icon bg-primary text-white me-3">
              <i class="bi bi-door-open"></i>
            </div>
            <div>
              <h3 class="mb-0"><?php echo $totalRooms; ?></h3>
              <small class="text-muted">Total Rooms</small>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="card stat-card">
          <div class="card-body d-flex align-items-center">
            <div class="icon bg-success text-white me-3">
              <i class="bi bi-check-circle"></i>
            </div>
            <div>
              <h3 class="mb-0"><?php echo $activeRooms; ?></h3>
              <small class="text-muted">Active Rooms</small>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="card stat-card">
          <div class="card-body d-flex align-items-center">
            <div class="icon bg-warning text-white me-3">
              <i class="bi bi-calendar-check"></i>
            </div>
            <div>
              <h3 class="mb-0"><?php echo $pendingReservations; ?></h3>
              <small class="text-muted">Pending Bookings</small>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="card stat-card">
          <div class="card-body d-flex align-items-center">
            <div class="icon bg-info text-white me-3">
              <i class="bi bi-envelope"></i>
            </div>
            <div>
              <h3 class="mb-0"><?php echo $unreadMessages; ?></h3>
              <small class="text-muted">Unread Messages</small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-4">
      <!-- Recent Reservations -->
      <div class="col-lg-7">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0">Recent Reservations</h6>
            <a href="reservations.php" class="btn btn-sm btn-primary">View All</a>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead>
                  <tr>
                    <th>Guest</th>
                    <th>Room</th>
                    <th>Check In</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($res = mysqli_fetch_assoc($recentReservations)): ?>
                    <tr>
                      <td><?php echo htmlspecialchars($res['user_name']); ?></td>
                      <td><?php echo htmlspecialchars($res['room_name']); ?></td>
                      <td><?php echo date('M d, Y', strtotime($res['check_in'])); ?></td>
                      <td>
                        <?php
                        $statusClass = [
                          'pending' => 'warning',
                          'confirmed' => 'success',
                          'cancelled' => 'danger'
                        ];
                        ?>
                        <span class="badge bg-<?php echo $statusClass[$res['status']] ?? 'secondary'; ?>">
                          <?php echo ucfirst($res['status']); ?>
                        </span>
                      </td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent Messages -->
      <div class="col-lg-5">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0">Recent Messages</h6>
            <a href="messages.php" class="btn btn-sm btn-primary">View All</a>
          </div>
          <div class="card-body p-0">
            <ul class="list-group list-group-flush">
              <?php while ($msg = mysqli_fetch_assoc($recentMessages)): ?>
                <li class="list-group-item">
                  <div class="d-flex justify-content-between">
                    <strong><?php echo htmlspecialchars($msg['name']); ?></strong>
                    <small class="text-muted"><?php echo date('M d', strtotime($msg['created_at'])); ?></small>
                  </div>
                  <small class="text-muted"><?php echo htmlspecialchars($msg['subject']); ?></small>
                </li>
              <?php endwhile; ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>