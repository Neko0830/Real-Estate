<?php
session_start();
@include "../conn.php";

if (isset($_SESSION['UserID'])) {
    $userID = $_SESSION['UserID'];

    // Fetch user's properties based on UserID
    $sql = "SELECT * FROM Properties WHERE UserID = '$userID'";
    $result = mysqli_query($connection, $sql);

    if (!$result) {
        echo "Error fetching properties: " . mysqli_error($connection);
    }
} else {
    // Redirect to login if user is not logged in
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Properties</title>
    <link rel="stylesheet" href="../../dist/output.css">
</head>

<body>
    <h2>Your Listed Properties:</h2>
    <ul>
        <?php
        while ($property = mysqli_fetch_assoc($result)) {
            echo "<li>";
            echo "<h3>" . $property['Title'] . "</h3>";
            // Display other property details as needed

            // Link to view/edit property (Replace 'edit_property.php' with your edit property page)
            echo "<a href='edit_property.php?property_id=" . $property['PropertyID'] . "'>Edit</a> | ";
            
            // Form to delete property
            echo '<form action="delete_property.php" method="POST">';
            echo '<input type="hidden" name="property_id" value="' . $property['PropertyID'] . '">';
            echo '<button type="submit" name="delete_property">Delete</button>';
            echo '</form>';
            
            echo "</li>";
        }
        ?>
    </ul>

    <!-- Link to add more properties -->
    <a href="add_property.php">Add More Properties</a>

    <a href="dashboard.php">Back to Dashboard</a>
</body>

</html>
