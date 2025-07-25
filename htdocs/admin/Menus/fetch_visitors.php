<?php
require_once __DIR__ . '/db/connect.php'; // adjust path as needed


$month = $_GET['month'] ?? date('Y-m');
$stmt = $conn->prepare("SELECT * FROM visitors WHERE DATE_FORMAT(visit_date, '%Y-%m') = ?");
$stmt->bind_param('s', $month);
$stmt->execute();
$result = $stmt->get_result();

$visitors = [];
while ($row = $result->fetch_assoc()) {
    $visitors[] = [
        'id' => $row['id'],
        'name' => $row['visitor_name'],
        'email' => $row['email'],
        'unit' => $row['unit'],
        'date' => $row['visit_date'],
        'num_visitors' => $row['num_visitors'],
        'purpose' => $row['purpose'],
        'status' => $row['status']
    ];
}
echo json_encode($visitors);
?>

