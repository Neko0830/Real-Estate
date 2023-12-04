<?php
session_start();

// Check if the user is logged in, else redirect to login
if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}

// Include connection to the database
@include "../conn.php";

// Fetch user details based on UserID
$userID = $_SESSION['UserID'];
$sql = "SELECT * FROM Users WHERE UserID = '$userID'";
$result = mysqli_query($connection, $sql);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../../dist/output.css">
</head>

<body>
    <h2>Welcome, <?php echo $user['FullName']; ?>!</h2>
    <a href="update_profile.php">Profile</a>
    <a href="manage_properties.php">Manage Properties</a>
</body>

</html>
