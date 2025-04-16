<?php
include 'db.php';

$donation_id = $_POST['donation_id'];
$name = $_POST['name'];
$breed = $_POST['breed'];
$age = $_POST['age'];

$sql = "INSERT INTO Rehoming (donation_id, Rpet_name, Rpet_Breed, Rpet_age) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("issi", $donation_id, $name, $breed, $age);

if ($stmt->execute()) {
    echo "Rehoming request submitted!";
} else {
    echo "Failed to submit rehoming.";
}
?>
