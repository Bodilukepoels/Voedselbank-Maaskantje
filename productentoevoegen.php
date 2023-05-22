<?php
include "navigation.php";
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        // User is logged in
        include "config.php";

        // Check if the form was submitted for adding a new product
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $naam = $_POST['naam'];
            $beschrijving = $_POST['beschrijving'];
            $voorraad = $_POST['voorraad'];
            $eanNummer = $_POST['eanNummer'];

            try {
                $sql = "INSERT INTO producten (naam, beschrijving, voorraad, `EAN-Nummer`) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$naam, $beschrijving, $voorraad, $eanNummer]);
                $successMessage = "Het product is succesvol toegevoegd.";
            } catch (PDOException $e) {
                $errorMessage = "Iets is misgegaan: " . $e->getMessage();
            }
        }
    } else {
        // User is not logged in, redirect to login page
        header("Location: index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    label {
        color: black;
    }
</style>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h1 style="color: black" class="text-center mb-4">Nieuwe product toevoegen</h1>
                <?php if (isset($errorMessage)): ?>
                    <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
                <?php endif; ?>
                <?php if (isset($successMessage)): ?>
                    <div class="alert alert-success"><?php echo $successMessage; ?></div>
                <?php endif; ?>
                <form action="productentoevoegen.php" method="POST">
                    <div class="form-group">
                        <label>Product Naam:</label>
                        <input type="text" class="form-control" id="naam" name="naam" required>
                    </div>
                    <div class="form-group">
                        <label>Beschrijving:</label>
                        <input type="text" class="form-control" id="beschrijving" name="beschrijving" required>
                    </div>
                    <div class="form-group">
                        <label for="voorraad">Voorraad:</label>
                        <input type="number" class="form-control" id="voorraad" name="voorraad" required>
                    </div>
                    <div class="form-group">
                        <label>EAN Nummer:</label>
                        <input type="text" class="form-control" id="eanNummer" name="eanNummer" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Product toevoegen</button>
                </form>
            </div>
        </div>

        <h2 style="color: black;" class="text-center mt-5">Bestaande producten</h2>
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
                                echo "<td>
                                    <a href='edit_product.php?id=" . $product['id'] . "' class='btn btn-primary btn-sm'>Bewerk</a>
                                    <button class='btn btn-danger btn-sm' data-toggle='modal' data-target='#confirmDeleteModal" . $product['id'] . "'>Verwijder</button>
                                    </td>";
                                echo "</tr>";
                                echo "<div class='modal fade' id='confirmDeleteModal" . $product['id'] . "' tabindex='-1' role='dialog' aria-labelledby='confirmDeleteModalLabel" . $product['id'] . "' aria-hidden='true'>
                                    <div class='modal-dialog' role='document'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h5 class='modal-title' id='confirmDeleteModalLabel" . $product['id'] . "'>Bevestiging</h5>
                                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                    <span aria-hidden='true'>&times;</span>
                                                </button>
                                            </div>
                                            <div class='modal-body'>
                                                Weet je zeker dat je dit product wilt verwijderen?
                                            </div>
                                            <div class='modal-footer'>
                                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Annuleer</button>
                                                <a href='remove_product.php?id=" . $product['id'] . "' class='btn btn-danger'>Verwijder</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>";
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
