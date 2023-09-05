<?php

$servername = "127.0.0.1";
$username = "your databse username";
$password = "your database password";
$dbname = "reminder_app";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
