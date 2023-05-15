<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
        include "navigation.php";
    ?>

<h1>Producten toevoegen</h1>
<h2>Add a new product</h2>
<form style="display:block; line-height: 5px" action="alleproducten.php" method="POST">
    <label style="padding-right: 60px;" for="naam">Name:</label>
    <input type="text" id="naam" name="naam" required style="border: 1px solid gray; margin-top: 5px"><br>
    <label style="padding-right: 16px;" for="beschrijving">Beschrijving:</label>
    <input type="text" id="beschrijving" name="beschrijving" required style="border: 1px solid gray; margin-top: 5px"><br>
    <label style="padding-right: 37px;" for="voorraad">Voorraad:</label>
    <input type="number" id="voorraad" name="voorraad" required style="border: 1px solid gray; margin-top: 5px"><br>
    <label style="padding-right: 4px;" for="eanNummer">EAN Nummer:</label>
    <input type="text" id="eanNummer" name="eanNummer" required style="border: 1px solid gray; margin-top: 5px"><br>
    <label style="padding-right: 58px;" for="image">Image:</label>
    <input type="text" id="image" name="image" required style="border: 1px solid gray; margin-top: 5px"><br><br>
    <input style="cursor:pointer"type="submit" value="Add Product">
</form>


    <h2>Bestaande producten</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Naam</th>
            <th>Beschrijving</th>
            <th>Voorraad</th>
            <th>EAN Nummer</th>
            <th>Actions</th>
        </tr>
        <?php
        include 'config.php';

        if (isset($_GET['success']) && $_GET['success'] == 1) {
            echo "Product updated successfully.";
        } else if (isset($_GET['success']) && $_GET['success'] <> 1){
            echo "Something went wrong.";
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $naam = $_POST['naam'];
            $beschrijving = $_POST['beschrijving'];
            $voorraad = $_POST['voorraad'];
            $eanNummer = $_POST['eanNummer'];
            $image = $_POST['image'];

            try {
                $sql = "INSERT INTO producten (naam, beschrijving, voorraad, `EAN-Nummer`, `image`) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$naam, $beschrijving, $voorraad, $eanNummer, $image]);
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        try {
            $sql = "SELECT * FROM producten";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $products = $stmt->fetchAll();

            foreach ($products as $product) {
                echo "<tr>";
                echo "<td>" . $product['id'] . "</td>";
                echo "<td>" . $product['naam'] . "</td>";
                echo "<td>" . $product['beschrijving'] . "</td>";
                echo "<td>" . $product['voorraad'] . "</td>";
                echo "<td>" . $product['EAN-Nummer'] . "</td>";
                echo "<td><a href='edit_product.php?id=" . $product['id'] . "'>Edit</a></td>";
                echo "</tr>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>
    </table>
</body>
</html>
