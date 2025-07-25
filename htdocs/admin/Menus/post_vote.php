<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1);
header('Content-Type: application/json');
require_once 'db_config.php'; // Database configuration

try {
    // Only accept POST requests
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Method Not Allowed', 405);
    }

    // Validate input
    $required = ['title', 'deadline'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("Missing required field: $field", 400);
        }
    }

    // Process options
    $options = $_POST['option'] ?? [];
    if (count($options) < 2) {
        throw new Exception('At least 2 options are required', 400);
    }

    // Prepare data
    $title = htmlspecialchars(trim($_POST['title']));
    $description = htmlspecialchars(trim($_POST['description'] ?? ''));
    $deadline = date('Y-m-d H:i:s', strtotime($_POST['deadline']));

    // Database operations
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Start transaction
    $pdo->beginTransaction();

    // Insert vote
    $stmt = $pdo->prepare("INSERT INTO votes (title, description, deadline) VALUES (?, ?, ?)");
    $stmt->execute([$title, $description, $deadline]);
    $voteId = $pdo->lastInsertId();

    // Insert options
    $stmt = $pdo->prepare("INSERT INTO vote_options (vote_id, option_name) VALUES (?, ?)");
    foreach ($options as $option) {
        $option = htmlspecialchars(trim($option));
        if (!empty($option)) {
            $stmt->execute([$voteId, $option]);
        }
    }

    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Vote created successfully',
        'vote_id' => $voteId
    ]);

} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code($e->getCode() ?: 500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>