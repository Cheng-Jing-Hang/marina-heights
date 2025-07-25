<?php
header('Content-Type: application/json');
require_once 'db_config.php'; // Database configuration

try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get active votes and their options with counts
    $stmt = $pdo->query("
        SELECT v.id AS vote_id, v.title, v.description, v.deadline,
               vo.id AS option_id, vo.option_name, vo.votes
        FROM votes v
        JOIN vote_options vo ON v.id = vo.vote_id
        WHERE v.deadline > NOW()
        ORDER BY v.deadline ASC, vo.id ASC
    ");

    $votes = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $voteId = $row['vote_id'];

        // If this is the first time we encounter this vote
        if (!isset($votes[$voteId])) {
            $votes[$voteId] = [
                'id' => $voteId,
                'title' => $row['title'],
                'description' => $row['description'],
                'deadline' => $row['deadline'],
                'options' => []
            ];
        }

        // Add the option to the current vote
        $votes[$voteId]['options'][] = [
            'id' => $row['option_id'],
            'name' => $row['option_name'],
            'votes' => $row['votes'] // Get the actual vote count
        ];
    }

    // Convert associative array to indexed array for JSON output
    echo json_encode(array_values($votes));

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => $e->getMessage()
    ]);
}
?>