<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overzicht producten</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php
        include "leverancierstoevoegen.php";
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    ?>
    <br>
    <CENTER><h1 style="color: black;">Overzicht leveranciers</h1>
    <div class="table-responsive mt-4">
        <table class="table table-striped">
        <tr>
            <th>ID</th>
            <th>Naam</th>
            <th>Beschrijving</th>
            <th>Voorraad</th>
            <th>EAN Nummer</th>
        </tr>
        </div>
        </CENTER>
        <?php
        include 'config.php';

        try {
            $sql = "SELECT * FROM leveranciers";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $products = $stmt->fetchAll();

            foreach ($products as $product) {
                echo "<tr>";
                echo "<td>" . $product['id'] . "</td>";
                echo "<td>" . $product['naam'] . "</td>";
                echo "<td>" . $product['beschrijving'] . "</td>";
                echo "<td>" . $product['voorraad'] . "</td>";
                echo "<td>" . $product['EAN-Nummer'] . "</td>";
                echo "</tr>";
            }
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>" . $e->getMessage() . "</div>";
        }
    ?>
        ?>
    </table>
</body>
</html>
  <?php
  }
  else {
    header("Location: index.php");
  }
  ?>
    