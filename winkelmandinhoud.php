<?php
require_once 'config.php';

echo '<table>
        <thead>
            <tr>
                <th>Product naam</th>
                <th>beschrijving</th>
                <th>EAN Nummer</th>
                <th>Hoeveelheid</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="cart-body">';

foreach ($cart as $index => $item) {
    $productId = $item['id'];
    $quantity = $item['quantity'];

    $sql = "SELECT * FROM producten WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $productId);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<tr>
            <td>{$row['naam']}</td>
            <td>{$row['beschrijving']}</td>
            <td>hier hoort ean nummer</td>
            <td>
                <button type='button' onclick='updateQuantity({$index}, -1)'>&minus;</button>
                {$quantity}
                <button type='button' onclick='updateQuantity({$index}, 1)'>&plus;</button>
            </td>
            <td>
                <button type='button' onclick='removeFromCart({$index})'>Remove</button>
            </td>
          </tr>";
}

echo '</tbody></table>';
?>
