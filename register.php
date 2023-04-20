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
    <h1>Registreer Account</h1>
    <form action="register_process.php" method="post" onsubmit="return validateForm()">
        <label for="username">Gebruikers Naam:</label>
        <input type="text" name="username" id="username" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>

        <label for="password">Wachtwoord:</label>
        <input type="password" name="password" id="password" required><br>

        <label for="confirm_password">Wachtwoord Bevestigen:</label>
        <input type="password" name="confirm_password" id="confirm_password" required><br>

        <label for="naam">Naam:</label>
        <input type="text" name="naam" id="naam" required><br>

        <label for="adres">Adres:</label>
        <input type="text" name="adres" id="adres" required><br>

        <label for="telefoonnummer">Telefoonnummer:</label>
        <input type="text" name="telefoonnummer" id="telefoonnummer" required><br>

        <input type="submit" value="Registreer">
    </form>
</body>
</html>
