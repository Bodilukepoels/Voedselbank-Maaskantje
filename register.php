<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 400px;
            margin: 0 auto;
            margin-top: 100px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .noacc {
            text-align: center;
            margin-top: 30px;
        }
    </style>
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
<body>
    <div class="container">
        <h1>Registreer Account</h1>
        <form action="register_process.php" method="post" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="naam">Naam:</label>
                <input type="text" class="form-control" name="naam" id="naam" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>

            <div class="form-group">
                <label for="telefoonnummer">Telefoonnummer:</label>
                <input type="text" class="form-control" name="telefoonnummer" id="telefoonnummer" required>
            </div>

            <div class="form-group">
                <label for="password">Wachtwoord:</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Wachtwoord Bevestigen:</label>
                <input type="password" class="form-control" name="confirm_password" id="confirm_password" required>
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Registreer">
            </div>

            <h6 class="noacc">Heb je al een account? <a href="login.php" id="link">Klik hier.</a></h6>
        </form>
    </div>
</body>
</html>
