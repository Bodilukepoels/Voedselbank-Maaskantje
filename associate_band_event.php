<?php
require_once 'config.php';

if (isset($_POST['event_id'], $_POST['band_id'])) {
    $sql = "INSERT INTO event_bands (event_id, band_id) VALUES (:event_id, :band_id)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':event_id', $_POST['event_id']);
    $stmt->bindParam(':band_id', $_POST['band_id']);
    $stmt->execute();
}

header("Location: admin.php");
exit();
