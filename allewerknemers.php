<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overzicht werknemers</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <?php
        include "navigation.php";
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    ?>
    <br>
    <CENTER><h1 style="color: black;">Overzicht werknemers</h1>
    <div class="table-responsive mt-4">
        <table class="table table-striped">
        <tr>
            <th>ID</th>
            <th>Naam</th>
        </tr>
        </div>
        </CENTER>
        <?php
        include 'config.php';

        try {
            $sql = "SELECT naam, accountid FROM user";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $products = $stmt->fetchAll();

            foreach ($products as $product) {
                echo "<tr>";
                echo "<td>" . $product['accountid'] . "</td>";
                echo "<td>" . $product['naam'] . "</td>";
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