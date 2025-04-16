<?php
include 'db.php';

$name = $_POST['name'];
$email = $_POST['email'];
$amount = $_POST['amount'];

$sql = "INSERT INTO donations (donor_name, donor_email, amount) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssd", $name, $email, $amount);

if ($stmt->execute()) {
    echo "Thank you for your donation!";
} else {
    echo "Donation failed.";
}
?>
