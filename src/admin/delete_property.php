<?php
session_start();
@include "../conn.php";

// Check if a property ID is sent for deletion
if (isset($_POST['property_id'])) {
    $propertyID = $_POST['property_id'];
    $userID = $_SESSION['UserID'];

    // Delete associated images first
    $deleteImagesSQL = "DELETE FROM PropertyImages WHERE property_id = '$propertyID'";
    if (mysqli_query($connection, $deleteImagesSQL)) {
        // Then delete the property
        $deletePropertySQL = "DELETE FROM Properties WHERE property_id = '$propertyID'";
        if (mysqli_query($connection, $deletePropertySQL)) {
            echo "Property and associated images deleted successfully.";
            header("location: dashboard.php");
        } else {
            echo "Error deleting property: " . mysqli_error($connection);
        }
    } else {
        echo "Error deleting associated images: " . mysqli_error($connection);
    }
} else {
    echo "No property ID provided for deletion.";
}
?>
