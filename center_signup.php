<?php
include('db_connect.php');
session_start();

ini_set('display_errors', 1); // To show PHP errors
error_reporting(E_ALL);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get POST data
    $shop_no = $_POST['shop_no'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate if fields are not empty
    if (empty($shop_no) || empty($name) || empty($address) || empty($email) || empty($password)) {
        echo "Please fill in all fields.";
    } else {
        // Insert new center record
        $sql = "INSERT INTO adopt_center (shop_no, name, address, email_id, password) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            // Handle error with prepare statement
            die('MySQL prepare error: ' . $conn->error);
        }

        // Bind parameters
        $stmt->bind_param("sssss", $shop_no, $name, $address, $email, $password);

        // Execute query and check for errors
        if ($stmt->execute()) {
            // Redirect to login page after successful sign-up
            header("Location:  center_login.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Adoption Center</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <h2>Center Sign Up</h2>
    <form action="center_signup.php" method="POST">
        <input type="text" name="shop_no" placeholder="Shop No" required>
        <input type="text" name="name" placeholder="Center Name" required>
        <input type="text" name="address" placeholder="Center Address" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Sign Up</button>
    </form>

    <p>Already have an account?</p>
    <a href="center_login.php">
        <button type="button">Login</button>
    </a>
</body>
</html>
