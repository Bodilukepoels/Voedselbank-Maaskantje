<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    include "config.php";

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
        $leverancierId = $_GET['id'];

        try {
            $sql = "DELETE FROM leveranciers WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$leverancierId]);

            header("Location: leverancierstoevoegen.php?success=1");
            exit();
        } catch (PDOException $e) {
            header("Location: leverancierstoevoegen.php?success=0");
            exit();
        }
    } else {
        header("Location: leverancierstoevoegen.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>
