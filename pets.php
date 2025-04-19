<?php
include('db_connect.php');
session_start();

if (!isset($_SESSION['center_id'])) {
    header("Location: center_login.php");
    exit();
}

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_pet'])) {
    $pet_name = $_POST['pet_name'];
    $pet_gender = $_POST['pet_gender'];
    $pet_breed = $_POST['pet_breed'];
    $pet_age = intval($_POST['pet_age']);
    $pet_image_url = $_POST['pet_image_url']; // New image URL input

    if (!empty($pet_name) && !empty($pet_gender) && !empty($pet_breed) && !empty($pet_age) && !empty($pet_image_url)) {
        $sql = "INSERT INTO pet_list (center_id, pet_name, pet_gender, pet_breed, pet_age, pet_image_url) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("isssis", $_SESSION['center_id'], $pet_name, $pet_gender, $pet_breed, $pet_age, $pet_image_url);
            if ($stmt->execute()) {
                $success = "Pet added successfully!";
            } else {
                $error = "Failed to add pet. Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error = "Database error (Insert): " . $conn->error;
        }
    } else {
        $error = "All fields are required.";
    }
}

if (isset($_GET['success']) && $_GET['success'] == 1) {
    $success = "Adoption form submitted successfully!";
}


// Fetch pets
$pets = null;
$sql = "SELECT * FROM pet_list WHERE center_id = ? AND is_adopted = 0";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("i", $_SESSION['center_id']);
    if ($stmt->execute()) {
        $pets = $stmt->get_result();
    } else {
        $error = "Failed to fetch pets. Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    $error = "Database error (Select): " . $conn->error;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Pet Management</title>
    <link rel="stylesheet" href="assets/css/pets.css">
</head>

<body>
    <header>
        <h1>Welcome, <?php echo $_SESSION['name']; ?></h1>
        <nav>
            <ul>
                <li><a href="center_dashboard.php">Dashboard</a></li>
                <li><a href="javascript:void(0);" id="profileLink">Profile</a></li>
                <li><a href="pets.php">Rehoming</a></li>
                <li><a href="donate.php">Donations</a></li>
                <li><a href="pets.php">Pet List</a></li>
                <li><a href="pet_logs.php">Pet Logs</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <?php if (!empty($error)): ?>
        <div class="message error"><?= htmlspecialchars($error) ?></div>
    <?php elseif (!empty($success)): ?>
        <div class="message success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <h2>Add New Pet</h2>
    <form method="POST" action="pets.php">
        <input type="text" name="pet_name" placeholder="Pet Name" required>
        <select name="pet_gender" required>
            <option value="">Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
        <input type="text" name="pet_breed" placeholder="Breed" required>
        <input type="number" name="pet_age" placeholder="Age" required>
        <input type="text" name="pet_image_url" placeholder="Pet Image URL" required> <!-- New field for image URL -->
        <button type="submit" name="add_pet">Add Pet</button>
    </form>

    <h2>Your Pets</h2>
    <?php if ($pets && $pets->num_rows > 0): ?>
        <div class="pet-tiles">
            <?php while ($pet = $pets->fetch_assoc()): ?>
                <div class="pet-tile">
                    <img src="<?= htmlspecialchars($pet['pet_image_url']) ?>" alt="Pet Image">
                    <div class="pet-info">
                        <h3><?= htmlspecialchars($pet['pet_name']) ?></h3>
                        <p><strong>Gender:</strong> <?= htmlspecialchars($pet['pet_gender']) ?></p>
                        <p><strong>Breed:</strong> <?= htmlspecialchars($pet['pet_breed']) ?></p>
                        <p><strong>Age:</strong> <?= htmlspecialchars($pet['pet_age']) ?></p>
                    </div>
                    <button class="adopt-btn" onclick="openAdoptionForm(<?= $pet['pet_id'] ?>, '<?= htmlspecialchars($pet['pet_name']) ?>')">Adopt</button>

                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>No pets found for your center.</p>
    <?php endif; ?>
    <div id="adoptionModal" class="adopt-modal">
    <div class="adoption-modal-content">
        <span class="close" id="closeAdoptionModalBtn">&times;</span>
        <h2>Adopt <span id="adoptPetName"></span></h2>
        <form id="adoptionForm" method="POST" action="process_adoption.php">
            <input type="hidden" name="pet_id" id="modalPetId">
            <label>Reason for Adoption:</label>
            <textarea name="reason_of_adoption" required></textarea>
            <label>Date:</label>
            <input type="date" name="date" required>
            <label>Household Type:</label>
            <input type="text" name="house_hold" required>
            <button type="submit" name="submit_adoption">Submit Adoption</button>
        </form>
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

<script src="assets/js/pets.js"></script>

</html>