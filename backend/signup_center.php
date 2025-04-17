<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $shop_no = $_POST['shop_no'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $password = $_POST['password']; // You can hash this

    // Optional: Hash password for security
    // $password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO adopt_center (shop_no, name, address, email_id, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $shop_no, $name, $address, $email, $password);

    if ($stmt->execute()) {
        echo "Signup successful. <a href='../center_login.html'>Login here</a>";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
