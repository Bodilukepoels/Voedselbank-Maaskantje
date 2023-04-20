<?php
require_once 'config.php';

if (isset($_POST['Email'], $_POST['Wachtwoord'])) {
    $sql = "SELECT * FROM user WHERE Email = :Email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':Email', $_POST['Email']);
    $stmt->execute();

    if ($stmt->rowCount() === 1) {
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($_POST['Wachtwoord'], $admin['Wachtwoord'])) {
            header("Location: index.php");
            exit();
        }
    }

    echo "Incorrecte wachtwoord of email probeer opnieuw.";
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
    <form action="login.php" method="post">
        <label for="email">Email:</label>
        <input type="text" name="Email" id="Email" required><br>
        <label for="password">Wachtwoord:</label>
        <input type="password" name="Wachtwoord" id="Wachtwoord" required><br>
        <input type="submit" value="Login">
    </form>
</br>
    <a href="register.php">Registreer</a>
</body>
</html>
