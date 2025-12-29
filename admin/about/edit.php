<?php
// Protect page (admin only)
require_once "../../config/auth.php";

// Database connection
require_once "../../config/db.php";

// Fetch existing About Us data
try {
    $stmt = $conn->prepare("SELECT * FROM about LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
    $about = $result->fetch_assoc();
} catch (Exception $e) {
    die("Error fetching About Us data");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    try {
        // Clean inputs
        $heading = trim($_POST['heading']);
        $description = trim($_POST['description']);
        $join_link = trim($_POST['join_link']);

        // Validation
        if (empty($heading) || empty($description) || empty($join_link)) {
            throw new Exception("All fields are required.");
        }

        // Update About Us
        $stmt = $conn->prepare(
            "UPDATE about SET heading = ?, description = ?, join_link = ? WHERE id = ?"
        );
        $stmt->bind_param(
            "sssi",
            $heading,
            $description,
            $join_link,
            $about['id']
        );
        $stmt->execute();

        // Set flash message for dashboard
        $_SESSION['success_message'] = "About Us updated successfully.";

        // Redirect to dashboard (POST → REDIRECT → GET)
        header("Location: ../dashboard.php");
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
    <title>Edit About Us | Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Admin CSS -->
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>
<body>

<div class="dashboard-container">

    <h1 class="dashboard-title">Edit About Us</h1>

    <!-- Back button -->
    <a href="../dashboard.php" class="back-btn">← Back to Dashboard</a>

    <!-- Error message only (no success here now) -->
    <?php if (!empty($error)) : ?>
        <div class="error-message">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="form-box">

        <label>Heading</label>
        <input type="text" name="heading"
               value="<?= htmlspecialchars($about['heading']) ?>" required>

        <label>Description</label>
        <textarea name="description" rows="6" required><?= htmlspecialchars($about['description']) ?></textarea>

        <label>Join Community Button Link</label>
        <input type="url" name="join_link"
               value="<?= htmlspecialchars($about['join_link']) ?>" required>

        <button type="submit">Save Changes</button>
    </form>

</div>

</body>
</html>
