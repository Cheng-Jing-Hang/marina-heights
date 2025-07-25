<?php
<?php
header('Content-Type: application/json');
require_once 'db_config.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Method Not Allowed', 405);
    }

    if (empty($_POST['vote_id']) || empty($_POST['option_id']) || empty($_POST['user_id'])) {
        throw new Exception('Missing vote ID, option ID, or user ID', 400);
    }

    $voteId = (int)$_POST['vote_id'];
    $optionId = (int)$_POST['option_id'];
    $userId = $_POST['user_id']; // Use session or POST

    // Check if user already voted for this poll
    $checkStmt = $pdo->prepare("SELECT 1 FROM user_votes WHERE vote_id = ? AND user_id = ?");
    $checkStmt->execute([$voteId, $userId]);
    if ($checkStmt->fetch()) {
        echo json_encode([
            'success' => false,
            'error' => 'You have already voted on this poll.'
        ]);
        exit;
    }

    // Log the vote
    $stmt = $pdo->prepare("INSERT INTO user_votes (vote_id, option_id, user_id) VALUES (?, ?, ?)");
    $stmt->execute([$voteId, $optionId, $userId]);

    // Update vote count
    $updateStmt = $pdo->prepare("UPDATE vote_options SET votes = votes + 1 WHERE id = ?");
    $updateStmt->execute([$optionId]);

    echo json_encode([
        'success' => true,
        'message' => 'Vote submitted successfully!'
    ]);

} catch (Exception $e) {
    http_response_code($e->getCode() ?: 500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>