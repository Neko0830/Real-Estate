<?php
session_start();
@include "../conn.php";

// Create connection
$connection = mysqli_connect($servername, $username, $password, $dbname);
if (isset($_SESSION['UserID'])) {
    $userID = $_SESSION['UserID'];

    // Fetch properties owned by the logged-in owner
    $sql = "SELECT * FROM Properties WHERE admin_id = '$userID'";
    $result = mysqli_query($connection, $sql);

    if (!$result) {
        echo "Error fetching properties: " . mysqli_error($connection);
    }
} else {
    // Redirect to login if user is not logged in
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <title>Owner Dashboard</title>
    <link rel="stylesheet" href="../../dist/output.css">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.19/dist/full.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <?php
    include 'partials/header.php';
    ?>
    <table class="table">
        <thead>
            <tr>
                <th>Property Name</th>
                <th>Date From</th>
                <th>Date To</th>
                <th>Guest</th>
                <th>Status</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody>
            <?php @include "../conn.php";

            $data = "SELECT * FROM bookings";
            $query = mysqli_query($connection, $data);
        


            while ($row = mysqli_fetch_array($query)) {
                $properties = "SELECT * FROM properties WHERE property_id = '$row[2]'";
              $querys = mysqli_query($connection, $properties);
              $name;
              while ($rows = mysqli_fetch_array($querys)){
                       $name = $rows[1];
              }
                
                echo "
           <tr><td>$name</td>
           <td>$row[3]</td>
           <td>$row[4]</td>
           <td>$row[5]</td>
           <td>$row[6]</td>
           <td>
           <form action='bookings.php' method='post' >
           <input type='hidden'name='pId' value='$row[0]'>
           <input type='submit'name='updateStats' value='Accept'>
           </form>
           </td>
           </tr>
   
            ";
            }


           if(isset($_POST['updateStats'])) {
           $ids = $_POST['pId'];
           $ups =  "UPDATE bookings SET status = 'Confirmed' WHERE booking_id = '$ids'";
           $ups = mysqli_query($connection, $ups);
           if($ups){
            echo "<script>alert('Done');</script>";
           }

           }

            ?>
        </tbody>
    </table>
    <!-- Link to add more properties -->
    <script src="https://cdn.tailwindcss.com"></script>
</body>
<style>

</style>

</html>