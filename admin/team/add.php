<?php
// Protect admin page
require_once "../../config/auth.php";

// Database connection
require_once "../../config/db.php";

// Error message variable
$error = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    try {
        // Get and clean inputs
        $name = trim($_POST['name']);
        $role = trim($_POST['role']);
        $category_raw = trim($_POST['category']);
        $linkedin_url = trim($_POST['linkedin_url']);

        // Validate inputs
        if (empty($name) || empty($role) || empty($category_raw) || empty($linkedin_url)) {
            throw new Exception("All fields are required.");
        }

        // Normalize category (store in lowercase)
        $category = strtolower($category_raw);

        // Validate LinkedIn URL
        if (!filter_var($linkedin_url, FILTER_VALIDATE_URL)) {
            throw new Exception("Please enter a valid LinkedIn URL.");
        }

        // Validate image upload
        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== 0) {
            throw new Exception("Profile image is required.");
        }

        $image = $_FILES['image'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

        if (!in_array($image['type'], $allowedTypes)) {
            throw new Exception("Only JPG and PNG images are allowed.");
        }

        // Generate unique image name
        $imageName = time() . "_" . basename($image['name']);
        $uploadPath = "../../assets/images/team/" . $imageName;

        // Upload image
        if (!move_uploaded_file($image['tmp_name'], $uploadPath)) {
            throw new Exception("Failed to upload profile image.");
        }

        // Insert team member into database
        $stmt = $conn->prepare(
            "INSERT INTO team (name, role, category, image, linkedin_url)
             VALUES (?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "sssss",
            $name,
            $role,
            $category,
            $imageName,
            $linkedin_url
        );

        $stmt->execute();

        // Flash success message
        $_SESSION['success_message'] = "Team member added successfully.";

        // Redirect to team list
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
    <title>Add Team Member | Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Admin CSS -->
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>
<body>

<div class="dashboard-container">

    <h1 class="dashboard-title">Add Team Member</h1>

    <!-- Back button -->
    <a href="list.php" class="back-btn">← Back to Team</a>

    <!-- Error message -->
    <?php if (!empty($error)) : ?>
        <div class="error-message">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <!-- Add Team Member Form -->
    <form method="POST" enctype="multipart/form-data" class="form-box">

        <label>Full Name</label>
        <input type="text" name="name" required>

        <label>Role / Designation</label>
        <input type="text" name="role" required>

        <label>Category (e.g. Initiators, Web Team, etc.)</label>
        <input type="text" name="category" placeholder="Enter team category" required>

        <label>LinkedIn Profile URL</label>
        <input type="url" name="linkedin_url" placeholder="https://linkedin.com/in/username" required>

        <label>Profile Image</label>
        <input type="file" name="image" accept="image/*" required>

        <button type="submit">Add Member</button>
    </form>

</div>

</body>
</html>
