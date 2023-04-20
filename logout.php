<?php //cookies
setcookie("admin_logged_in", "", time() - 3600); // Remove the cookie
header("Location: admin_login.php");
exit();
?>