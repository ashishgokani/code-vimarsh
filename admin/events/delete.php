<?php
// Protect admin page
require_once "../../config/auth.php";

// Database connection
require_once "../../config/db.php";

// Validate event ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: list.php");
    exit();
}

$event_id = (int) $_GET['id'];

try {
    // First fetch event to get image name
    $stmt = $conn->prepare("SELECT image FROM events WHERE id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // If event not found
    if ($result->num_rows !== 1) {
        header("Location: list.php");
        exit();
    }

    $event = $result->fetch_assoc();

    // Delete image file if exists
    $imagePath = "../../assets/images/events/" . $event['image'];
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    // Delete event from database
    $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();

    // Flash success message
    $_SESSION['success_message'] = "Event deleted successfully.";

} catch (Exception $e) {
    $_SESSION['success_message'] = "Something went wrong while deleting event.";
}

// Redirect back to events list
header("Location: list.php");
exit();
