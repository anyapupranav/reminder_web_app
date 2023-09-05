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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>ADD REMINDER</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Create Reminder</h2>
        <form action="add_reminder.php" method="post">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" class="form-control" id="date" name="date">
            </div>
            <div class="form-group">
                <label for="time">Time:</label>
                <input type="time" class="form-control" id="time" name="time" required>
            </div>
            <div class="mb-3">
                <label for="RepeatInterval" class="form-label">Repeat Interval</label>
                <select class="form-select" name="RepeatInterval" id="RepeatInterval">
                    <option> --Select-- </option>
                    <option value="everyday">Everyday</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                    <option value="yearly">Yearly</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Create Reminder</button>
            <a href='my_reminders.php' class='btn btn-light'>Cancel</a>
        </form>
    </div>

    <?php
    // Check if the form has been submitted
    if (isset($_POST['submit'])) {
        // Process the form data here
        $title = $_POST['title'];
        $description = $_POST['description'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $repeatInterval = $_POST['RepeatInterval'];

        include 'sql_conn.php';

        $session_passed_emailid_for_validation = $_SESSION['session_passed_user_email'];

        $sql = "INSERT INTO reminders (title, description, date, time, reminderinterval, EmailId) VALUES ('$title', '$description', '$date', '$time', '$repeatInterval', '$session_passed_emailid_for_validation')";

        if ($conn->query($sql) === TRUE) {
            echo '<script type="text/javascript">'; 
            echo 'alert("Reminder created successfully!");'; 
            echo 'window.location.href = "my_reminders.php";';
            echo '</script>';
        } else {
            echo '<script type="text/javascript">'; 
            echo 'alert("An error occurred while creating the reminder.");'; 
            echo 'window.location.href = "my_reminders.php";';
            echo '</script>';
        }
    }
    ?>
</body>
</html>
