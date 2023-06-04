<?php
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

if (count($products) > 0) {
    echo "<ul class='list-group'>";

    foreach ($products as $product) {
        echo "<li class='list-group-item'>
                <a href='#product-{$product['id']}' class='product-link'>{$product['naam']}</a>
            </li>";
    }

    echo "</ul>";
} else {
    echo "<div class='alert alert-info'>Geen producten gevonden.</div>";
}
?>
