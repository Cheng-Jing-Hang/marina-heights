<?php
session_start();
require_once __DIR__ . '/admin/Menus/db/connect.php';

if (!isset($_SESSION['resident_id'])) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

$resident_id = $_SESSION['resident_id'];

$stmt = $conn->prepare("SELECT email, unit_number FROM residents WHERE id = ?");
$stmt->bind_param("i", $resident_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode([
        'success' => true,
        'email' => $row['email'],
        'unit_number' => $row['unit_number']
    ]);
} else {
    echo json_encode(['success' => false, 'error' => 'Resident not found']);
}
?>
