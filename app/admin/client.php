<?php
// Include your database configuration file here
require_once('../core/init.php');

// Check if the "Show Daily" button is clicked
if (isset($_POST['showDaily'])) {
    // Get the current date
    $currentDate = date('Y-m-d');

    // Query to get clients created on the current day with age information
    $query = "SELECT age.age_range, client.* FROM client INNER JOIN age ON client.age_id = age.age_id WHERE DATE(client.created_at) = '$currentDate'";
} elseif (isset($_POST['showMonthly'])) {
    // Get the selected month and year from the dropdown
    $selectedMonth = $_POST['selectedMonth'];
    $currentYear = date('Y');

    // Query to get clients created in the selected month of the current year with age information
    $query = "SELECT age.age_range, client.* FROM client INNER JOIN age ON client.age_id = age.age_id WHERE MONTH(client.created_at) = '$selectedMonth' AND YEAR(client.created_at) = '$currentYear'";
} elseif (isset($_POST['showYearly'])) {
    // Get the selected year from the dropdown
    $selectedYear = $_POST['selectedYear'];

    // Query to get clients created in the selected year with age information
    $query = "SELECT age.age_range, client.* FROM client INNER JOIN age ON client.age_id = age.age_id WHERE YEAR(client.created_at) = '$selectedYear'";
} else {
    // Default query to get all clients with age information (you can modify this based on your requirements)
    $query = "SELECT age.age_range, client.* FROM client INNER JOIN age ON client.age_id = age.age_id";
}

// Execute the query and fetch the results
$result = mysqli_query($conn, $query);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <!-- Include your CSS styles if needed -->
</head>
<body>
<div class="container">
<?php require_once 'includes/sidebar.php' ?>
    <?php require_once 'includes/header.php' ?>
<main>
    <h1>Client List</h1>
    
    
    <!-- Add your dropdown and buttons for filtering here -->
    <form method="post" class="d-flex gap-2">
        <button type="submit" name="showDaily" class="btn btn-primary btn-sm">Show Daily</button>
        
        <!-- Monthly dropdown for monthly filter -->
        <select name="selectedMonth" class="form-select btn btn-primary btn-sm" style="width: 110px;">
            <!-- Generate options for each month -->
            <?php
            for ($month = 1; $month <= 12; $month++) {
                $monthName = date("F", mktime(0, 0, 0, $month, 1));
                echo '<option value="' . $month . '">' . $monthName . '</option>';
            }
            ?>
        </select>

        <button type="submit" name="showMonthly" class="btn btn-primary btn-sm">Show Monthly</button>
        
        <!-- Year dropdown for yearly filter -->
        <select name="selectedYear" class="form-select btn btn-primary btn-sm" style="width: 90px;">
            <!-- Add options dynamically based on your database data -->
            <?php
            // Assuming your 'client' table has a column named 'created_at'
            $yearsQuery = "SELECT DISTINCT YEAR(`created_at`) AS year FROM `client`";
            $yearsResult = mysqli_query($conn, $yearsQuery);
            
            while ($yearRow = mysqli_fetch_assoc($yearsResult)) {
                echo '<option value="' . $yearRow['year'] . '">' . $yearRow['year'] . '</option>';
            }
            ?>
        </select>

        <button type="submit" name="showYearly" class="btn btn-primary btn-sm">Show Yearly</button>

        <!-- Submit Button -->
        
    </form>
     <br><br><br>
    <!-- Display clients based on the query results -->
    <!-- Display clients based on the query results -->
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <!-- Modify the table headers based on your actual schema -->
                <th>ID</th>
                <th>Fullname</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Occupation</th>
                <th>Educational Attainment</th>
            </tr>
        </thead>
        <tbody id="clientData">
            <?php
            // Display clients dynamically

            
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['client_id'] . '</td>';
                echo '<td>' . $row['f_name'] . ' ' . $row['l_name'] . '</td>';
                echo '<td>' . $row['age_range'] . '</td>'; // Display age range instead of age ID
                echo '<td>' . $row['gender'] . '</td>';
                echo '<td>' . $row['occupation'] . '</td>';
                echo '<td>' . $row['education'] . '</td>';
                echo '</tr>';
            }
            
            
            
            ?>
        </tbody>
    </table>
</div>

            



        <br><br>
        <h1>PURPOSE OF VISITING</h1>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Queue Number</th>
                    <th scope="col">Purpose of Visiting</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch purpose of visiting data from the database
                $result = $conn->query("SELECT * FROM queue_details");

                // Display purpose of visiting dynamically
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<th scope="row">' . $row['qd_id'] . '</th>';
                    echo '<td>' . $row['queue_number'] . '</td>';
                    echo '<td>' . $row['service'] . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
</main>
    <!-- End of Main Content -->

    <!-- Right Section -->
    <div class="right-section">
        <div class="nav">
            <button id="menu-btn">
                <span class="material-icons-sharp">
                    menu
                </span>
            </button>
            <div class="dark-mode">
                <span class="material-icons-sharp active">
                    light_mode
                </span>
                <span class="material-icons-sharp">
                    dark_mode
                </span>
            </div>

            <div class="profile">
                <div class="info">
                    <p>Hey, <b>Admin</b></p>
                    <small class="text-muted">Admin</small>
                </div>
                <div class="profile-photo">
                    <img src="./assets/images/profile-1.jpg">
                </div>
            </div>
        </div>
        <!-- End of Nav -->

        <div class="user-profile">
            <div class="logo">
                <img src="./assets/images/qcpl.logo.png">
                <h2>EngageMate</h2>
                <p>Web-based KIOSK</p>
            </div>
        </div>

        <div class="reminders">
            <div class="header">
                <h2>Recent History</h2>
                <span class="material-icons-sharp">
                    notifications_none
                </span>
            </div>

            <div class="notification">
                <div class="icon">
                    <span class="material-icons-sharp">
                    notifications_none
                    </span>
                </div>
                <div class="content">
                    <div class="info">
                        <h3>Users change questions</h3>
                        <small class="text_muted">
                            08:00 AM - 12:00 PM
                        </small>
                    </div>
                    <span class="material-icons-sharp">
                        delete
                    </span>
                </div>
            </div>

            <div class="notification">
                <div class="icon">
                    <span class="material-icons-sharp">
                      notifications_none
                    </span>
                </div>
                <div class="content">
                    <div class="info">
                        <h3>Users logIn</h3>
                        <small class="text_muted">
                            08:00 AM - 12:00 PM
                        </small>
                    </div>
                    <span class="material-icons-sharp">
                        delete
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal" id="addModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Record</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal Body -->
      <div class="modal-body">
        <!-- Edit form goes here -->
        <form>
          <div class="form-group">
            <label for="editName">Username:</label>
            <input type="text" class="form-control" id="editName">
            <label for="editName">Password:</label>
            <input type="text" class="form-control" id="editName">
              <br>
            <select class="form-select" aria-label="Default select example">
              <option selected>Specify Role</option>
              <option value="1">Admin</option>
              <option value="2">Staff</option>
            </select>
          </div>
          <br>
          <button type="button" class="btn btn-primary" data-dismiss="modal">Save Changes</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal" id="editModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Record</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal Body -->
      <div class="modal-body">
        <!-- Edit form goes here -->
        <form>
          <div class="form-group">
            <label for="editName">Name:</label>
            <input type="text" class="form-control" id="editName">
              <br>
            <select class="form-select" aria-label="Default select example">
              <option selected>Specify Role</option>
              <option value="1">Admin</option>
              <option value="2">Staff</option>
            </select>
          </div>
          <br>
          <button type="button" class="btn btn-primary" data-dismiss="modal">Save Changes</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Delete Modal -->
<div class="modal" id="deleteModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Delete Record</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal Body -->
      <div class="modal-body">
        <p>Are you sure you want to delete this record?</p>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Delete</button>
      </div>
    </div>
  </div>
</div>

<?php require_once 'includes/scripts.php'; ?>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function filterData(filterType) {
        var formData = $('#filterForm').serialize() + '&filter=' + filterType;

        $.ajax({
            type: 'POST',
            url: 'fetch_client_data.php',
            data: formData,
            success: function (response) {
                $('#clientData').html(response);
            }
        });
    }
</script>

</body>
</html>
