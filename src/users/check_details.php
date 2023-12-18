<?php
session_start();
@include "../conn.php";

if (isset($_SESSION['UserID'])) {
    // Assuming the property_id is passed via GET parameter
    if (isset($_GET['property_id'])) {
        $property_id = $_GET['property_id'];

        // Fetch property details using property_id
        $propertyQuery = "SELECT * FROM Properties WHERE property_id = '$property_id'";
        $propertyResult = mysqli_query($connection, $propertyQuery);

        if (!$propertyResult) {
            echo "Error fetching property details: " . mysqli_error($connection);
        } else {
            $property = mysqli_fetch_assoc($propertyResult);
            include 'header.html';
            echo "<h1>Property Details</h1>";
            echo "<p>Property Name: " . $property['property_name'] . "</p>";
            echo "<p>Description: " . $property['description'] . "</p>";
            // Add more property details as needed
            echo "<form action='process_booking.php' method='POST'>";
            echo "<input type='hidden' name='property_id' value='" . $property['property_id'] . "'>";
            echo "<input type='date' name='date_from' required>";
            echo "<input type='date' name='date_to' required>";
            echo "<input type='number' name='guests' placeholder='Number of guests' required>";
            echo "<button type='submit' class='btn btn-secondary'>Book Now</button>";
            echo "</form>";

            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "Property ID not provided.";
    }
} else {
    // Redirect to login if user is not logged in
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en" data-theme='dark'>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../dist/output.css">
</head>

<body>
    
</body>
</html>