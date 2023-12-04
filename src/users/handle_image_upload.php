<?php
// Handle image upload and insertion into the database
session_start();

@include "../conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $propertyID = $_POST['property_id'];

    // Process the uploaded image
    $image = $_FILES['image'];
    $imageName = $image['name'];
    $imageTmpName = $image['tmp_name'];
    $imageError = $image['error'];

    if ($imageError === 0) {
        // Store the image in a folder on your server
        $uploadPath = "../../uploads/"; // Adjust the path as per your server setup
        $imagePath = $uploadPath . $imageName;
        move_uploaded_file($imageTmpName, $imagePath);

        // Insert image path into the PropertyImages table
        $insertSQL = "INSERT INTO PropertyImages (PropertyID, ImageURL) VALUES ('$propertyID', '$imagePath')";
        if (mysqli_query($connection, $insertSQL)) {
            echo "Image uploaded and added to the database.";
        } else {
            echo "Error: " . mysqli_error($connection);
        }
    } else {
        echo "Error uploading image: " . $imageError;
    }
}
?>
