<?php
require_once 'config.php';
//wachtwoord en username van de adim
if (isset($_POST['username'], $_POST['password'])) {
    $sql = "SELECT * FROM admins WHERE username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $_POST['username']);
    $stmt->execute();

    if ($stmt->rowCount() === 1) {
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($_POST['password'], $admin['password_hash'])) {
            setcookie("admin_logged_in", "true", time() + 3600); // Cookie expires in 1 hour
            header("Location: admin.php");
            exit();
        }
    }

    echo "Incorrecte wachtwoord of gebruikers naam probeer opnieuw.";
}
//als je goeieinlog gegevens hebt gegeven dan word je doorgestuurd naar de admin pagina
if (isset($_COOKIE['admin_logged_in']) && $_COOKIE['admin_logged_in'] == "true") {
    echo "logged in";
    header("Location: admin.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Admin Login</h1>
    <form action="admin_login.php" method="post">
        <label for="username">Gebruikers Naam:</label>
        <input type="text" name="username" id="username" required><br>
        <label for="password">Wachtwoord:</label>
        <input type="password" name="password" id="password" required><br>
        <input type="submit" value="Login">
    </form>
    <a href="register.php">Registreer</a>
</body>
</html>
