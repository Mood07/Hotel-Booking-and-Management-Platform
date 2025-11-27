<?php
session_start();
require_once '../inc/config.php';

if (!isset($_SESSION['admin_logged'])) {
  header("Location: index.php");
  exit;
}

// Handle room status toggle
if (isset($_GET['toggle'])) {
  $id = (int)$_GET['toggle'];
  execute("UPDATE rooms SET status = NOT status WHERE id = $id");
  header("Location: rooms.php");
  exit;
}

// Handle room delete
if (isset($_GET['delete'])) {
  $id = (int)$_GET['delete'];
  execute("DELETE FROM rooms WHERE id = $id");
  header("Location: rooms.php");
  exit;
}

// Handle add/edit room
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = isset($_POST['room_id']) ? (int)$_POST['room_id'] : 0;
  $name = sanitize($_POST['name']);
  $description = sanitize($_POST['description']);
  $price = (float)$_POST['price'];
  $adults = (int)$_POST['adults'];
  $children = (int)$_POST['children'];
  $area = (int)$_POST['area'];
  $status = isset($_POST['status']) ? 1 : 0;

  // Handle image upload
  $image = '';
  if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $image = uploadImage($_FILES['image'], 'rooms');
  }

  if ($id > 0) {
    // Update
    $query = "UPDATE rooms SET name='$name', description='$description', price=$price, 
                  adults=$adults, children=$children, area=$area, status=$status";
    if ($image) {
      $query .= ", image='$image'";
    }
    $query .= " WHERE id=$id";
    execute($query);
  } else {
    // Insert
    $query = "INSERT INTO rooms (name, description, price, adults, children, area, status, image) 
                  VALUES ('$name', '$description', $price, $adults, $children, $area, $status, '$image')";
    execute($query);
  }
  header("Location: rooms.php");
  exit;
}

// Get all rooms
$rooms = select("SELECT * FROM rooms ORDER BY id DESC");
$editRoom = null;
if (isset($_GET['edit'])) {
  $editId = (int)$_GET['edit'];
  $editResult = select("SELECT * FROM rooms WHERE id = $editId");
  $editRoom = mysqli_fetch_assoc($editResult);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rooms - Admin Panel</title>
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

    .brand-logo {
      color: #fff;
      font-size: 1.3rem;
      font-weight: bold;
      padding: 0 20px 20px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      margin-bottom: 20px;
    }
  </style>
</head>

<body>
  <!-- Sidebar -->
  <nav class="sidebar">
    <div class="brand-logo"><i class="bi bi-building"></i> Hotel Admin</div>
    <ul class="nav flex-column">
      <li class="nav-item"><a class="nav-link" href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
      <li class="nav-item"><a class="nav-link active" href="rooms.php"><i class="bi bi-door-open"></i> Rooms</a></li>
      <li class="nav-item"><a class="nav-link" href="reservations.php"><i class="bi bi-calendar-check"></i> Reservations</a></li>
      <li class="nav-item"><a class="nav-link" href="messages.php"><i class="bi bi-envelope"></i> Messages</a></li>
      <li class="nav-item"><a class="nav-link" href="settings.php"><i class="bi bi-gear"></i> Settings</a></li>
      <li class="nav-item mt-4"><a class="nav-link" href="../index.php" target="_blank"><i class="bi bi-globe"></i> View Website</a></li>
      <li class="nav-item"><a class="nav-link text-danger" href="logout.php"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
    </ul>
  </nav>

  <!-- Main Content -->
  <div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="mb-0">Manage Rooms</h4>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#roomModal">
        <i class="bi bi-plus-lg"></i> Add Room
      </button>
    </div>

    <div class="card">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="table-light">
              <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Capacity</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($room = mysqli_fetch_assoc($rooms)): ?>
                <tr>
                  <td>
                    <img src="<?php echo ROOM_IMG_PATH . ($room['image'] ?: 'default.jpg'); ?>"
                      alt="Room" style="width: 60px; height: 40px; object-fit: cover; border-radius: 5px;"
                      onerror="this.src='https://via.placeholder.com/60x40?text=Room'">
                  </td>
                  <td><?php echo htmlspecialchars($room['name']); ?></td>
                  <td>$<?php echo number_format($room['price'], 2); ?></td>
                  <td><?php echo $room['adults']; ?> Adults, <?php echo $room['children']; ?> Children</td>
                  <td>
                    <span class="badge bg-<?php echo $room['status'] ? 'success' : 'secondary'; ?>">
                      <?php echo $room['status'] ? 'Active' : 'Inactive'; ?>
                    </span>
                  </td>
                  <td>
                    <a href="?toggle=<?php echo $room['id']; ?>" class="btn btn-sm btn-outline-<?php echo $room['status'] ? 'warning' : 'success'; ?>">
                      <i class="bi bi-<?php echo $room['status'] ? 'pause' : 'play'; ?>"></i>
                    </a>
                    <a href="?edit=<?php echo $room['id']; ?>" class="btn btn-sm btn-outline-primary">
                      <i class="bi bi-pencil"></i>
                    </a>
                    <a href="?delete=<?php echo $room['id']; ?>" class="btn btn-sm btn-outline-danger"
                      onclick="return confirm('Delete this room?')">
                      <i class="bi bi-trash"></i>
                    </a>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Room Modal -->
  <div class="modal fade" id="roomModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><?php echo $editRoom ? 'Edit Room' : 'Add New Room'; ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <form method="POST" enctype="multipart/form-data">
          <?php if ($editRoom): ?>
            <input type="hidden" name="room_id" value="<?php echo $editRoom['id']; ?>">
          <?php endif; ?>
          <div class="modal-body">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Room Name *</label>
                <input type="text" name="name" class="form-control" required
                  value="<?php echo $editRoom ? htmlspecialchars($editRoom['name']) : ''; ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label">Price per Night *</label>
                <input type="number" name="price" class="form-control" step="0.01" required
                  value="<?php echo $editRoom ? $editRoom['price'] : ''; ?>">
              </div>
              <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3"><?php echo $editRoom ? htmlspecialchars($editRoom['description']) : ''; ?></textarea>
              </div>
              <div class="col-md-4">
                <label class="form-label">Adults Capacity</label>
                <input type="number" name="adults" class="form-control" min="1"
                  value="<?php echo $editRoom ? $editRoom['adults'] : '2'; ?>">
              </div>
              <div class="col-md-4">
                <label class="form-label">Children Capacity</label>
                <input type="number" name="children" class="form-control" min="0"
                  value="<?php echo $editRoom ? $editRoom['children'] : '0'; ?>">
              </div>
              <div class="col-md-4">
                <label class="form-label">Area (sqft)</label>
                <input type="number" name="area" class="form-control" min="0"
                  value="<?php echo $editRoom ? $editRoom['area'] : ''; ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label">Room Image</label>
                <input type="file" name="image" class="form-control" accept="image/*">
              </div>
              <div class="col-md-6">
                <label class="form-label">Status</label>
                <div class="form-check mt-2">
                  <input type="checkbox" name="status" class="form-check-input"
                    <?php echo (!$editRoom || $editRoom['status']) ? 'checked' : ''; ?>>
                  <label class="form-check-label">Active</label>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save Room</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <?php if ($editRoom): ?>
    <script>
      new bootstrap.Modal(document.getElementById('roomModal')).show();
    </script>
  <?php endif; ?>
</body>

</html>