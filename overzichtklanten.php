<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klantoverzicht</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php
    include "navigation.php";
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        ?>
        <br>
        <CENTER><h1 style="color: black;">Klantoverzicht</h1></CENTER>
        <div class="table-responsive mt-4">
            <table class="table table-striped">
                <tr>
                    <th>Gezins ID</th>
                    <th>Gezinsnaam</th>
                    <th>Volwassenen</th>
                    <th>Kinderen</th>
                </tr>
                <?php
                include 'config.php';

                try {
                    $sql = "SELECT * FROM gezinnen";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $gezinnen = $stmt->fetchAll();

                    foreach ($gezinnen as $gezin) {
                        echo "<tr>";
                        echo "<td>" . $gezin['id'] . "</td>";
                        echo "<td>" . $gezin['naam'] . "</td>";
                        echo "<td>" . $gezin['volwassenen'] . "</td>";
                        echo "<td>" . $gezin['kinderen'] . "</td>";
                        echo "</tr>";
                    }
                } catch (PDOException $e) {
                    echo "<div class='alert alert-danger'>" . $e->getMessage() . "</div>";
                }
                ?>
            </table>
        </div>
        <?php
    } else {
        header("Location: index.php");
    }
    ?>
</body>
</html>
