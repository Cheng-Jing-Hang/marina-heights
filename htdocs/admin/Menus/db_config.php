<?php
// db_config.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// IMPORTANT: Replace with your actual database credentials
$db_host = 'sql303.infinityfree.com';       // Your database host
$db_name = 'if0_39493961_marinaHeights';  // Your database name
$db_user = 'if0_39493961';              // Your database username
$db_pass = 'sAEEWAxg63ve';        // Your database password

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Fetch rows as associative arrays by default
} catch (PDOException $e) {
    // Log the error message instead of displaying it directly in a production environment
    error_log("Database connection failed: " . $e->getMessage());
    die("A database error occurred. Please try again later."); // Generic message for users
}
?>