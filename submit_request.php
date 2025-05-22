<?php
session_start();

// Make sure the employee is logged in
if (!isset($_SESSION['employee_id'])) {
    die("You are not logged in.");
}

$conn = new mysqli('localhost', 'root', '', 'attendance_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the employee_id from session
    $employee_id = $_SESSION['employee_id'];

    // Get other form data
    $attendance_date = $_POST['attendance_date'];
    $reason = $_POST['reason'];
    
    // Sanitize the inputs to avoid SQL injection
    $attendance_date = $conn->real_escape_string($attendance_date);
    $reason = $conn->real_escape_string($reason);

    // Prepare the SQL query
    $sql = "INSERT INTO requests (employee_id, attendance_date, reason, status) 
            VALUES ('$employee_id', '$attendance_date', '$reason', 'pending')";

    if ($conn->query($sql) === TRUE) {
        echo "Request submitted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Request</title>
</head>
<body>
    <h2>Submit Attendance Request</h2>
    
    <!-- Form to submit the request -->
    <form action="" method="POST">
        <label for="attendance_date">Attendance Date:</label>
        <input type="date" id="attendance_date" name="attendance_date" required><br><br>

        <label for="reason">Reason:</label>
        <textarea id="reason" name="reason" required></textarea><br><br>

        <button type="submit">Submit Request</button>
    </form>

    <!-- Back Button to Employee Portal -->
    <br><br>
    <a href="employee_portal.php">Back to Employee Portal</a>

</body>
</html>
