<?php   
error_reporting(E_ALL ^ E_WARNING);
error_reporting(E_ERROR | E_PARSE);
?>

<?php
// Database connection 
include "sql_conn.php";

// Handle login logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve submitted form data
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Prepare SQL statement to fetch user details based on email
  $stmt = $conn->prepare("SELECT * FROM login WHERE EmailId = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    // User found, verify password
    $login = $result->fetch_assoc();

    if($login['ActiveFlag'] == 1 and $login['DeleteFlag'] == 0){

      if (password_verify($password, $login['Password'])) {
        // Password matches, create session and redirect to home page
        session_start();
        $_SESSION['session_passed_user_email'] = $email;
        header('Location: my_reminders.php');
        exit();
    } 
      else {
        // Invalid password
        $error = "Invalid password";
      }
      }
    else {
      // User is deleted or inactive
      $error = "User Deleted or Inactive";
    }
  } 
  else {
    // User not found
    $error = "User not found";
  }

  // Close statement and database connection
  $stmt->close();
  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Login | Reminder App </title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

  <!-- Custom CSS -->
  <style>
    body {
      background-color: #81b7aa;
    }

    .login-container {
      max-width: 400px;
      margin: 0 auto;
      padding: 40px;
      background-color: #fff;
      margin-top: 100px;
      border-radius: 5px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .login-container h2 {
      text-align: center;
      margin-bottom: 30px;
    }

    .form-control {
      border-radius: 0;
    }

    .btn {
      border-radius: 0;
      padding: 10px 20px;
    }

    .signup-link {
      text-align: center;
      margin-top: 20px;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="login-container">
          <h2>Login</h2>
          <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <?php if (isset($error)) { ?>
              <div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
            <?php } ?>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary">Login</button>
            </div>
            <div class="signup-link">
              <p>Don't have an account? <a href="signup.php">Sign up</a></p>
            <div class="forgot-password-link">
                <p><a href="forgot_password.php">Forgot password?</a></p>
            </div>
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
