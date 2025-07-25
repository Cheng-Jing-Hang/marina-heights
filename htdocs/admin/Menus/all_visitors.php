<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/db/connect.php';
?>

<div class="container-fluid py-4">
  <h2 class="mb-4 fw-bold text-primary">
    <i class="bi bi-person-badge me-2"></i> Visitor Management
  </h2>

  <!-- Month filter -->
  <div class="row mb-3">
    <div class="col-md-3">
      <label for="visitorMonth" class="form-label">Filter by Month</label>
      <input type="month" id="visitorMonth" class="form-control" value="<?php echo date('Y-m'); ?>">
    </div>
  </div>

  <!-- Visitor tables by status -->
  <div class="card shadow-sm border-0 rounded-4 mb-4">
    <div class="card-body">
      <h5 class="fw-semibold text-success">Approved & Checked-in</h5>
      <div class="table-responsive mb-4">
        <table class="table table-hover align-middle mb-0" id="usedVisitors">
          <thead class="table-light text-uppercase small text-muted">
  <tr>
    <th>Visitor Name</th>
    <th>Email</th> <!-- NEW -->
    <th>Visiting Unit</th>
    <th>Visit Date</th>
    <th>No. of Visitors</th> <!-- NEW -->
    <th>Purpose</th> <!-- NEW -->
    <th>Status</th>
    <th class="text-end">Actions</th>
  </tr>
</thead>
          <tbody></tbody>
        </table>
      </div>

      <h5 class="fw-semibold text-primary">Approved but Not Yet Checked-in</h5>
      <div class="table-responsive mb-4">
        <table class="table table-hover align-middle mb-0" id="approvedVisitors">
          <thead class="table-light text-uppercase small text-muted">
  <tr>
    <th>Visitor Name</th>
    <th>Email</th> <!-- NEW -->
    <th>Visiting Unit</th>
    <th>Visit Date</th>
    <th>No. of Visitors</th> <!-- NEW -->
    <th>Purpose</th> <!-- NEW -->
    <th>Status</th>
    <th class="text-end">Actions</th>
  </tr>
</thead>
          <tbody></tbody>
        </table>
      </div>

 <h5 class="fw-semibold text-warning">Pending Approval</h5>
<div class="table-responsive mb-4">
  <table class="table table-hover align-middle mb-0" id="pendingVisitorsTable">
    <thead class="table-light text-uppercase small text-muted">
      <tr>
        <th>Visitor Name</th>
        <th>Email</th>
        <th>Visiting Unit</th>
        <th>Visit Date</th>
        <th>No. of Visitors</th>
        <th>Purpose</th>
        <th>Status</th>
        <th class="text-end">Actions</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
</div>


      <h5 class="fw-semibold text-danger">Rejected</h5>
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" id="rejectedVisitors">
          <thead class="table-light text-uppercase small text-muted">
  <tr>
    <th>Visitor Name</th>
    <th>Email</th> <!-- NEW -->
    <th>Visiting Unit</th>
    <th>Visit Date</th>
    <th>No. of Visitors</th> <!-- NEW -->
    <th>Purpose</th> <!-- NEW -->
    <th>Status</th>
    <th class="text-end">Actions</th>
  </tr>
</thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Delete confirmation modal -->
<div class="modal fade" id="visitorConfirm" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-warning-subtle">
        <h5 class="modal-title text-warning"><i class="bi bi-exclamation-triangle me-2"></i>Confirm</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="visitorMsg">Are you sure you want to delete this visitor entry?</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-danger" id="visitorYes">Yes</button>
      </div>
    </div>
  </div>
</div>

<!-- Deletion success modal (same style as noticeboard) -->
<div class="modal fade" id="successModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success-subtle">
        <h5 class="modal-title text-success"><i class="bi bi-check-circle-fill me-2"></i>Success</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p id="successModalMsg" class="mb-0">Visitor entry deleted successfully.</p>
      </div>
    </div>
  </div>
</div>

<script>
const monthInput = document.getElementById('visitorMonth');
const confirmModal = new bootstrap.Modal(document.getElementById('visitorConfirm'));
const successModal = new bootstrap.Modal(document.getElementById('successModal'));
let deleteRow;

const tables = {
  Used: document.querySelector('#usedVisitors tbody'),
  Approved: document.querySelector('#approvedVisitors tbody'),
  Pending: document.querySelector('#pendingVisitorsTable tbody'),
  Rejected: document.querySelector('#rejectedVisitors tbody')
};

function loadVisitors() {
  const month = monthInput.value;
  fetch(`/admin/Menus/fetch_visitors.php?month=${month}`)
    .then(res => res.json())
    .then(data => {
      Object.values(tables).forEach(tbody => tbody.innerHTML = '');
      data.forEach(v => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${v.name}</td>
        <td>${v.email}</td>
        <td>${v.unit}</td>
        <td>${v.date}</td>
        <td>${v.num_visitors}</td>
        <td>${v.purpose}</td>
        <td><span class="badge ${badgeClass(v.status)}">${v.status}</span></td>
        <td class="text-end">
            ${actionButtons(v.status, v.id)}
        </td>
        `;
        row.dataset.id = v.id;
        tables[v.status]?.appendChild(row);
      });
    });
}

function badgeClass(status) {
  return {
    Approved: 'bg-success',
    Pending: 'bg-warning text-dark',
    Used: 'bg-primary',
    Rejected: 'bg-danger'
  }[status] || '';
}

function actionButtons(status, id) {
  if (status === 'Pending') {
    return `<div class="btn-group btn-group-sm">
      <button class="btn btn-outline-success" onclick="updateStatus(${id}, 'Approved')">Approve</button>
      <button class="btn btn-outline-danger" onclick="updateStatus(${id}, 'Rejected')">Reject</button>
    </div>`;
  }
  if (status === 'Approved') {
    return `<div class="btn-group btn-group-sm">
      <button class="btn btn-outline-primary" onclick="updateStatus(${id}, 'Used')">Mark Used</button>
      <button class="btn btn-outline-danger" onclick="confirmDelete(this)">Delete</button>
    </div>`;
  }
  return `<button class="btn btn-sm btn-outline-danger" onclick="confirmDelete(this)">Delete</button>`;
}

function updateStatus(id, status) {
  const formData = new URLSearchParams();
  formData.append('id', id);
  formData.append('status', status);

  fetch('/admin/Menus/update_visitor_status.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: formData.toString()
  })
  .then(res => res.text())  // <== changed from res.json() to res.text()
  .then(text => {
    console.log('Raw response:', text);  // SEE WHAT THE SERVER IS ACTUALLY RETURNING
    try {
      const data = JSON.parse(text);  // Try parsing if it's valid JSON
      if (data.success) {
        loadVisitors();
      } else {
        alert(data.msg || 'Failed to update status.');
      }
    } catch (err) {
      alert('Server returned invalid JSON. See console.');
    }
  });
}

function confirmDelete(btn) {
  deleteRow = btn.closest('tr');
  confirmModal.show();
}

document.getElementById('visitorYes').onclick = () => {
  const id = deleteRow.dataset.id;
  fetch('/admin/Menus/delete_visitor.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ id })
  }).then(res => res.text()).then(() => {
    deleteRow.remove();
    confirmModal.hide();
    document.getElementById('successModalMsg').textContent = 'Visitor entry deleted successfully.';
    successModal.show();
  });
};

monthInput.addEventListener('change', loadVisitors);
loadVisitors();
</script>
