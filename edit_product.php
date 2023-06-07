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
        header("Location: productentoevoegen.php?success=3");
        exit;
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
    <style>
        body {
            color: #000;
        }
        
        .container {
            max-width: 400px;
            margin: 0 auto;
            margin-top: 100px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group {
            display: flex;
            margin-bottom: 15px;
        }

        .form-group label {
            width: 120px;
        }

        .form-group input[type="text"],
        .form-group input[type="number"] {
            flex: 1;
            margin-left: 10px;
        }

        input[type="submit"] {
            margin: 0 auto;
            display: block;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Edit Product</h1>
        <form action="edit_product.php" method="POST">
            <div class="form-group">
                <label for="naam">Naam:</label>
                <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                <input type="text" class="form-control" id="naam" name="naam" value="<?php echo $product['naam']; ?>" required>
            </div>

            <div class="form-group">
                <label for="beschrijving">Beschrijving:</label>
                <input type="text" class="form-control" id="beschrijving" name="beschrijving" value="<?php echo $product['beschrijving']; ?>" required>
            </div>

            <div class="form-group">
                <label for="voorraad">Voorraad:</label>
                <input type="number" class="form-control" id="voorraad" name="voorraad" value="<?php echo $product['voorraad']; ?>" required>
            </div>

            <div class="form-group">
                <label for="eanNummer">EAN Nummer:</label>
                <input type="text" class="form-control" id="eanNummer" name="eanNummer" value="<?php echo $product['EAN-Nummer']; ?>" required>
            </div>

            <input type="submit" class="btn btn-primary" value="Update Product">
        </form>
    </div>
</body>
</html>