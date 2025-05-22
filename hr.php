<?php
session_start();

// Fixed HR credentials
$hr_id = 'HR001';  // Fixed HR Employee ID
$hr_password = 'hrpassword';  // Fixed HR password

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if employee_id and password are set in the POST array
    if (isset($_POST['employee_id']) && isset($_POST['password'])) {
        $employee_id = $_POST['employee_id'];
        $password = $_POST['password'];

        // Check if the entered credentials match the fixed HR credentials
        if ($employee_id == $hr_id && $password == $hr_password) {
            // HR login successful, set session variable
            $_SESSION['hr_id'] = $hr_id;
            header("Location: hr_requests.php"); // Redirect to the requests page
            exit();
        } else {
            echo "Invalid Employee ID or Password.";
        }
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
    <title>HR Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>HR Login</h2>
        <form action="hr.php" method="POST">
            <label for="employee_id">Employee ID:</label>
            <input type="text" id="employee_id" name="employee_id" required><br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
