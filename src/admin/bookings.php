<?php 
require_once 'manage_properties.php';
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['updateStats'])) {
    if (($_SESSION['AdminID'] != $userID)) {
        echo "Unauthorized access";
        exit();
    }

    $ids = $_POST['pId'];
    $ups =  "UPDATE bookings SET status = 'Confirmed' WHERE booking_id = '$ids'";
    $result = mysqli_query($connection, $ups);

    if ($result) {
        echo "<script>alert('Booking accepted');</script>";
        echo "<script>window.location.href = 'dashboard.php';</script>";
        exit(); 
    } else {
        echo "<script>alert('Error updating status');</script>";
    }
}
?>

    <table class="table align-middle">
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
            <?php

            $data = "SELECT * FROM bookings WHERE status != 'confirmed'";
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
           <input class='btn btn-sm btn-success btn-outline mt-3 'type='submit'name='updateStats' value='Accept'>
           </form>
           </td>
           </tr>
   
            ";
            }
            ?>
        </tbody>
    </table>