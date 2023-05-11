<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
        include "navigation.php";
    ?>
    <h1>View Products</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Naam</th>
            <th>Beschrijving</th>
            <th>Voorraad</th>
            <th>EAN Nummer</th>
        </tr>
        <?php
        include 'config.php';

        try {
            $sql = "SELECT * FROM producten";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $products = $stmt->fetchAll();

            foreach ($products as $product) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($product['id']) . "</td>";
                echo "<td>" . htmlspecialchars($product['naam']) . "</td>";
                echo "<td>" . htmlspecialchars($product['beschrijving']) . "</td>";
                echo "<td>" . htmlspecialchars($product['voorraad']) . "</td>";
                echo "<td>" . htmlspecialchars($product['EAN-Nummer']) . "</td>";
                echo "</tr>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>
    </table>
</body>
</html>
    