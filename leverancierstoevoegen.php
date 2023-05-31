<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leverancier Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
            color: black;
        }

        .container {
            max-width: 800px;
        }

        h1, h2 {
            margin-top: 30px;
            color: black;
        }
    </style>
</head>

<body>
    <?php
    include "navigation.php";
    ?>
    <div class="container">
        <h1>Leverancier toevoegen</h1>
        <h2>Add a new Leverancier</h2>
        <form action="leveranciers.php" method="POST">
            <div class="form-group">
                <label for="naam">Name:</label>
                <input type="text" class="form-control" id="naam" name="naam" required>
            </div>
            <div class="form-group">
                <label for="beschrijving">Beschrijving:</label>
                <input type="text" class="form-control" id="beschrijving" name="beschrijving" required>
            </div>
            <div class="form-group">
                <label for="Telefoonnummer">Telefoonnummer:</label>
                <input type="number" class="form-control" id="Telefoonnummer" name="Telefoonnummer" required>
            </div>
            <div class="form-group">
                <label for="Mail">Mail:</label>
                <input type="email" class="form-control" id="Mail" name="Mail" required>
            </div>
            <div class="form-group">
                <label for="postcode">Postcode:</label>
                <input type="text" class="form-control" id="postcode" name="postcode" required>
            </div>
            <button type="submit" class="btn btn-primary">Add leverancier</button>
        </form>

        <h2>Bestaande leveranciers</h2>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Naam</th>
                    <th>Beschrijving</th>
                    <th>Telefoonnummer</th>
                    <th>Mail</th>
                    <th>Postcode</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'config.php';

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $naam = $_POST['naam'];
                    $beschrijving = $_POST['beschrijving'];
                    $Telefoonnummer = $_POST['Telefoonnummer'];
                    $Mail = $_POST['Mail'];
                    $postcode = $_POST['postcode'];

                    try {
                        $sql = "INSERT INTO leveranciers (naam, beschrijving, Telefoonnummer, `Mail`, postcode) VALUES (?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute([$naam, $beschrijving, $Telefoonnummer, $Mail, $postcode]);
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                }

                try {
                    $sql = "SELECT * FROM leveranciers";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $leveranciers = $stmt->fetchAll();

                    foreach ($leveranciers as $leverancier) {
                        echo "<tr>";
                        echo "<td>" . $leverancier['id'] . "</td>";
                        echo "<td>" . $leverancier['naam'] . "</td>";
                        echo "<td>" . $leverancier['beschrijving'] . "</td>";
                        echo "<td>" . $leverancier['Telefoonnummer'] . "</td>";
                        echo "<td>" . $leverancier['Mail'] . "</td>";
                        echo "<td>" . $leverancier['postcode'] . "</td>";
                        echo "<td><a href='edit_leverancier.php?id=" . $leverancier['id'] . "' class='btn btn-primary btn-sm'>Edit</a></td>";
                        echo "</tr>";
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>
