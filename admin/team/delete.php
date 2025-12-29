<?php
// Protect admin page
require_once "../../config/auth.php";

// Database connection
require_once "../../config/db.php";

// Validate member ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: list.php");
    exit();
}

$member_id = (int) $_GET['id'];

try {
    // Fetch member to get image name
    $stmt = $conn->prepare("SELECT image FROM team WHERE id = ?");
    $stmt->bind_param("i", $member_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // If member not found
    if ($result->num_rows !== 1) {
        header("Location: list.php");
        exit();
    }

    $member = $result->fetch_assoc();

    // Delete image file if exists
    $imagePath = "../../assets/images/team/" . $member['image'];
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    // Delete member from database
    $stmt = $conn->prepare("DELETE FROM team WHERE id = ?");
    $stmt->bind_param("i", $member_id);
    $stmt->execute();

    // Flash success message
    $_SESSION['success_message'] = "Team member deleted successfully.";

} catch (Exception $e) {
    $_SESSION['success_message'] = "Something went wrong while deleting team member.";
}

// Redirect back to team list
header("Location: list.php");
exit();
