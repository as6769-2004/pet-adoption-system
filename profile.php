<?php
session_start();
include('db_connect.php');

// Check if the user is logged in
if (!isset($_SESSION['center_id'])) {
    echo "You must be logged in to view this page.";
    exit();
}

$center_id = $_SESSION['center_id'];

// Fetch the center details from the database
$sql = "SELECT * FROM adopt_center WHERE center_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $center_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $center = $result->fetch_assoc();
} else {
    echo "No data found for this center.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $shop_no = $_POST['shop_no'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate the fields
    if (empty($shop_no) || empty($name) || empty($address) || empty($email) || empty($password)) {
        echo "Please fill in all fields.";
    } else {
        // Update the center details in the database
        $update_sql = "UPDATE adopt_center SET shop_no = ?, name = ?, address = ?, email_id = ?, password = ? WHERE center_id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("sssssi", $shop_no, $name, $address, $email, $password, $center_id);
        
        if ($stmt->execute()) {
            echo "Profile updated successfully.";
            header("Location:center_dashboard.php");
            exit();
        } else {
            echo "Error updating profile: " . $stmt->error;
        }
    }
}
?>

<!-- Profile form -->
 <html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>
<h2>Edit Profile</h2>
<form action="profile.php" method="POST">
    <input type="text" name="shop_no" value="<?php echo $center['shop_no']; ?>" placeholder="Shop No" required>
    <input type="text" name="name" value="<?php echo $center['name']; ?>" placeholder="Center Name" required>
    <input type="text" name="address" value="<?php echo $center['address']; ?>" placeholder="Center Address" required>
    <input type="email" name="email" value="<?php echo $center['email_id']; ?>" placeholder="Email" required>
    <input type="password" name="password" value="<?php echo $center['password']; ?>" placeholder="Password" required>
    <button type="submit">Update Profile</button>
</form>

</body>
</html>
