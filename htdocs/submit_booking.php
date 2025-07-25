<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start(); // if you use sessions to get resident_id

require_once __DIR__ . '/admin/Menus/db/connect.php'; // adjust path as needed

header('Content-Type: application/json');

// Check if POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
    exit;
}

// Get JSON input from fetch or form submit
$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    // fallback for normal form submit (application/x-www-form-urlencoded)
    $data = $_POST;
}

// Validate required fields
$requiredFields = ['facility', 'date', 'paymentMethod'];
foreach ($requiredFields as $field) {
    if (empty($data[$field])) {
        echo json_encode(['success' => false, 'error' => "Missing field: $field"]);
        exit;
    }
}

// Retrieve fields safely
$facility = $data['facility'];
$date = $data['date'];
$paymentMethod = $data['paymentMethod'];
$hours = isset($data['hours']) ? (int)$data['hours'] : 1; // default 1 hour if not given

// TODO: Adjust resident_id according to your auth system
// Example: resident_id from session
$resident_id = $_SESSION['resident_id'] ?? null;
if (!$resident_id) {
    echo json_encode(['success' => false, 'error' => 'Resident not logged in']);
    exit;
}

// Calculate booking_time (start time and end time)
// For simplicity, assume start time is 12:00 noon (or customize)
$startTime = '12:00:00';
$booking_datetime_start = $date . ' ' . $startTime;

// Calculate end time based on hours
$startTimestamp = strtotime($booking_datetime_start);
$endTimestamp = strtotime("+$hours hours", $startTimestamp);
$booking_datetime_end = date('Y-m-d H:i:s', $endTimestamp);

// Prepare insert statement
// Assuming your table columns: id (auto-increment), resident_id, facility_name, booking_date, booking_time, paid, payment_method, created_at
// We store booking_date = $date and booking_time = "start-end" string or store start time only? 
// I will store booking_date as date and booking_time as VARCHAR with range e.g. "12:00:00 - 15:00:00"

$booking_time = date('H:i:s', $startTimestamp) . ' - ' . date('H:i:s', $endTimestamp);
$paid = 0; // default unpaid

$stmt = $conn->prepare("INSERT INTO facility_bookings (resident_id, facility_name, booking_date, booking_time, paid, payment_method, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
if (!$stmt) {
    echo json_encode(['success' => false, 'error' => 'Prepare failed: ' . $conn->error]);
    exit;
}

$stmt->bind_param("isssis", $resident_id, $facility, $date, $booking_time, $paid, $paymentMethod);
$success = $stmt->execute();

if ($success) {
    echo json_encode(['success' => true, 'message' => 'Booking submitted successfully']);
} else {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>