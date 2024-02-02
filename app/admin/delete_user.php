<?php
include '../core/init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $userIdToDelete = $_POST['user_id'];

    // Perform the deletion
    $sqlDelete = "DELETE FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sqlDelete);
    $stmt->bind_param('i', $userIdToDelete);

    if ($stmt->execute()) {
        // Deletion successful
        header("Location: user.php"); // Redirect to the original page
        exit();
    } else {
        // Error in deletion
        echo "Error deleting user: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    // Invalid request
    echo "Invalid request";
}
