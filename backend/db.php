<?php
$host = 'localhost';
$user = 'root';
$pass = '9709303105';
$db = 'pet_adoption';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
