<?php require_once '../app/core/init.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUEUING DISPLAY</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Poppins:wght@100;200;300;400;500;700;800;900&family=Roboto:wght@300&family=Teko:wght@300;400&display=swap" rel="stylesheet">
    <style type="text/css">
        body {
            background-color: #f2f2f2;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            margin-top: 10px;
        }

        .container {
            width: 80%;
            display: flex;
            flex-direction: column;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h1 {
            text-transform: uppercase;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
            font-size: 24px;
        }

        .onqueue, .onqueue1 {
            padding: 20px;
            border: 4px solid #333;
            border-radius: 10px;
            margin: 10px 0;
            overflow: hidden;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            background-color: #fff;
            max-height: 300px;
        }

        .queue-item, .queue-item1 {
            margin: 10px;
            padding: 15px;
            border-radius: 8px;
            color: #333;
            width: calc(33.33% - 20px);
            font-size: 30px;
            font-weight: 700;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 3px solid rgb(0, 203, 169);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
        }

        .priority .queue-item, .priority .queue-item1 {
            background-color: #FFD700; /* Priority item color */
        }

        .queue-item:hover, .queue-item1:hover {
            transform: scale(1.05);
        }

        a {
            color: #333;
            text-decoration: none;
            position: relative;
        }

        .onqueue {
            border-color: red;
        }

        .no-data {
            color: #555;
            font-style: italic;
            margin-top: 10px;
            text-align: center;
        }
        p {
            text-transform: uppercase;
            font-size: 20px;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>QUEUEING LINE</h1>
        <p>PRIORITY LANE</p>
        <div class="onqueue">

            <?php
            $query = "SELECT DISTINCT client.`status`, queue_details.queue_number, queue_details.`status`
            FROM client
            JOIN queue_details ON client.client_id = queue_details.client_id
            WHERE client.`status` = 1  AND queue_details.`status` = 0";

            $result1 = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result1)) {
                $queueNumber = $row['queue_number'];
                $priorityClass = ($row['status'] == 1) ? 'priority' : '';
                echo '<div class="queue-item ' . $priorityClass . '"><a href="">' . $queueNumber . '</a></div>';
            }

            if (mysqli_num_rows($result1) == 0) {
                echo '<p class="no-data">No data found.</p>';
            }
            ?>
        </div>
        <p>NON-PRIORITY LANE</p>
        <div class="onqueue1">
            <?php
            $query = "SELECT DISTINCT client.`status`, queue_details.queue_number, queue_details.`status`
            FROM client
            JOIN queue_details ON client.client_id = queue_details.client_id
            WHERE client.`status` = 0  AND queue_details.`status` = 0";

            $result0 = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result0)) {
                $queueNumber = $row['queue_number'];
                $priorityClass = ($row['status'] == 1) ? 'priority' : '';
                echo '<div class="queue-item1 ' . $priorityClass . '"><a href="">' . $queueNumber . '</a></div>';
            }

            if (mysqli_num_rows($result0) == 0) {
                echo '<p class="no-data">No data found.</p>';
            }
            ?>
        </div>
    </div>

    <script>
        setInterval(function() {
            location.reload();
        }, 1000);
    </script>
</body>
</html>
