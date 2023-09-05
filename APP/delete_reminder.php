<?php
// Database connection
include 'sql_conn.php';

// Check if the ID is provided in the query parameter
if (isset($_GET['id'])) {
    $reminderId = $_GET['id'];

    // Perform the deletion
    $sql = "update reminders set deleteflag = 1 where id = $reminderId";

    if ($conn->query($sql) === TRUE) {
        // Deletion successful
        echo '<script type="text/javascript">'; 
        echo 'alert("Reminder has been deleted successfully.");'; 
        echo 'window.location.href = "my_reminders.php";';
        echo '</script>';
    } else {
        // Error during deletion
        echo '<script type="text/javascript">'; 
        echo 'alert("An error occured while deleting reminder.");'; 
        echo 'window.location.href = "my_reminders.php";';
        echo '</script>';
    }
} else {
    echo "Invalid request. No ID provided.";
}

// Close the database connection
$conn->close();
?>
