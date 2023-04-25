<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        // Add to cart functionality (same as in index.php)
    </script>
</head>
<body>
    <?php
    include 'navigation.php';

    if (isset($_GET['id'])) {
        require_once 'config.php';

        $sql = "SELECT * FROM producten WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $_GET['id']);
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<div class='product-details'>
                    <img src='path/to/image/{$row['image']}' alt='{$row['naam']}' />
                    <h2>{$row['naam']}</h2>
                    <p>{$row['beschrijving']}</p>
                    <button type='button' onclick='addToCart({$row['id']})'>Add to cart</button>
                  </div>";
        } else {
            echo "<p>Product not found.</p>";
        }
    } else {
        echo "<p>Invalid product ID.</p>";
    }
    ?>

</body>
</html>
