<?php
session_start();
@include "../conn.php";

if (isset($_SESSION['AdminID'])) {
    $userID = $_SESSION['AdminID'];

    // Fetch user's properties based on UserID
    $sql = "SELECT * FROM Properties WHERE admin_id = '$userID'";
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
    <link rel="stylesheet" href="../../dist/output.css">
</head>

<body>


    <h2 class='text-lg font-semibold mb-4 indent-5'>Your Listed Properties:</h2>

    <div class='grid grid-cols-3 gap-3 ml-14 gap-y-48'>
    <?php
while ($property = mysqli_fetch_assoc($result)) {
    echo "<div class='card bg-base-100 shadow-xl image-full rounded-sm w-80 mb-6'>";

    // Fetch property images
    $property_id = $property['property_id'];
    $imageQuery = "SELECT Image_URL FROM PropertyImages WHERE property_id = '$property_id'";
    $imageResult = mysqli_query($connection, $imageQuery);

    echo "<div class='card-body p-3'>";

    echo '<div class="carousel w-80">';
    $i = 0;
    while ($image = mysqli_fetch_assoc($imageResult)) {
        echo "<div class='carousel-item'>";
        echo "<figure class='w-80'>";
        echo "<img class='rounded-lg' src='" . $image['Image_URL'] . "' alt='Property Image'>";
        echo "</figure>";

        if ($i === 0) {
            // Add active class to the first carousel item
            echo '<div class="">';
            echo '<span class="tooltip tooltip-bottom" data-tip="Property 1 of ' . mysqli_num_rows($imageResult) . '"></span>';
            echo '</div>';
        }
        echo "</div>";
        $i++;
    }
    echo '</div>';

    echo "<h2>" . $property['property_name'] . "</h2>";
    // Display other property details as needed
    echo "<p class='px-3 pt-2 '>" . $property['description'] . "</p>";

    // Link to view/edit property
    echo "<div class='card-actions justify-end'>";
    echo "<a class='btn btn-primary btn-outline btn-sm' href='edit_property.php?property_id=" . $property['property_id'] . "'>Edit Details</a> ";
    echo "<a class='btn btn-primary btn-outline btn-sm' href='handle_image_upload.php?property_id=" . $property['property_id'] . "'>Upload Images</a></div>";
    echo '<form action="delete_property.php" method="POST">';
    echo '<input type="hidden" name="property_id" value="' . $property['property_id'] . '">';
    echo "<div class='card-actions justify-end'>";
    echo '<input class="btn btn-error btn-outline btn-xs" type="submit" name="delete_property" value="Delete">';
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