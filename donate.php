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
    
    // Validate the donation amount
    if (empty($amount) || !is_numeric($amount) || $amount <= 0) {
        $error_message = "Please enter a valid donation amount.";
    } else {
        // Insert donation record into the database (assuming you have a donations table)
        include('db_connect.php');
        
        // Prepare the query to insert the donation
        $sql = "INSERT INTO donations (center_id, amount, payment_method, donation_date) 
                VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ids", $_SESSION['center_id'], $amount, $payment_method);
        
        if ($stmt->execute()) {
            $success_message = "Thank you for your generous donation!";
        } else {
            $error_message = "There was an error processing your donation. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Page</title>
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>
    <header>
        <h1>Welcome, <?php echo $_SESSION['name']; ?></h1>
        <nav>
            <ul>
                <li><a href="center_dashboard.php">Dashboard</a></li>
                <li><a href="rehome.php">Rehoming</a></li>
                <li><a href="pets.php">Pet List</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Make a Donation</h2>

        <?php
        // Display success or error messages
        if (isset($success_message)) {
            echo "<div class='success'>$success_message</div>";
        }
        if (isset($error_message)) {
            echo "<div class='error'>$error_message</div>";
        }
        ?>

        <form action="donate.php" method="POST">
            <label for="amount">Donation Amount:</label>
            <input type="number" name="amount" id="amount" placeholder="Enter amount" required>

            <label for="payment_method">Payment Method:</label>
            <select name="payment_method" id="payment_method" required>
                <option value="Credit Card">Credit Card</option>
                <option value="Debit Card">Debit Card</option>
                <option value="PayPal">PayPal</option>
            </select>

            <button type="submit">Donate</button>
        </form>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Pet Adoption Center</p>
    </footer>
</body>
</html>
