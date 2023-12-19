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
    <title>Manage Rooms</title>
    <link rel="stylesheet" href="../../dist/output.css">
</head>
<?php include 'partials/header.php'; ?>

<body>
    <h1>Add/Edit Rooms</h1>
    <form class='form-control' action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="mt-4">
            <label class='label-text' for="id">Property:</label>
            <input class='input input-bordered bg-slate-700 text-slate-100' type="hidden" name="id" value="<?php echo $room['room_id']; ?>">
            <select class='select select-bordered bg-slate-700' name="property_id" id="property_id">
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
            <label class='label-text' for="type">Room Type:</label>
            <select class='select select-bordered bg-slate-700' name="type" id="type">
                <option value="Single" <?php if ($room['type'] === "Single") echo "selected"; ?>>Single Room</option>
                <option value="Double" <?php if ($room['type'] === "Double") echo "selected"; ?>>Double Room</option>
                <option value="Family Suite" <?php if ($room['type'] === "Family Suite") echo "selected"; ?>>Family Suite</option>
                <option value="Other" <?php if ($room['type'] !== "Single" && $room['type'] !== "Double" && $room['type'] !== "Family Suite") echo "selected"; ?>>Other</option>
            </select>
            <br>
            <br>
        </div>
        <div class="mt-4">
            <label class='label-text' for="price">Price (Daily)</label>
            <input class='input input-bordered bg-slate-700 text-slate-100' required type="number" name="price" id="price" step="0.01" value="<?php echo $room['price']; ?>"><br>
        </div>
        <br>
        <div class="mt-4">
            <label class='label-text' for="size">Size (m²):</label>
            <input class='input input-bordered bg-slate-700 text-slate-100' type="number" name="size" id="size" value="<?php echo $room['size']; ?>">
            <br>
            <br>
        </div>
        <div class="mt-4">
            <div class='label label-text'>
                <label><span class="label-text-alt">Input Existing Room  To Edit</span></label>
            </div>
            <label class='label-text' for="room_number">Room Number:</label>
            <input class='input input-bordered bg-slate-700 text-slate-100' required type="number" name="room_number" id="room_number">
        </div>
        <br>
        <div class="mt-4">
            <label class='cursor-pointer-label'>
                <span class='label-text' for="availability">Is Available?</span>
                <input class='checkbox checkbox-secondary align-middle bg-slate-700 text-slate-100' type="checkbox" name="availability" id="availability" <?php if ($room['availability']) : ?>checked<?php endif; ?>>
            </label>
        </div>
        <br>
        <div class="mt-4">
            <label class='label-text' for="description">Description:</label><br>
            <textarea class='textarea textarea-primary' name="description" id="description"><?php echo $room['description']; ?></textarea>
        </div>
        <button class='btn btn-primary w-96' type="submit"><?php echo $id ? 'Update' : 'Add'; ?> Room</button>
    </form>

</body>

</html>