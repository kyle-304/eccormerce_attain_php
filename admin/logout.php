<?php
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the login page
header("Location: admin_login.php");  // Adjust the path based on your directory structure
exit();
?>
