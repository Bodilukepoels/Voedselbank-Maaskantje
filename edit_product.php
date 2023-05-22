<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $naam = $_POST['naam'];
    $beschrijving = $_POST['beschrijving'];
    $voorraad = $_POST['voorraad'];
    $eanNummer = $_POST['eanNummer'];

    try {
        $sql = "UPDATE producten SET naam = ?, beschrijving = ?, voorraad = ?, `EAN-Nummer` = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$naam, $beschrijving, $voorraad, $eanNummer, $id]);
        header("Location: productentoevoegen.php?success=1");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if (!isset($_GET['id'])) {
    echo "No product selected.";
    exit;
}

try {
    $sql = "SELECT * FROM producten WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_GET['id']]);
    $product = $stmt->fetch();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<CENTER> <h1>Edit Product</h1>
    <form action="edit_product.php" method="POST">
        
        <div style="display: flex; width: 350px;">

        <div style="width: 120px;"><label for="naam">Naam:</label>
        <label for="beschrijving">Beschrijving:</label>
        <label for="voorraad">Voorraad:</label>
        <label for="eanNummer">EAN Nummer:</label></div>

        <div style="width: 120px; line-height: 26px;"><input type="hidden" name="id" value="<?php echo $product['id']; ?>">
        <input type="text" id="naam" name="naam" value="<?php echo $product['naam']; ?>" required><br>
        <input type="text" id="beschrijving" name="beschrijving" value="<?php echo $product['beschrijving']; ?>" required><br>
        <input type="number" id="voorraad" name="voorraad" value="<?php echo $product['voorraad']; ?>" required><br>
        <input type="text" id="eanNummer" name="eanNummer" value="<?php echo $product['EAN-Nummer']; ?>" required><br>
        </div></div>
        <input type="submit" value="Update Product">
</CENTER>

    </form>
</body>
</html>
