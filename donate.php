<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['center_id'])) {
    header("Location: center_login.php");
    exit();
}

// Handle the donation form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment_method'];
    $pet_id = $_POST['pet_id']; // Get pet_id for adoption

    // Validate the donation amount
    if (empty($amount) || !is_numeric($amount) || $amount <= 0) {
        $error_message = "Please enter a valid donation amount.";
    } else {
        include('db_connect.php');

        // Start a transaction to ensure both operations (donation and adoption) are completed
        $conn->begin_transaction();

        try {
            // Insert adoption record into the database
            $sql_adoption = "INSERT INTO pet_adoption (pet_id, reason_of_adoption, date, house_hold) 
                             VALUES (?, ?, NOW(), ?)";
            $stmt_adoption = $conn->prepare($sql_adoption);
            if (!$stmt_adoption) {
                throw new Exception("Adoption prepare failed: " . $conn->error);
            }
            $reason_of_adoption = "Donation-based adoption";
            $house_hold = "New Home"; // Replace with actual data if needed
            $stmt_adoption->bind_param("iss", $pet_id, $reason_of_adoption, $house_hold);
            if (!$stmt_adoption->execute()) {
                throw new Exception("Adoption execute failed: " . $stmt_adoption->error);
            }

            // Get the last inserted adoption_id
            $adoption_id = $conn->insert_id;

            // Insert donation record into the database
            $sql_donation = "INSERT INTO donate_fee (adoption_id, date, amount, buyer_info) VALUES (?, NOW(), ?, ?)";
            $stmt_donation = $conn->prepare($sql_donation);
            if (!$stmt_donation) {
                throw new Exception("Donation prepare failed: " . $conn->error);
            }
            $buyer_info = "Some buyer info"; // You can replace this with actual buyer data
            $stmt_donation->bind_param("ids", $adoption_id, $amount, $buyer_info);
            if (!$stmt_donation->execute()) {
                throw new Exception("Donation execute failed: " . $stmt_donation->error);
            }

            // Update pet status to adopted
            $sql_update_pet = "UPDATE pet_list SET donation = 1 WHERE pet_id = ?";
            $stmt_update_pet = $conn->prepare($sql_update_pet);
            if (!$stmt_update_pet) {
                throw new Exception("Pet update prepare failed: " . $conn->error);
            }
            $stmt_update_pet->bind_param("i", $pet_id);
            if (!$stmt_update_pet->execute()) {
                throw new Exception("Pet update execute failed: " . $stmt_update_pet->error);
            }

            // Commit if everything went well
            $conn->commit();
            $success_message = "Thank you for your donation! The pet has been adopted successfully.";
        } catch (Exception $e) {
            $conn->rollback();
            $error_message = "There was an error processing your donation and adoption. Please try again.";
            // Debug output
            echo "DEBUG ERROR: " . $e->getMessage();
        }
    }
}

// Fetch the list of adopted pets (for display)
include('db_connect.php');
$sql = "SELECT pet_id, pet_name, pet_image_url, pet_gender, pet_breed, pet_age FROM pet_list WHERE is_adopted = 1 AND donation = 0";
$pets_result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Page</title>
    <link rel="stylesheet" href="assets/css/donate.css">
    <script>
        function openDonationPopup(pet_id, pet_name, pet_image_url, pet_gender, pet_breed, pet_age) {
            document.getElementById('pet_id').value = pet_id;
            document.getElementById('pet_name').innerText = pet_name;
            document.getElementById('pet_image').src = pet_image_url;
            document.getElementById('pet_gender').innerText = 'Gender: ' + pet_gender;
            document.getElementById('pet_breed').innerText = 'Breed: ' + pet_breed;
            document.getElementById('pet_age').innerText = 'Age: ' + pet_age;
            document.getElementById('donationPopup').style.display = 'flex';
        }

        function closePopup() {
            document.getElementById('donationPopup').style.display = 'none';
        }
    </script>
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

    <main>
        <h2>Adopted Pets</h2>

        <?php
        if (isset($success_message)) {
            echo "<div class='success'>$success_message</div>";
        }
        if (isset($error_message)) {
            echo "<div class='error'>$error_message</div>";
        }

        if ($pets_result->num_rows > 0) {
            echo "<div class='pet-tiles'>";
            while ($pet = $pets_result->fetch_assoc()) {
                echo "<div class='pet-tile'>";
                echo "<img src='" . htmlspecialchars($pet['pet_image_url']) . "' alt='Pet Image'>";
                echo "<div class='pet-info'>";
                echo "<h3>" . htmlspecialchars($pet['pet_name']) . "</h3>";
                echo "<p><strong>Gender:</strong> " . htmlspecialchars($pet['pet_gender']) . "</p>";
                echo "<p><strong>Breed:</strong> " . htmlspecialchars($pet['pet_breed']) . "</p>";
                echo "<p><strong>Age:</strong> " . htmlspecialchars($pet['pet_age']) . "</p>";
                echo "</div>";
                echo "<button class='donate-btn' onclick='openDonationPopup(" . $pet['pet_id'] . ", \"" . htmlspecialchars($pet['pet_name']) . "\", \"" . htmlspecialchars($pet['pet_image_url']) . "\", \"" . htmlspecialchars($pet['pet_gender']) . "\", \"" . htmlspecialchars($pet['pet_breed']) . "\", \"" . htmlspecialchars($pet['pet_age']) . "\")'>Donate</button>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<p>No pets have been adopted yet.</p>";
        }
        ?>

        <div id="donationPopup" class="popup">
            <div class="popup-content">
                <span class="close-btn" onclick="closePopup()">&times;</span>
                <h3>Donate for Pet Adoption</h3>
                <div class="pet-details">
                    <img id="pet_image" src="" alt="Pet Image" />
                    <h4 id="pet_name"></h4>
                    <p id="pet_gender"></p>
                    <p id="pet_breed"></p>
                    <p id="pet_age"></p>
                </div>

                <form action="donate.php" method="POST">
                    <label for="amount">Donation Amount:</label>
                    <input type="number" name="amount" id="amount" placeholder="Enter amount" required>

                    <label for="payment_method">Payment Method:</label>
                    <select name="payment_method" id="payment_method" required>
                        <option value="Credit Card">Credit Card</option>
                        <option value="Debit Card">Debit Card</option>
                        <option value="PayPal">PayPal</option>
                    </select>

                    <input type="hidden" name="pet_id" id="pet_id">

                    <button type="submit">Donate</button>
                </form>
            </div>
        </div>

    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Pet Adoption Center</p>
    </footer>
</body>

</html>