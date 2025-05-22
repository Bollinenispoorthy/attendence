<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'attendance_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = $_POST['employee_id'];
    $employee_name = $_POST['employee_name'];
    $password = $_POST['password'];

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert employee data into the employees table
    $sql = "INSERT INTO employees (employee_id, name, password) VALUES ('$employee_id', '$employee_name', '$hashed_password')";
    if ($conn->query($sql) === TRUE) {
        echo "Employee account created successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
