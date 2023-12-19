<?php
session_start();
@include "../conn.php";

if (isset($_SESSION['UserID']) && isset($_GET['property_id'])) {
    $userID = $_SESSION['UserID'];
    $propertyID = $_GET['property_id'];

    // Fetch property details based on property_id and UserID
    $sql = "SELECT * FROM Properties WHERE property_id = '$propertyID' AND admin_id = '$userID'";
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
    <form class='mb-4 'action="update_property.php" method="POST">
        <input type="hidden" name="property_id" value="<?php echo $property['property_id']; ?>">

        <!-- Editable fields -->
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" value="<?php echo $property['property_name']; ?>" required><br><br>

        <label for="address">Address:</label><br>
        <input type="text" id="address" name="address" value="<?php echo $property['address']; ?>" required><br><br>

        <label for="city">City:</label><br>
        <input type="text" id="city" name="city" value="<?php echo $property['city']; ?>" required><br><br>

        <label for="country">Country:</label><br>
        <input type="text" id="country" name="country" value="<?php echo $property['country']; ?>" required><br><br>

        <label for="description">Description:</label><br>
        <textarea id="description" name="description" required><?php echo $property['description']; ?></textarea><br><br>

        <input class='btn btn-sm btn-primary'type="submit" value="Save Changes">
</form>
        <a class=' btn btn-sm btn-secondary'href="Dashboard.php">Cancel</a>
    
</body>

</html>
