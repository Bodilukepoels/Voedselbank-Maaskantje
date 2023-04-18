<?php
require_once 'config.php';

if (isset($_POST['event_name'], $_POST['event_date'], $_POST['start_time'], $_POST['price'])) {
    $sql = "INSERT INTO events (name, event_date, start_time, price) VALUES (:name, :event_date, :start_time, :price)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $_POST['event_name']);
    $stmt->bindParam(':event_date', $_POST['event_date']);
    $stmt->bindParam(':start_time', $_POST['start_time']);
    $stmt->bindParam(':price', $_POST['price']);
    $stmt->execute();
}

header("Location: admin.php");
exit();
