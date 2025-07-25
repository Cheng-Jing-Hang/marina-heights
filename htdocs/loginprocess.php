<?php
// Enable full error reporting (for debugging)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
header('Content-Type: application/json');

// Check if valid POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['login_id']) || !isset($_POST['password'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit();
}

// Connect to database
$host = "sql112.byetcluster.com";
$dbname = "if0_39179476_marinaHeights";
$db_user = "if0_39179476";
$db_pass = "MarinaHeights";

$conn = new mysqli($host, $db_user, $db_pass, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

// Get login data
$login_id = trim($_POST['login_id']);
$password = $_POST['password'];
$remember = isset($_POST['remember']);

// Query residents table by email, first_name, last_name, or unit_number
$sql = "SELECT * FROM residents 
        WHERE (email = ? OR first_name = ? OR last_name = ? OR unit_number = ?)
        AND approved = 1";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Query failed']);
    exit();
}

$stmt->bind_param("ssss", $login_id, $login_id, $login_id, $login_id);
$stmt->execute();
$result = $stmt->get_result();

// If found
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    if ($password === $user['password']) {
        // Save user session
        $_SESSION['user'] = $user['email'];
        $_SESSION['resident_id'] = $user['id'];
        $_SESSION['first_name'] = $user['first_name']; // Save resident_id for bookings

        // Handle Remember Me
        if ($remember) {
            setcookie(
                "remember_login",
                $login_id,
                [
                    'expires' => time() + (86400 * 30),
                    'path' => '/',
                    'secure' => false, // change to true if using HTTPS
                    'httponly' => true,
                    'samesite' => 'Lax'
                ]
            );
        } else {
            setcookie(
                "remember_login",
                '',
                [
                    'expires' => time() - 3600,
                    'path' => '/',
                    'secure' => false,
                    'httponly' => true,
                    'samesite' => 'Lax'
                ]
            );
        }

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Incorrect password']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'User not found or not approved']);
}

$stmt->close();
$conn->close();
?>
