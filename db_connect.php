<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "9709303105";
$dbname = "pet_adoption_db"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
