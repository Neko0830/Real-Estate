<?php
session_start();
@include "../conn.php";

if (isset($_SESSION['UserID'])) {
    $userID = $_SESSION['UserID'];

    $query = "SELECT * FROM Users WHERE UserID = $userID";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
    } else {
        echo "User not found!";
    }
} else {
    echo "User not logged in!";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = $_SESSION['UserID'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($password === $confirmPassword) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $updateSQL = "UPDATE Users SET FullName = '$fullname', Email = '$email', Password = '$hashedPassword' WHERE UserID = '$userID'";

        if (mysqli_query($connection, $updateSQL)) {
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Error updating profile: " . mysqli_error($connection);
        }
    } else {
        echo "Passwords do not match";
    }
}
?>
<!DOCTYPE html>
<html lang="en" data-theme='dark'>

<head>
    <meta charset="UTF-8">
    <title>Update Profile</title>
    <link rel="stylesheet" href="../../dist/output.css">
</head>

<body>
    <form action="update_profile.php" method="POST">
        <label for="fullname">Full Name:</label><br>
        <input type="text" id="fullname" name="fullname" value="<?php echo $user['FullName']; ?>" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo $user['Email']; ?>" required><br><br>

        <label for="password">New Password:</label><br>
        <input type="password" id="password" name="password"><br><br>

        <label for="confirm_password">Confirm Password:</label><br>
        <input type="password" id="confirm_password" name="confirm_password"><br><br>

        <input type="submit" value="Update Profile">
    </form>

    <a href="dashboard.php">Back</a>
</body>

</html>
