<?php
// Show PHP errors in browser
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Fix the path to connect.php based on actual folder structure
require_once 'db/connect.php';

header('Content-Type: application/json');

// Query the latest 5 notices (make sure your table name and column are correct)
$result = $conn->query("SELECT title FROM notices ORDER BY posted_at DESC LIMIT 5");

$notices = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $notices[] = $row['title'];
    }
    echo json_encode($notices);
} else {
    echo json_encode(["error" => $conn->error]); // Show SQL error if query fails
}
?>

