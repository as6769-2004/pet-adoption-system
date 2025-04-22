<?php
// Include the database connection
include('db_connect.php');
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['name'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM pet_log";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Pet Logs</title>
    <link rel="stylesheet" href="assets/css/pet_logs.css" />
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

    <main>
        <h2>Pet Logs</h2>

        <div class="tiles-container">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="pet-tile" onclick='showPetDetails(<?php echo json_encode($row); ?>)'>
                        <img src="<?php echo htmlspecialchars($row['pet_image_url']); ?>" class="pet-image" alt="Pet Image">
                        <div class="pet-info">
                            <h3><?php echo htmlspecialchars($row['pet_name']); ?></h3>
                            <p><strong>Breed:</strong> <?php echo htmlspecialchars($row['pet_breed']); ?></p>
                            <p><strong>Gender:</strong> <?php echo htmlspecialchars($row['pet_gender']); ?></p>
                            <p><strong>Age:</strong> <?php echo htmlspecialchars($row['pet_age']); ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="no-records">No logs found.</div>
            <?php endif; ?>
            <?php $conn->close(); ?>
        </div>
    </main>

    <!-- Pet Detail Modal -->
    <div id="petDetailModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <div id="modalDetails"></div>
        </div>
    </div>

    <!-- Profile Modal -->
    <div id="profileModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="document.getElementById('profileModal').style.display='none'">&times;</span>
            <div id="profileContent">
                <p><strong>Name:</strong> <?php echo htmlspecialchars($_SESSION['name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
                <p><strong>Center ID:</strong> <?php echo htmlspecialchars($_SESSION['center_id']); ?></p>
            </div>
        </div>
    </div>



</body>
<script src="assets/js/pets_logs_script.js"></script>

</html>