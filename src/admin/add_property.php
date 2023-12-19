<?php
session_start();
@include "../conn.php";

if (isset($_SESSION['UserID'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $userID = $_SESSION['UserID'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        // Add other form fields and validation as needed

        // Insert new property into the database
        $insertSQL = "INSERT INTO Properties (admin_id, property_name, Description) VALUES ('$userID', '$title', '$description')";
        if (mysqli_query($connection, $insertSQL)) {
            // Redirect to manage properties after successful addition
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Error adding property: " . mysqli_error($connection);
        }
    }
} else {
    // Redirect to login if user is not logged in
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en" data-theme='dark'>

<head>
    <meta charset="UTF-8">
    <title>Add Property</title>
    <link rel="stylesheet" href="../../dist/output.css">
</head>
<?php
include 'partials/header.php';
?>
<body>
    <h2>Add New Property</h2>
    <form action="add_property.php" method="POST">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" required><br><br>

        <label for="description">Description:</label><br>
        <textarea id="description" name="description" required></textarea><br><br>

        <!-- Add other property details input fields here -->

        <input class='btn btn-primary'type="submit" value="Add Property">
    </form>

    
</body>

</html>
