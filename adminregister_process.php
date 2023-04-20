<?php
require_once 'config.php';

if (isset($_POST['username'], $_POST['password'], $_POST['confirm_password'])) {
    if ($_POST['password'] === $_POST['confirm_password']) {
        $username = $_POST['username'];
        $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

        try {
            $sql = "INSERT INTO admins (username, password_hash) VALUES (:username, :password_hash)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password_hash', $password_hash);
            $stmt->execute();

            header("Location: admin_login.php");
            exit();
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                // Duplicate entry error
                echo "Gebruikers naam is al gebruikt.";
            } else {
                echo "Error: " . $e->getMessage();
            }
        }
    } else {
        echo "Wachtwoorden zijn niet hetzelfde!";
    }
} else {
    header("Location: register.php");
    exit();
}
