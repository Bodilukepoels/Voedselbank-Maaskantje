<?php
    session_start();
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        include "config.php";

        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
            $productId = $_GET['id'];

            try {
                $sql = "DELETE FROM producten WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$productId]);

                header("Location: productentoevoegen.php?success=1");
                exit();
            } catch (PDOException $e) {
                header("Location: productentoevoegen.php?success=0");
                exit();
            }
        } else {
            header("Location: productentoevoegen.php");
            exit();
        }
    } else {
        header("Location: index.php");
        exit();
    }
?>