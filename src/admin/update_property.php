<?php
session_start();
@include "../conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['UserID'])) {
    $userID = $_SESSION['UserID'];
    $property_id = $_POST['property_id'];
    $newTitle = $_POST['title'];
    // Retrieve other fields from the form for modification

    // Verify user's ownership of the property before update
    $checkOwnershipSQL = "SELECT * FROM Properties WHERE property_id = '$property_id' AND admin_id = '$userID'";
    $ownershipResult = mysqli_query($connection, $checkOwnershipSQL);

    if ($ownershipResult && mysqli_num_rows($ownershipResult) > 0) {
        // Update the property details in the database
        $updateSQL = "UPDATE Properties SET property_name = '$newTitle' WHERE property_id = '$property_id'";
        // Update other property fields as needed in the query

        if (mysqli_query($connection, $updateSQL)) {
            // Property details updated successfully
            header("Location: manage_properties.php");
            exit();
        } else {
            echo "Error updating property: " . mysqli_error($connection);
        }
    } else {
        echo "Unauthorized update: You do not own this property.";
    }
} else {
    // Redirect if user is not logged in or POST data is missing
    header("Location: ../login.php");
    exit();
}
?>
