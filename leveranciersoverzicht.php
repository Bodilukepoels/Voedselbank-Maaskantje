<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overzicht producten</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
        }

        th {
            color: black;
        }
    </style>
</head>

<body>
    <?php
 
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    ?>
        <div class="container">
            <h1 class="text-center mt-5">Overzicht leveranciers</h1>
            <div class="table-responsive mt-4">
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Naam</th>
                            <th>E-mail</th>
                            <th>Telefoonnummer</th>
                            <th>Bezorgingsdatum</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'config.php';

                        try {
                            $sql = "SELECT * FROM leveranciers";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $leveranciers = $stmt->fetchAll();

                            foreach ($leveranciers as $leverancier) {
                                echo "<tr>";
                                echo "<td>" . $leverancier['id'] . "</td>";
                                echo "<td>" . $leverancier['naam'] . "</td>";
                                echo "<td>" . $leverancier['mail'] . "</td>";
                                echo "<td>" . $leverancier['telefoonnummer'] . "</td>";
                                echo "<td>" . $leverancier['bezorgingsdatum'] . "</td>";
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
    <?php
    } else {
        header("Location: leverancierstoevoegen.php");
    }
    ?>
</body>

</html>
