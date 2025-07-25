<?php
session_start();
require_once __DIR__ . '/db/connect.php'; // PDO connection

// Fetch approved residents
$stmt = $pdo->prepare("SELECT * FROM residents WHERE approved = 1 ORDER BY created_at DESC");
$stmt->execute();
$approved = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch pending residents
$stmt = $pdo->prepare("SELECT * FROM residents WHERE approved = 0 ORDER BY created_at DESC");
$stmt->execute();
$pending = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="fw-bold text-primary"><i class="bi bi-people-fill me-2"></i> Residents List</h2>
  </div>

  <!-- Approved Residents -->
  <div class="card shadow-sm border-0 rounded-4 mb-4">
    <div class="card-header bg-light">Approved Residents</div>
    <div class="table-responsive">
      <table class="table align-middle mb-0">
        <thead class="table-light text-uppercase small text-muted">
          <tr><th>Name</th><th>Unit</th><th>Email</th><th>Joined</th><th class="text-end">Actions</th></tr>
        </thead>
        <tbody>
          <?php foreach($approved as $r): ?>
          <tr data-id="<?= $r['id'] ?>">
            <td><?= htmlspecialchars($r['first_name'].' '.$r['last_name']) ?></td>
            <td><?= htmlspecialchars($r['unit_number']) ?></td>
            <td><?= htmlspecialchars($r['email']) ?></td>
            <td><?= date('Y-m-d', strtotime($r['created_at'])) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Pending Approval -->
  <div class="card shadow-sm border-0 rounded-4 mb-4">
    <div class="card-header bg-light">Pending Approval</div>
    <div class="table-responsive">
      <table class="table align-middle mb-0">
        <thead class="table-light text-uppercase small text-muted">
          <tr><th>Name</th><th>Unit</th><th>Email</th><th>Registered</th><th class="text-end">Actions</th></tr>
        </thead>
        <tbody>
          <?php foreach($pending as $r): ?>
          <tr data-id="<?= $r['id'] ?>">
            <td><?= htmlspecialchars($r['first_name'].' '.$r['last_name']) ?></td>
            <td><?= htmlspecialchars($r['unit_number']) ?></td>
            <td><?= htmlspecialchars($r['email']) ?></td>
            <td><?= date('Y-m-d', strtotime($r['created_at'])) ?></td>
            <td class="text-end">
              <button class="btn btn-sm btn-outline-success btn-approve"><i class="bi bi-check-circle"></i></button>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Confirm Delete Modal -->
<!-- Resident Delete Confirmation Modal (Styled like Noticeboard) -->
<div class="modal fade" id="confirmResidentDeleteModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow-sm">
      <div class="modal-body text-center p-4">
        <div class="display-5 text-danger mb-3"><i class="bi bi-exclamation-circle-fill"></i></div>
        <h5 class="mb-3 fw-semibold">Are you sure you want to delete this resident?</h5>
        <div class="d-flex justify-content-center gap-3">
          <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
          <button type="button" id="confirmDeleteResidentBtn" class="btn btn-danger rounded-pill px-4">Delete</button>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow-sm">
      <div class="modal-body text-center p-4">
        <div class="display-4 text-success mb-2"><i class="bi bi-check-circle-fill"></i></div>
        <h5 class="mb-0 fw-semibold">Success!</h5>
        <p id="successModalMsg" class="mb-0 fw-semibold mt-2"></p>
      </div>
    </div>
  </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', () => {
  const confirmDeleteModal = new bootstrap.Modal(document.getElementById('confirmResidentDeleteModal'));
  const successModal = new bootstrap.Modal(document.getElementById('successModal'));
  let deleteRow = null;

  document.addEventListener('click', function (e) {
    const target = e.target.closest('.btn-delete');
    if (target) {
      deleteRow = target.closest('tr');
      const id = deleteRow.dataset.id;
      if (!id) return;
      confirmDeleteModal.show();
      document.getElementById('confirmDeleteResidentBtn').onclick = () => {
        fetch('delete_resident.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: 'id=' + encodeURIComponent(id)
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            deleteRow.remove();
            confirmDeleteModal.hide();
            document.getElementById('successModalMsg').textContent = 'Resident Deleted';
            successModal.show();
          } else {
            alert(data.error || 'Delete failed.');
          }
        });
      };
    }
  });

  document.addEventListener('click', function (e) {
  const target = e.target.closest('.btn-approve');
  if (target) {
    const row = target.closest('tr');
    const id = row.dataset.id;
    if (!id) return;

    fetch('Menus/approve_resident.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'id=' + encodeURIComponent(id)
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        document.getElementById('successModalMsg').textContent = 'Resident Approved';
        successModal.show();
        loadPage('Menus/all_residents.php'); // Reload list
      } else {
        alert(data.error || 'Approval failed.');
      }
    });
  }
});

  });

});

</script>

