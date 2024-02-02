<?php
    session_start();
    require_once 'conn.php';
    if(isset($_SESSION['user_id'])){
        $user_id_session = $_SESSION['user_id'];
        $username_session = $_SESSION['username'];
        $user_role_id_session = $_SESSION['user_role_id'];
    } else {
        // header('location: login.php');
        // die();
    }