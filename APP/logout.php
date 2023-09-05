<?php

// Check if the user is logged in
if (isset($_SESSION['session_passed_user_email'])) {
  // User is logged in, perform logout
  session_unset(); // Unset all session variables
  session_destroy(); // Destroy the session
}

// Redirect the user to the login page
header("Location: login.php");
exit();
?>
