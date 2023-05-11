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
    echo "<center><h1>Voedselbank Maaskant</h1></center>";
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        // index contents wordt geinclude wanneer account is ingelogt
        include "indexcontents.php";
    }
    else{
        // dit wordt ge-echo'd wanneer  account niet is ingelogt
        echo "<div class='container'>
        <h2>Hallo mederwerker!</h2>
        <a href='login.php'><h1>Login</h1></a>
    </div>";
    }
    ?>
</body>
</html>
