<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function validateForm() {
            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("confirm_password").value;
            
            if (password !== confirmPassword) {
                alert("Wachtwoorden zijn niet hetzelfde!");
                return false;
            }
            
            return true;
        }
    </script>
</head>
<body> <!--- formulier voor registratie --->
<?php
    include 'navigation.php';
    ?>
    <div class="container" style="height: 470px;">
    <h1>Registreer Account</h1>
    <div style="line-height: 30px;">
    <form action="register_process.php" method="post" onsubmit="return validateForm()">
        <label for="naam">Naam:</label><br>
        <input type="text" name="naam" id="naam" required><br>

        <label for="email">Email:</label><br>
        <input type="email" name="email" id="email" required><br>

        <label for="telefoonnummer">Telefoonnummer:</label><br>
        <input type="text" name="telefoonnummer" id="telefoonnummer" required><br>

        <label for="password">Wachtwoord:</label><br>
        <input type="password" name="password" id="password" required><br>

        <label for="confirm_password">Wachtwoord Bevestigen:</label><br>
        <input type="password" name="confirm_password" id="confirm_password" required><br><br>

        <input type="submit" id="login" value="Registreer"><br>

        <h2 class="noacc">Heb je al een account? <a href="login.php" id="link">Klik hier.</a></h2>
    </form>
    </div>
    </div>
</body>
</html>
