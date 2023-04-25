<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Admin</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
        <?php
    include 'navigation.php';
    ?>
    <div class="container">
    <h1>Register Admin</h1>
    <form action="adminregister_process.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br><br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" id="confirm_password" required><br><br>
        <input type="submit" id="login" value="Register"><br>
    </form>
</div>
</body>
</html>
