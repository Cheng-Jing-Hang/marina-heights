<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/db/connect.php';
    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'error' => 'Database connection failed: ' . $conn->connect_error]);
        exit;
    }

    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if (empty($title) || empty($content)) {
        echo json_encode(['success' => false, 'error' => 'Title and content are required.']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO notices (title, content, posted_at) VALUES (?, ?, NOW())");
    if (!$stmt) {
        echo json_encode(['success' => false, 'error' => 'Prepare failed: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param("ss", $title, $content);
    if ($stmt->execute()) {
        // Get the inserted ID and posted_at timestamp
        $inserted_id = $stmt->insert_id;

        // Fetch the inserted notice to get the posted_at timestamp (if your DB supports NOW() return)
        $result = $conn->query("SELECT id, title, content, posted_at FROM notices WHERE id = $inserted_id LIMIT 1");
        if ($result && $row = $result->fetch_assoc()) {
            echo json_encode([
                'success' => true,
                'notice' => $row
            ]);
        } else {
            // Fallback if fetch failed
            echo json_encode(['success' => true]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Execution failed: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
    exit;
}

echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
exit;
