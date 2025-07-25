<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/db/connect.php';
session_start();


$month = $_GET['month'] ?? date('Y-m');
$stmt = $pdo->prepare("
  SELECT fb.*, r.first_name, r.last_name, r.unit_number
  FROM facility_bookings fb
  JOIN residents r ON fb.resident_id = r.id
  WHERE DATE_FORMAT(booking_date, '%Y-%m') = ?
  ORDER BY booking_date DESC, booking_time DESC
");
$stmt->execute([$month]);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="fw-bold text-primary"><i class="bi bi-calendar-event me-2"></i> Facility Bookings</h2>
    <input type="month" id="filterMonth" class="form-control w-auto" value="<?= htmlspecialchars($month) ?>">
  </div>

  <div class="card shadow-sm border-0 rounded-4">
    <div class="table-responsive">
      <table class="table table-bordered align-middle mb-0">
        <thead class="table-light text-uppercase small text-muted">
          <tr>
            <th>Name</th>
            <th>Unit</th>
            <th>Facility</th>
            <th>Date</th>
            <th>Time</th>
            <th>Paid</th>
            <th>Method</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($bookings as $b): ?>
            <tr data-id="<?= $b['id'] ?>">
              <td><?= htmlspecialchars($b['first_name'].' '.$b['last_name']) ?></td>
              <td><?= htmlspecialchars($b['unit_number']) ?></td>
              <td><?= htmlspecialchars($b['facility_name']) ?></td>
              <td><?= htmlspecialchars($b['booking_date']) ?></td>
              <td><?= htmlspecialchars(date('H:i', strtotime($b['booking_time']))) ?></td>
              <td><?= $b['paid'] ? '<span class="text-success">Yes</span>' : '<span class="text-danger">No</span>' ?></td>
              <td><?= htmlspecialchars($b['payment_method']) ?></td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
document.querySelectorAll('.btn-delete').forEach(btn => {
  btn.onclick = () => {
    const row = btn.closest('tr');
    const id = row.dataset.id;
    showConfirmModal('Delete this booking?', () => {
      fetch('delete_booking.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'id=' + id
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          row.remove();
          showSuccess('Booking deleted successfully');
        } else alert('Error: ' + data.error);
      });
    });
  };
});

document.getElementById('filterMonth').addEventListener('change', function () {
  const month = this.value;
  loadPage('facility_bookings.php?month=' + month);
});
</script>
