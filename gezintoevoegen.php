<?php
include "navigation.php";

$wensen = array(
    '            ',
    'niks',
    'tarwe',
    'noten',
    'pinda',
    'sesam',
    'melk(eiwit)',
    'soja',
    'vis',
    'snelle bezorging',
);

if ($row && $row['role'] == "3") {
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    include "config.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $naam = $_POST['naam'];
        $volwassenen = $_POST['volwassenen'];
        $kinderen = $_POST['kinderen'];
        $postcode = $_POST['postcode'];
        $mail = $_POST['mail'];
        $telefoonnummer = $_POST['telefoonnummer'];
        $wensen = $_POST['wensen'];
        
        try {
            $sql = "INSERT INTO gezinnen (naam, volwassenen, kinderen, postcode, mail, telefoonnummer, wensen) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$naam, $volwassenen, $kinderen, $postcode, $mail, $telefoonnummer, $wensen]);
            $successMessage = "De gezin is succesvol toegevoegd.";
        } catch (PDOException $e) {
            $errorMessage = "Iets is misgegaan: " . $e->getMessage();
        }
    }
    if (isset($_GET['success']) && $_GET['success'] == 1) {
        $deleteSuccessMessage = "De gezin is succesvol verwijderd.";
    } elseif (isset($_GET['success']) && $_GET['success'] == 2) {
        $deleteErrorMessage = "Iets is misgegaan bij het verwijderen van de gezin.";
    }
    if (isset($_GET['success']) && $_GET['success'] == 3) {
        $editSuccessMessage = "De gezin is succesvol bijgewerkt.";
    }
} else {
    header("Location: gezintoevoegen.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>gezin Management</title>
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
                <h1 style="color: black" class="text-center mb-4">overzicht gezinnen</h1>
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
                <?php if (isset($editSuccessMessage)): ?>
                    <div class="alert alert-success"><?php echo $editSuccessMessage; ?></div>
                <?php endif; ?>

                <form action="" method="POST">
                    <div class="form-group">
                        <label>Gezinsnaam:</label>
                        <input type="text" class="form-control" id="naam" name="naam" required>
                    </div>

                    <div class="form-group">
                        <label>Volwassenen:</label>
                        <input type="text" class="form-control" id="volwassenen" name="volwassenen" required>
                    </div>

                    <div class="form-group">
                        <label>Kinderen:</label>
                        <input type="text" class="form-control" id="kinderen" name="kinderen" required>
                    </div>

                    <div class="form-group">
                        <label>Postcode:</label>
                        <input type="text" class="form-control" id="postcode" name="postcode" required>
                    </div>

                    <div class="form-group">
                        <label>Mail:</label>
                        <input type="text" class="form-control" id="mail" name="mail" required>
                    </div>

                    <div class="form-group">
                        <label>Telefoonnummer:</label>
                        <input type="text" class="form-control" id="telefoonnummer" name="telefoonnummer" required>
                    </div>

                    <div class="form-group">
                        <label>Wensen/allergien:</label>
                        <select class="form-control" id="wensen" name="wensen" required>
                            <?php foreach ($wensen as $wensen): ?>
                                <option value="<?php echo $wensen; ?>"><?php echo $wensen; ?></option>
                                <?php endforeach; ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Gezin toevoegen</button>
                </form>
            </div>
        </div>

        <h2 style="color: black;" class="text-center mt-5">Bestaande gezinnen</h2>
        <div class="table-responsive mt-4">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                    <th>Gezinsnaam</th>
                    <th>Volwassenen</th>
                    <th>Kinderen</th>
                    <th>Postcode</th>
                    <th>Mail</th>
                    <th>Telefoonnummer</th>
                    <th>Wensen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        try {
                            $sql = "SELECT * FROM gezinnen";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $gezinnen = $stmt->fetchAll();

                            foreach ($gezinnen as $gezin) {
                                echo "<tr>";
                                echo "<td>" . $gezin['naam'] . "</td>";
                                echo "<td>" . $gezin['volwassenen'] . "</td>";
                                echo "<td>" . $gezin['kinderen'] . "</td>";
                                echo "<td>" . $gezin['postcode'] . "</td>";
                                echo "<td>" . $gezin['mail'] . "</td>";
                                echo "<td>" . $gezin['telefoonnummer'] . "</td>";
                                echo "<td>" . $gezin['wensen'] . "</td>";
                                echo "</tr>";
                                echo "<td>
                                
                                <button class='btn btn-danger btn-sm' data-toggle='modal' data-target='#confirmDeleteModal" . $gezin['id'] . "'>Verwijder</button>
                                </td>";
                            echo "</tr>";
                            echo "<div class='modal fade' id='confirmDeleteModal" . $gezin['id'] . "' tabindex='-1' role='dialog' aria-labelledby='confirmDeleteModalLabel" . $gezin['id'] . "' aria-hidden='true'>
                                <div class='modal-dialog' role='document'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title' id='confirmDeleteModalLabel" . $gezin['id'] . "'>Bevestiging</h5>
                                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                <span aria-hidden='true'>&times;</span>
                                            </button>
                                        </div>
                                        <div class='modal-body'>
                                            Weet je zeker dat je dit gezin wilt verwijderen?
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Annuleer</button>
                                            <a href='remove_gezin.php?id=" . $gezin['id'] . "' class='btn btn-danger'>Verwijder</a>
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
<?php
} else {
    header("location:index.php");
}