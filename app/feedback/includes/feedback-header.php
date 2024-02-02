<?php
    require_once('../core/init.php');
    if(isset($_GET['client_id'])){
        $client_id = $_GET['client_id'];
        $sql = "UPDATE queue_details SET status = 1 WHERE client_id = $client_id;";
        mysqli_query($conn, $sql);
    }else{
        header('location: feedback.php');
        die();
    }
?>
<!DOCTYPE html>
<html>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quezon City Public Library</title>
    <link rel="shortcut icon" href="../../public/assets/images/qcplLogo.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <!-- jquery ajax -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/assets/css/style.css">
    <!-- latest bootstrap cdn -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            background-color: #f1f1f1;
        }
        #regForm {
            background-color: #ffffff;
            margin: 100px auto;
            font-family: Raleway;
            padding: 40px;
            width: 70%;
            min-width: 300px;
        }
        h1 {
            text-align: center;
        }
        input {
            padding: 10px;
            width: 100%;
            font-size: 17px;
            font-family: Raleway;
            border: 1px solid #aaaaaa;
        }
        /* Mark input boxes that gets an error on validation: */
        input.invalid {
            background-color: #ffdddd;
        }
        /* Hide all steps by default: */
        .tab {
            display: none;
        }
        button {
            background-color: #04AA6D;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            font-size: 17px;
            font-family: Raleway;
            cursor: pointer;
        }
        button:hover {
            opacity: 0.8;
        }
        #prevBtn {
            background-color: #bbbbbb;
        }
        /* Make circles that indicate the steps of the form: */
        .step {
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbbbbb;
            border: none;
            border-radius: 50%;
            display: inline-block;
            opacity: 0.5;
        }
        .step.active {
            opacity: 1;
        }
        /* Mark the steps that are finished and valid: */
        .step.finish {
            background-color: #04AA6D;
        }
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
            font-family: 'Arial', sans-serif;
        }
        #question-container {
            text-align: center;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }
        #question {
            font-size: 1.8em;
            margin-bottom: 20px;
        }
        .reaction-container {
            display: flex;
            justify-content: space-around;
            gap: 0.5em;
        }
        .reaction {
            text-align: center;
        }
        .reaction img {
            width: 100px;
            /* Adjust the size as needed */
            margin-top: 10px;
        }
        .reaction img:hover {
            transform: translate(0px, -20px);
            transition: ease-in 0.1s;
            cursor: pointer;
        }
        .word {
            font-size: 1.2em;
            margin-top: 10px;
        }
        label {
            font-size: 1em;
        }

        /* HIDE RADIO */
    [type=radio] { 
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
    }

    /* IMAGE STYLES */
    [type=radio] + img {
    cursor: pointer;
    }

    /* CHECKED STYLES */
    [type=radio]:checked + img {
    transform: translate(0px, -18px);
    box-shadow: 26px 200px 203px -96px rgba(0,0,0,1);
    -webkit-box-shadow: 26px 200px 203px -96px rgba(0,0,0,1);
    -moz-box-shadow: 26px 200px 203px -96px rgba(0,0,0,1);
    filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.3));
    border-radius: 50%;
    background-color: transparent;
    }
    .hidden {
        display: none;
    }
    </style>