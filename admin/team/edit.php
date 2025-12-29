<?php
// Protect admin page
require_once "../../config/auth.php";

// Database connection
require_once "../../config/db.php";

// Validate team member ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: list.php");
    exit();
}

$member_id = (int) $_GET['id'];
$error = "";

// Fetch existing team member
try {
    $stmt = $conn->prepare("SELECT * FROM team WHERE id = ?");
    $stmt->bind_param("i", $member_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows !== 1) {
        header("Location: list.php");
        exit();
    }

    $member = $result->fetch_assoc();

} catch (Exception $e) {
    die("Error loading team member");
}

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

        // Normalize category (store lowercase)
        $category = strtolower($category_raw);

        // Validate LinkedIn URL
        if (!filter_var($linkedin_url, FILTER_VALIDATE_URL)) {
            throw new Exception("Please enter a valid LinkedIn URL.");
        }

        // Default: keep old image
        $imageName = $member['image'];

        // If new image uploaded
        if (!empty($_FILES['image']['name'])) {

            $image = $_FILES['image'];
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

            if (!in_array($image['type'], $allowedTypes)) {
                throw new Exception("Only JPG and PNG images are allowed.");
            }

            $imageName = time() . "_" . basename($image['name']);
            $uploadPath = "../../assets/images/team/" . $imageName;

            if (!move_uploaded_file($image['tmp_name'], $uploadPath)) {
                throw new Exception("Failed to upload profile image.");
            }

            // Delete old image file
            $oldImagePath = "../../assets/images/team/" . $member['image'];
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        // Update team member
        $stmt = $conn->prepare(
            "UPDATE team
             SET name = ?, role = ?, category = ?, image = ?, linkedin_url = ?
             WHERE id = ?"
        );

        $stmt->bind_param(
            "sssssi",
            $name,
            $role,
            $category,
            $imageName,
            $linkedin_url,
            $member_id
        );

        $stmt->execute();

        // Flash success message
        $_SESSION['success_message'] = "Team member updated successfully.";

        // Redirect back to team list
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
    <title>Edit Team Member | Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Admin CSS -->
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>
<body>

<div class="dashboard-container">

    <h1 class="dashboard-title">Edit Team Member</h1>

    <!-- Back button -->
    <a href="list.php" class="back-btn">← Back to Team</a>

    <!-- Error message -->
    <?php if (!empty($error)) : ?>
        <div class="error-message">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <!-- Edit Team Member Form -->
    <form method="POST" enctype="multipart/form-data" class="form-box">

        <label>Full Name</label>
        <input type="text" name="name"
               value="<?= htmlspecialchars($member['name']) ?>" required>

        <label>Role / Designation</label>
        <input type="text" name="role"
               value="<?= htmlspecialchars($member['role']) ?>" required>

        <label>Category</label>
        <input type="text" name="category"
               value="<?= htmlspecialchars($member['category']) ?>" required>

        <label>LinkedIn Profile URL</label>
        <input type="url" name="linkedin_url"
               value="<?= htmlspecialchars($member['linkedin_url']) ?>" required>

        <label>Change Profile Image (optional)</label>
        <input type="file" name="image" accept="image/*">

        <button type="submit">Update Member</button>
    </form>

</div>

</body>
</html>