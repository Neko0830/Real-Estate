<?php
session_start();

@include "conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the login is for an admin
    $sqlAdmin = "SELECT * FROM Admins WHERE Email = '$email'";
    $resultAdmin = mysqli_query($connection, $sqlAdmin);

    if ($resultAdmin && mysqli_num_rows($resultAdmin) > 0) {
        $rowAdmin = mysqli_fetch_assoc($resultAdmin);
        if (password_verify($password, $rowAdmin['password'])) {
            $_SESSION['AdminID'] = $rowAdmin['admin_id'];
            header("Location: admin/dashboard.php");
            exit();
        } else {
            echo "Incorrect admin password";
        }
    } else {
        // For regular users
        $sqlUser = "SELECT * FROM Users WHERE Email = '$email'";
        $resultUser = mysqli_query($connection, $sqlUser);

        if ($resultUser && mysqli_num_rows($resultUser) > 0) {
            $rowUser = mysqli_fetch_assoc($resultUser);
            if (password_verify($password, $rowUser['password'])) {
                $_SESSION['UserID'] = $rowUser['user_id'];
                header("Location: users/dashboard.php");
                exit();
            } else {
                echo "Incorrect password";
            }
        } else {
            echo "User not found";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../dist/output.css">
</head>

<body>
    <div class="w-full container flex justify-center m-auto">
    <div class="card w-96 shadow-lg">
        <div class="card-body">
            <div class="card-title"><h2>Login</h2></div>
            <form action="login.php" method="POST">
                <label for="email">Email:</label><br>
                <input class='input input-bordered w-full bg-slate-700 text-slate-100' type="text" id="email" name="email" required><br><br>

                <label for="password">Password:</label><br>
                <input class='input input-bordered w-full bg-slate-700 text-slate-100' type="password" id="password" name="password" required><br><br>

                <input class="btn w-full btn-accent btn-outline" type="submit" value="Login">
            </form>
        </div>
    </div>
    </div>
</body>

</html>
