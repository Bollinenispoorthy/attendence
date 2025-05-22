<?php
session_start();

// Check if the HR is logged in
if (!isset($_SESSION['hr_id'])) {
    die("You are not logged in.");
}

$conn = new mysqli('localhost', 'root', '', 'attendance_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch all leave requests (pending)
$sql = "SELECT r.id, r.attendance_date, r.reason, r.status, e.name as employee_name, e.employee_id 
        FROM requests r
        JOIN employees e ON r.employee_id = e.employee_id
        WHERE r.status = 'pending'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Requests</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Leave Requests</h2>

        <!-- Display all pending leave requests -->
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Employee ID</th>
                    <th>Attendance Date</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['employee_name'] . "</td>";
                        echo "<td>" . $row['employee_id'] . "</td>";
                        echo "<td>" . $row['attendance_date'] . "</td>";
                        echo "<td>" . $row['reason'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "<td><a href='approve_request.php?id=" . $row['id'] . "'>Approve</a> | <a href='reject_request.php?id=" . $row['id'] . "'>Reject</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No requests found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
