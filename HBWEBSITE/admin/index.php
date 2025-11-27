<?php
session_start();
require_once '../inc/config.php';

// Redirect if already logged in
if (isset($_SESSION['admin_logged'])) {
    header("Location: dashboard.php");
    exit;
}

// Handle login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = sanitize($_POST['username']);
    $password = $_POST['password'];

    $result = select("SELECT * FROM admin WHERE username = '$username'");

    if (mysqli_num_rows($result) > 0) {
        $admin = mysqli_fetch_assoc($result);

        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_logged'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['username'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "Admin not found!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Hotel Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }

        .login-card {
            max-width: 400px;
            width: 100%;
            border: none;
            border-radius: 15px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
        }

        .login-header {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            border-radius: 15px 15px 0 0;
            padding: 30px;
            text-align: center;
        }

        .login-header i {
            font-size: 3rem;
            color: #c9a227;
        }

        .login-header h4 {
            color: #fff;
            font-family: 'Playfair Display', serif;
        }

        .btn-primary {
            background: linear-gradient(135deg, #c9a227, #d4af37);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #d4af37, #c9a227);
        }

        .input-group-text {
            background: #f8f9fa;
            border-right: none;
        }

        .form-control {
            border-left: none;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #c9a227;
        }

        .input-group:focus-within .input-group-text {
            border-color: #c9a227;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card login-card mx-auto">
            <div class="login-header">
                <i class="bi bi-shield-lock"></i>
                <h4 class="mt-3 mb-0">Admin Login</h4>
            </div>
            <div class="card-body p-4">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-circle"></i> <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" name="username" class="form-control" placeholder="Enter username" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </button>
                </form>

                <div class="text-center mt-3">
                    <a href="../index.php" class="text-muted small">
                        <i class="bi bi-arrow-left"></i> Back to Website
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>