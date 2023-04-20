<?php
require_once 'config.php';

if (isset($_POST['email'], $_POST['password'], $_POST['confirm_password'])) {
    if ($_POST['password'] === $_POST['confirm_password']) {
        $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        print_r($_POST);
        try {
            $sql = "INSERT INTO user (Email, Wachtwoord, Naam, Adres, Telefoonnummer) VALUES (:Email, :Wachtwoord, :Naam, :Adres, :Telefoonnummer)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':Email', $_POST['email']);
            $stmt->bindParam(':Wachtwoord', $password_hash);
            $stmt->bindParam(':Naam', $_POST['naam']);
            $stmt->bindParam(':Adres', $_POST['adres']);
            $stmt->bindParam(':Telefoonnummer', $_POST['telefoonnummer']);
            $stmt->execute();

            header("Location: login.php");
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
} /*else {
    header("Location: register.php");
    exit();
}
*/