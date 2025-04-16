<?php
include 'db.php';

$name = $_POST['name'];
$breed = $_POST['breed'];
$gender = $_POST['gender'];
$age = $_POST['age'];
$center = $_POST['center_id'];

$sql = "INSERT INTO Pet_List (Centre_id, pet_name, pet_gender, pet_breed, pet_age) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isssi", $center, $name, $gender, $breed, $age);

if ($stmt->execute()) {
    echo "Pet added successfully!";
} else {
    echo "Error adding pet.";
}
?>
