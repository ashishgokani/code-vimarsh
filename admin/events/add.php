<?php
// Protect admin page
require_once "../../config/auth.php";

// Database connection
require_once "../../config/db.php";

// Error message
$error = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    try {
        // Get and clean inputs
        $title = trim($_POST['title']);
        $event_date = $_POST['event_date'];
        $event_time = $_POST['event_time'];
        $description = trim($_POST['description']);

        // Validate required fields
        if (empty($title) || empty($event_date) || empty($event_time) || empty($description)) {
            throw new Exception("All fields are required.");
        }

        // Validate image upload
        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== 0) {
            throw new Exception("Event image is required.");
        }

        $image = $_FILES['image'];

        // Allowed image types
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

        if (!in_array($image['type'], $allowedTypes)) {
            throw new Exception("Only JPG and PNG images are allowed.");
        }

        // Create unique image name
        $imageName = time() . "_" . basename($image['name']);
        $uploadPath = "../../assets/images/events/" . $imageName;

        // Move uploaded image
        if (!move_uploaded_file($image['tmp_name'], $uploadPath)) {
            throw new Exception("Failed to upload image.");
        }

        // Insert event into database
        $stmt = $conn->prepare(
            "INSERT INTO events (title, image, event_date, event_time, description)
             VALUES (?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "sssss",
            $title,
            $imageName,
            $event_date,
            $event_time,
            $description
        );

        $stmt->execute();

        // Flash success message
        $_SESSION['success_message'] = "Event added successfully.";

        // Redirect to events list
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
    <title>Add Event | Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Admin CSS -->
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>
<body>

<div class="dashboard-container">

    <h1 class="dashboard-title">Add New Event</h1>

    <a href="list.php" class="back-btn">← Back to Events</a>

    <!-- Show error if exists -->
    <?php if (!empty($error)) : ?>
        <div class="error-message">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <!-- Add Event Form -->
    <form method="POST" enctype="multipart/form-data" class="form-box">

        <label>Event Title</label>
        <input type="text" name="title" required>

        <label>Event Date</label>
        <input type="date" name="event_date" required>

        <label>Event Time</label>
        <input type="time" name="event_time" required>

        <label>Event Image</label>
        <input type="file" name="image" accept="image/*" required>

        <label>Event Description</label>
        <textarea name="description" rows="6" required></textarea>

        <button type="submit">Add Event</button>
    </form>

</div>

</body>
</html>
