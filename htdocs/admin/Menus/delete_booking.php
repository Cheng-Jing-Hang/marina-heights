<?php
require '../db/connect.php';
header('Content-Type: application/json');
session_start();

$id = $_POST['id'] ?? null;
if ($id) {
  $stmt = $pdo->prepare("DELETE FROM facility_bookings WHERE id = ?");
  $success = $stmt->execute([$id]);
  echo json_encode(['success' => $success]);
} else {
  echo json_encode(['success' => false, 'error' => 'Invalid ID']);
}
