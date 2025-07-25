<?php
require_once __DIR__ . '/db/connect.php';

// Ensure clean JSON output
header('Content-Type: application/json');
ob_clean(); // clear any accidental output
ob_start();

$data = [
    'residents' => 0,
    'pending_visitors' => 0,
    'open_reports' => 0
];

$data['residents'] = $conn->query("SELECT COUNT(*) FROM residents")->fetch_row()[0];
$data['pending_visitors'] = $conn->query("SELECT COUNT(*) FROM visitors WHERE TRIM(status) = 'Pending'")->fetch_row()[0];
$data['open_reports'] = $conn->query("SELECT COUNT(*) FROM resident_reports WHERE status = 'Pending'")->fetch_row()[0];

echo json_encode($data);

$conn->close();
