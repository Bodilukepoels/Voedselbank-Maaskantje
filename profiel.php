<?php
include "navigation.php";
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}
require_once 'config.php';

$userId = $_SESSION['user_id'];
try {
    $sql = "SELECT * FROM user WHERE AccountID = :accountId";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':accountId', $userId);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "Verbinding mislukt: " . $e->getMessage();
    exit();
}

$roleLabels = [
    0 => 'Vrijwilliger',
    2 => 'Medewerker',
    3 => 'Directie'
];
$role = isset($user['role']) ? $roleLabels[$user['role']] : 'Onbekend';

// Wachtwoord wijziging status
$passwordChangeStatus = null;

if (isset($_POST['newPassword']) && isset($_POST['currentPassword'])) {
    $newPassword = $_POST['newPassword'];
    $currentPassword = $_POST['currentPassword'];

    if (password_verify($currentPassword, $user['Wachtwoord'])) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $sql = "UPDATE user SET Wachtwoord = :password WHERE AccountID = :accountId";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':accountId', $userId);
        $stmt->execute();

        $passwordChangeStatus = 'success';
    } else {
        $passwordChangeStatus = 'error';
    }
}

?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profiel</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 400px;
            margin: 0 auto;
            margin-top: 100px;
            text-align: center;
            border: 1px solid #ccc;
            padding: 20px;
        }

        h1, label {
            color: black;
        }

        .noacc {
            color: black;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welkom, <?php echo $user['Naam']; ?>!</h1>
        <p>Rol: <?php echo $role; ?></p>

        <h3>Wijzig Wachtwoord</h3>
        <?php if ($passwordChangeStatus === 'success') { ?>
            <div class="alert alert-success" role="alert">
                Wachtwoord succesvol gewijzigd.
            </div>
        <?php } elseif ($passwordChangeStatus === 'error') { ?>
            <div class="alert alert-danger" role="alert">
                Ongeldig huidig wachtwoord. Probeer het opnieuw.
            </div>
        <?php } ?>
        <button id="changePasswordBtn" class="btn btn-primary">Wijzig Wachtwoord</button>
        <div id="passwordForm" style="display: none;">
            <form action="profiel.php" method="post">
                <div class="form-group">
                    <label for="currentPassword">Huidig Wachtwoord:</label>
                    <input type="password" class="form-control" name="currentPassword" id="currentPassword" required>
                </div>
                <div class="form-group">
                    <label for="newPassword">Nieuw Wachtwoord:</label>
                    <input type="password" class="form-control" name="newPassword" id="newPassword" required>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Wijzig Wachtwoord">
                </div>
            </form>
        </div>

        <div class="noacc">
            <a href="logout.php">Uitloggen</a>
        </div>
    </div>

    <script>
        document.getElementById("changePasswordBtn").addEventListener("click", function() {
            document.getElementById("changePasswordBtn").style.display = "none";
            document.getElementById("passwordForm").style.display = "block";
        });
    </script>
</body>
</html>
