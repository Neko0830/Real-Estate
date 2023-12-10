<?php
session_start();
@include "../conn.php";

if (isset($_SESSION['UserID'])) {
    $userID = $_SESSION['UserID'];

    // Fetch properties except those belonging to the logged-in user
    $sql = "SELECT * FROM Properties";
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
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.19/dist/full.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class='navbar justify-between'>
        <a href="dashboard.php">Dashboard</a>
        <ul>
            <li><a class='underline' href="../logout.php">Logout</a><li>
        </ul>
    </div>
    
    <h2>Listed Properties:</h2>

    <div class='grid grid-cols-3 gap-2'>
        <?php
        while ($property = mysqli_fetch_assoc($result)) {
            echo "<div class='card bg-base-100 shadow-xl image-full rounded-sm w-80 h-48 ml-10 mt-6'>";
            $property_id = $property['property_id'];
            $imageQuery = "SELECT Image_URL FROM PropertyImages WHERE property_id = '$property_id'";
            $imageResult = mysqli_query($connection, $imageQuery);

            echo "<div class='card-body p-3'>";

            echo '<div class="carousel w-80 h-48">';
            $i = 0;
            while ($image = mysqli_fetch_assoc($imageResult)) {
                echo "<div class='carousel-item'>";
                echo "<figure class='w-80 h-max object-cover'>";
                echo "<img class='rounded-lg' src='" . $image['Image_URL'] . "' alt='Property Image'>";
                echo "</figure>";

                if ($i === 0) {
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
            echo "<p class='px-3 pt-2 mb-4'>" . $property['description'] . "</p>";

            // Link to view/edit property
            echo "<div class='card-actions justify-end'>";
            echo "<a class='btn btn-primary'href='check_details.php'>"."Check Details</a>";
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