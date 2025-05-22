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

// Get the employee ID from the session
$employee_id = $_SESSION['employee_id'];

// Fetch employee name based on employee ID
$sql_employee = "SELECT name FROM employees WHERE employee_id='$employee_id'";
$result_employee = $conn->query($sql_employee);
$employee = $result_employee->fetch_assoc();

// Query to fetch the status of the employee's leave requests
$sql_requests = "SELECT attendance_date, reason, status FROM requests WHERE employee_id='$employee_id' ORDER BY attendance_date DESC";
$result_requests = $conn->query($sql_requests);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Portal</title>
</head>
<body>
    <h2>Employee Portal</h2>

    <!-- Display Employee Name and ID -->
    <p><strong>Name:</strong> <?php echo $employee['name']; ?></p>
    <p><strong>Employee ID:</strong> <?php echo $employee_id; ?></p>

    <!-- Link to Leave Request Form -->
    <p><a href="submit_request.php">Request for Leave</a></p>

    <h3>Your Leave Requests</h3>
    <?php
    if ($result_requests->num_rows > 0) {
        // Loop through and display each request
        echo "<table border='1'>";
        echo "<tr><th>Attendance Date</th><th>Reason</th><th>Status</th></tr>";
        while ($row = $result_requests->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['attendance_date'] . "</td>";
            echo "<td>" . $row['reason'] . "</td>";
            echo "<td>" . ucfirst($row['status']) . "</td>"; // Display status (Sent, Approved, Rejected)
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>You have not made any leave requests yet.</p>";
    }
    ?>

</body>
</html>

<?php
$conn->close();
?>
