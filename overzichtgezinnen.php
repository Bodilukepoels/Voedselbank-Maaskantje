<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overzicht gezinnen</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <?php
        include "navigation.php";
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    ?>
    <br>
    <CENTER><h1 style="color: black;">Overzicht gezinnen</h1>
    <div class="table-responsive mt-4">
        <table class="table table-striped">
        <tr>
            <th>ID</th>
            <th>Naam</th>
            <th>Volwassenen</th>
            <th>Kinderen</th>
            <th>Postcode</th>
            <th>Mail</th>
            <th>Telefoonnummer</th>
            <th>Wensen en allergieën</th>
        </tr>
        </div>
        </CENTER>
        <?php
        include 'config.php';

        try {
            $sql = "SELECT * FROM gezinnen";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $gezinnen = $stmt->fetchAll();

            foreach ($gezinnen as $gezin) {
                echo "<tr>";
                echo "<td>" . $gezin['accountid'] . "</td>";
                echo "<td>" . $gezin['naam'] . "</td>";
                echo "<td>" . $gezin['volwassenen'] . "</td>";
                echo "<td>" . $gezin['kinderen'] . "</td>";
                echo "<td>" . $gezin['postcode'] . "</td>";
                echo "<td>" . $gezin['mail'] . "</td>";
                echo "<td>" . $gezin['telefoonnummer'] . "</td>";
                echo "<td>" . $gezin['wensen'] . "</td>";
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