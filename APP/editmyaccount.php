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
  // Replace with your database credentials
  include "sql_conn.php";

  // Fetch user data from the database
  $session_passed_user_mail_id = $_SESSION['session_passed_user_email'];
  $sql = "SELECT * FROM users WHERE EmailId = '$session_passed_user_mail_id' "; 
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $fetched_email = $row['EmailId'];
        $fetched_first_name = $row['FirstName'];
        $fetched_last_name = $row['LastName'];
        $fetched_mobile_no = $row['MobileNumber'];
        $fetched_active_flag = $row['ActiveFlag'];
    }
    }
  ?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> EDIT | My Account </title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f8f9fa;
    }

    .container {
      margin-top: 50px;
    }

    .card {
      padding: 20px;
      border: none;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .profile-img {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      object-fit: cover;
    }
  </style>
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
                        <a class="nav-link active" href="myprofile.php">My Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="change_password.php">Change Password</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content of the page goes here -->
  <?php
  // Include SQL connection
  include "sql_conn.php";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the form
    $new_first_name = $_POST['new_first_name'];
    $new_last_name = $_POST['new_last_name'];
    $new_mobile = $_POST['new_mobile'];

  // Fetch user data from the database
  $session_passed_user_mail_id = $_SESSION['session_passed_user_email'];
  $sql = "SELECT * FROM users WHERE EmailId = '$session_passed_user_mail_id' "; 
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $fetched_email = $row['EmailId'];
        $fetched_first_name = $row['FirstName'];
        $fetched_last_name = $row['LastName'];
        $fetched_mobile_no = $row['MobileNumber'];
        $fetched_active_flag = $row['ActiveFlag'];
    }
    }

    // Update other user information
    $update_sql = "UPDATE users SET FirstName = '$new_first_name', LastName = '$new_last_name', MobileNumber = '$new_mobile' WHERE EmailId = '$session_passed_user_mail_id'";
    if ($conn->query($update_sql) !== TRUE) {
      echo "Error updating record: " . $conn->error;
    }
    else{
      header('Location: myprofile.php');
    }
  }

  $conn->close();
  ?>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <form action="editmyaccount.php" method="POST" enctype="multipart/form-data">
            <div class="text-center">
            </div>
            <h3 class="mt-3 text-center"><?php echo $new_name ?? $fetched_last_name .' '. $fetched_first_name; ?></h3>
            <p class="text-center"><?php echo $fetched_email; ?></p>
            <hr>
            <p><strong>Account Information</strong></p>
            <p><strong>First Name:</strong> <input type="text" name="new_first_name"
                value="<?php echo $new_first_name ?? $fetched_first_name; ?>"></p>
            <p><strong>Last Name:</strong> <input type="text" name="new_last_name"
                value="<?php echo $new_last_name ?? $fetched_last_name; ?>"></p>
            <hr>
            <p><strong>Contact Information</strong></p>
            <p><strong>Email:</strong> <?php echo $fetched_email; ?></p>
            <p><strong>Phone:</strong> <input type="text" name="new_mobile"
                value="<?php echo $new_mobile ?? $fetched_mobile_no; ?>"></p>
            <hr>
            <div class="text-center">
              <input type="submit" class="btn btn-primary" value="Save Changes">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
