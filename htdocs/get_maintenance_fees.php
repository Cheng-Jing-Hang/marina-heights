<?php
session_start();
require_once __DIR__ . '/admin/Menus/db/connect.php';

header('Content-Type: application/json'); // Must be first thing output!

$resident_id = $_SESSION['resident_id'] ?? null;
if (!$resident_id) {
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit;
}


$sql = "SELECT SUM(amount) AS total_due, MAX(due_date) AS next_due FROM maintenance_fees WHERE resident_id = ? AND status = 'Unpaid'";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $resident_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

$response = [
    'success' => true,
    'total_due' => $result['total_due'] ?? 0,
    'next_due' => $result['next_due'] ?? null
];

echo json_encode($response);
?>
