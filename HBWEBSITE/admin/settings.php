<?php
session_start();
require_once '../inc/config.php';

if (!isset($_SESSION['admin_logged'])) {
    header("Location: index.php");
    exit;
}

// Handle settings update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $siteTitle = sanitize($_POST['site_title']);
    $siteAbout = sanitize($_POST['site_about']);
    $siteEmail = sanitize($_POST['site_email']);
    $sitePhone = sanitize($_POST['site_phone']);

    execute("UPDATE settings SET site_title='$siteTitle', site_about='$siteAbout', 
             site_email='$siteEmail', site_phone='$sitePhone' WHERE id=1");

    $success = "Settings updated successfully!";

    // Refresh settings
    $settings = getSettings();
}

// Handle password change
if (isset($_POST['change_password'])) {
    $currentPass = $_POST['current_password'];
    $newPass = $_POST['new_password'];
    $confirmPass = $_POST['confirm_password'];

    $adminResult = select("SELECT * FROM admin WHERE id = " . $_SESSION['admin_id']);
    $admin = mysqli_fetch_assoc($adminResult);

    if (!password_verify($currentPass, $admin['password'])) {
        $passError = "Current password is incorrect!";
    } elseif ($newPass != $confirmPass) {
        $passError = "New passwords do not match!";
    } elseif (strlen($newPass) < 6) {
        $passError = "Password must be at least 6 characters!";
    } else {
        $hashedPass = password_hash($newPass, PASSWORD_DEFAULT);
        execute("UPDATE admin SET password = '$hashedPass' WHERE id = " . $_SESSION['admin_id']);
        $passSuccess = "Password changed successfully!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Admin Panel</title>
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
            <li class="nav-item"><a class="nav-link" href="reservations.php"><i class="bi bi-calendar-check"></i> Reservations</a></li>
            <li class="nav-item"><a class="nav-link" href="messages.php"><i class="bi bi-envelope"></i> Messages</a></li>
            <li class="nav-item"><a class="nav-link active" href="settings.php"><i class="bi bi-gear"></i> Settings</a></li>
            <li class="nav-item mt-4"><a class="nav-link" href="../index.php" target="_blank"><i class="bi bi-globe"></i> View Website</a></li>
            <li class="nav-item"><a class="nav-link text-danger" href="logout.php"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <h4 class="mb-4">Settings</h4>

        <div class="row g-4">
            <!-- Site Settings -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="bi bi-gear"></i> Site Settings</h6>
                    </div>
                    <div class="card-body">
                        <?php if (isset($success)): ?>
                            <div class="alert alert-success"><?php echo $success; ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Site Title</label>
                                <input type="text" name="site_title" class="form-control"
                                    value="<?php echo htmlspecialchars($settings['site_title']); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">About Text</label>
                                <textarea name="site_about" class="form-control" rows="4"><?php echo htmlspecialchars($settings['site_about']); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="site_email" class="form-control"
                                    value="<?php echo htmlspecialchars($settings['site_email']); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="site_phone" class="form-control"
                                    value="<?php echo htmlspecialchars($settings['site_phone']); ?>">
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check"></i> Save Changes
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Change Password -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="bi bi-lock"></i> Change Password</h6>
                    </div>
                    <div class="card-body">
                        <?php if (isset($passError)): ?>
                            <div class="alert alert-danger"><?php echo $passError; ?></div>
                        <?php endif; ?>
                        <?php if (isset($passSuccess)): ?>
                            <div class="alert alert-success"><?php echo $passSuccess; ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <input type="hidden" name="change_password" value="1">
                            <div class="mb-3">
                                <label class="form-label">Current Password</label>
                                <input type="password" name="current_password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" name="new_password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" name="confirm_password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-key"></i> Change Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>