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

// Check if the request ID is passed in the URL
if (isset($_GET['id'])) {
    $request_id = $_GET['id'];

    // Sanitize the input to avoid SQL injection
    $request_id = $conn->real_escape_string($request_id);

    // Update the status of the request to 'rejected'
    $sql = "UPDATE requests SET status='rejected' WHERE id='$request_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Request has been rejected.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "No request ID provided.";
}

$conn->close();
?>
