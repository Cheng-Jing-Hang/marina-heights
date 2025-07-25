<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '/admin/Menus/db/connect.php';

$name = $_POST['visitor_name'] ?? '';
$email = $_POST['email'] ?? '';
$unit = $_POST['unit'] ?? '';
$date = $_POST['visit_date'] ?? '';
$status = 'Pending'; // default initial status

if (!$name || !$email || !$unit || !$date) {
    echo json_encode(['success' => false, 'msg' => 'Please fill in all required fields.']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO visitors (visitor_name, email, unit, visit_date, status, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
$stmt->bind_param("sssss", $name, $email, $unit, $date, $status);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'msg' => 'Registration successful, pending approval']);
} else {
    echo json_encode(['success' => false, 'msg' => 'Failed to register visitor']);
}

