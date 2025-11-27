<?php
// Database Configuration
// Copy this file to config.php and update with your credentials

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); // Enter your MySQL password here
define('DB_NAME', 'hbwebsite');

// Site URL
define('SITE_URL', 'http://localhost/HBWEBSITE/');

// Image Paths
define('UPLOAD_PATH', 'uploads/');
define('ROOM_IMG_PATH', SITE_URL . 'uploads/rooms/');
define('CAROUSEL_IMG_PATH', SITE_URL . 'uploads/carousel/');

// Database Connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Set charset
mysqli_set_charset($conn, "utf8mb4");

// Helper Functions

// Sanitize input
function sanitize($data)
{
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars(trim($data)));
}

// Simple select query
function select($sql)
{
    global $conn;
    return mysqli_query($conn, $sql);
}

// Simple execute query
function execute($sql)
{
    global $conn;
    return mysqli_query($conn, $sql);
}

// Get last insert ID
function lastInsertId()
{
    global $conn;
    return mysqli_insert_id($conn);
}

// Redirect function
function redirect($url)
{
    header("Location: " . SITE_URL . $url);
    exit;
}

// Alert function
function alert($type, $message)
{
    $_SESSION['alert'] = ['type' => $type, 'message' => $message];
}

// Display alert
function showAlert()
{
    if (isset($_SESSION['alert'])) {
        $alert = $_SESSION['alert'];
        $class = $alert['type'] == 'success' ? 'alert-success' : 'alert-danger';
        echo "<div class='alert {$class} alert-dismissible fade show' role='alert'>
                {$alert['message']}
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
              </div>";
        unset($_SESSION['alert']);
    }
}

// Upload image
function uploadImage($file, $folder)
{
    $target_dir = "uploads/{$folder}/";

    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $filename = uniqid() . '_' . basename($file['name']);
    $target_file = $target_dir . $filename;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image
    $check = getimagesize($file['tmp_name']);
    if ($check === false) {
        return false;
    }

    // Check file size (5MB max)
    if ($file['size'] > 5000000) {
        return false;
    }

    // Allow certain formats
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
        return false;
    }

    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        return $filename;
    }

    return false;
}

// Delete image
function deleteImage($filename, $folder)
{
    $path = "uploads/{$folder}/{$filename}";
    if (file_exists($path)) {
        return unlink($path);
    }
    return false;
}

// Get site settings
function getSettings()
{
    $result = select("SELECT * FROM settings WHERE id = 1");
    return mysqli_fetch_assoc($result);
}
