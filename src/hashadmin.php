<?php
session_start();

@include "conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['Username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO admins (Username, Password) VALUES ('$user', '$password')";

    $sql_query = mysqli_query($connection, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registration</title>
    <link rel="stylesheet" href="../../dist/output.css">
</head>

<body>
    <h2>Registration</h2>
    <form action="hashadmin.php" method="POST">
        <label for="Username">Full Name:</label><br>
        <input type="text" id="Username" name="Username" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <input class="btn btn-accent p-6 btn-outline" type="submit" value="Register">
    </form>
</body>

</html>
