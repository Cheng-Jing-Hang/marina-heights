<?php
session_start();
require_once __DIR__ . '/admin/Menus/db/connect.php';
// Make sure user is logged in
if (!isset($_SESSION['resident_id'])) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

$resident_id = $_SESSION['resident_id'];
$email = $_POST['email'] ?? '';
$unit_number = $_POST['unit_number'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($unit_number)) {
    echo json_encode(['success' => false, 'error' => 'Email and unit number are required']);
    exit;
}

$updateFields = "email = ?, unit_number = ?";
$params = [$email, $unit_number];
$types = "ss";

// If a new password is provided
if (!empty($password)) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $updateFields .= ", password = ?";
    $params[] = $hashedPassword;
    $types .= "s";
}

$params[] = $resident_id;
$types .= "i";

$stmt = $conn->prepare("UPDATE residents SET $updateFields WHERE id = ?");
$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to update account']);
}
?>
