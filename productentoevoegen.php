<? php
   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php
        include "navigation.php";
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h1 class="text-center mb-4">Nieuwe product toevoegen</h1>
                <form action="productentoevoegen.php" method="POST">
                    <div class="form-group">
                        <label>Product Naam:</label>
                        <input type="text" class="form-control" id="naam" name="naam" placeholder="Product Naam" required>
                    </div>
                    <div class="form-group">
                        <label>Beschrijving:</label>
                        <input type="text" class="form-control" id="beschrijving" name="beschrijving" placeholder="Beschrijving" required>
                    </div>
                    <div class="form-group">
                        <label for="voorraad">Voorraad:</label>
                        <input type="number" class="form-control" id="voorraad" name="voorraad" placeholder="Hoeveelheid" required>
                    </div>
                    <div class="form-group">
                        <label>EAN Nummer:</label>
                        <input type="text" class="form-control" id="eanNummer" name="eanNummer" placeholder="EAN Nummer" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Product toevoegen</button>
                </form>
            </div>
        </div>

        <h2 class="text-center mt-5">Bestaande producten</h2>
        <div class="table-responsive mt-4">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Naam</th>
                        <th>Beschrijving</th>
                        <th>Voorraad</th>
                        <th>EAN Nummer</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        include 'config.php';

                        if (isset($_GET['success']) && $_GET['success'] == 1) {
                            echo "Het product is successvol bijgewerkt";
                        } else if (isset($_GET['success']) && $_GET['success'] <> 1){
                            echo "Something went wrong.";
                        }

                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            $naam = $_POST['naam'];
                            $beschrijving = $_POST['beschrijving'];
                            $voorraad = $_POST['voorraad'];
                            $eanNummer = $_POST['eanNummer'];

                            try {
                                $sql = "INSERT INTO producten (naam, beschrijving, voorraad, `EAN-Nummer`) VALUES (?, ?, ?, ?)";
                                                                $conn->prepare($sql);
                                $stmt->execute([$naam, $beschrijving, $voorraad, $eanNummer]);
                            } catch (PDOException $e) {
                                echo "<div class='alert alert-danger'>" . $e->getMessage() . "</div>";
                            }
                        }

                        try {
                            $sql = "SELECT * FROM producten";
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
                                echo "<td><a href='edit_product.php?id=" . $product['id'] . "' class='btn btn-primary btn-sm'>Edit</a></td>";
                                echo "</tr>";
                            }
                        } catch (PDOException $e) {
                            echo "<div class='alert alert-danger'>" . $e->getMessage() . "</div>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
  <?php
  }
  else {
    header("Location: index.php");
  }
  ?>
