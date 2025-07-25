<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json'); // or remove if you want to redirect after

require __DIR__ . '/admin/Menus/db/connect.php';

// Get POST data and sanitize
$first_name = trim($_POST['first_name'] ?? '');
$last_name = trim($_POST['last_name'] ?? '');
$unit_number = trim($_POST['unit_number'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// Basic validation
if (!$first_name || !$last_name || !$unit_number || !$email || !$password) {
    echo json_encode(['success' => false, 'msg' => 'All fields are required']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'msg' => 'Invalid email format']);
    exit;
}

// Check if email or unit_number already exists (optional but recommended)
$stmt = $conn->prepare("SELECT id FROM residents WHERE email = ? OR unit_number = ?");
$stmt->bind_param('ss', $email, $unit_number);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    echo json_encode(['success' => false, 'msg' => 'Email or Unit Number already registered']);
    exit;
}

// Hash password securely
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert new resident
$stmt = $conn->prepare("INSERT INTO residents (first_name, last_name, unit_number, email, password, approved, created_at) VALUES (?, ?, ?, ?, ?, 0, NOW())");
$stmt->bind_param('sssss', $first_name, $last_name, $unit_number, $email, $hashed_password);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'msg' => 'Registration successful, pending approval']);
} else {
    echo json_encode(['success' => false, 'msg' => 'Database error: ' . $conn->error]);
}
