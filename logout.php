<?php //cookies on logout
setcookie("admin_logged_in", "", time() - 3600); // Remove the cookie
header("Location: admin_login.php");
exit();
?>