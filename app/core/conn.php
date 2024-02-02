<?php
    $conn = mysqli_connect(DBHOST, DBUSERNAME, DBPASSWORD, DBNAME);

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}