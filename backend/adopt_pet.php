<?php
include 'db.php';

$pet_id = $_POST['pet_id'];
$house_hold = $_POST['house_hold'];
$reason = $_POST['reason'];
$date = $_POST['date'];

$sql = "INSERT INTO Pet_Adoption (pet_id, Reason_of_adoption, date, house_hold) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isss", $pet_id, $reason, $date, $house_hold);

if ($stmt->execute()) {
    $conn->query("UPDATE Pet_List SET is_adopted = 1 WHERE pet_id = $pet_id");
    echo "Adoption successful!";
} else {
    echo "Failed to adopt.";
}
?>
