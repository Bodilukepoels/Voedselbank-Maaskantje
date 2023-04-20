<?php
require_once 'config.php';

if (isset($_POST['username'], $_POST['password'])) {
    $sql = "SELECT * FROM user WHERE username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $_POST['username']);
    $stmt->execute();

    if ($stmt->rowCount() === 1) {
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($_POST['password'], $admin['password_hash'])) {
            header("Location: index.php");
            exit();
        }
    }

    echo "Incorrecte wachtwoord of gebruikers naam probeer opnieuw.";
}?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Login</h1>
    <form action="admin_login.php" method="post">
        <label for="username">Gebruikers Naam:</label>
        <input type="text" name="username" id="username" required><br>
        <label for="password">Wachtwoord:</label>
        <input type="password" name="password" id="password" required><br>
        <input type="submit" value="Login">
    </form>
</br>
    <a href="register.php">Registreer</a>
</body>
</html>
