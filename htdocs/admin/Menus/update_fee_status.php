<?php
require_once 'db/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'] ?? null;
  $status = $_POST['status'] ?? null;

  if (!$id || !in_array($status, ['Paid', 'Unpaid'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
    exit;
  }

  $stmt = $conn->prepare("
    UPDATE maintenance_fees SET status = ?, paid_at = ?
    WHERE id = ?
  ");
  $paidAt = $status === 'Paid' ? date('Y-m-d H:i:s') : null;
  $stmt->bind_param("ssi", $status, $paidAt, $id);
  $stmt->execute();

  echo json_encode(['success' => true]);
}
