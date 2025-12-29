<?php
// Protect this page (admin only)
require_once "../../config/auth.php";

// Database connection
require_once "../../config/db.php";

// Fetch all events
try {
    $stmt = $conn->prepare("SELECT * FROM events ORDER BY event_date DESC");
    $stmt->execute();
    $result = $stmt->get_result();
} catch (Exception $e) {
    die("Error fetching events");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Events | Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Admin CSS -->
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>
<body>

<div class="dashboard-container">

    <h1 class="dashboard-title">Manage Events</h1>

    <a href="../dashboard.php" class="back-btn">← Back to Dashboard</a>

    <!-- Flash success message -->
    <?php if (isset($_SESSION['success_message'])) : ?>
        <div class="info-message">
            <?= htmlspecialchars($_SESSION['success_message']) ?>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <!-- Add Event Button -->
    <div class="top-actions">
        <a href="add.php" class="primary-btn">+ Add New Event</a>
    </div>

    <!-- Events Table -->
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

            <?php if ($result->num_rows > 0) : ?>
                <?php while ($event = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?= htmlspecialchars($event['title']) ?></td>
                        <td><?= htmlspecialchars($event['event_date']) ?></td>
                        <td><?= htmlspecialchars($event['event_time']) ?></td>
                        <td>
                            <a href="edit.php?id=<?= $event['id'] ?>" class="action-btn edit">Edit</a>
                            <a href="delete.php?id=<?= $event['id'] ?>"
                               class="action-btn delete"
                               onclick="return confirm('Are you sure you want to delete this event?');">
                               Delete
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else : ?>
                <tr>
                    <td colspan="4">No events found.</td>
                </tr>
            <?php endif; ?>

            </tbody>
        </table>
    </div>

</div>

</body>
</html>
