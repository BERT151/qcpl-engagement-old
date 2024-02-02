<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<head><script src="https://code.jquery.com/jquery-3.6.0.min.js"></script></head>

<div class="container">
        <?php require_once 'includes/sidebar.php' ?>
        <?php require_once 'includes/header.php' ?>
        <?php require_once '../core/init.php' ?>
        <?php 
          // Fetch new users
    $sql = "SELECT * FROM users ORDER BY created_at DESC LIMIT 3"; // Limit to 3 latest users
    $result = $conn->query($sql);

    // Initialize $newUsers as an empty array
    $newUsers = [];
    ?>
        <!-- Main Content -->
        <main>
            <h1>Dashboard</h1>
            <!-- Analyses -->
            <div class="analyse">   
                <div class="sales">
                    <div class="status">
                    <div class="info">
        <h3>Total clients</h3>
        <?php
        // Fetch total clients count
        $sqlTotalClients = "SELECT COUNT(*) as totalClients FROM client";
        $resultTotalClients = $conn->query($sqlTotalClients);

        // Check if the query was successful
        if ($resultTotalClients) {
            $rowTotalClients = $resultTotalClients->fetch_assoc();
            echo '<h1>' . $rowTotalClients['totalClients'] . '</h1>';
        } else {
            // Handle query error (optional)
            echo "Error: " . $conn->error;
        }
        ?>
    </div>
                    </div>
                </div>
                <div class="visits">
                    <div class="status">
                        <div class="info">
                            <h3>Feedback Recieve</h3>
                            <h1>100</h1>
                        </div>
                        <div class="progresss">
                            <svg>
                                <circle cx="38" cy="38" r="36"></circle>
                            </svg>
                            <div class="percentage">
                                <p>+81%%</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="searches">
                    <div class="status">
                        <div class="info">
                            <h3>Services Offered</h3>
                            <h1>4</h1>
                        </div>
                        <div class="progresss">
                            <svg>
                                <circle cx="38" cy="38" r="36"></circle>
                            </svg>
                            <div class="percentage">
                                <p>+100%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Analyses -->

<!-- New Users Section -->
<div class="new-users">
    <h2>New Users</h2>
    <div class="user-list">
        <?php
        // Fetch new users
        $sql = "SELECT * FROM users ORDER BY created_at DESC LIMIT 3";
        $result = $conn->query($sql);

        // Initialize $newUsers as an empty array
        $newUsers = [];

        // Check if the query was successful
        if ($result) {
            // Fetch data and store it in $newUsers
            while ($row = $result->fetch_assoc()) {
                $newUsers[] = $row;
            }

            // Display new users
            foreach ($newUsers as $user) {
                echo '<div class="user">';
                echo '<h2>' . $user['username'] . '</h2>';
                echo '<p>' . $user['created_at'] . '</p>';
                echo '</div>';
            }
        } else {
            // Handle query error (optional)
            // You might want to log the error or handle it in another way
            echo "Error: " . $conn->error;
        }
        ?>
<div class="user">
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal" style="background-color: transparent; border: none;">
    <img src="<?= ROOT ?>/assets/images/plus.png" style="width: 50px; height: 50px;" id="addUserBtn"></button>
    <!-- <h2>More</h2> -->
    <p>Add New User</p>
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
                    <form method="post" action="process_add_user.php">
                        <div class="form-group">
                            <label for="editName">Username:</label>
                            <input type="text" class="form-control" name="editName" id="editName">
                            <label for="editPassword">Password:</label>
                            <input type="password" class="form-control" name="editPassword" id="editPassword">
                            <br>
                            <select class="form-select" name="user_role" aria-label="Default select example">
                                <option selected>Specify Role</option>
                                <option value="1">Admin</option>
                                <option value="2">Staff</option>
                            </select>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    </div>
</div>
<!-- End of New Users Section -->
            <!-- Recent Orders Table -->
            <div class="recent-orders">
                <h2>Recent Feedbacks</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Client Name</th>
                            <th>Queue Number</th>
                            <th>Time Submitted</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <th scope="row">Luffy</th>
                      <td>23-0732</td>
                      <td>11:59pm</td>
                      <td>
                      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailModal">Details</button>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">Zoro</th>
                      <td>23-0452</td>
                      <td>1:00pm</td>
                      <td>
                      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailModal">Details</button>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">Nami</th>
                      <td>23-0567</td>
                      <td>10:11am</td>
                      <td>
                      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailModal">Details</button>
                      </td>
                    </tr>
                    </tbody>
                </table>
                <a href="feedback.php">Show All</a>
            </div>
            <!-- End of Recent Orders -->

        </main>
        <!-- End of Main Content -->
<!-- Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">User Feedback</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4>How did you learn about our service?</h4>
        <ul>
          <li>Online Search [ Sa Internet ]</li>
          <li>Word of Mouth [ Kwento ng Iba ]</li>
        </ul>
        <h4>How was your experience with our services?</h4>
        <ul>
          <li>Neutral &#128578;</li>
        </ul>
        <h4>How likely are you to recommend specific services within the E-Government Section to others?</h4>
        <ul>
          <li>Excellent &#128513;</li>
        </ul>
        <h4>How satisfied are you with the response time of the E-Government Section in addressing your queries and concerns?</h4>
        <ul>
        <li>Neutral &#128578;</li>
        </ul>
        <h4>Did you find the staff in the E-Government Section
helpful and knowledgeable?</h4>
        <ul>
        <li>Neutral &#128578;</li>
        </ul>
        <h4>Did you find the information presented within the E-Government Section to be easily comprehensible?</h4>
        <ul>
        <li>Neutral &#128578;</li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
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
                        <img src="<?= ROOT ?>/assets/images/profile-1.jpg">
                    </div>
                </div>

            </div>
            <!-- End of Nav -->

            <div class="user-profile">
                <div class="logo">
                    <img src="<?= ROOT ?>/assets/images/qcpl.logo.png">
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
    
    <?php
        require_once 'includes/scripts.php';
    ?>
</body>

</html>
