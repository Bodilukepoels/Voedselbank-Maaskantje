<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voedselbank Maaskant</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
    include 'navigation.php';
    ?>
    <h1>Voedselbank Maaskant</h1>
    <div class="product-grid">
        <?php
        require_once 'config.php';

        $sql = "SELECT * FROM producten";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<div class='product-card'>
                    <a href='product.php?id={$row['id']}'>
                        <img src='img/{$row['image']}' alt='{$row['naam']}' />
                        <h3>{$row['naam']}</h3>
                    </a>
                  </div>";
        }
        ?>
    </div>

</body>
</html>
