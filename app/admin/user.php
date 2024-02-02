<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>User Management</title>
</head>

<body>

    <div class="container">
        <?php require_once 'includes/sidebar.php' ?>
        <?php require_once 'includes/header.php' ?>

        <!-- Main Content -->
        <main>
            <h1>Users</h1>
            <!-- Add Button -->
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal">Add user</button>
            <br>
            <br>
            <!-- User Table -->
            <table class="table table-bordered table-striped" id="datatable">
                <thead>
                    <tr>
                        <th class="table-light text-uppercase text-center">ID</th>
                        <th class="d-none">ID</th>
                        <th class="table-light text-uppercase text-center">User Role</th>
                        <th class="table-light text-uppercase text-center">Username</th>
                        <th class="table-light text-uppercase text-center">Status</th>
                        <th class="table-light text-uppercase text-center">Last Login</th>
                        <th class="table-light text-uppercase text-center">Date Added</th>
                        <th class="table-light text-uppercase text-center">Last Updated</th>
                        <th class="table-light text-uppercase text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_select = "SELECT user_role.user_role_id, user_role.user_role, users.* FROM users INNER JOIN user_role USING (user_role_id) ORDER BY users.user_id DESC;";
                    $result_select = mysqli_query($conn, $sql_select);
                    if (mysqli_num_rows($result_select) > 0) {
                        while ($row_select = mysqli_fetch_assoc($result_select)) {
                            $user_id = $row_select['user_id'];
                            $user_role_id = $row_select['user_role_id'];
                            $user_role = $row_select['user_role'];
                            $username = $row_select['username'];
                            $is_active = $row_select['is_active'];
                            $last_login = $row_select['last_login'];
                            $created_at = $row_select['created_at'];
                            $updated_at = $row_select['updated_at'];

                            if ($is_active == 0) {
                                $is_active = 'Inactive';
                            } elseif ($is_active == 1) {
                                $is_active = 'Active';
                            }
                    ?>
                            <tr>
                                <td class="text-center"><?= $user_id ?></td>
                                <td class="d-none"><?= $user_role_id ?></td>
                                <td class="text-center"><?= $user_role ?></td>
                                <td class="text-center"><?= $username ?></td>
                                <td class="text-center"><?= $is_active ?></td>
                                <td class="text-center"><?= $last_login ?></td>
                                <td class="text-center"><?= $created_at ?></td>
                                <td class="text-center"><?= $updated_at ?></td>
                                <td class="text-center">
                                    <!-- Edit Button -->
                                    <a class="btn btn-sm btn-success edit" href="#" data-bs-toggle="modal" data-bs-target="#editModal_<?= $user_id ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <!-- Delete Button -->
                                    <a class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_user_modal_<?= $user_id ?>"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal_<?= $user_id ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel_<?= $user_id ?>" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel_<?= $user_id ?>">Edit Record</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Edit form goes here -->
                                            <form method="post" action="process_edit_user.php">
                                                <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                                <div class="form-group">
                                                    <label for="editName">Username:</label>
                                                    <input type="text" class="form-control" name="editName" id="editName" value="<?= $username ?>">
                                                </div>
                                                <div class="form-group">
                                                <div class="form-group">
                                                <label for="editPassword">Password:</label>
                                                 <div class="input-group">
                                                   <input type="password" class="form-control" name="editPassword" id="editPassword" required>
                                                     <div class="input-group-append">
                                               </div>
                                         </div>
                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="editUserRole">User Role:</label>
                                                    <select class="form-select" name="editUserRole" aria-label="Default select example">
                                                        <option value="1" <?= ($user_role_id == 1) ? 'selected' : '' ?>>Admin</option>
                                                        <option value="2" <?= ($user_role_id == 2) ? 'selected' : '' ?>>Staff</option>
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="delete_user_modal_<?= $user_id ?>" tabindex="-1" role="dialog" aria-labelledby="delete_user_modal_label_<?= $user_id ?>" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="delete_user_modal_label_<?= $user_id ?>">Delete Record</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete this record?</p>
                                            <form method="post" action="delete_user.php">
                                                <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                    ?>
                        <tr>
                            <td colspan="" class="text-center d-none"></td>
                            <td colspan="" class="text-center d-none"></td>
                            <td colspan="" class="text-center d-none"></td>
                            <td colspan="" class="text-center d-none"></td>
                            <td colspan="8" class="text-center">No records found.</td>
                        </tr>
                    <?php
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

    <!-- Notification modal code -->
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
    <!-- End of Notification modal code -->


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

    <?php require_once 'includes/scripts.php'; ?>

</body>

</html>
