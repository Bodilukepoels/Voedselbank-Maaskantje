<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voedselbank Maaskant</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
    include 'navigation.php';
    echo "<br><center><h1 style='color: black;'>Voedselbank Maaskant</h1><br>";
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        // index contents wordt geinclude wanneer account is ingelogt
        include "indexcontents.php";
    }
    else{
        // dit wordt ge-echo'd wanneer  account niet is ingelogt
        echo "<div style='color: black;'class='container'>
        <h2>Hallo medewerker!</h2>
        <a href='login.php'><h1>Login</h1></a>
    </div></center>";
    }
    ?>
</body>
</html>
