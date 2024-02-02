<?php
require_once '../core/init.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the required form fields are set
    if (isset($_POST['editName'], $_POST['editPassword'], $_POST['user_role'])) {
        // Retrieve data from the form
        $username = mysqli_real_escape_string($conn, $_POST['editName']);
        $password = password_hash($_POST['editPassword'], PASSWORD_DEFAULT);
        $user_role_id = mysqli_real_escape_string($conn, $_POST['user_role']);

        // Check if the username is not empty
        if (!empty($username)) {
            // Insert data into the 'users' table
            $sql_insert = "INSERT INTO users (user_role_id, username, password, is_active, created_at, updated_at) 
                           VALUES ('$user_role_id', '$username', '$password', 1, NOW(), NOW())";

            // Debugging statement to print the generated SQL query
            echo "Debug: SQL Query - $sql_insert<br>";

            // Check for duplicate entry
            $check_duplicate = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
            if (mysqli_num_rows($check_duplicate) == 0) {
                // No duplicate entry, proceed with the insertion
                if (mysqli_query($conn, $sql_insert)) {
                    // Success
                    header("Location: user.php");
                    exit();
                } else {
                    // Error
                    echo "Error: " . mysqli_error($conn);
                }
            } else {
                // Duplicate entry
                echo "Error: Duplicate username";
            }
        } else {
            // Username is empty
            echo "Error: Username cannot be empty";
        }
    } else {
        // Required form fields are not set
        echo "Error: Required form fields are missing";
    }
} else {
    // Form is not submitted
    echo "Error: Form not submitted";
}

// Close the database connection
mysqli_close($conn);
?>
