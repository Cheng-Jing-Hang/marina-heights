<?php
session_start();
require_once 'db/connect.php'; // Make sure the path is correct

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
    $id = $_POST['id'];

    // Optional: Check if the resident exists first
    $check = $pdo->prepare("SELECT * FROM residents WHERE id = ?");
    $check->execute([$id]);
    $resident = $check->fetch(PDO::FETCH_ASSOC);

    if (!$resident) {
        echo json_encode(['success' => false, 'error' => 'Resident not found.']);
        exit;
    }

    // Delete resident
    $delete = $pdo->prepare("DELETE FROM residents WHERE id = ?");
    if ($delete->execute([$id])) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to delete resident.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request.']);
}
