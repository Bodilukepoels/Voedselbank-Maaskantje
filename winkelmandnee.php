<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voedselbank Maaskant - Cart</title>
    <link rel="stylesheet" href="styles.css">
    <script>
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

        function setCartToCookie(cart) {
            document.cookie = 'cart=' + JSON.stringify(cart) + ';max-age=' + (12 * 60 * 60) + ';path=/';
        }

        function removeFromCart(index) {
            let cart = getCartFromCookie();
            cart.splice(index, 1);
            setCartToCookie(cart);
            window.location.reload();
        }

        function updateQuantity(index, delta) {
            let cart = getCartFromCookie();
            cart[index].quantity += delta;
            if (cart[index].quantity < 1) {
                cart[index].quantity = 1;
            }
            setCartToCookie(cart);
            window.location.reload();
        }


    </script>
</head>
<body>
    <?php
    include 'navigation.php';
    ?>
    <h1>Winkelmand</h1>
    <?php
    $cart = json_decode($_COOKIE['cart'], true);

            if (count($cart) > 0) {
                    include 'winkelmandinhoud.php';
                }
                else {echo "Winkelmand is leeg.";}
    ?>

</body>
</html>