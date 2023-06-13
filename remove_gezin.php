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

            header("Location: gezintoevoegen.php?success=1");
            exit();
        } catch (PDOException $e) {
            header("Location: gezintoevoegen.php?success=2");
            exit();
        }
    } else {
        header("Location: gezintoevoegen.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>