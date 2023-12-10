<?php
session_start();

@include "conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['ownerFullName'];
    $username = $_POST['ownerUserName'];
    $email = $_POST['ownerEmail'];
    $password = $_POST['ownerPassword'];
    $registrationDate = date('Y-m-d H:i:s');
    $contact = $_POST['contact'];
    $hpass = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO admins (fullname, username, Email, password, Registration_Date, contact_number) VALUES ('$fullname','$username', '$email', '$hpass', '$registrationDate','$contact')";

    if (mysqli_query($connection, $sql)) {
        $_SESSION['UserID'] = mysqli_insert_id($connection);
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}
