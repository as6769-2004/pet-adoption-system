<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['center_id'])) {
    header("Location: center_login.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Center Dashboard</title>
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>

<body>
    <header>
        <h1>Welcome, <?php echo $_SESSION['name']; ?></h1>
        <nav>
            <ul>
                <li><a href="center_dashboard.php">Dashboard</a></li>
                <li><a href="javascript:void(0);" id="profileLink">Profile</a></li>
                <li><a href="rehome.php">Rehoming</a></li>
                <li><a href="donate.php">Donations</a></li>
                <li><a href="pets.php">Pet List</a></li>
                <li><a href="pet_logs.php">Pet Logs</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <h2>Center Dashboard</h2>
        <p>Manage your pets, adoptions, donations, and more from here.</p>
    </div>

    <!-- Profile Modal (Popup) -->
    <div id="profileModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="profileContent">
                <!-- You can dynamically load profile content here, for example: -->
                <p><strong>Name:</strong> <?php echo $_SESSION['name']; ?></p>
                <p><strong>Email:</strong> <?php echo $_SESSION['email']; ?></p>
                <p><strong>Center ID:</strong> <?php echo $_SESSION['center_id']; ?></p>
                <!-- Add more user details as needed -->
            </div>
        </div>
    </div>

    <script src="assets/js/profile-modal.js"></script>
</body>

</html>