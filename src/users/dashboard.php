<?php
session_start();
@include "../conn.php";

if (isset($_SESSION['UserID'])) {
    $userID = $_SESSION['UserID'];

    // Fetch properties except those belonging to the logged-in user
    $sql = "SELECT * FROM Properties WHERE UserID != '$userID'";
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
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../dist/output.css">
    <!-- Other CSS and JS links as needed -->
</head>

<body>
    <div class='navbar flex justify-between'>
        <button class='btn btn-ghost'>Dashboard</button>
        <ul class="flex">
            <li><a class="btn btn-sm btn-outline btn-primary" href="manage_properties.php">Manage Properties</a></li>
            <li><a class="btn btn-sm btn-outline btn-ghost" href="../logout.php">logout</a></li>
        </ul>
    </div>
    <div class='grid grid-cols-3 gap-4'> <!-- Adjust 'grid-cols' based on the number of properties you want per row -->
        <?php
        while ($property = mysqli_fetch_assoc($result)) {
            // Display property details without editing features
            echo "<div class='card bg-base-100 shadow-xl'>";
            echo "<div class='card bg-base-100 shadow-xl image-full rounded-sm w-96 h-64'>";

            $propertyID = $property['PropertyID'];
            $imageQuery = "SELECT ImageURL FROM PropertyImages WHERE PropertyID = '$propertyID'";
            $imageResult = mysqli_query($connection, $imageQuery);

            while ($image = mysqli_fetch_assoc($imageResult)) {
                echo "<figure><img class='max-w-none max-h-none' src='" . $image['ImageURL'] . "' alt='Property Image'></figure>";
            }

            // Display property details (title, price, location, etc.)
            echo "<div class='card-body'>";
            echo "<h2 class='card-title'>" . $property['Title'] . "</h2>";
            // Display other property details as needed

            // Link to view property details
            echo "<div class='card-actions justify-end'>";
            echo "<a class='btn btn-primary btn-outline btn-sm' href='view_property.php?property_id=" . $property['PropertyID'] . "'>View Details</a></div> ";
            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>

    <!-- Other features for inquiries, browsing, etc. -->

    <!-- Link to go back to the homepage or other pages -->
</body>

</html>