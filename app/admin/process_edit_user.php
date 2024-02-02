<?php
// Include your database connection file
require_once '../core/init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve data from the form
    $user_id = $_POST['user_id'];
    $editName = $_POST['editName'];
    $editPassword = $_POST['editPassword'];
    $editUserRole = $_POST['editUserRole'];

    // Validate and sanitize the input if needed

    // Check if a new password is provided
    if (!empty($editPassword)) {
        // Hash the new password
        $hashedPassword = password_hash($editPassword, PASSWORD_DEFAULT);
        // Update user details with the new password
        $sql_update = "UPDATE users SET username = '$editName', password = '$hashedPassword', user_role_id = $editUserRole WHERE user_id = $user_id";
    } else {
        // Update user details without changing the password
        $sql_update = "UPDATE users SET username = '$editName', user_role_id = $editUserRole WHERE user_id = $user_id";
    }

    if (mysqli_query($conn, $sql_update)) {
        // Successfully updated
        header('Location: user.php'); // Redirect to the user.php page or any other page
        exit();
    } else {
        // Handle the update error
        echo "Error updating user: " . mysqli_error($conn);
    }
} else {
    // Handle the case where the form is not submitted using POST
    echo "Invalid request";
}
?>
