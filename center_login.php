<?php
// Include the database connection
include('db_connect.php');
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if email and password are provided
    if (empty($email) || empty($password)) {
        echo "Please fill in both fields.";
    } else {
        // Prepare the query to find the user with the entered email and password
        $sql = "SELECT * FROM adopt_center WHERE email_id = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $password);  // "ss" means two string parameters
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the user exists
        if ($result->num_rows > 0) {
            // Fetch the user details
            $user = $result->fetch_assoc();
            // Store the user info in the session
            $_SESSION['center_id'] = $user['center_id'];
            $_SESSION['email'] = $user['email_id'];
            $_SESSION['name'] = $user['name'];

            // Redirect to the dashboard
            header("Location:center_dashboard.php");
            exit();
        } else {
            echo "Invalid email or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Adoption Center Login</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <h2>Center Login</h2>
  <form action="center_login.php" method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
  </form>

  <p>Don't have an account?</p>
  <a href="center_signup.php">
    <button type="button">Sign Up</button>
  </a>
</body>
</html>
