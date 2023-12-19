<?php session_start();
include '../conn.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../dist/output.css">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.19/dist/full.min.css" rel="stylesheet" type="text/css" />
    <title>Document</title>
</head>

<body>
    <?php
    @include 'header.html';
    ?>
    <table class="table">
        <h1>USERS STATUS:</h1>

        <thead>
            <tr>
                <th>Property Name</th>
                <th>Date From</th>
                <th>Date To</th>
                <th>Guest</th>
                <th>Status</th>
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
                while ($rows = mysqli_fetch_array($querys)) {
                    $name = $rows[1];
                }

                echo "
           <tr><td>$name</td>
           <td>$row[3]</td>
           <td>$row[4]</td>
           <td>$row[5]</td>
           <td>$row[6]</td>
           <td>
           <form action='user_booking.php' method='post' >
           <input type='hidden'name='pId' value='$row[0]'>
           <input type='submit'name='delete' value='Delete'>
           </form>
           </td>
           </tr>
   
            ";
            }


            if (isset($_POST['delete'])) {
                $ids = $_POST['pId'];
                $ups =  "DELETE FROM bookings  WHERE booking_id = '$ids'";
                $ups = mysqli_query($connection, $ups);
                if ($ups) {
                    echo "<script>alert('Done');
                     windows.location.href='dashboard.php';</script>";
                }
            }

            ?>
        </tbody>
    </table>

    <script src="https://cdn.tailwindcss.com"></script>
</body>

</html>