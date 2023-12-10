<?php
session_start();
include "../conn.php";

if (!isset($_SESSION['UserID'])) {
    header("Location: ../login.php");
    exit;
}

$roomId = isset($_GET['id']) ? intval($_GET['id']) : null;

// Check if room exists and user owns it
$sql = "SELECT * FROM rooms WHERE room_id = ? AND property_id IN (SELECT property_id FROM properties WHERE admin_id = ?)";
$stmt = mysqli_prepare($connection, $sql);
$stmt->execute([$roomId, $_SESSION['UserID']]);
$room = $stmt->get_result()->fetch_assoc();

if (!$room) {
    // Display error message if room doesn't exist or user doesn't own it
    echo "Error: Room not found or you don't have permission to delete it.";
} else {
    // Delete room if confirmation is received
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $sql = "DELETE FROM rooms WHERE room_id = ?";
        $stmt = mysqli_prepare($connection, $sql);
        $stmt->execute([$roomId]);

        if ($stmt->affected_rows === 1) {
            header("Location: room_listing.php");
            exit;
        } else {
            echo "Error: Failed to delete room.";
        }
    } else {
        // Display confirmation message before deletion
        echo "Are you sure you want to delete this room? This action cannot be undone.";
        echo "<form action='delete_room.php?id=$roomId' method='POST'>";
        echo "<input type='submit' value='Delete'>";
        echo "</form>";
    }
}
?>
