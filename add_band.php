<?php
require_once 'config.php';

if (isset($_POST['band_name'], $_POST['genre'])) {
    $sql = "INSERT INTO bands (name, genre) VALUES (:name, :genre)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $_POST['band_name']);
    $stmt->bindParam(':genre', $_POST['genre']);
    $stmt->execute();
}

header("Location: admin.php");
exit();
