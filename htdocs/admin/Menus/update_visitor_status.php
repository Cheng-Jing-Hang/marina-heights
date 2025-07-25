<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

require __DIR__ . '/db/connect.php';

$id = $_POST['id'] ?? 0;
$status = $_POST['status'] ?? '';

// Validate ID
if (!is_numeric($id) || $id <= 0) {
  echo json_encode(['success' => false, 'msg' => 'Invalid visitor ID']);
  exit;
}

// Validate status
$allowed = ['Approved', 'Rejected', 'Used'];
if (!in_array($status, $allowed)) {
  echo json_encode(['success' => false, 'msg' => 'Invalid status']);
  exit;
}

// Update status
$stmt = $conn->prepare("UPDATE visitors SET status = ? WHERE id = ?");
$stmt->bind_param("si", $status, $id);
$success = $stmt->execute();
$updated = $stmt->affected_rows > 0;

echo json_encode(['success' => $updated]);
?>

