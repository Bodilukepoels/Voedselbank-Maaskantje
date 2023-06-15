<?php
include "config.php";
include "navigation.php";
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['quantities']) && !empty($_POST['quantities'])) {
        $selectedProducts = $_POST['quantities'];
        $foodPackageName = $_POST['foodPackageName'];
        $numberOfPackages = $_POST['numberOfPackages'];
        $creationDate = $_POST['creationDate'];
        $pickupDate = $_POST['pickupDate'];

        try {
            $stmt = $conn->prepare("INSERT INTO voedselpakket (naam, producten, aantal_pakketten, samenstellingsdatum, ophaaldatum) VALUES (:naam, :producten, :aantal_pakketten, :samenstellingsdatum, :ophaaldatum)");

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
            $stmt->bindParam(':samenstellingsdatum', $creationDate);
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

try {
    $sql = "SELECT * FROM gezinnen";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $gezinnen = $stmt->fetchAll();
} catch (PDOException $e) {
    $errorMessage = $e->getMessage();
    exit();
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
            margin-bottom: 1rem !important;
        }

        .text-danger {
            color: red;
        }

        .text-success {
            color: green;
        }

        .food-package-window {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .gezinnen-window {
            position: fixed;
            top: 50%;
            right: 0;
            transform: translateY(-50%);
            background-color: white;
            padding: 20px;
            z-index: 999;
            width: 300px;
            max-height: 400px;
            overflow-y: auto;
        }
        th {
            font-size: 15px;
        }
    </style>
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Voedselpakket samenstellen</h2>

        <?php if (isset($successMessage)) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $successMessage; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($errorMessage)) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errorMessage; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="foodPackageName">Naam voedselpakket</label>
                <input type="text" class="form-control" id="foodPackageName" name="foodPackageName" required>
            </div>

            <div class="form-group">
                <label for="numberOfPackages">Aantal pakketten</label>
                <input type="number" class="form-control" id="numberOfPackages" name="numberOfPackages" min="1" required>
            </div>

            <div class="form-group">
                <label for="creationDate">Samenstellingsdatum</label>
                <input type="date" class="form-control" id="creationDate" name="creationDate" required>
            </div>

            <div class="form-group">
                <label for="pickupDate">Ophaaldatum</label>
                <input type="date" class="form-control" id="pickupDate" name="pickupDate" required>
            </div>

            <div class="form-group">
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#product-modal" type="button">Voeg product toe</button>
            </div>


            <div class="modal fade" id="product-modal" tabindex="-1" role="dialog" aria-labelledby="product-modal-label" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="product-modal-label">Producten</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
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
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" id="add-products-btn" data-dismiss="modal">Voeg toe aan geselecteerde</button>
                            <button class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
                        </div>
                    </div>
                </div>
            </div>

            <ul class="selected-products" id="selected-products-list"></ul>

            <button type="submit" class="btn btn-primary">Creëer Voedselpakket</button>
        </form>
    </div>

    <div class="gezinnen-window">
            <h3>Gezinnen</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Naam</th>
                        <th>Volwassenen</th>
                        <th>Kinderen</th>
                        <th>Wensen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($gezinnen as $gezin) : ?>
                        <tr>
                            <td><?= $gezin['naam']; ?></td>
                            <td><?= $gezin['volwassenen']; ?></td>
                            <td><?= $gezin['kinderen']; ?></td>
                            <td><?= $gezin['wensen']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            var selectedProducts = {};

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
                        var productName = $("input[name='quantities[" + productId + "]']").closest('tr').find('td:first').text();
                        var listItem = '<li>' + productName + ' x' + quantity + '</li>';
                        $('#selected-products-list').append(listItem);
                    });

                    var selectedProductsJSON = JSON.stringify(selectedProducts);
                    $('input[name="selectedProducts"]').val(selectedProductsJSON);
                }
            });
        });
    </script>
</body>

</html>
