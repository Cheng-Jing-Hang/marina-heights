<?php
require '../db/connect.php';

header('Content-Type: application/json');

$id = $_POST['id'] ?? 0;

// Validate ID
if (!is_numeric($id) || $id <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'msg' => 'Invalid visitor ID']);
    exit;
}

$stmt = $conn->prepare("DELETE FROM visitors WHERE id = ?");
$stmt->bind_param("i", $id);
$success = $stmt->execute();
$deleted = $stmt->affected_rows > 0;

echo json_encode(['success' => $deleted]);
?>

