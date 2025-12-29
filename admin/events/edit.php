<?php
// Protect admin page
require_once "../../config/auth.php";

// Database connection
require_once "../../config/db.php";

// Check event ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: list.php");
    exit();
}

$event_id = (int) $_GET['id'];
$error = "";

// Fetch existing event
try {
    $stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows !== 1) {
        header("Location: list.php");
        exit();
    }

    $event = $result->fetch_assoc();

} catch (Exception $e) {
    die("Error loading event");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    try {
        // Get inputs
        $title = trim($_POST['title']);
        $event_date = $_POST['event_date'];
        $event_time = $_POST['event_time'];
        $description = trim($_POST['description']);

        // Validate
        if (empty($title) || empty($event_date) || empty($event_time) || empty($description)) {
            throw new Exception("All fields are required.");
        }

        $imageName = $event['image']; // Default: old image

        // If new image uploaded
        if (!empty($_FILES['image']['name'])) {

            $image = $_FILES['image'];
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

            if (!in_array($image['type'], $allowedTypes)) {
                throw new Exception("Only JPG and PNG images are allowed.");
            }

            $imageName = time() . "_" . basename($image['name']);
            $uploadPath = "../../assets/images/events/" . $imageName;

            if (!move_uploaded_file($image['tmp_name'], $uploadPath)) {
                throw new Exception("Failed to upload image.");
            }

            // Optional: delete old image file
            $oldImagePath = "../../assets/images/events/" . $event['image'];
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        // Update event
        $stmt = $conn->prepare(
            "UPDATE events
             SET title = ?, image = ?, event_date = ?, event_time = ?, description = ?
             WHERE id = ?"
        );

        $stmt->bind_param(
            "sssssi",
            $title,
            $imageName,
            $event_date,
            $event_time,
            $description,
            $event_id
        );

        $stmt->execute();

        // Flash message
        $_SESSION['success_message'] = "Event updated successfully.";

        // Redirect to list
        header("Location: list.php");
        exit();

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Event | Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Admin CSS -->
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>
<body>

<div class="dashboard-container">

    <h1 class="dashboard-title">Edit Event</h1>

    <a href="list.php" class="back-btn">← Back to Events</a>

    <!-- Error message -->
    <?php if (!empty($error)) : ?>
        <div class="error-message">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="form-box">

        <label>Event Title</label>
        <input type="text" name="title"
               value="<?= htmlspecialchars($event['title']) ?>" required>

        <label>Event Date</label>
        <input type="date" name="event_date"
               value="<?= htmlspecialchars($event['event_date']) ?>" required>

        <label>Event Time</label>
        <input type="time" name="event_time"
               value="<?= htmlspecialchars($event['event_time']) ?>" required>

        <label>Change Event Image (optional)</label>
        <input type="file" name="image" accept="image/*">

        <label>Event Description</label>
        <textarea name="description" rows="6" required><?= htmlspecialchars($event['description']) ?></textarea>

        <button type="submit">Update Event</button>
    </form>

</div>

</body>
</html>
