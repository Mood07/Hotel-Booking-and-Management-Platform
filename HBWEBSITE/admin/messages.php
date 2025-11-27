<?php
session_start();
require_once '../inc/config.php';

if (!isset($_SESSION['admin_logged'])) {
    header("Location: index.php");
    exit;
}

// Handle mark as read
if (isset($_GET['read'])) {
    $id = (int)$_GET['read'];
    execute("UPDATE contact_messages SET is_read = 1 WHERE id = $id");
    header("Location: messages.php");
    exit;
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    execute("DELETE FROM contact_messages WHERE id = $id");
    header("Location: messages.php");
    exit;
}

// Get all messages
$messages = select("SELECT * FROM contact_messages ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - Admin Panel</title>
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

        .unread {
            background: #f8f9fa;
            font-weight: bold;
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
            <li class="nav-item"><a class="nav-link" href="reservations.php"><i class="bi bi-calendar-check"></i> Reservations</a></li>
            <li class="nav-item"><a class="nav-link active" href="messages.php"><i class="bi bi-envelope"></i> Messages</a></li>
            <li class="nav-item"><a class="nav-link" href="settings.php"><i class="bi bi-gear"></i> Settings</a></li>
            <li class="nav-item mt-4"><a class="nav-link" href="../index.php" target="_blank"><i class="bi bi-globe"></i> View Website</a></li>
            <li class="nav-item"><a class="nav-link text-danger" href="logout.php"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Contact Messages</h4>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>From</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($msg = mysqli_fetch_assoc($messages)): ?>
                                <tr class="<?php echo $msg['is_read'] ? '' : 'unread'; ?>">
                                    <td>
                                        <?php if (!$msg['is_read']): ?>
                                            <i class="bi bi-circle-fill text-primary" style="font-size: 8px;"></i>
                                        <?php endif; ?>
                                        <?php echo $msg['id']; ?>
                                    </td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($msg['name']); ?></strong><br>
                                        <small class="text-muted"><?php echo htmlspecialchars($msg['email']); ?></small>
                                    </td>
                                    <td><?php echo htmlspecialchars($msg['subject']); ?></td>
                                    <td>
                                        <span data-bs-toggle="tooltip" title="<?php echo htmlspecialchars($msg['message']); ?>">
                                            <?php echo htmlspecialchars(substr($msg['message'], 0, 50)); ?>...
                                        </span>
                                    </td>
                                    <td><?php echo date('M d, Y H:i', strtotime($msg['created_at'])); ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                            data-bs-target="#viewModal<?php echo $msg['id']; ?>">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <?php if (!$msg['is_read']): ?>
                                            <a href="?read=<?php echo $msg['id']; ?>" class="btn btn-sm btn-outline-success">
                                                <i class="bi bi-check"></i>
                                            </a>
                                        <?php endif; ?>
                                        <a href="?delete=<?php echo $msg['id']; ?>" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Delete this message?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>

                                <!-- View Modal -->
                                <div class="modal fade" id="viewModal<?php echo $msg['id']; ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><?php echo htmlspecialchars($msg['subject']); ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>From:</strong> <?php echo htmlspecialchars($msg['name']); ?></p>
                                                <p><strong>Email:</strong> <?php echo htmlspecialchars($msg['email']); ?></p>
                                                <p><strong>Date:</strong> <?php echo date('M d, Y H:i', strtotime($msg['created_at'])); ?></p>
                                                <hr>
                                                <p><?php echo nl2br(htmlspecialchars($msg['message'])); ?></p>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="mailto:<?php echo $msg['email']; ?>" class="btn btn-primary">
                                                    <i class="bi bi-reply"></i> Reply
                                                </a>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    </script>
</body>

</html>