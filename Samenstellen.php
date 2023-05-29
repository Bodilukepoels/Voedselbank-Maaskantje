<?php
include "navigation.php";
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    include "config.php";
    $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

    try {
        $sql = "SELECT * FROM producten WHERE naam LIKE ? ORDER BY naam";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$searchQuery . '%']);
        $products = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>" . $e->getMessage() . "</div>";
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Voedselpakket samenstellen</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 style="color: black;" class="text-center mb-4">Voedselpakket samenstellen</h1>
        <form>
            <div class="form-group">
                <label for="product-select">Selecteer producten en hoeveelheden:</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Zoeken op naam" id="search-input" name="search" value="<?php echo $searchQuery; ?>">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="search-btn">Zoeken</button>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Hoeveelheid</th>
                            <th>Beschikbaar</th>
                        </tr>
                    </thead>
                    <tbody id="product-list">
                        <?php foreach ($products as $product) : ?>
                            <tr>
                                <td><?php echo $product['naam']; ?></td>
                                <td>
                                    <input type="number" class="form-control" name="quantities[<?php echo $product['id']; ?>]" min="0" max="<?php echo $product['voorraad']; ?>" required>
                                </td>
                                <td><?php echo $product['voorraad']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Creëer Voedselpakket</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="samenstellen.js">
</script>
</body>
</html>
