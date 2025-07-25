<?php
header('Content-Type: application/json');
require_once 'admin/Menus/db_config.php';

session_start();
$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    http_response_code(401);
    echo json_encode(['error' => 'User not authenticated']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT vote_id FROM user_votes WHERE user_id = ?");
    $stmt->execute([$userId]);
    $votedPolls = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

    echo json_encode(['votedPolls' => $votedPolls]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
