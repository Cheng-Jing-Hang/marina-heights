<?php
// Connect to the database
require_once 'admin/Menus/db/connect.php'; // adjust path if needed

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $visitor_name = trim($_POST['visitor_name']);
    $email = trim($_POST['email']);
    $unit = trim($_POST['unit']);
    $visit_date = $_POST['visit_date'];
    $num_visitors = (int) $_POST['num_visitors'];
    $purpose = trim($_POST['purpose']);
    $status = 'Pending';

    $stmt = $conn->prepare("INSERT INTO visitors (visitor_name, email, unit, visit_date, num_visitors, purpose, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");

    if ($stmt) {
        $stmt->bind_param("ssssiss", $visitor_name, $email, $unit, $visit_date, $num_visitors, $purpose, $status);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }

    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}
?>
