<?php
function initializeMaintenanceFees($conn, $month, $year) {
  $stmt = $conn->prepare("SELECT id FROM maintenance_fees WHERE month = ? AND year = ?");
  $stmt->bind_param("ii", $month, $year);
  $stmt->execute();
  $stmt->store_result();

  // If already generated, skip
  if ($stmt->num_rows > 0) return;

  $due_date = date("$year-$month-10");

  $residents = $conn->query("SELECT id FROM residents");
  while ($resident = $residents->fetch_assoc()) {
    $stmt = $conn->prepare("
      INSERT INTO maintenance_fees (resident_id, month, year, amount, status, due_date)
      VALUES (?, ?, ?, 150.00, 'Unpaid', ?)
    ");
    $stmt->bind_param("iiis", $resident['id'], $month, $year, $due_date);
    $stmt->execute();
  }
}
