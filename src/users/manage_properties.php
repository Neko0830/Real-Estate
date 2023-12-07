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
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <title>Manage Properties</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.19/dist/full.min.css" rel="stylesheet" type="text/css" />
    
</head>

<body>
    <a href="add_property.php">Add More Properties</a>
    <a href="dashboard.php">Dashboard</a>

    <h2>Your Listed Properties:</h2>

    <div class='grid grid-cols-3 gap-2'> <!-- Adjust 'grid-cols' based on the number of properties you want per row -->
        <?php
        while ($property = mysqli_fetch_assoc($result)) {
            echo "<div class='card bg-base-100 shadow-xl image-full rounded-sm w-96 h-64'>";


            // Fetch property images from the database for each property
            $propertyID = $property['PropertyID'];
            $imageQuery = "SELECT ImageURL FROM PropertyImages WHERE PropertyID = '$propertyID'";
            $imageResult = mysqli_query($connection, $imageQuery);

            
            echo "<div class='card-body'>";
            while ($image = mysqli_fetch_assoc($imageResult)) {
            echo "<figure class='w-full h-56'><img class='' src='" . $image['ImageURL'] . "' alt='Property Image'></figure>";
        }
            echo "<h2 class='card-title'>" . $property['Title'] . "</h2>";
            // Display other property details as needed

            // Link to view/edit property (Replace 'edit_property.php' with your edit property page)
            echo "<div class='card-actions justify-end'>";
            echo "<a class='btn btn-primary btn-outline btn-sm' href='edit_property.php?property_id=" . $property['PropertyID'] . "'>Edit Details</a> ";
            echo "<a class='btn btn-primary btn-outline btn-sm' href='handle_image_upload.php?property_id=" . $property['PropertyID'] . "'>Upload Images</a></div>";
            // Form to delete property
            echo '<form action="delete_property.php" method="POST">';
            echo '<input type="hidden" name="property_id" value="' . $property['PropertyID'] . '">';
            echo "<div class='card-actions justify-end'>";
            echo '<a class="btn btn-error btn-xs text-error"type="submit" name="delete_property">Delete</a>';
            echo '</form>';
            echo "</div>";
            
            
            
            echo "</div>";
            echo "</div>";
            
        }
        ?>
    </div>

    <!-- Link to add more properties -->
    <script src="https://cdn.tailwindcss.com"></script>
</body>

</html>