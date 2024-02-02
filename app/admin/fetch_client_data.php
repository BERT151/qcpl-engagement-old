<?php
// Include the database connection file
require_once '../core/init.php';

// Initialize filter conditions
$filterConditions = [];

// Determine the date column dynamically
$dateColumnQuery = "SELECT TABLE_NAME, COLUMN_NAME
                   FROM INFORMATION_SCHEMA.COLUMNS
                   WHERE TABLE_NAME = 'client'
                   AND COLUMN_NAME LIKE 'created%'
                   LIMIT 1";

$dateColumnResult = $conn->query($dateColumnQuery);

if ($dateColumnResult) {
    $dateColumnRow = $dateColumnResult->fetch_assoc();
    $tableName = $dateColumnRow['TABLE_NAME'];
    $dateColumn = $dateColumnRow['COLUMN_NAME'];
} else {
    // Set default values if the query fails
    $tableName = 'client';
    $dateColumn = 'created_at';
}

// Get selected month and year from the AJAX request
$selectedMonth = isset($_POST['month']) ? $_POST['month'] : date('n');
$selectedYear = isset($_POST['year']) ? $_POST['year'] : date('Y');

if ($selectedMonth == 12) {
    $filterConditions[] = "(
        MONTH($tableName.$dateColumn) = 12 AND YEAR($tableName.$dateColumn) = $selectedYear
    ) OR (
        MONTH($tableName.$dateColumn) = 1 AND YEAR($tableName.$dateColumn) = " . ($selectedYear + 1) . "
    )";
} else {
    $filterConditions[] = "MONTH($tableName.$dateColumn) = $selectedMonth AND YEAR($tableName.$dateColumn) = $selectedYear";
}

// Combine filter conditions
$whereClause = !empty($filterConditions) ? " WHERE " . implode(" AND ", $filterConditions) : '';

// Fetch client data with filter conditions
$query = "SELECT client.client_id, client.f_name, client.l_name, age.age_range, client.gender, client.occupation, client.education 
          FROM client 
          JOIN age ON client.age_id = age.age_id";
$query .= $whereClause;
$result = $conn->query($query);

// Check for SQL errors
if (!$result) {
    die("SQL Error: " . $conn->error);
}

// Output the table rows dynamically
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

// Close the database connection
$conn->close();
?>
