<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    include "config.php";

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
        $gezinnenId = $_GET['id'];

        try {
            $sql = "DELETE FROM gezinnen WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$gezinnenId]);

            header("Location: overzichtklanten1.php?success=1");
            exit();
        } catch (PDOException $e) {
            header("Location: overzichtklanten1.php?success=0");
            exit();
        }
    } else {
        header("Location: overzichtklanten1.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>
