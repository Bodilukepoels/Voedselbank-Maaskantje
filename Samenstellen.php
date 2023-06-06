<?php
include "navigation.php";
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    include "config.php";

    if (isset($_POST['selectedProducts']) && !empty($_POST['selectedProducts'])) {
        $selectedProducts = $_POST['selectedProducts'];
        $foodPackageName = $_POST['foodPackageName'];
        $numberOfPackages = $_POST['numberOfPackages'];
        $pickupDate = $_POST['pickupDate'];
    
        try {
            $stmt = $conn->prepare("INSERT INTO voedselpakket (naam, producten, aantal_pakketten, ophaaldatum) VALUES (:naam, :producten, :aantal_pakketten, :ophaaldatum)");
    
            // Prepare the product string (e.g., 'appel x1, tomaat x2')
            $productString = '';
            foreach ($selectedProducts as $productId => $quantity) {
                $product = $products[array_search($productId, array_column($products, 'id'))];
                $productName = $product['naam'];
                $productString .= $productName . ' x' . $quantity . ', ';
            }
            $productString = rtrim($productString, ', '); // Remove the trailing comma and space
    
            $stmt->bindParam(':naam', $foodPackageName);
            $stmt->bindParam(':producten', $productString);
            $stmt->bindParam(':aantal_pakketten', $numberOfPackages);
            $stmt->bindParam(':ophaaldatum', $pickupDate);
            $stmt->execute();
    
            echo "<div class='alert alert-success'>Producten geplaatst in de database.</div>";
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Error producten toevoegen:  " . $e->getMessage() . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Geen producten geselecteerd.</div>";
    }
    

    try {
        $sql = "SELECT * FROM producten ORDER BY naam";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $products = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>" . $e->getMessage() . "</div>";
        exit();
    }
} else {
    header("Location: index.php");
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

<body class="bg-light">
    <div class="container mt-5">
        <h1 style="color: black;" class="text-center mb-4">Voedselpakket samenstellen</h1>
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
                                <td><?php echo $product['naam']; ?></td>
                                <td>
                                    <input type="number" class="form-control product-quantity" name="quantities[<?php echo $product['id']; ?>]" min="0" max="<?php echo $product['voorraad']; ?>">
                                </td>
                                <td><?php echo $product['voorraad']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <button class="btn btn-primary" id="add-products-btn">Voeg toe aan geselecteerde</button>
            <button class="btn btn-secondary" id="close-popup-btn">Sluiten</button>
        </div>

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
            var products = <?php echo json_encode($products); ?>;

            $('#open-popup-btn').click(function() {
                $('#product-popup').show();
            });

            $('#close-popup-btn').click(function() {
                $('#product-popup').hide();
            });

            $('#add-products-btn').click(function() {
                var hasInvalidQuantity = false;

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
                    } else {
                        delete selectedProducts[productId];
                    }
                });

                if (hasInvalidQuantity) {
                    alert("Invalid quantity. Please enter a valid quantity.");
                } else {
                    updateSelectedProductsList();
                    $('#product-popup').hide();
                }
            });

            function updateSelectedProductsList() {
                var selectedProductsList = $('#selected-products-list');
                selectedProductsList.empty();

                $.each(selectedProducts, function(productId, quantity) {
                    var product = products.find(p => p.id === parseInt(productId));

                    if (product) {
                        var listItem = $('<li>').text(product.naam + ' x' + quantity);

                        var deleteButton = $('<button>').text('Verwijder').addClass('btn btn-danger btn-sm ml-2');
                        deleteButton.data('productId', productId);

                        listItem.append(deleteButton);
                        selectedProductsList.append(listItem);
                    }
                });
                $('#selected-products-input').val(JSON.stringify(selectedProducts));
            }
            $('#selected-products-list').on('click', '.btn-danger', function() {
                var productId = $(this).data('productId');
                delete selectedProducts[productId];
                updateSelectedProductsList();
            });
        });
    </script>
</body>

</html>
