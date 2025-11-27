<?php
session_start();
require_once '../inc/config.php';

if (!isset($_SESSION['admin_logged'])) {
    header("Location: index.php");
    exit;
}

// Handle status update
if (isset($_GET['status']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $status = sanitize($_GET['status']);
    execute("UPDATE reservations SET status = '$status' WHERE id = $id");
    header("Location: reservations.php");
    exit;
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    execute("DELETE FROM reservations WHERE id = $id");
    header("Location: reservations.php");
    exit;
}

// Get all reservations
$reservations = select("SELECT r.*, rm.name as room_name 
                        FROM reservations r 
                        LEFT JOIN rooms rm ON r.room_id = rm.id 
                        ORDER BY r.created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations - Admin Panel</title>
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
            <li class="nav-item"><a class="nav-link" href="rooms.php"><i class="bi bi-door-open"></i> Rooms</a></li>
            <li class="nav-item"><a class="nav-link active" href="reservations.php"><i class="bi bi-calendar-check"></i> Reservations</a></li>
            <li class="nav-item"><a class="nav-link" href="messages.php"><i class="bi bi-envelope"></i> Messages</a></li>
            <li class="nav-item"><a class="nav-link" href="settings.php"><i class="bi bi-gear"></i> Settings</a></li>
            <li class="nav-item mt-4"><a class="nav-link" href="../index.php" target="_blank"><i class="bi bi-globe"></i> View Website</a></li>
            <li class="nav-item"><a class="nav-link text-danger" href="logout.php"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Reservations</h4>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Guest</th>
                                <th>Room</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($res = mysqli_fetch_assoc($reservations)): ?>
                                <tr>
                                    <td><?php echo $res['id']; ?></td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($res['user_name']); ?></strong><br>
                                        <small class="text-muted"><?php echo htmlspecialchars($res['user_email']); ?></small>
                                    </td>
                                    <td><?php echo htmlspecialchars($res['room_name']); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($res['check_in'])); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($res['check_out'])); ?></td>
                                    <td>$<?php echo number_format($res['total_amount'], 2); ?></td>
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
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <?php if ($res['status'] == 'pending'): ?>
                                                <a href="?id=<?php echo $res['id']; ?>&status=confirmed" class="btn btn-outline-success" title="Confirm">
                                                    <i class="bi bi-check"></i>
                                                </a>
                                            <?php endif; ?>
                                            <?php if ($res['status'] != 'cancelled'): ?>
                                                <a href="?id=<?php echo $res['id']; ?>&status=cancelled" class="btn btn-outline-warning" title="Cancel">
                                                    <i class="bi bi-x"></i>
                                                </a>
                                            <?php endif; ?>
                                            <a href="?delete=<?php echo $res['id']; ?>" class="btn btn-outline-danger"
                                                onclick="return confirm('Delete this reservation?')" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>