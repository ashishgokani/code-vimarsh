<?php
// Start session to store admin login information
session_start();

// Include database connection file
require_once "../config/db.php";

// Variable to store error message
$error = "";

// Check if login form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {
        // Get form inputs and remove extra spaces
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        // Validate inputs
        if (empty($email) || empty($password)) {
            throw new Exception("Email and Password are required.");
        }

        // Prepare SQL query (secure from SQL injection)
        $stmt = $conn->prepare("SELECT id, password FROM admins WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        // Fetch result
        $result = $stmt->get_result();

        // Check if admin exists
        if ($result->num_rows === 1) {

            $admin = $result->fetch_assoc();

            // Verify hashed password
            if (password_verify($password, $admin['password'])) {

                // Store admin id in session
                $_SESSION['admin_id'] = $admin['id'];

                // Redirect to dashboard
                header("Location: dashboard.php");
                exit();

            } else {
                throw new Exception("Invalid email or password.");
            }

        } else {
            throw new Exception("Invalid email or password.");
        }

    } catch (Exception $e) {
        // Store error message safely
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login | Code Vimarsh</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Admin CSS -->
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<div class="auth-container">
    <div class="auth-box">
        <h2>Admin Login</h2>

        <!-- Display error if exists -->
        <?php if (!empty($error)) : ?>
            <div class="error-message">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <!-- Login form -->
        <form method="POST">
            <label>Email</label>
            <input type="email" name="email" required placeholder="Enter admin email">

            <label>Password</label>
            <input type="password" name="password" required placeholder="Enter password">

            <button type="submit">Login</button>
        </form>

        <div class="auth-link">
            <a href="forgot-password.php">Forgot Password?</a>
        </div>
    </div>
</div>

</body>
</html>
