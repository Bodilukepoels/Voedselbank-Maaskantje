<?php
include "navigation.php";
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    // User is logged in
    include "config.php";

    // Check if the form was submitted for adding a new leverancier
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $naam = $_POST['naam'];
        $Mail = $_POST['Mail'];
        $Telefoonnummer = $_POST['Telefoonnummer'];
        $Postcode = $_POST['postcode'];
        $bezorgingsdatum = $_POST['bezorgingsdatum'];
        
        try {
            $sql = "INSERT INTO leveranciers (naam, `Mail`, Telefoonnummer, postcode, bezorgingsdatum) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$naam, $Mail, $Telefoonnummer, $Postcode, $bezorgingsdatum]);
            $successMessage = "De leverancier is succesvol toegevoegd.";
        } catch (PDOException $e) {
            $errorMessage = "Iets is misgegaan: " . $e->getMessage();
        }
    }

    // Check if a leverancier was deleted
    if (isset($_GET['success']) && $_GET['success'] == 1) {
        $deleteSuccessMessage = "De leverancier is succesvol verwijderd.";
    } elseif (isset($_GET['success']) && $_GET['success'] != 1) {
        $deleteErrorMessage = "Iets is misgegaan bij het verwijderen van de leverancier.";
    }
} else {
    // User is not logged in, redirect to login page
    header("Location: leverancierstoevoegen.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Leverancier Management</title>
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
                <h1 style="color: black" class="text-center mb-4">Leverancier toevoegen</h1>
                <?php if (isset($errorMessage)): ?>
                    <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
                <?php endif; ?>
                <?php if (isset($successMessage)): ?>
                    <div class="alert alert-success"><?php echo $successMessage; ?></div>
                <?php endif; ?>

                <?php if (isset($deleteSuccessMessage)): ?>
                    <div class="alert alert-success mt-4"><?php echo $deleteSuccessMessage; ?></div>
                <?php endif; ?>
                <?php if (isset($deleteErrorMessage)): ?>
                    <div class="alert alert-danger mt-4"><?php echo $deleteErrorMessage; ?></div>
                <?php endif; ?>
                <form action="" method="POST">
                    <div class="form-group">
                        <label>Naam:</label>
                        <input type="text" class="form-control" id="naam" name="naam" required>
                    </div>
                    <div class="form-group">
                        <label>Mail:</label>
                        <input type="mail" class="form-control" id="Mail" name="Mail" required>
                    </div>
                    <div class="form-group">
                        <label>Telefoonnummer:</label>
                        <input type="text" class="form-control" id="Telefoonnummer" name="Telefoonnummer" required>
                    </div>
                    <div class="form-group">
                        <label>Postcode:</label>
                        <input type="text" class="form-control" id="Postcode" name="postcode" required>
                    </div>
                    <div class="form-group">
                        <label>Bezorgingsdatum:</label>
                        <input type="date" class="form-control" id="bezorgingsdatum" name="bezorgingsdatum" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Leverancier toevoegen</button>
                </form>
            </div>
        </div>

        <h2 style="color: black;" class="text-center mt-5">Bestaande leveranciers</h2>
        <div class="table-responsive mt-4">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Naam</th>
                        <th>Telefoonnummer</th>
                        <th>Mail</th>
                        <th>Postcode</th>
                        <th>Bezorgingsdatum</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        try {
                            $sql = "SELECT * FROM leveranciers";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $leveranciers = $stmt->fetchAll();

                            foreach ($leveranciers as $leverancier) {
                                echo "<tr>";
                                echo "<td>" . $leverancier['id'] . "</td>";
                                echo "<td>" . $leverancier['naam'] . "</td>";
                                echo "<td>" . $leverancier['Mail'] . "</td>";
                                echo "<td>" . $leverancier['Telefoonnummer'] . "</td>";
                                echo "<td>" . $leverancier['Postcode'] . "</td>";
                                echo "<td>" . $leverancier['Bezorgingsdatum'] . "</td>";
                                echo "<td>
                                    <a href='edit_leverancier.php?id=" . $leverancier['id'] . "' class='btn btn-primary btn-sm'>Bewerk</a>
                                    <button class='btn btn-danger btn-sm' data-toggle='modal' data-target='#confirmDeleteModal" . $leverancier['id'] . "'>Verwijder</button>
                                    </td>";
                                echo "</tr>";
                                echo "<div class='modal fade' id='confirmDeleteModal" . $leverancier['id'] . "' tabindex='-1' role='dialog' aria-labelledby='confirmDeleteModalLabel" . $leverancier['id'] . "' aria-hidden='true'>
                                    <div class='modal-dialog' role='document'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h5 class='modal-title' id='confirmDeleteModalLabel" . $leverancier['id'] . "'>Bevestiging</h5>
                                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                    <span aria-hidden='true'>&times;</span>
                                                </button>
                                            </div>
                                            <div class='modal-body'>
                                                Weet je zeker dat je deze leverancier wilt verwijderen?
                                            </div>
                                            <div class='modal-footer'>
                                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Annuleer</button>
                                                <a href='remove_leverancier.php?id=" . $leverancier['id'] . "' class='btn btn-danger'>Verwijder</a>
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
