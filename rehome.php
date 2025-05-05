<?php
include('db_connect.php');
session_start();

if (!isset($_SESSION['center_id'])) {
    header("Location: center_login.php");
    exit();
}


$message = '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $center_id = $_SESSION['center_id'];
    $pet_name = trim($_POST['pet_name']);
    $pet_gender = trim($_POST['pet_gender']);
    $pet_breed = trim($_POST['pet_breed']);
    $pet_age = intval($_POST['pet_age']);
    $pet_image_url = trim($_POST['pet_image_url']);

    if ($pet_name && $pet_gender && $pet_breed && $pet_age > 0 && $pet_image_url) {
        $stmt = $conn->prepare("INSERT INTO pet_list (center_id, pet_name, pet_gender, pet_breed, pet_age, pet_image_url) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssis", $center_id, $pet_name, $pet_gender, $pet_breed, $pet_age, $pet_image_url);
        if ($stmt->execute()) {
            $message = "✅ Pet added successfully.";
        } else {
            $message = "❌ Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "❌ Please fill all fields correctly.";
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Pet Management</title>
    <link rel="stylesheet" href="assets/css/rehoming.css">
</head>

<body>
    <header>
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?></h1>
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


    <?php if ($message): ?>
        <div class="message <?= str_starts_with($message, '❌') ? 'error' : '' ?>">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="rehome.php">
        <h2>Rehome a Pet</h2>
        <input type="text" name="pet_name" placeholder="Pet Name" required>
        <select name="pet_gender" required>
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
        <input type="text" name="pet_breed" placeholder="Pet Breed" required>
        <input type="number" name="pet_age" placeholder="Pet Age" min="1" required>
        <input type="text" name="pet_image_url" placeholder="Pet Image URL" required>
        <button type="submit">Add Pet</button>
    </form>

    <!-- Profile Modal -->
    <div id="profileModal" class="modal">
        <div class="modal-content">
            <span class="close-btn"
                onclick="document.getElementById('profileModal').style.display='none'">&times;</span>
            <div id="profileContent">
                <p><strong>Name:</strong> <?= htmlspecialchars($_SESSION['name']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($_SESSION['email']) ?></p>
                <p><strong>Center ID:</strong> <?= htmlspecialchars($_SESSION['center_id']) ?></p>
            </div>
        </div>
    </div>
</body>

</html>