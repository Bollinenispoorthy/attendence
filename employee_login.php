<?php
session_start();

// Check if the form was submitted and the POST data exists
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if 'employee_id' and 'password' keys exist in $_POST
    if (isset($_POST['employee_id']) && isset($_POST['password'])) {
        $employee_id = $_POST['employee_id'];
        $password = $_POST['password'];

        // Connect to the database
        $conn = new mysqli('localhost', 'root', '', 'attendance_db');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query the database to check if the employee exists
        $sql = "SELECT * FROM employees WHERE employee_id = '$employee_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Employee found, check if the password matches
            $employee = $result->fetch_assoc();
            if (password_verify($password, $employee['password'])) {
                // Password is correct, log the employee in
                $_SESSION['employee_id'] = $employee['employee_id'];
                $_SESSION['employee_name'] = $employee['name'];
                header("Location: employee_portal.php"); // Redirect to the attendance request page
                exit();
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "No such employee found.";
        }

        $conn->close();
    } else {
        echo "Please enter both Employee ID and Password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Login</title>
</head>
<body>
    <h2>Employee Login</h2>

    <!-- Login form -->
    <form action="employee_login.php" method="POST">
        <label for="employee_id">Employee ID:</label>
        <input type="text" id="employee_id" name="employee_id" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>

</body>
</html>
