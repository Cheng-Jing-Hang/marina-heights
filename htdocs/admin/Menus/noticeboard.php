<?php
session_start();
require_once __DIR__ . '/db/connect.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$result = $conn->query("SELECT * FROM notices ORDER BY posted_at DESC");
if (!$result) {
  die("Query failed: " . $conn->error);
}
?>


<div class="container-fluid py-4">
    <h2 class="mb-4 fw-bold text-primary">
        <i class="bi bi-megaphone-fill me-2"></i> Notice Board
    </h2>

    <div id="notices" class="mb-4">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card shadow-sm border-0 rounded-4 mb-3 notice-card" data-id="<?= $row['id'] ?>">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="card-title mb-1"><?= htmlspecialchars($row['title']) ?></h5>
                                <div class="small text-muted"><?= date('Y-m-d • h:i A', strtotime($row['posted_at'])) ?></div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0"><?= nl2br(htmlspecialchars($row['content'])) ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="alert alert-info">No notices posted yet</div>
        <?php endif; ?>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <h5 class="mb-3 text-primary"><i class="bi bi-plus-circle me-2"></i> Post a New Notice</h5>
            <form id="noticeForm" onsubmit="postNotice(event)">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" id="noticeTitle" name="title" class="form-control" required placeholder="Write your title here...">
                </div>
                <div class="mb-3">
                    <label class="form-label">Content</label>
                    <textarea id="noticeContent" name="content" class="form-control" rows="6" required placeholder="Write your notice here..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-send-fill me-1"></i> Post Notice
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Delete Notice Confirmation Modal -->
<div class="modal fade" id="confirmNoticeDeleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-sm">
            <div class="modal-body text-center p-4">
                <div class="display-5 text-danger mb-3">
                    <i class="bi bi-exclamation-circle-fill"></i>
                </div>
                <h5 class="mb-3 fw-semibold">Are you sure you want to delete this notice?</h5>
                <div class="d-flex justify-content-center gap-3">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmDeleteNoticeBtn" class="btn btn-danger rounded-pill px-4">Delete</button>
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
                <h5 class="mb-0 fw-semibold" id="successModalMsg">Success!</h5>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
let targetNotice = null;
let targetRow = null;
// Reload notices from load_notices.php and replace the #notices container
function loadNotices() {
  fetch('/admin/Menus/load_notices.php')
    .then(response => response.text())
    .then(html => {
      document.getElementById('notices').innerHTML = html;
    })
    .catch(err => {
      console.error('Failed to load notices:', err);
    });
}

// Delete notice button click (event delegation)
document.getElementById('notices').addEventListener('click', function(e) {
  const btn = e.target.closest('.delete-notice-btn');
  if (!btn) return;

  targetNotice = btn.closest('.notice-card');
  if (!targetNotice) {
    alert("Could not find the notice card.");
    return;
  }

  const confirmModal = new bootstrap.Modal(document.getElementById('confirmNoticeDeleteModal'));
  confirmModal.show();
});

// Confirm delete modal button
document.getElementById('confirmDeleteNoticeBtn').addEventListener('click', function () {
  if (!targetRow) {
    console.error('No row selected for deletion');
    return;
  }

  const id = targetRow.dataset.id;

  fetch('delete_report.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `id=${encodeURIComponent(id)}`
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        targetRow.remove();
        confirmModal.hide();
        successMessage.textContent = 'Report deleted successfully';
        successModal.show();
      } else {
        alert(data.error || 'Failed to delete');
      }
    })
    .catch(error => {
      console.error('Delete failed:', error);
      alert('Delete failed: ' + error.message);
    });
});


// Post a new notice
function postNotice(event) {
  event.preventDefault();

  const title = document.getElementById('noticeTitle').value.trim();
  const content = document.getElementById('noticeContent').value.trim();

  if (!title || !content) {
    alert('Please fill in both title and content.');
    return;
  }

  fetch('/admin/Menus/post_notice.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({ title, content })
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      // Clear form fields
      document.getElementById('noticeForm').reset();

      // Reload notices to include the new notice
      loadNotices();

      // Show success modal
      document.getElementById('successModalMsg').textContent = 'Notice Posted Successfully';
      const successModal = new bootstrap.Modal(document.getElementById('successModal'));
      successModal.show();
    } else {
      alert(data.error || 'Failed to post notice.');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Server error while posting notice');
  });
}


</script>
