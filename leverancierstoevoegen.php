<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leverancier Management</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
        include "navigation.php";
    ?>
    <h1>Leverancier toevoegen</h1>
    <h2>Add a new Leverancier</h2>
    <form action="leveranciers.php" method="POST">
        <label for="naam">Name:</label>
        <input type="text" id="naam" name="naam" required><br>
        <label for="beschrijving">Beschrijving:</label>
        <input type="text" id="beschrijving" name="beschrijving" required><br>
        <label for="Telefoonnummer">Telefoonnummer:</label>
        <input type="number" id="Telefoonnummer" name="Telefoonnummer" required><br>
        <label for="Mail">Mail:</label>
        <input type="email" id="Mail" name="Mail" required><br>
        <label for="postcode">Postcode:</label>
        <input type="text" id="postcode" name="postcode" required><br>
        <input type="submit" value="Add leverancier">
    </form>

    <h2>Bestaande leveranciers</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Naam</th>
            <th>Beschrijving</th>
            <th>Telefoonnummer</th>
            <th>Mail</th>
            <th>Postcode</th>
        </tr>
        <?php
        include 'config.php';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $naam = $_POST['naam'];
            $beschrijving = $_POST['beschrijving'];
            $Telefoonnummer = $_POST['Telefoonnummer'];
            $Mail = $_POST['Mail'];

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
                echo "<td>" . $leverancier['Telefoonnummer'] . "</td>";
                echo "<td>" . $leverancier['Mail'] . "</td>";
                echo "<td>" . $leverancier['Postcode'] . "</td>";
                echo "<td><a href='edit_leverancier.php?id=" . $leverancier['id'] . "'>Edit</a></td>";
                echo "</tr>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>
    </table>
</body>
</html>
