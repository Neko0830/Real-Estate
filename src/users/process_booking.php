<?php
session_start();
@include "../conn.php";

if (isset($_SESSION['UserID'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['property_id']) && isset($_POST['date_from']) && isset($_POST['date_to']) && isset($_POST['guests'])) {
        $userID = $_SESSION['UserID'];
        $property_id = $_POST['property_id'];
        $date_from = $_POST['date_from'];
        $date_to = $_POST['date_to'];
        $guests = $_POST['guests'];

        // Insert booking details into the Bookings table
        $insertQuery = "INSERT INTO Bookings (user_id, property_id, date_from, date_to, guests, status) 
                        VALUES ('$userID', '$property_id', '$date_from', '$date_to', '$guests', 'pending')";

        $result = mysqli_query($connection, $insertQuery);

        if (!$result) {
            echo "Error processing booking: " . mysqli_error($connection);
        } else {
            echo "Booking processed successfully!";
            // Additional actions after successful booking processing, if needed
        }
    } else {
        echo "Invalid request parameters.";
    }
} else {
    // Redirect to login if user is not logged in
    header("Location: ../login.php");
    exit();
}

?>
