<?php
session_start();

@include "conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $registrationDate = date('Y-m-d H:i:s');

    $sql = "INSERT INTO Users (FullName, Email, Password, RegistrationDate) VALUES ('$fullname', '$email', '$password', '$registrationDate')";

    if (mysqli_query($connection, $sql)) {
        $_SESSION['UserID'] = mysqli_insert_id($connection);
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($connection);
    }
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
    <form action="registration.php" method="POST">
        <label for="fullname">Full Name:</label><br>
        <input type="text" id="fullname" name="fullname" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <input class="btn btn-accent p-6 btn-outline" type="submit" value="Register">
    </form>
</body>

</html>
