<?php
// Protect this page (only logged-in admin can access)
require_once "../config/auth.php";

// Include database connection
require_once "../config/db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | Code Vimarsh</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Admin CSS -->
    <link rel="stylesheet" href="../assets/css/admin.css">

</head>
<body>

<div class="dashboard-container">

    <!-- Logout button -->
    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>

    <h1 class="dashboard-title">Admin Dashboard</h1>

    <?php
        // Show success message once (flash message)
        if (isset($_SESSION['success_message'])) :
        ?>
            <div class="info-message">
                <?= htmlspecialchars($_SESSION['success_message']) ?>
            </div>
        <?php
            // Remove message after showing once
            unset($_SESSION['success_message']);
        endif;
    ?>

    <!-- Dashboard cards -->
    <div class="card-grid">

        <div class="card">
            <h3>About Us</h3>
            <p>Edit heading, description and join button.</p>
            <a href="about/edit.php">Edit About</a>
        </div>

        <div class="card">
            <h3>Events</h3>
            <p>Add, edit or delete upcoming events.</p>
            <a href="events/list.php">Manage Events</a>
        </div>

        <div class="card">
            <h3>Team Members</h3>
            <p>Manage initiators, core team and web team.</p>
            <a href="team/list.php">Manage Team</a>
        </div>

        <div class="card">
            <h3>Contact & Social Links</h3>
            <p>Update email and social media links.</p>
            <a href="contact/edit.php">Edit Contact</a>
        </div>

    </div>

</div>

</body>
</html>
