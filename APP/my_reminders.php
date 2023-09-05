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
    <title>My Reminders</title>
</head>
<body>
    <a href="logout.php" class="btn btn-light float-right">
        <span class="material-symbols-outlined">
        logout
        </span>
    </a>
    <a href="myprofile.php" class="btn btn-light float-right">
        <span class="material-symbols-outlined">
        settings
        </span>
    </a>

    <div class="container-fluid">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th colspan="6"> <h2>My Reminders</h2> </th>
                    <th> <a href='add_reminder.php' class='btn btn-success'><strong>+ ADD</strong></a> </th>
                </tr>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Repeat Interval</th>
                    <th colspan="2" style="text-align:center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Database connection 
                include 'sql_conn.php';

                $session_passed_emailid_for_validation = $_SESSION['session_passed_user_email'];

                // Query to fetch reminders from the 'reminders' table
                $sql = "SELECT * FROM reminders where emailid = '$session_passed_emailid_for_validation' and deleteflag = 0";
                $result = $conn->query($sql);

                // Display reminders in the table
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['title'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>" . $row['date'] . "</td>";
                        echo "<td>" . $row['time'] . "</td>";

                        if ($row['reminderinterval'] == 'everyday') {
                            $fetched_reminder_interval_colour_Class = 'text-success';
                            echo "<td> <p> <strong><span class='$fetched_reminder_interval_colour_Class'>" . $row['reminderinterval'] . "</span> </p> </td>";
                          } elseif ($row['reminderinterval'] == 'weekly') {
                                $fetched_reminder_interval_colour_Class = 'text-primary';
                                echo "<td> <p> <strong><span class='$fetched_reminder_interval_colour_Class'>" . $row['reminderinterval'] . "</span> </p> </td>";
                            }elseif ($row['reminderinterval'] == 'monthly') {
                                $fetched_reminder_interval_colour_Class = 'text-warning';
                                echo "<td> <p> <strong><span class='$fetched_reminder_interval_colour_Class'>" . $row['reminderinterval'] . "</span> </p> </td>";
                            }elseif ($row['reminderinterval'] == 'yearly') {
                                $fetched_reminder_interval_colour_Class = 'text-secondary';
                                echo "<td> <p> <strong><span class='$fetched_reminder_interval_colour_Class'>" . $row['reminderinterval'] . "</span> </p> </td>";
                            }

                        echo "<td><a href='modify_reminder.php?id=" . $row['id'] . "' class='btn btn-primary'>Modify</a></td>";
                        echo "<td><a href='delete_reminder.php?id=" . $row['id'] . "' class='btn btn-danger'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No reminders found.</td></tr>";
                }

                // Close the database connection
                $conn->close();
                ?>
            </tbody>
        </table>
        <div class="d-inline p-2 bg-success text-white">Daily</div>
        <div class="d-inline p-2 bg-primary text-white">Weekly</div>
        <div class="d-inline p-2 bg-warning text-white">Monthly</div>
        <div class="d-inline p-2 bg-secondary text-white">Yearly</div>
        <p> <i> *This displays the colour for the Repeat Interval. </i> </p>
    </div>
</body>
</html>
