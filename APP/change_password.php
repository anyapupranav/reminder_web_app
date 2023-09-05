<?php   
error_reporting(E_ALL ^ E_WARNING);
error_reporting(E_ERROR | E_PARSE);
?>

<?php
session_start();
if ($_SESSION['session_passed_user_email'] == NULL){
    header('Location: login.php');
}
?>

<?php
// Include your database connection here
include "sql_conn.php";

// Initialize variables
$current_password = $new_password = $confirm_new_password = "";
$password_change_status = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    // Fetch user data from the database
    $passed_session_user_mail_id = $_SESSION['session_passed_user_email'];
    $sql = "SELECT * FROM login WHERE EmailId = '$passed_session_user_mail_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $current_db_password = $row['Password'];

        // Check if the current password matches the one in the database
        if (password_verify($current_password, $current_db_password)) {
            // Verify that the new password and confirm new password match
            if ($new_password === $confirm_new_password) {
                // Hash the new password
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Update the password in the database
                $update_sql = "UPDATE login SET password = '$hashed_new_password' WHERE EmailId = '$passed_session_user_mail_id'";
                if ($conn->query($update_sql) === TRUE) {
                    $password_change_status = "Password changed successfully!";
                } else {
                    $password_change_status = "Error updating password!";
                }
            } else {
                $password_change_status = "New password and confirm new password do not match!";
            }
        } else {
            $password_change_status = "Current password is incorrect!";
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Change Password </title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="my_reminders.php">My Reminders</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="myprofile.php">My Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="change_password.php">Change Password</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content of the page goes here -->
    <div class="container mt-5">
        <h2>Change Password</h2>
        <form action="change_password.php" method="post">
            <div class="mb-3">
                <label for="current_password" class="form-label">Current Password:</label>
                <input type="password" class="form-control" id="current_password" name="current_password" required>
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">New Password:</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_new_password" class="form-label">Confirm New Password:</label>
                <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" required>
            </div>
            <button type="submit" class="btn btn-primary">Change Password</button>
        </form>
        <?php if ($password_change_status) : ?>
            <div class="mt-3 alert alert-<?php echo strpos($password_change_status, 'successfully') !== false ? 'success' : 'danger'; ?>">
                <?php 
                echo '<script type="text/javascript">'; 
                echo 'alert("' . $password_change_status . '");'; 
                echo 'window.location.href = "myprofile.php";';
                echo '</script>';
                ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
