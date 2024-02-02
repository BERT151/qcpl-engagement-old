<?php
require_once("includes/queue-header.php");
if (isset($_GET['queue_no'])) {
    $queue_no = $_GET['queue_no'];
} else {
    header("location: queue.php");
    die();
}
?>
<style>
    .bg {
        background-color: white;
        background-size: 100%;
        height: 100vh;
        background-repeat: no-repeat;
    }
    .QCLOGO {
        height: 100px;
        width: 120px;
    }
    body {
        margin: 0;
        font-size: 35px;
        color: black;
        font-weight: bolder;
        font-family: 'Inter';
    }
    h1 {
        color: black;
        text-align: center;
        font-size: 190px;
        font-family: Arial, Helvetica, sans-serif;
        margin-top: 0px;
        margin-bottom: 0px;
    }
    h2 {
        color: white;
        text-align: center;
        font-family: 'Glacial Indifference', sans-serif;
        font-size: 70px;
        font-weight: bold;
    }
    h3 {
        color: black;
        text-align: center;
        font-family: 'Glacial Indifference', sans-serif;
        font-size: 30px;
        font-weight: bold;
    }
    h4 {
        margin-top: -290px;
        color: black;
        font-size: 35px;
        font-weight: bolder;
        font-family: 'Inter';
    }
    .taas {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    ul {
        display: flex;
    }
    li {
        list-style: none;
    }
    .buttons {
        float: right;
        margin-top: -100px;
    }
    p {
        margin-top: -230px;
        color: black;
        font-size: 35px;
        font-weight: bolder;
        font-family: 'Inter';
        margin-left: -400px;

    }
</style>
<body>
    <div class="bg">
        <div class="taas">
            <ul>
                <li><img class="QCLOGO" src="../../public/assets/images/qclogo.jpg"></li>
                <li>
                    <pre><h3> Quezon City Public Library
    Quezon City Goverment  
            </h3></pre>
                </li>
                <li><img class="QCLOGO" src="../../public/assets/images/qcpl.logo.png"></li>
            </ul>
        </div>
        <center>
            <br><br><br><br>
            <p>QUEUE NUMBER:</p>
            <br>
            <?php
                $sql = "SELECT * FROM queue_details WHERE queue_number = '$queue_no' AND status = 0 LIMIT 1;";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $queue_number = $row['queue_number'];
                    $timestamp = $row['created_at'];
                }
            ?>
            <h1><b><?= $queue_number ?></b></h1>
            <p2><?= $timestamp ?></p2>
            <br><br><br>
            <p3><i>You will be served based on your<br>Queue Number</i></p3>
            <br>
            <br>
            <p>Main Library</p>
        </center>
        <br><br><br><br>
        <div class=" buttons">
        </div>
    </div>
</body>
</html>