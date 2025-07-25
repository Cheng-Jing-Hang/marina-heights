<?php
session_start();
require_once __DIR__ . '/admin/Menus/db/connect.php';

header('Content-Type: application/json');

$resident_id = $_SESSION['resident_id'] ?? null;

if (!$resident_id) {
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit;
}

$amount = $_POST['amount'] ?? null;
$method = $_POST['method'] ?? null;

if (!$amount || !$method) {
    echo json_encode(['success' => false, 'error' => 'Missing payment info']);
    exit;
}

$now = date('Y-m-d H:i:s');

$stmt = $conn->prepare("UPDATE maintenance_fees SET status = 'Paid', paid_at = ?, payment_method = ? WHERE resident_id = ? AND status = 'Unpaid'");
$stmt->bind_param("ssi", $now, $method, $resident_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Payment recorded']);
} else {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>