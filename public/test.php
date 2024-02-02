<?php
    require_once('../app/core/init.php');
    // $queue_number = 0000001;

    // $queue_number++;
    // for ($queue_number = 0000001; $queue_number <= 1000; $queue_number++) {
    //     $queue_number = sprintf('%05d', $queue_number);
    //     echo '<br>';
    //     echo $queue_number;
    // }
    
    $sql = "SELECT * FROM queue_details ORDER BY queue_number DESC LIMIT 1;";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);

        $queue_number = $row['queue_number'];
        list($prefix, $string_number) = explode('-', $queue_number);
        
        $int_number = intval($string_number);
        echo "Prefix: " . $prefix . "<br>";
        echo "Number: " . sprintf('%05d', $int_number);
        echo '<br>';
        $int_number++;
        $new_int_number = sprintf('%05d', $int_number);
        $new_string_number = strval($new_int_number);
        echo $prefix. '-' .$new_string_number;
    }