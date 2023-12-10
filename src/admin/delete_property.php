<?php
session_start();
@include "../conn.php";

// Check if a property ID is sent for deletion
if (isset($_POST['property_id'])) {
    $propertyID = $_POST['property_id'];
    $userID = $_SESSION['UserID'];

    // Fetch property details to check ownership
    $propertySQL = "SELECT UserID FROM Properties WHERE PropertyID = '$propertyID'";
    $propertyResult = mysqli_query($connection, $propertySQL);

    if ($propertyResult) {
        if (mysqli_num_rows($propertyResult) > 0) {
            $propertyData = mysqli_fetch_assoc($propertyResult);

            // Check if the logged-in user owns the property
            if ($propertyData['UserID'] == $userID) {
                // Delete the property if ownership is confirmed
                $deleteSQL = "DELETE FROM Properties WHERE PropertyID = '$propertyID'";
                if (mysqli_query($connection, $deleteSQL)) {
                    echo "Property deleted successfully.";
                    // Redirect or handle the response as needed after deletion
                } else {
                    echo "Error deleting property: " . mysqli_error($connection);
                }
            } else {
                echo "Unauthorized deletion: You do not own this property.";
            }
        } else {
            echo "Error: Property not found.";
        }
    } else {
        echo "Error fetching property details: " . mysqli_error($connection);
    }
} else {
    echo "No property ID provided for deletion.";
}
?>
