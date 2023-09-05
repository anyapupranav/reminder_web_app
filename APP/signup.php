<?php   
error_reporting(E_ALL ^ E_WARNING);
error_reporting(E_ERROR | E_PARSE);
?>

<?php
// Database connection 
include "sql_conn.php";

// Handle registration logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve submitted form data
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Check if email is already registered
  $stmt = $conn->prepare("SELECT * FROM users WHERE emailid = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    // Email is already registered
    $error = "Email is already registered";
  } else {
    // Email is available, proceed with user registration
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user details into database table users
    $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, emailid) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $firstname, $lastname, $email);
    $stmt->execute();

    $sql = "SELECT UserId FROM users WHERE EmailId = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $fetched_userid_to_insert = $row['UserId'];
        }
    }

    // Insert details into database table login
    $sql1 = "INSERT INTO login (UserId, emailid, password) VALUES ('$fetched_userid_to_insert', '$email', '$hashedPassword')";
    $conn->query($sql1);

    // Redirect to login page after successful registration
    header('Location: login.php');
    exit();
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
  <title> SIGNUP | Reminder App </title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

  <!-- Custom CSS -->
  <style>
    body {
      background-color: #81b7aa;
    }

    .signup-container {
      max-width: 400px;
      margin: 0 auto;
      padding: 40px;
      background-color: #fff;
      margin-top: 100px;
      border-radius: 5px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .signup-container h2 {
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

    .login-link {
      text-align: center;
      margin-top: 20px;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="signup-container">
          <h2>Signup</h2>
          <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <?php if (isset($error)) { ?>
              <div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
            <?php } ?>
            <div class="mb-3">
              <label for="firstname" class="form-label">First Name</label>
              <input type="text" class="form-control" id="firstname" name="firstname" required>
            </div>
            <div class="mb-3">
              <label for="lastname" class="form-label">Last Name</label>
              <input type="text" class="form-control" id="lastname" name="lastname" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary">Signup</button>
            </div>
            <div class="login-link">
              <p>Already have an account? <a href="login.php">Login</a></p>
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
