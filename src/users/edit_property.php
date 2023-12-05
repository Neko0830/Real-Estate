<?php
session_start();
@include "../conn.php";

if (isset($_SESSION['UserID']) && isset($_GET['property_id'])) {
    $userID = $_SESSION['UserID'];
    $propertyID = $_GET['property_id'];

    // Fetch property details based on PropertyID and UserID
    $sql = "SELECT * FROM Properties WHERE PropertyID = '$propertyID' AND UserID = '$userID'";
    $result = mysqli_query($connection, $sql);

    if (!$result) {
        echo "Error fetching property: " . mysqli_error($connection);
    } else {
        $property = mysqli_fetch_assoc($result);
    }
} else {
    // Redirect if user is not logged in or property ID is missing
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Property</title>
    <link rel="stylesheet" href="../../dist/output.css">
</head>

<body>
    <h2>Edit Property</h2>
    <form action="update_property.php" method="POST">
        <input type="hidden" name="property_id" value="<?php echo $property['PropertyID']; ?>">

        <!-- Editable fields (e.g., title, description, price, etc.) -->
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" value="<?php echo $property['Title']; ?>" required><br><br>

        <!-- Add other property fields for editing -->

        <input type="submit" value="Save Changes">
    </form>

    <a href="manage_properties.php">Back to Manage Properties</a>
    
</body>

</html>
