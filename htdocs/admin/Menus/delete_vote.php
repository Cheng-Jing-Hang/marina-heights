<?php
// Menus/delete_vote.php
header('Content-Type: application/json');

// Include your database connection file.
// Since db_config.php is in the same 'Menus' directory, no path adjustment is needed.
include_once 'db_config.php';

$response = ['success' => false, 'error' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if vote_id is set and not empty
    if (isset($_POST['vote_id']) && !empty($_POST['vote_id'])) {
        $voteId = $_POST['vote_id'];

        // Validate $voteId to ensure it's an integer.
        // This is crucial even with prepared statements as an extra layer of validation.
        $voteId = filter_var($voteId, FILTER_VALIDATE_INT);

        if ($voteId === false) {
            $response['error'] = 'Invalid vote ID provided.';
        } else {
            try {
                // Start a transaction for atomicity (optional but good practice for related deletions)
                $pdo->beginTransaction();

                // Delete from the 'votes' table using a prepared statement
                $stmt = $pdo->prepare("DELETE FROM votes WHERE id = :id");
                $stmt->bindParam(':id', $voteId, PDO::PARAM_INT);
                $stmt->execute();

                // Check if any rows were affected (i.e., if a vote was actually deleted)
                if ($stmt->rowCount() > 0) {
                    $response['success'] = true;
                    $response['message'] = 'Vote and its options deleted successfully.';
                } else {
                    $response['error'] = 'Vote not found or already deleted.';
                }

                // Commit the transaction
                $pdo->commit();

            } catch (PDOException $e) {
                // Rollback the transaction on error
                if ($pdo->inTransaction()) {
                    $pdo->rollBack();
                }
                // Log the error for debugging, but provide a generic message to the user
                error_log("Error deleting vote: " . $e->getMessage());
                $response['error'] = 'A database error occurred during deletion. Please try again later.';
            }
        }
    } else {
        $response['error'] = 'Vote ID not provided.';
    }
} else {
    $response['error'] = 'Invalid request method.';
}

echo json_encode($response);
?>