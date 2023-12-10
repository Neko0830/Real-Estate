<?php
session_start();
@include "../conn.php";

$property_id = null; // Initialize $property_id variable

if (isset($_GET['property_id'])) {
    $property_id = $_GET['property_id'];

    // Verify if the property exists in the database
    $propertySQL = "SELECT property_name FROM Properties WHERE property_id = '$property_id'";
    $propertyResult = mysqli_query($connection, $propertySQL);

    if ($propertyData = mysqli_fetch_assoc($propertyResult)) {
        $propertyTitle = $propertyData['property_name'];
    } else {
        $propertyTitle = "Property Not Found";
    }
}

// Handle image upload and insertion into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['property_id'])) {
        $property_id = $_POST['property_id']; // Use the POST data if available
    }

    // Check if $property_id is still null or invalid
    if ($property_id === null || !is_numeric($property_id)) {
        echo "Invalid property ID.";
        exit;
    }

    // Process the uploaded image
    $image = $_FILES['image'];
    $imageName = $image['name'];
    $imageTmpName = $image['tmp_name'];
    $imageError = $image['error'];

    if ($imageError === 0) {
        // Store the image in a folder on your server
        $uploadPath = "../../uploads/"; // Adjust the path as needed
        $imagePath = $uploadPath . $imageName;
        move_uploaded_file($imageTmpName, $imagePath);

        // Insert image path into the PropertyImages table
        $insertSQL = "INSERT INTO PropertyImages (property_id, Image_URL) VALUES ('$property_id', '$imagePath')";
        if (mysqli_query($connection, $insertSQL)) {
            echo "Image uploaded and added to the database.";
            header("Location: manage_properties.php");
        } else {
            echo "Error: " . mysqli_error($connection);
        }
    } else {
        echo "Error uploading image: " . $imageError;
    }
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <title>Image Upload</title>
    <link rel="stylesheet" href="../../dist/output.css">
</head>

<body>
    <form action="handle_image_upload.php" method="POST" enctype="multipart/form-data">
        <label for="property_id">Property ID:</label>
        <input  class="disabled:opacity-75" type="text" id="property_id" name="property_id" value="<?php echo $property_id; ?>" readonly><br><br>

        <label for="property_title">Property Title:</label>
        <input  type="text" id="property_title" name="title" value="<?php echo $propertyTitle ?? ''; ?>" readonly><br><br>

        <label for="image">Select Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required><br><br>

        <input type="submit" value="Upload">
    </form>
    <a href="manage_properties.php">Cancel</a>
</body>

</html>
