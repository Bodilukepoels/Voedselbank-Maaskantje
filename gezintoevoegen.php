<?php
include "navigation.php";

if ($row && $row['role'] == "3") {
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        include "config.php";
        try {
            $sql = "SELECT beschikbare_allergieën FROM extra";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $options = $stmt->fetchAll(PDO::FETCH_COLUMN);
            $allergieën = ['            '];
            foreach ($options as $option) {
                $allergieën[] = $option;
            }

        } catch (PDOException $e) {
            $options = array();
        }

        $successMessage = $errorMessage = $deleteSuccessMessage = $deleteErrorMessage = $editSuccessMessage = "";

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $naam = $_POST['naam'];
            $volwassenen = $_POST['volwassenen'];
            $kinderen = $_POST['kinderen'];
            $postcode = $_POST['postcode'];
            $mail = $_POST['mail'];
            $telefoonnummer = $_POST['telefoonnummer'];
            $wensen_allergieën = $_POST['wensen_allergieën'];

            $allergieënString = '';

            foreach ($wensen_allergieën as $allergie) {
                $allergieënString .= $allergie . ', ';
            }

            $allergieënString = rtrim($allergieënString, ', ');

            try {
                $sql = "INSERT INTO gezinnen (naam, volwassenen, kinderen, postcode, mail, telefoonnummer, wensen) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$naam, $volwassenen, $kinderen, $postcode, $mail, $telefoonnummer, $allergieënString]);
                $successMessage = "Het gezin is succesvol toegevoegd.";
            } catch (PDOException $e) {
                $errorMessage = "Er is iets misgegaan: " . $e->getMessage();
            }
        }

        if (isset($_GET['success']) && $_GET['success'] == 1) {
            $deleteSuccessMessage = "Het gezin is succesvol verwijderd.";
        } elseif (isset($_GET['success']) && $_GET['success'] == 2) {
            $deleteErrorMessage = "Er is iets misgegaan bij het verwijderen van het gezin.";
        }

        if (isset($_GET['success']) && $_GET['success'] == 3) {
            $editSuccessMessage = "Het gezin is succesvol bijgewerkt.";
        }
    } else {
        header("Location: gezintoevoegen.php");
        exit();
    }
} else {
    header("location:index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gezin Management</title>
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
                <h1 style="color: black" class="text-center mb-4">Overzicht gezinnen</h1>
                <?php if (!empty($errorMessage)): ?>
                    <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
                <?php endif; ?>
                <?php if (!empty($successMessage)): ?>
                    <div class="alert alert-success"><?php echo $successMessage; ?></div>
                <?php endif; ?>
                <?php if (!empty($deleteSuccessMessage)): ?>
                    <div class="alert alert-success mt-4"><?php echo $deleteSuccessMessage; ?></div>
                <?php endif; ?>
                <?php if (!empty($deleteErrorMessage)): ?>
                    <div class="alert alert-danger mt-4"><?php echo $deleteErrorMessage; ?></div>
                <?php endif; ?>
                <?php if (!empty($editSuccessMessage)): ?>
                    <div class="alert alert-success"><?php echo $editSuccessMessage; ?></div>
                <?php endif; ?>

                <form action="" method="POST">
                    <div class="form-group">
                        <label>Gezinsnaam:</label>
                        <input type="text" class="form-control" id="naam" name="naam" required>
                    </div>

                    <div class="form-group">
                        <label>Volwassenen:</label>
                        <input type="number" class="form-control" id="volwassenen" name="volwassenen" required>
                    </div>

                    <div class="form-group">
                        <label>Kinderen:</label>
                        <input type="number" class="form-control" id="kinderen" name="kinderen" required>
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
                        <input type="number" class="form-control" id="telefoonnummer" name="telefoonnummer" required>
                    </div>

                    <div class="form-group">
                    <label>Wensen en Allergieën:</label>
                    <div id="allergieën-container">
                        <div class="input-group mb-2">
                            <select class="form-control allergieën-select" name="wensen_allergieën[]" required>
                                <?php foreach ($allergieën as $allergie): ?>
                                    <option value="<?php echo $allergie; ?>"><?php echo $allergie; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-danger delete-allergy">-</button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary mt-2" id="add-allergy">+</button>
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
                        <th>Id</th>
                        <th>Gezinsnaam</th>
                        <th>Volwassenen</th>
                        <th>Kinderen</th>
                        <th>Postcode</th>
                        <th>Mail</th>
                        <th>Telefoonnummer</th>
                        <th>Wensen/Allergieën</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM gezinnen";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['naam']; ?></td>
                            <td><?php echo $row['volwassenen']; ?></td>
                            <td><?php echo $row['kinderen']; ?></td>
                            <td><?php echo $row['postcode']; ?></td>
                            <td><?php echo $row['mail']; ?></td>
                            <td><?php echo $row['telefoonnummer']; ?></td>
                            <td><?php echo $row['wensen']; ?></td>
                            <td>
                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirmDeleteModal<?php echo $row['id']; ?>">Verwijder</button>
                            </td>
                        </tr>
                        <div class="modal fade" id="confirmDeleteModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmDeleteModalLabel<?php echo $row['id']; ?>">Bevestiging</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Weet je zeker dat je dit gezin wilt verwijderen?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleer</button>
                                        <a href="remove_gezin.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Verwijder</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>

        <script>
        $(document).ready(function() {
            var allergyCount = 1;

            $("#add-allergy").click(function() {
                allergyCount++;
                var inputHtml = '<div class="input-group mb-2"><select class="form-control allergieën-select" name="wensen_allergieën[]" required><option value="">Selecteer wensen en allergie</option><?php foreach ($allergieën as $allergie): ?><option value="<?php echo $allergie; ?>"><?php echo $allergie; ?></option><?php endforeach; ?></select><div class="input-group-append"><button type="button" class="btn btn-danger delete-allergy">-</button></div></div>';
                $("#allergieën-container").append(inputHtml);
            });

            $(document).on('click', '.delete-allergy', function() {
                $(this).closest('.input-group').remove();
            });

            $(document).on('change', '.allergieën-select', function() {
                var selectedValues = [];
                $(this).closest('.input-group').find('.allergieën-select option:selected').each(function() {
                    selectedValues.push($(this).val());
                });
                $(this).closest('.input-group').find('.form-control').val(selectedValues.join(', '));
            });
        });
</script>
</body>
</html>