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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Settings</title>
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

  $conn->close();
  ?>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="text-center">
          </div>
          <h3 class="mt-3 text-center"><?php echo $fetched_last_name .' '. $fetched_first_name; ?></h3>
          <p class="text-center"><?php echo $fetched_email; ?></p>
          <hr>
          <p><strong>Account Information</strong></p>
          <p><strong>First name:</strong> <?php echo $fetched_first_name; ?></p>
          <p><strong>Last name:</strong> <?php echo $fetched_last_name; ?></p>


          <?php 
          if ($fetched_active_flag == 1) {
            $active_flag_Color_Class = 'text-success';
            $fetched_active_flag_name = 'Active &#10004;';
          } elseif ($fetched_active_flag == 0) {
              $active_flag_Color_Class = 'text-danger';
              $fetched_active_flag_name = 'Inactive &#10008;';
            }
            echo "<p> <strong>Account Status: <span class='$active_flag_Color_Class'>" . $fetched_active_flag_name . "</span> </p>";
          ?>   
          <hr>
          <p><strong>Contact Information</strong></p>
          <p><strong>Email:</strong> <?php echo $fetched_email; ?></p>
          <p><strong>Phone:</strong> <?php echo $fetched_mobile_no; ?></p>
          <hr>
          <div class="text-center">
            <a href="editmyaccount.php" class="btn btn-primary">Edit Profile</a>
          </div>
        </div>
      </div>
    </div>
  </div>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
