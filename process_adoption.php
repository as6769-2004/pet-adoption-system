<?php
include('db_connect.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_adoption'])) {
    $pet_id = $_POST['pet_id'];
    $reason = $_POST['reason_of_adoption'];
    $date = $_POST['date'];
    $house = $_POST['house_hold'];

    // Begin a transaction to ensure both operations (insertion and update) are executed together
    $conn->begin_transaction();

    try {
        // Insert the adoption request into pet_adoption table
        $stmt = $conn->prepare("INSERT INTO pet_adoption (pet_id, reason_of_adoption, date, house_hold) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("isss", $pet_id, $reason, $date, $house);
            if (!$stmt->execute()) {
                throw new Exception("Error inserting adoption request: " . $stmt->error);
            }
            $stmt->close();
        } else {
            throw new Exception("DB Error (Insert into pet_adoption): " . $conn->error);
        }

        // Update the pet's is_adopted status to 1 (adopted) in pet_list table
        $update_stmt = $conn->prepare("UPDATE pet_list SET is_adopted = 1 WHERE pet_id = ?");
        if ($update_stmt) {
            $update_stmt->bind_param("i", $pet_id);
            if (!$update_stmt->execute()) {
                throw new Exception("Error updating pet adoption status: " . $update_stmt->error);
            }
            $update_stmt->close();
        } else {
            throw new Exception("DB Error (Update pet adoption status): " . $conn->error);
        }

        // Commit the transaction if both queries are successful
        $conn->commit();

        // Redirect to pets page with success message
        header("Location: pets.php?success=1");
        exit();

    } catch (Exception $e) {
        // Rollback transaction in case of error
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
}
?>
