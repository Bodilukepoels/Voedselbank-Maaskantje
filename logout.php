<?php
session_start(); // Start the session

// Cookies on logout
setcookie("admin_logged_in", "", time() - 3600); // Remove the cookie

// Clear the session
session_destroy();

header("Location: index.php");
exit();
?>