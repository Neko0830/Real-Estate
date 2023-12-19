<?php
session_start();
include "../conn.php";

if (isset($_SESSION['UserID'])) {
    $userID = $_SESSION['UserID'];

    // Fetch user's properties based on UserID
    $sql = "SELECT * FROM Properties WHERE admin_id = '$userID'";
    $result = mysqli_query($connection, $sql);
    $property = mysqli_fetch_assoc($result);

    if (!$result) {
        echo "Error fetching properties: " . mysqli_error($connection);
    }
} else {
    // Redirect to login if user is not logged in
    header("Location: ../login.php");
    exit();
}

// Fetch rooms associated with user's properties
$sqlRooms = "SELECT rooms.*, properties.property_name AS property_name 
             FROM rooms 
             INNER JOIN properties ON rooms.property_id = properties.property_id 
             WHERE properties.admin_id = '$userID'";
$stmt = mysqli_prepare($connection, $sqlRooms);
mysqli_stmt_execute($stmt);
$resultRooms = mysqli_stmt_get_result($stmt);
$rooms = mysqli_fetch_all($resultRooms, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Rooms</title>
    <link rel="stylesheet" href="../../dist/output.css">
</head>
<?php
@include 'partials/header.php';
?>
<body>
    <h1>Rooms List</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Property</th>
                <th>Type</th>
                <th>Room Number</th>
                <th>Price</th>
                <th>Size (m²)</th>
                <th>Availability</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rooms as $room) : ?>
                <tr>
                    <td><?php echo $room['property_name']; ?></td>
                    <td><?php echo $room['room_type']; ?></td>
                    <td><?php echo $room['room_number']; ?></td>
                    <td><?php echo $room['price']; ?></td>
                    <td><?php echo $room['room_size']; ?></td>
                    <td><?php echo $room['availability'] ? 'Available' : 'Not Available'; ?></td>
                    <td>
                    <a class="btn btn-outline btn-primary btn-sm" href="manage_rooms.php?id=<?php echo $room['room_id'];?>">Edit</a> |
                        <a class="btn btn-outline btn-error btn-sm"href="delete_room.php?id=<?php echo $room['room_id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a class='btn btn-success btn-outline border mt-6'href="manage_rooms.php">Add Room</a>
</body>

</html>