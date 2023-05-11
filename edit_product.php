<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $naam = $_POST['naam'];
    $beschrijving = $_POST['beschrijving'];
    $voorraad = $_POST['voorraad'];
    $eanNummer = $_POST['eanNummer'];
    $image = $_POST['image'];

    try {
        $sql = "UPDATE producten SET naam = ?, beschrijving = ?, voorraad = ?, `EAN-Nummer` = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$naam, $beschrijving, $voorraad, $eanNummer, $id]);
        echo "Product updated successfully.";
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
</head>
<body>
    <h1>Edit Product</h1>
    <form action="edit_product.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
        <label for="naam">Name:</label>
        <input type="text" id="naam" name="naam" value="<?php echo $product['naam']; ?>" required><br>
        <label for="beschrijving">Description:</label>
        <input type="text" id="beschrijving" name="beschrijving" value="<?php echo $product['beschrijving']; ?>" required><br>
        <label for="voorraad">Stock:</label>
        <input type="number" id="voorraad" name="voorraad" value="<?php echo $product['voorraad']; ?>" required><br>
        <label for="eanNummer">EAN Number:</label>
        <input type="text" id="eanNummer" name="eanNummer" value="<?php echo $product['EAN-Nummer']; ?>" required><br>
        <input type="submit" value="Update Product">
    </form>
</body>
</html>
