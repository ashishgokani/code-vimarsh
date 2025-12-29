<?php
// Protect admin page
require_once "../../config/auth.php";

// Database connection
require_once "../../config/db.php";

// Fetch all team members
try {
    $stmt = $conn->prepare("SELECT * FROM team ORDER BY category, name");
    $stmt->execute();
    $result = $stmt->get_result();
} catch (Exception $e) {
    die("Error fetching team members");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Team | Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Admin CSS -->
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>
<body>

<div class="dashboard-container">

    <h1 class="dashboard-title">Manage Team Members</h1>

    <a href="../dashboard.php" class="back-btn">← Back to Dashboard</a>

    <!-- Flash success message -->
    <?php if (isset($_SESSION['success_message'])) : ?>
        <div class="info-message">
            <?= htmlspecialchars($_SESSION['success_message']) ?>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <!-- Add Member Button -->
    <div class="top-actions">
        <a href="add.php" class="primary-btn">+ Add Team Member</a>
    </div>

    <!-- Team Table -->
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Category</th>
                    <th>LinkedIn</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

            <?php if ($result->num_rows > 0) : ?>
                <?php while ($member = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?= htmlspecialchars($member['name']) ?></td>
                        <td><?= htmlspecialchars($member['role']) ?></td>
                        <td><?= htmlspecialchars($member['category']) ?></td>
                        <td>
                            <a href="<?= htmlspecialchars($member['linkedin_url']) ?>"
                               target="_blank">View</a>
                        </td>
                        <td>
                            <a href="edit.php?id=<?= $member['id'] ?>" class="action-btn edit">
                                Edit
                            </a>
                            <a href="delete.php?id=<?= $member['id'] ?>"
                               class="action-btn delete"
                               onclick="return confirm('Are you sure you want to delete this member?');">
                                Delete
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5">No team members found.</td>
                </tr>
            <?php endif; ?>

            </tbody>
        </table>
    </div>

</div>

</body>
</html>
