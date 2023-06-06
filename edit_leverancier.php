<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Naam = $_POST['Naam'];
        $Mail = $_POST['Mail'];
        $Telefoonnummer = $_POST['Telefoonnummer'];
        $Postcode = $_POST['postcode'];
        $bezorgingsdatum = $_POST['bezorgingsdatum'];
        $bezorgingstijd = $_POST['bezorgingstijd'];

    try {
        $sql = "UPDATE leveranciers SET Naam = ?, Mail = ?, Telefoonnummer = ?, postcode = ?, bezorgingsdatum = ?, bezorgingstijd = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$Naam, $Mail, $Telefoonnummer, $Postcode, $bezorgingsdatum, $bezorgingstijd, $id]);
        header("Location: leverancierstoevoegen.php?success=1");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if (!isset($_GET['id'])) {
    echo "No leveranciers selected.";
    exit;
}

try {
    $sql = "SELECT * FROM leveranciers WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_GET['id']]);
    $leveranciers = $stmt->fetch();
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
    <title>Edit Leveranciers</title>
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
            margin-left: 15px;
        }

        input[type="submit"] {
            margin: 0 auto;
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit leveranciers</h1>
        <form action="edit_leveranciers.php" method="POST">
            <div class="form-group">
                <label for="Naam">Naam:</label>
                <input type="hidden" name="id" value="<?php echo $leveranciers['Naam']; ?>">
                <input type="text" class="form-control" id="Naam" name="Naam" value="<?php echo $leveranciers['Naam']; ?>" required>
            </div>

            <div class="form-group">
                <label for="Mail">Mail:</label>
                <input type="text" class="form-control" id="Mail" name="Mail" value="<?php echo $leveranciers['Mail']; ?>" required>
            </div>

            <div class="form-group">
                <label for="Telefoonnummer">Telefoonnummer:</label>
                <input type="number" class="form-control" id="Telefoonnummer" name="Telefoonnummer" value="<?php echo $leveranciers['Telefoonnummer']; ?>" required>
            </div>

            <div class="form-group">
                <label for="Postcode">Postcode:</label>
                <input type="text" class="form-control" id="Postcode" name="Postcode" value="<?php echo $leveranciers['Postcode']; ?>" required>
            </div>

            <div class="form-group">
                <label for="bezorgingsdatum">Bezorgingsdatum:</label>
                <input type="date" class="form-control" id="bezorgingsdatum" name="bezorgingsdatum" value="<?php echo $leveranciers['bezorgingsdatum']; ?>" required>
            </div>

            <div class="form-group">
                <label for="bezorgingstijd">Bezorgingstijd:</label>
                <input type="time" class="form-control" id="bezorgingstijd" name="bezorgingstijd" value="<?php echo $leveranciers['bezorgingstijd']; ?>" required>
            </div>

            <input type="submit" class="btn btn-primary" value="Update Leveranciers">
        </form>
    </div>
</body>
</html>
