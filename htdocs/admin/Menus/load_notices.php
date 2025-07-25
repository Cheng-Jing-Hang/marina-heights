<?php
require_once __DIR__ . '/db/connect.php';
$result = $conn->query("SELECT * FROM notices ORDER BY posted_at DESC");
?>

<?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="card shadow-sm border-0 rounded-4 mb-3 notice-card" data-id="<?= $row['id'] ?>">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="card-title mb-1"><?= htmlspecialchars($row['title']) ?></h5>
                        <div class="small text-muted"><?= date('Y-m-d • h:i A', strtotime($row['posted_at'])) ?></div>
                    </div>
                    <button class="btn btn-sm btn-outline-danger delete-notice-btn ms-3">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </div>
                <p class="mt-3 mb-0"><?= nl2br(htmlspecialchars($row['content'])) ?></p>
            </div>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <div class="alert alert-info">No notices posted yet</div>
<?php endif; ?>
