<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voedselbank Maaskant</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function addToCart(productId) {
            let cart = getCartFromCookie();
            if (!cart) {
                cart = [];
            }

            let itemFound = false;
            for (let i = 0; i < cart.length; i++) {
                if (cart[i].id === productId) {
                    cart[i].quantity++;
                    itemFound = true;
                    break;
                }
            }

            if (!itemFound) {
                cart.push({ id: productId, quantity: 1 });
            }

            document.cookie = 'cart=' + JSON.stringify(cart) + ';max-age=' + (12 * 60 * 60) + ';path=/';
            alert('Product added to cart!');
        }

        function getCartFromCookie() {
            const cookies = document.cookie.split('; ');
            for (let i = 0; i < cookies.length; i++) {
                const cookiePair = cookies[i].split('=');
                if (cookiePair[0] === 'cart') {
                    return JSON.parse(cookiePair[1]);
                }
            }
            return [];
        }
    </script>
</head>
<body>
    <?php
    include 'navigation.php';
    ?>
    <h1>Voedselbank Maaskant</h1>
    <table>
        <thead>
            <tr>
                <th>Product naam</th>
                <th>beschrijving</th>
                <th>vooraad</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once 'config.php';

            $sql = "SELECT * FROM producten";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>{$row['naam']}</td>
                        <td>{$row['beschrijving']}</td>
                        <td>{$row['voorraad']}</td>
                        <td>
                            <button type='button' onclick='addToCart({$row['id']})'>Add to cart</button>
                        </td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>
