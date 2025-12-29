<?php
// Protect admin page
require_once "../../config/auth.php";

// Database connection
require_once "../../config/db.php";

// Validate social link ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: edit.php");
    exit();
}

$social_id = (int) $_GET['id'];

try {
    // Delete social link
    $stmt = $conn->prepare("DELETE FROM social_links WHERE id = ?");
    $stmt->bind_param("i", $social_id);
    $stmt->execute();

    // Flash success message
    $_SESSION['success_message'] = "Social link deleted successfully.";

} catch (Exception $e) {
    $_SESSION['success_message'] = "Failed to delete social link.";
}

// Redirect back to contact edit page
header("Location: edit.php");
exit();
