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

<body class="bg-light">
    <?php
    include "config.php";
    include "navigation.php";
    if ($row && $row['role'] == "3") {
 
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    ?>
        <div class="container">
            <h1 style="color: black" class="text-center mt-5">Overzicht leveranciers</h1>
            <div class="table-responsive mt-4">
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Naam</th>
                            <th>E-mail</th>
                            <th>Telefoonnummer</th>
                            <th>postcode</th>
                            <th>Bezorgingsdatum</th>
                            <th>Bezorgingstijd</th>
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
                                echo "<td>" . $leverancier['postcode'] . "</td>";
                                echo "<td>" . $leverancier['bezorgingsdatum'] . "</td>";
                                echo "<td>" . $leverancier['bezorgingstijd'] . "</td>";
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
    }
    } else {
        header("Location: index.php");
    }
    ?>
</body>
</html>