<?php
session_start();
@include '../conn.php';

if (!isset($_SESSION['UserID'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form data
    $property_id = intval($_POST['property_id']);
    $room_number = $_POST['room_number'];
    $type = $_POST['type'];
    $price = floatval($_POST['price']);
    $size = intval($_POST['size']);
    $availability = boolval($_POST['availability']);
    $image = $_POST['image'];
    $description = $_POST['description'];

    // Check if room exists
    $sql_check = "SELECT COUNT(*) FROM rooms WHERE room_number = ?";
    $stmt_check = $connection->prepare($sql_check);
    $stmt_check->bind_param('s', $room_number);
    $stmt_check->execute();
    $stmt_check->bind_result($count);
    $stmt_check->fetch();
    $stmt_check->close();

    if ($count > 0) {
        // Update existing room
        $sql = "UPDATE rooms SET property_id = ?, room_type = ?, price = ?, room_size = ?, availability = ?, image = ?, description = ? WHERE room_number = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('isdissss', $property_id, $type, $price, $size, $availability, $image, $description, $room_number);
        $stmt->execute();
        $stmt->close();
    } else {
        // Add new room
        $sql = "INSERT INTO rooms (property_id, room_number, room_type, price, room_size, availability, image, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('isdissss', $property_id, $room_number, $type, $price, $size, $availability, $image, $description);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: room_listing.php");
    exit;
}


// Get room details if editing
$id = isset($_GET['UserID']) ? intval($_GET['UserID']) : null;
if ($id) {
    $sql = "SELECT * FROM rooms WHERE room_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->execute([$id]);
    $room = $stmt->fetch();
} else {
    $room = [
        'room_id' => null,
        'property_id' => null,
        'room_number' => '',
        'type' => '',
        'price' => 0.00,
        'size' => 0,
        'availability' => true,
        'image' => '',
        'description' => '',
    ];
}
?>

<!DOCTYPE html>
<html lang="en" data-theme='dark'>

<head>
    <meta charset="UTF-8">
    <title><?php echo $id ? 'Edit Room' : 'Add Room'; ?></title>
    <link rel="stylesheet" href="../../dist/output.css">
</head>
<?php include 'partials/header.php';?>
<body>
    <h1><?php echo $id ? 'Edit Room' : 'Add Room'; ?></h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="mt-4">
            <label for="id">Property:</label>
            <input type="hidden" name="id" value="<?php echo $room['room_id']; ?>">
            <select name="property_id" id="property_id">
                <?php
                // List properties owned by the logged-in user
                $sql = "SELECT * FROM properties WHERE admin_id = ?";
                $stmt = $connection->prepare($sql);
                $stmt->execute([$_SESSION['UserID']]);
                $properties = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                foreach ($properties as $property) : ?>
                    <option value="<?php echo $property['property_id']; ?>" <?php if ($property['property_id'] == $room['property_id']) : ?>selected<?php endif; ?>><?php echo $property['property_name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <br>
        <div class="mt-2">
            <label for="type">Room Type:</label>
            <select name="type" id="type">
                <option value="Single" <?php if ($room['type'] === "Single") echo "selected"; ?>>Single Room</option>
                <option value="Double" <?php if ($room['type'] === "Double") echo "selected"; ?>>Double Room</option>
                <option value="Family Suite" <?php if ($room['type'] === "Family Suite") echo "selected"; ?>>Family Suite</option>
                <option value="Other" <?php if ($room['type'] !== "Single" && $room['type'] !== "Double" && $room['type'] !== "Family Suite") echo "selected"; ?>>Other</option>
            </select>
            <br>
            <br>
        </div>
        <div class="mt-4">
            <label for="price">Price (Daily)</label>
            <input required type="number" name="price" id="price" step="0.01" value="<?php echo $room['price']; ?>"><br>
        </div>
        <br>
        <div class="mt-4">
            <label for="size">Size (m²):</label>
            <input type="number" name="size" id="size" value="<?php echo $room['size']; ?>">
            <br>
            <br>
        </div>
        <div class="mt-4">
            <label for="room_number">Room Number:</label>
            <input required type="number" name="room_number" id="room_number" value="<?php echo $room['room_number']; ?>">
        </div>
        <br>
        <div class="mt-4">
            <label for="availability">Is Available?</label>
            <input type="checkbox" name="availability" id="availability" <?php if ($room['availability']) : ?>checked<?php endif; ?>>
        </div>
        <br>
        <div class="mt-4">
            <label for="image">Image URL:</label>
            <input type="text" name="image" id="image" value="<?php echo $room['image']; ?>">
        </div>
        <br>
        <div class="mt-4">
            <label for="description">Description:</label><br>
            <textarea name="description" id="description"><?php echo $room['description']; ?></textarea>
        </div>
        <button class='btn btn-primary'type="submit"><?php echo $id ? 'Update' : 'Add'; ?> Room</button>
    </form>
    
</body>

</html>