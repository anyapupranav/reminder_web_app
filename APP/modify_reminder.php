<?php
// Database connection
include 'sql_conn.php';

// Check if the ID is provided in the query parameter
if (isset($_GET['id'])) {
    $reminderId = $_GET['id'];

    // Fetch existing reminder data
    $sql = "SELECT * FROM reminders WHERE id = $reminderId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $title = $row['title'];
        $description = $row['description'];
        $date = $row['date'];
        $time = $row['time'];
        $repeatInterval = $row['reminderinterval'];
    } else {
        echo "Reminder not found.";
        exit;
    }
} else {
    echo "Invalid request. No ID provided.";
    exit;
}

// Check if the modification form is submitted
if (isset($_POST['submit'])) {
    // Retrieve modified data from the form
    $newTitle = $_POST['title'];
    $newDescription = $_POST['description'];
    $newDate = $_POST['date'];
    $newTime = $_POST['time'];
    $newRepeatInterval = $_POST['RepeatInterval'];

    // Perform the update operation
    $updateSql = "UPDATE reminders SET 
                  title = '$newTitle', 
                  description = '$newDescription', 
                  date = '$newDate', 
                  time = '$newTime', 
                  reminderinterval = '$newRepeatInterval' 
                  WHERE id = $reminderId";

    if ($conn->query($updateSql) === TRUE) {
        echo '<script type="text/javascript">'; 
        echo 'alert("Reminder has been modified successfully.");'; 
        echo 'window.location.href = "my_reminders.php";';
        echo '</script>';
    } else {
        echo "Error updating reminder: " . $conn->error;
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
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Modify Reminder</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Modify Reminder</h2>
        <form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $reminderId; ?>" method="post">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $title; ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $description; ?></textarea>
            </div>
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" class="form-control" id="date" name="date" value="<?php echo $date; ?>">
            </div>
            <div class="form-group">
                <label for="time">Time:</label>
                <input type="time" class="form-control" id="time" name="time" value="<?php echo $time; ?>" required>
            </div>
            <div class="mb-3">
                <label for="RepeatInterval" class="form-label">Repeat Interval:</label>
                <select class="form-select" name="RepeatInterval" id="RepeatInterval">
                    <option value="everyday" <?php if ($repeatInterval === 'everyday') echo 'selected'; ?>>Everyday</option>
                    <option value="weekly" <?php if ($repeatInterval === 'weekly') echo 'selected'; ?>>Weekly</option>
                    <option value="monthly" <?php if ($repeatInterval === 'monthly') echo 'selected'; ?>>Monthly</option>
                    <option value="yearly" <?php if ($repeatInterval === 'yearly') echo 'selected'; ?>>Yearly</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Save Modifications</button>
        </form>
    </div>
</body>
</html>
