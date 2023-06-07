<?php
include "config.php";
include "navigation.php";
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['selectedProducts']) && !empty($_POST['selectedProducts'])) {
        $selectedProducts = json_decode($_POST['selectedProducts'], true); // Decode the JSON string into an array
        $foodPackageName = $_POST['foodPackageName'];
        $numberOfPackages = $_POST['numberOfPackages'];
        $pickupDate = $_POST['pickupDate'];

        try {
            $stmt = $conn->prepare("INSERT INTO voedselpakket (naam, producten, aantal_pakketten, ophaaldatum) VALUES (:naam, :producten, :aantal_pakketten, :ophaaldatum)");

            $productString = '';
            foreach ($selectedProducts as $productId => $quantity) {
                $product = getProductById($conn, $productId);
                $productName = $product['naam'];
                $productString .= $productName . ' x' . $quantity . ', ';
            }
            $productString = rtrim($productString, ', ');

            $stmt->bindParam(':naam', $foodPackageName);
            $stmt->bindParam(':producten', $productString);
            $stmt->bindParam(':aantal_pakketten', $numberOfPackages);
            $stmt->bindParam(':ophaaldatum', $pickupDate);
            $stmt->execute();

            $successMessage = "Producten geplaatst in de database.";
        } catch (PDOException $e) {
            $errorMessage = "Error producten toevoegen: " . $e->getMessage();
        }
    } else {
        $errorMessage = "Geen producten geselecteerd.";
    }
}

try {
    $sql = "SELECT * FROM producten ORDER BY naam";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll();
} catch (PDOException $e) {
    $errorMessage = $e->getMessage();
    exit();
}

function getProductById($conn, $productId)
{
    $stmt = $conn->prepare("SELECT * FROM producten WHERE id = :id");
    $stmt->bindParam(':id', $productId);
    $stmt->execute();
    return $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Voedselpakket samenstellen</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 600px;
        }

        .mt-5 {
            margin-top: 3rem !important;
        }

        .mb-4 {
            margin-bottom: 2rem !important;
        }

        .mb-3 {
            margin-bottom: 1.5rem !important;
        }

        .text-center {
            text-align: center !important;
        }

        .btn-primary {
            background-color: #007bff !important;
            border-color: #007bff !important;
        }

        .btn-primary:hover {
            background-color: #0069d9 !important;
            border-color: #0062cc !important;
        }

        .btn-secondary {
            background-color: #6c757d !important;
            border-color: #6c757d !important;
        }

        .btn-secondary:hover {
            background-color: #5a6268 !important;
            border-color: #545b62 !important;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
            padding: .75rem 1.25rem;
            margin-bottom: 1rem;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
            padding: .75rem 1.25rem;
            margin-bottom: 1rem;
        }

        #product-popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            z-index: 999;
        }

        #product-popup .product-list {
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Voedselpakket samenstellen</h1>
        <button class="btn btn-primary mb-3" id="open-popup-btn">Voeg product toe</button>
        <div id="product-popup">
            <h3>Producten</h3>
            <div class="product-list">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Hoeveelheid</th>
                            <th>Beschikbaar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product) : ?>
                            <tr>
                                <td><?= $product['naam']; ?></td>
                                <td>
                                    <input type="number" class="form-control product-quantity" name="quantities[<?= $product['id']; ?>]" min="0" max="<?= $product['voorraad']; ?>">
                                </td>
                                <td><?= $product['voorraad']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <button class="btn btn-primary" id="add-products-btn">Voeg toe aan geselecteerde</button>
            <button class="btn btn-secondary" id="close-popup-btn">Sluiten</button>
        </div>

        <?php if (isset($successMessage)) : ?>
            <div class="alert alert-success"><?= $successMessage ?></div>
        <?php endif; ?>

        <?php if (isset($errorMessage)) : ?>
            <div class="alert alert-danger"><?= $errorMessage ?></div>
        <?php endif; ?>

        <h3>Geselecteerde producten</h3>
        <ul id="selected-products-list"></ul>

        <form method="POST" action="">
            <div class="form-group">
                <label for="foodPackageName">Naam van het voedselpakket:</label>
                <input type="text" class="form-control" id="foodPackageName" name="foodPackageName" required>
            </div>
            <div class="form-group">
                <label for="numberOfPackages">Aantal pakketten:</label>
                <input type="number" class="form-control" id="numberOfPackages" name="numberOfPackages" min="1" required>
            </div>
            <div class="form-group">
                <label for="pickupDate">Ophaaldatum:</label>
                <input type="date" class="form-control" id="pickupDate" name="pickupDate" required>
            </div>
            <input type="hidden" name="selectedProducts" id="selected-products-input">
            <button type="submit" class="btn btn-primary" id="create-package-btn">Creeer voedselpakket</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            var selectedProducts = {};

            $('#open-popup-btn').click(function() {
                $('#product-popup').show();
            });

            $('#close-popup-btn').click(function() {
                $('#product-popup').hide();
            });

            $('#add-products-btn').click(function() {
                var hasInvalidQuantity = false;
                var selectedProducts = {};

                $('.product-quantity').each(function() {
                    var productId = $(this).attr('name').match(/\d+/)[0];
                    var quantity = parseInt($(this).val()) || 0;
                    var maxQuantity = parseInt($(this).attr('max'));

                    if (quantity > maxQuantity) {
                        hasInvalidQuantity = true;
                        return false;
                    }

                    if (quantity > 0) {
                        selectedProducts[productId] = quantity;
                    }
                });

                if (hasInvalidQuantity) {
                    alert("Invalid quantity. Please enter a valid quantity.");
                } else {
                    $('#selected-products-list').empty();

                    $.each(selectedProducts, function(productId, quantity) {
                        var productName = $('input[name="quantities[' + productId + ']"]').closest('tr').find('td:first').text();
                        $('#selected-products-list').append('<li>' + productName + ' x' + quantity + '</li>');
                    });

                    $('#selected-products-input').val(JSON.stringify(selectedProducts));
                    $('#product-popup').hide();
                }
            });
        });
    </script>
</body>

</html>
