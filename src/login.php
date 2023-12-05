<?php
session_start();

@include "conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM Users WHERE Email = '$email'";
    $result = mysqli_query($connection, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['Password'])) {
            $_SESSION['UserID'] = $row['UserID'];
            if ($email === 'admin@email.com') {
                header("Location: /admin/dashboard.php");
                exit();
            } else {
                header("Location: users/dashboard.php");
                exit();
            }
        } else {
            echo "Incorrect password";
        }
    } else {
        echo "User not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../../dist/output.css">
</head>

<body>
    <h2>Login</h2>
    <form action="login.php" method="POST">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <input class="btn btn-accent p-6 btn-outline" type="submit" value="Login">
    </form>
</body>

</html>