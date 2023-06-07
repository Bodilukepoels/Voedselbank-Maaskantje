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
            // Start the session
            session_start();
            
            // Store user details in session variables
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $login['AccountID'];
            $_SESSION['user_email'] = $login['Email'];
            $_SESSION['user_name'] = $login['Naam'];
            
            header("Location: index.php");
            exit();
        } else {
            echo "<p style='color: black'>Incorrecte wachtwoord of email, probeer opnieuw.</p>";
        }
    } else {
        echo "<p style='color: black'>Incorrecte wachtwoord of email, probeer opnieuw.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 400px;
            margin: 0 auto;
            margin-top: 100px;
        }

        h1, label {
            color: black;
            text-align: center;
        }

        .noacc {
            color: black;
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <?php
    include 'navigation.php';
    ?>
    <div class="container">
        <h1>Login</h1>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="Email">Email:</label>
                <input type="text" class="form-control" name="Email" id="Email" required>
            </div>

            <div class="form-group">
                <label for="Wachtwoord">Wachtwoord:</label>
                <input type="password" class="form-control" name="Wachtwoord" id="Wachtwoord" required>
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary" id="login" value="Login">
            </div>

            <h6 class="noacc">Geen account? <a href="register.php" id="link">Klik hier.</a></h6>
        </form>
    </div>
</body>
</html>
