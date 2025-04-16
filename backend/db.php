<?php
$host = 'localhost';
$user = 'root';
$pass = '9709303105';
$db = 'pet_adoption_system';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
