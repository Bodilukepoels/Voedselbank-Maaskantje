<?php
include "navigation.php";
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    include "config.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['quantities']) && !empty($_POST['quantities'])) {
            $quantities = $_POST['quantities'];
            $selectedProducts = [];
            $placeholders = implode(",", array_fill(0, count($quantities), "?"));

            try {
                $stmt = $conn->prepare("SELECT * FROM producten WHERE id IN ($placeholders)");
                $stmt->execute(array_keys($quantities));
                $selectedProducts = $stmt->fetchAll();
            } catch (PDOException $e) {
                echo "<div class='alert alert-danger'>" . $e->getMessage() . "</div>";
                exit();
            }

            $foodPackage = [];

            foreach ($selectedProducts as $product) {
                $productId = $product['id'];
                $requestedQuantity = $quantities[$productId];
                $availableQuantity = $product['voorraad'];

                if ($requestedQuantity <= $availableQuantity) {
                    $foodPackage[] = $product['naam'] . ' x' . $requestedQuantity;
                } else {
                    echo "<div class='alert alert-danger'>Requested quantity for '{$product['naam']}' exceeds the available stock.</div>";
                }
            }

            if (!empty($foodPackage)) {
                unset($_POST['quantities']);
                $numberOfPackages = $_POST['numberOfPackages'];
                $pickupDate = $_POST['pickupDate'];

                try {
                    $stmt = $conn->prepare("INSERT INTO voedselpakket (producten, aantal_pakketten, ophaaldatum) VALUES (:producten, :aantal_pakketten, :ophaaldatum)");

                    for ($i = 0; $i < $numberOfPackages; $i++) {
                        $stmt->bindParam(':producten', implode(", ", $foodPackage));
                        $stmt->bindParam(':aantal_pakketten', $requestedQuantity);
                        $stmt->bindParam(':ophaaldatum', $pickupDate);
                        $stmt->execute();
                    }

                    echo "<div class='alert alert-success'>Food package created successfully!</div>";
                } catch (PDOException $e) {
                    echo "<div class='alert alert-danger'>Error inserting food package into the database: " . $e->getMessage() . "</div>";
                }
            }
        } else {
            echo "<div class='alert alert-danger'>No quantities submitted.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Invalid request method.</div>";
    }
} else {
    header("Location: index.php");
    exit();
}
?>
