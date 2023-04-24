<?php
require_once 'config.php';
//helpt om sneller in te loggen
if (isset($_POST['Email'], $_POST['Wachtwoord'])) {
    $sql = "SELECT * FROM user WHERE Email = :Email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':Email', $_POST['Email']);
    $stmt->execute();
//word weer doorgestuurd naar goede pagina na correcte inlog
    if ($stmt->rowCount() === 1) {
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($_POST['Wachtwoord'], $admin['Wachtwoord'])) {
            header("Location: index.php");
            exit();
        }
    }
//error voor incorrecte inlog
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
        <?php
    include 'navigation.php';
    ?>
    <div class="container">
    <h1>Login</h1>
    <form action="login.php" method="post">
    <label for="username">Gebruikersnaam:</label> <Br>
        <input type="text" name="username" id="username" placeholder= "..." required><br><br>
        <label for="password">Wachtwoord:</label> <Br>
        <input type="password" name="password" id="password" placeholder="..." required><br><br>
        <input style="width: 100px;" type="submit" id="login" value="Login"><br>
    </form>
     <h2 class="noacc">Geen account? <a href="register.php" id="link">Klik hier.</a></h2>
    </div>
</body>
</html>
