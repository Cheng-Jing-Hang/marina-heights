<?php
require_once 'db/connect.php';
require_once 'db/maintenance_fee_helper.php';
session_start();

$selectedMonth = $_GET['month'] ?? date('Y-m');
[$year, $month] = explode('-', $selectedMonth);

initializeMaintenanceFees($conn, $month, $year);

$stmt = $conn->prepare("
  SELECT f.*, r.first_name, r.last_name, r.unit_number
  FROM maintenance_fees f
  JOIN residents r ON f.resident_id = r.id
  WHERE f.month = ? AND f.year = ?
  ORDER BY r.unit_number
");
$stmt->bind_param("ii", $month, $year);
$stmt->execute();
$fees = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<div class="container-fluid py-4">
  <h2 class="mb-4 fw-bold text-primary">
    <i class="bi bi-cash-coin me-2"></i> Management Fee Management
  </h2>

  <div class="row mb-4">
    <div class="col-md-4">
      <label class="form-label">Select Month</label>
      <input type="month" class="form-control" id="feeMonth" value="<?= htmlspecialchars($selectedMonth) ?>">
    </div>
  </div>

  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table align-middle">
          <thead class="table-light">
            <tr>
              <th>Unit No</th>
              <th>Resident Name</th>
              <th>Amount (RM)</th>
              <th>Status</th>
              <th>Due Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($fees as $fee): ?>
              <tr data-id="<?= $fee['id'] ?>">
                <td><?= $fee['unit_number'] ?></td>
                <td><?= $fee['first_name'] . ' ' . $fee['last_name'] ?></td>
                <td>150.00</td>
                <td>
                  <span class="badge <?= $fee['status'] === 'Paid' ? 'bg-success' : 'bg-danger' ?>">
                    <?= $fee['status'] ?>
                  </span>
                </td>
                <td><?= $fee['due_date'] ?></td>
                <td>
                  <div class="d-flex gap-2">
                    <?php if ($fee['status'] === 'Unpaid'): ?>
                      <button class="btn btn-sm btn-outline-success mark-paid">
                        <i class="bi bi-check-circle"></i> Mark Paid
                      </button>
                    <?php else: ?>
                      <button class="btn btn-sm btn-outline-secondary download-receipt">
                        <i class="bi bi-download"></i> Receipt
                      </button>
                      <button class="btn btn-sm btn-outline-danger mark-unpaid">
                        <i class="bi bi-x-circle"></i> Mark Unpaid
                      </button>
                    <?php endif; ?>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Global Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4">
      <div class="modal-body text-center py-5">
        <i class="bi bi-check-circle-fill text-success fs-1 mb-3"></i>
        <h5 id="successModalMsg" class="mb-0"></h5>
      </div>
    </div>
  </div>
</div>

<script>
document.getElementById('feeMonth').addEventListener('change', function () {
  const month = this.value;
  window.location.href = 'maintenance_fee.php?month=' + month;
});

document.querySelectorAll('.mark-paid, .mark-unpaid').forEach(btn => {
  btn.addEventListener('click', () => {
    const row = btn.closest('tr');
    const id = row.dataset.id;
    const status = btn.classList.contains('mark-paid') ? 'Paid' : 'Unpaid';

    fetch('/admin/Menus/update_fee_status.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `id=${id}&status=${status}`
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        document.getElementById('successModalMsg').textContent = `Marked as ${status}`;
        new bootstrap.Modal(document.getElementById('successModal')).show();
        setTimeout(() => location.reload(), 1000);
      }
    });
  });
});
</script>
