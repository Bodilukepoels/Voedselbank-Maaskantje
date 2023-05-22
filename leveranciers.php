<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leveranciers Details</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function addToCart(id) {
            // Define your add to cart functionality here
        }
    </script>
</head>
<body>
    <?php
    include 'navigation.php';

    if (isset($_GET['id'])) {
        require_once 'config.php';

        $sql = "SELECT * FROM leveranciers WHERE id = :id"; // Check your table name
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $_GET['id']);
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<div class='leverancier-details'>
                    <img src='path/to/image/{$row['image']}' alt='{$row['naam']}' /> <!-- Correct the path -->
                    <h2>{$row['naam']}</h2>
                    <p>{$row['beschrijving']}</p>
                    <button type='button' onclick='addToCart({$row['id']})'>Add to cart</button>
                  </div>";
        } else {
            echo "<p>leverancier not found.</p>";
        }
    } else {
        echo "<p>Invalid leverancier ID.</p>";
    }
    ?>

</body>
</html>
