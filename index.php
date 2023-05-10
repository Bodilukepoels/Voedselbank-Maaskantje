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
    echo "<h1>Voedselbank Maaskant</h1>";
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        echo "<div class='container'>
        <h2>je bent een mens</h2>"
        . $_SESSION['user_name'] . 
        "<a href='logout.php'><h1>Logout</h1></a></div>
        ";
    }
    else{
        echo "<div class='container'>
        <h2>Hallo mederwerker!</h2>
        <a href='login.php'><h1>Login</h1></a>
    </div>";
    }
    ?>
</body>
</html>
