<?php
// Protect admin page
require_once "../../config/auth.php";

// Database connection
require_once "../../config/db.php";

// Fetch all social links
try {
    $stmt = $conn->prepare("SELECT * FROM social_links ORDER BY id ASC");
    $stmt->execute();
    $result = $stmt->get_result();
} catch (Exception $e) {
    die("Error fetching contact details");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    try {
        // Update existing social links
        if (!empty($_POST['social'])) {
            foreach ($_POST['social'] as $id => $data) {

                $platform = trim($data['platform']);
                $link = trim($data['link']);

                if (empty($platform) || empty($link)) {
                    continue;
                }

                $stmt = $conn->prepare(
                    "UPDATE social_links SET platform = ?, link = ? WHERE id = ?"
                );
                $stmt->bind_param("ssi", $platform, $link, $id);
                $stmt->execute();
            }
        }

        // Add new social link (optional)
        if (!empty($_POST['new_platform']) && !empty($_POST['new_link'])) {

            $new_platform = trim($_POST['new_platform']);
            $new_link = trim($_POST['new_link']);
            $icon = strtolower($new_platform) . ".png"; // convention-based icon

            $stmt = $conn->prepare(
                "INSERT INTO social_links (platform, icon, link)
                 VALUES (?, ?, ?)"
            );
            $stmt->bind_param("sss", $new_platform, $icon, $new_link);
            $stmt->execute();
        }

        // Flash message
        $_SESSION['success_message'] = "Contact & social links updated successfully.";

        // Redirect back to dashboard
        header("Location: ../dashboard.php");
        exit();

    } catch (Exception $e) {
        $error = "Failed to update contact details.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Contact & Social Links | Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Admin CSS -->
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>
<body>

<div class="dashboard-container">

    <h1 class="dashboard-title">Edit Contact & Social Links</h1>

    <!-- Back button -->
    <a href="../dashboard.php" class="back-btn">← Back to Dashboard</a>

    <!-- Error message -->
    <?php if (!empty($error)) : ?>
        <div class="error-message">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="form-box">

        <h3>Existing Social Links</h3>

        <?php while ($row = $result->fetch_assoc()) : ?>
            <div class="social-row">
                <input type="text"
                    name="social[<?= $row['id'] ?>][platform]"
                    value="<?= htmlspecialchars($row['platform']) ?>"
                    placeholder="Platform name">

                <input type="url"
                    name="social[<?= $row['id'] ?>][link]"
                    value="<?= htmlspecialchars($row['link']) ?>"
                    placeholder="Platform link">

                <a href="delete.php?id=<?= $row['id'] ?>"
                class="delete-social"
                onclick="return confirm('Are you sure you want to delete this social link?');">
                    Delete
                </a>
            </div>

        <?php endwhile; ?>

        <h3>Add New Social Link</h3>

        <input type="text"
               name="new_platform"
               placeholder="Platform name (e.g. Twitter)">

        <input type="url"
               name="new_link"
               placeholder="Platform link">

        <button type="submit">Save Changes</button>
    </form>

</div>

</body>
</html>
