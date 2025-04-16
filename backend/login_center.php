<?php
include 'db.php';
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM Adopt_Center WHERE email_id = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $_SESSION['center'] = $result->fetch_assoc();
    header("Location: ../center-dashboard.html");
} else {
    echo "Invalid login.";
}
?>
