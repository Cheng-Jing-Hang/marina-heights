<?php
require_once 'db/connect.php';

$id = $_GET['id'] ?? null;
if (!$id) die('No ID provided');

$stmt = $conn->prepare("SELECT m.*, r.first_name, r.last_name, r.unit_number FROM maintenance_fee m JOIN residents r ON m.resident_id = r.id WHERE m.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) die('Record not found');

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Maintenance Fee Receipt</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { padding: 2rem; font-family: 'Segoe UI', sans-serif; }
    .receipt-box {
      max-width: 600px;
      margin: auto;
      border: 1px solid #ddd;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .receipt-box h3 {
      color: #0d6efd;
    }
    .btn-print, .btn-download {
      margin-top: 20px;
    }
  </style>
</head>
<body>

<div class="receipt-box">
  <h3 class="text-center">Maintenance Fee Receipt</h3>
  <hr>
  <p><strong>Resident Name:</strong> <?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></p>
  <p><strong>Unit Number:</strong> <?= htmlspecialchars($row['unit_number']) ?></p>
  <p><strong>Amount Paid:</strong> RM <?= number_format($row['amount'], 2) ?></p>
  <p><strong>Payment Date:</strong> <?= date('Y-m-d', strtotime($row['paid_at'])) ?></p>
  <p><strong>For Month:</strong> <?= date('F Y', strtotime($row['fee_month'])) ?></p>
  <hr>
  <p class="text-center text-muted">Thank you for your payment.</p>

  <div class="d-flex justify-content-center gap-3">
    <button class="btn btn-primary btn-print" onclick="window.print()">
      <i class="bi bi-printer"></i> Print
    </button>
    <a href="download_receipt.php?id=<?= $row['id'] ?>" class="btn btn-outline-secondary btn-download">
      <i class="bi bi-download"></i> Download PDF
    </a>
  </div>
</div>

</body>
</html>
