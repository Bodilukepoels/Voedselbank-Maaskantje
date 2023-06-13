<?php
include "navigation.php";
include "config.php";

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("Location: index.php");
    exit();
}

try {
    $stmt = $conn->prepare("SELECT * FROM voedselpakket");
    $stmt->execute();
    $packages = $stmt->fetchAll();

    if (count($packages) == 0) {
        $errorMessage = "Er zijn geen voedselpakketten gevonden.";
    }
} catch (PDOException $e) {
    $errorMessage = "Er is een fout opgetreden bij het ophalen van de voedselpakketten: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>Details voedselpakket</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 600px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .product-list {
            list-style-type: none;
            padding: 0;
        }

        .product-item {
            margin-bottom: 10px;
        }

        .product-name {
            font-weight: bold;
        }

        .product-quantity {
            margin-left: 10px;
        }

        .error-message {
            color: red;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php if (isset($errorMessage)) : ?>
            <p class="error-message"><?php echo $errorMessage; ?></p>
        <?php else : ?>
            <?php foreach ($packages as $package) : ?>
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Details voedselpakket</h2>
                    </div>
                    <div class="card-body">
                        <p><strong>Naam van het voedselpakket:</strong> <?php echo $package['naam']; ?></p>
                        <p><strong>Aantal pakketten:</strong> <?php echo $package['aantal_pakketten']; ?></p>
                        <p><strong>Samenstellingsdatum:</strong> <?php echo $package['samenstellingsdatum']; ?></p>
                        <p><strong>Ophaaldatum:</strong> <?php echo $package['ophaaldatum']; ?></p>
                        <p><strong>Geselecteerde producten:</strong> <?php echo $package['producten']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div><br>
    <CENTER><img src="https://cdn.pixabay.com/photo/2012/04/24/16/17/box-40302_960_720.png" width="200px" style="cursor: pointer;">
</body>
</html> 
