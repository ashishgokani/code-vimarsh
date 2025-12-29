<?php
// Start the session
// Session is needed to store login information
session_start();

// Check if admin is logged in or not
// We will set $_SESSION['admin_id'] after successful login
if (!isset($_SESSION['admin_id'])) {

    // If admin is NOT logged in,
    // redirect user to login page
    header("Location: /code-vimarsh/admin/login.php");

    // Stop further execution of the page
    exit();
}
?>
