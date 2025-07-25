<?php
session_start();
require_once __DIR__ . '/admin/Menus/db/connect.php';
header('Content-Type: application/json');

// Read JSON input
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
    exit;
}

$reporter = $_SESSION['resident_id'] ?? 0;
$type = $data['type'] ?? '';
$description = trim($data['description'] ?? '');
$title = ($type === 'other') ? trim($data['otherTitle'] ?? '') : ucfirst($type);

// Remove unit_number check
if (!$reporter || !$title || !$description) {
    echo json_encode(['success' => false, 'error' => 'Missing required fields']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO resident_reports (reporter, title, description, status, created_at) VALUES (?, ?, ?, 'Pending', NOW())");
$stmt->bind_param("iss", $reporter, $title, $description);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Database error']);
}

$stmt->close();
$conn->close();
?>
