<?php
require_once 'config.php';

if (isset($_POST['Email'], $_POST['Wachtwoord'])) {
    $sql = "SELECT * FROM user WHERE Email = :Email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':Email', $_POST['Email']);
    $stmt->execute();

    if ($stmt->rowCount() === 1) {
        $login = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($_POST['Wachtwoord'], $login['Wachtwoord'])) {
            // Set session variables
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $login['id'];
            $_SESSION['user_email'] = $login['Email'];
            $_SESSION['user_name'] = $login['Naam'];
            header("Location: index.php");
            exit();
        }
    }
    echo "Incorrecte wachtwoord of email probeer opnieuw.";
}
?>

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
            <label for="Email">Email:</label> <Br>
            <input type="text" name="Email" id="Email" placeholder= "..." required><br><br>
            <label for="Wachtwoord">Wachtwoord:</label> <Br>
            <input type="password" name="Wachtwoord" id="Wachtwoord" placeholder="..." required><br><br>
            <input style="width: 100px;" type="submit" id="login" value="Login"><br>
        </form>
        <h2 class="noacc">Geen account? <a href="register.php" id="link">Klik hier.</a></h2>
    </div>
</body>
</html>
