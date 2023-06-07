<?php
include "navigation.php";
include "config.php";

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("Location: index.php");
    exit();
}

// Retrieve the food package details from the database
if (isset($_GET['package_id'])) {
    $packageId = $_GET['package_id'];

    try {
        $stmt = $conn->prepare("SELECT * FROM voedselpakket WHERE id = :packageId");
        $stmt->bindParam(':packageId', $packageId);
        $stmt->execute();
        $package = $stmt->fetch();

        if (!$package) {
            $errorMessage = "Het voedselpakket met ID " . $packageId . " kon niet worden gevonden.";
        }
    } catch (PDOException $e) {
        $errorMessage = "Er is een fout opgetreden bij het ophalen van het voedselpakket: " . $e->getMessage();
    }
} else {
    $errorMessage = "Geen voedselpakket ID opgegeven.";
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
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Details voedselpakket</h2>
            </div>
            <div class="card-body">
                <?php if (isset($package)) : ?>
                    <p><strong>Naam van het voedselpakket:</strong> <?php echo $package['naam']; ?></p>
                    <p><strong>Aantal pakketten:</strong> <?php echo $package['aantal_pakketten']; ?></p>
                    <p><strong>Ophaaldatum:</strong> <?php echo $package['ophaaldatum']; ?></p>
                    <p><strong>Geselecteerde producten:</strong> <?php echo $package['producten']; ?></p>
                <?php else : ?>
                    <p class="error-message"><?php echo $errorMessage; ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div><br>
    <CENTER><img src="https://cdn.pixabay.com/photo/2012/04/24/16/17/box-40302_960_720.png" width="200px" style="cursor: pointer;">
</body>

</html>
