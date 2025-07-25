<?php
require_once 'db/connect.php';

// Fetch existing notices
$result = $conn->query("SELECT * FROM notices ORDER BY posted_at DESC");

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        ?>
        <div class="card shadow-sm border-0 mb-4 rounded-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="card-title mb-1"><?= htmlspecialchars($row['title']) ?></h5>
                        <div class="small text-muted">
                            <?= date('Y-m-d • h:i A', strtotime($row['posted_at'])) ?>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <form method="POST" action="delete_notice.php" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                    onclick="return confirm('Delete this notice?')">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
                <p class="mt-3 mb-0"><?= nl2br(htmlspecialchars($row['content'])) ?></p>
            </div>
        </div>
        <?php
    }
} else {
    echo '<div class="alert alert-info">No notices posted yet</div>';
}
?>