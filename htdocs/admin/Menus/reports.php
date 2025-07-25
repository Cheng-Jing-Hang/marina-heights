<?php
// Menus/report.php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

// DB connection
require_once __DIR__ . '/db/connect.php';

// Fetch reports from DB
$query = "SELECT * FROM resident_reports ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<div class="container-fluid py-4">
  <h2 class="mb-4 fw-bold text-primary">
    <i class="bi bi-clipboard-data me-2"></i> Resident Reports
  </h2>

  <!-- Filter buttons -->
  <div class="d-flex flex-wrap gap-2 mb-3">
    <button class="btn btn-sm btn-outline-secondary filter-btn active" data-status="all">All</button>
    <button class="btn btn-sm btn-outline-warning filter-btn" data-status="Pending">Pending review</button>
    <button class="btn btn-sm btn-outline-info filter-btn" data-status="Resolving">Resolving</button>
    <button class="btn btn-sm btn-outline-success filter-btn" data-status="Completed">Completed</button>
  </div>

  <!-- Card Table -->
  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-light border-bottom-0 rounded-top-4 px-4 py-3">
      <h5 class="mb-0"><i class="bi bi-list-check me-2"></i> Reports List</h5>
    </div>
    <div class="table-responsive rounded-bottom-4">
      <table class="table table-hover align-middle mb-0" id="reportTable">
        <thead class="table-secondary text-uppercase small text-muted">
          <tr>
            <th>No.</th>
            <th>Title</th>
            <th>Description</th>
            <th>Status</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody id="reportBody">
  <?php if ($result && $result->num_rows > 0): ?>
    <?php $counter = 1; ?>
    <?php while ($row = $result->fetch_assoc()): ?>
      <tr data-id="<?= $row['id'] ?>" data-status="<?= $row['status'] ?>">
        <td class="fw-semibold"><?= $counter++ ?></td> <!-- This shows 1, 2, 3, ... -->
        <td><?= htmlspecialchars($row['title']) ?></td>
        <td class="text-truncate" style="max-width:260px;"><?= htmlspecialchars($row['description']) ?></td>
        <td><span class="badge status-badge"><?= htmlspecialchars($row['status']) ?></span></td>
        <td class="text-end">
          <div class="btn-group btn-group-sm">
            <button class="btn btn-outline-warning progress-btn">Pending</button>
            <button class="btn btn-outline-info progress-btn">Resolving</button>
            <button class="btn btn-outline-success progress-btn">Completed</button>
          </div>
        </td>
      </tr>
    <?php endwhile; ?>
  <?php else: ?>
    <tr><td colspan="6" class="text-center text-muted">No reports found</td></tr>
  <?php endif; ?>
</tbody>

      </table>
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="reportConfirmModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow-sm">
      <div class="modal-body text-center p-4">
        <div class="display-5 text-danger mb-3">
          <i class="bi bi-exclamation-circle-fill"></i>
        </div>
        <h5 class="mb-3 fw-semibold">Are you sure you want to delete this report?</h5>
        <div class="d-flex justify-content-center gap-3">
          <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
          <button type="button" id="confirmDeleteBtn" class="btn btn-danger rounded-pill px-4">Delete</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow-sm">
      <div class="modal-body text-center p-4">
        <div class="display-4 text-success mb-2">
          <i class="bi bi-check-circle-fill"></i>
        </div>
        <h5 id="successMessage" class="mb-0 fw-semibold">Success</h5>
      </div>
    </div>
  </div>
</div>



<!-- REQUIRED: Bootstrap JS Bundle (includes modal) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>

const statusMap = {
  Pending:   { cls: 'bg-warning-subtle text-dark',   label: 'Pending' },
  Resolving: { cls: 'bg-info-subtle text-dark',      label: 'Resolving' },
  Completed: { cls: 'bg-success-subtle text-dark',   label: 'Completed' }
};
  const confirmModalElement = document.getElementById('reportConfirmModal');
  const confirmModal = new bootstrap.Modal(confirmModalElement);
  const successModal = new bootstrap.Modal(document.getElementById('successModal'));
  const successMessage = document.getElementById('successMessage');

  let targetRow = null;

  document.getElementById('reportBody').addEventListener('click', e => {
    const btn = e.target.closest('.progress-btn, .delete-btn');

    if (!btn) return;
    const row = btn.closest('tr');
    const id = row.dataset.id;

    // Handle progress button click
    if (btn.classList.contains('progress-btn')) {
      const newStatus = btn.textContent.trim();
      const badge = row.querySelector('.status-badge');
      const { cls, label } = statusMap[newStatus];

      badge.className = 'badge status-badge ' + cls;
      badge.textContent = label;
      row.dataset.status = newStatus;

      fetch('/admin/Menus/update_report_status.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${encodeURIComponent(id)}&status=${encodeURIComponent(newStatus)}`
      });
    }

    // Handle delete button click
    if (btn.classList.contains('delete-btn')) {
  console.log('🗑️ Delete clicked'); // ✅ Add this line
  targetRow = row;
  confirmModal.show();
}

  });

  document.getElementById('confirmDeleteBtn').addEventListener('click', () => {
  console.log('✅ Confirm delete clicked. targetRow =', targetRow);

  if (!targetRow) {
    console.error('❌ No targetRow found.');
    return;
  }

  const id = targetRow.dataset.id;
  console.log('🆔 Deleting ID:', id);

  if (!id) {
    console.error('❌ No ID found on targetRow.');
    return;
  }

  fetch('delete_report.php', {
  method: 'POST',
  headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
  body: `id=${encodeURIComponent(id)}`
})

  .then(response => {
    console.log('📡 Fetch response status:', response.status);
    return response.json();
  })
  .then(data => {
    console.log('📦 Response data:', data);
    if (data.success) {
      console.log('✅ Deletion successful, removing row...');
      targetRow.remove();
      confirmModal.hide();
      successMessage.textContent = 'Report Deleted Successfully';
      successModal.show();
    } else {
      console.error('❌ Delete failed:', data.error);
      alert('Delete failed: ' + (data.error || 'Unknown error'));
    }
  })
  .catch(error => {
    console.error('❌ Fetch error:', error);
    alert('Error deleting report. See console.');
  });
});



  // Filter buttons
  document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      const status = btn.dataset.status;
      document.querySelectorAll('#reportBody tr').forEach(tr => {
        tr.style.display = (status === 'all' || tr.dataset.status === status) ? '' : 'none';
      });
    });
  });

</script>
