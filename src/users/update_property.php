<?php
session_start();
@include "../conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['UserID'])) {
    $userID = $_SESSION['UserID'];
    $propertyID = $_POST['property_id'];
    $newTitle = $_POST['title'];
    // Retrieve other fields from the form for modification

    // Verify user's ownership of the property before update
    $checkOwnershipSQL = "SELECT * FROM Properties WHERE PropertyID = '$propertyID' AND UserID = '$userID'";
    $ownershipResult = mysqli_query($connection, $checkOwnershipSQL);

    if ($ownershipResult && mysqli_num_rows($ownershipResult) > 0) {
        // Update the property details in the database
        $updateSQL = "UPDATE Properties SET Title = '$newTitle' WHERE PropertyID = '$propertyID'";
        // Update other property fields as needed in the query

        if (mysqli_query($connection, $updateSQL)) {
            // Property details updated successfully
            header("Location: edit_property.php?property_id=$propertyID");
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
