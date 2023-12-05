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
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.19/dist/full.min.css" rel="stylesheet" type="text/css" />
    <!-- Other CSS and JS links as needed -->
</head>

<body>
    <h2>Properties for Rent or Sale:</h2>
<a href="../logout.php"></a>
    <div class='grid grid-cols-3 gap-4'> <!-- Adjust 'grid-cols' based on the number of properties you want per row -->
        <?php
        while ($property = mysqli_fetch_assoc($result)) {
            // Display property details without editing features
            echo "<div class='card bg-base-100 shadow-xl'>";
            // Display property images dynamically (similar to previous code)
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
