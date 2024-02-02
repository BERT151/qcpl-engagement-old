<?php
// Include your database connection file here
require_once '../core/init.php';

// Assuming you have a valid database connection in $conn

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['filter']) && isset($_POST['month']) && isset($_POST['year'])) {
        $filter = $_POST['filter'];
        $month = $_POST['month'];
        $year = $_POST['year'];

        switch ($filter) {
            case 'monthly':
                $query = "SELECT client.client_id, client.f_name, client.l_name, age.age_range, client.gender, client.occupation, client.education, DATE_FORMAT(client.created_at, '%Y-%m-%d %H:%i:%s') as created_at
                          FROM client 
                          JOIN age ON client.age_id = age.age_id
                          WHERE MONTH(client.created_at) = $month AND YEAR(client.created_at) = $year";

                $result = $conn->query($query);

                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<th scope="row">' . $row['client_id'] . '</th>';
                        echo '<td>' . $row['f_name'] . ' ' . $row['l_name'] . '</td>';
                        echo '<td>' . $row['age_range'] . '</td>';
                        echo '<td>' . $row['gender'] . '</td>';
                        echo '<td>' . $row['occupation'] . '</td>';
                        echo '<td>' . $row['education'] . '</td>';
                        echo '<td>' . $row['time_in'] . '</td>';
                        echo '<td>' . $row['time_out'] . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo 'Error in query execution';
                }
                break;
            // Add more cases as needed
        }
    }
}
?>
