<?php
session_start();

@include "conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $registrationDate = date('Y-m-d H:i:s');
    $contact = $_POST['contact'];

    $sql = "INSERT INTO Users (FullName, username, Email, Password, Registration_Date, contact_number) VALUES ('$fullname', '$username', '$email', '$password', '$registrationDate', '$contact')";

    if (mysqli_query($connection, $sql)) {
        $_SESSION['UserID'] = mysqli_insert_id($connection);
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}
?>


