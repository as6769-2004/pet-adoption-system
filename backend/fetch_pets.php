<?php
include 'db.php';

$sql = "SELECT * FROM Pet_List WHERE is_adopted = 0";
$result = $conn->query($sql);

$pets = [];
while($row = $result->fetch_assoc()) {
    $pets[] = $row;
}
echo json_encode($pets);
?>
