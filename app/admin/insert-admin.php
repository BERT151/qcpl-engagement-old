<?php
    require_once '../core/init.php';

    $username = 'staff';
    $password = 'staff';
    $user_role_id = 2;
    $is_active = 1;
    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (user_role_id, username, password, is_active) VALUES ($user_role_id, '$username', '$hashed_password', $is_active);";

    if(mysqli_query($conn, $sql)){
        echo 'success';
    }else {
        echo 'failed';
    }