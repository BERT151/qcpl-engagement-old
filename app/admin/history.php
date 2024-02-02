<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

<div class="container">
        <?php require_once 'includes/sidebar.php' ?>
        <?php require_once 'includes/header.php' ?>
        <!-- Main Content -->
        <main>
            <h1>Dashboard</h1>
            <!-- Analyses -->
            <div class="right-section">
            <!-- End of Analyses -->
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
                <div class="notification">
                    <div class="icon">
                        <span class="material-icons-sharp">
                          notifications_none
                        </span>
                    </div>
                    <div class="content">
                        <div class="info">
                            <h3>User add new question</h3>
                            <small class="text_muted">
                                01:00 AM
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
                            <h3>Admin add new services</h3>
                            <small class="text_muted">
                                05:00 pm
                            </small>
                        </div>
                        <span class="material-icons-sharp">
                          delete
                        </span>
                    </div>
                </div>

            </div>

            </div>
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


        </div>


    </div>
    
    <?php
        require_once 'includes/scripts.php';
    ?>
</body>

</html>