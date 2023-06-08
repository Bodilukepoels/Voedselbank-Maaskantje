<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gebruikers overzicht</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php
    include "navigation.php";
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        ?>
        <br>
        <CENTER><h1 style="color: black;">Gebruikers overzicht</h1></CENTER>
        <div class="table-responsive mt-4">
            <table class="table table-striped">
                <tr>
                    <th>ID</th>
                    <th>Naam</th>
                </tr>
                <?php
                include 'config.php';

                try {
                    $sql = "SELECT * FROM user";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $user = $stmt->fetchAll();

                    foreach ($user as $user) {
                        echo "<tr>";
                        echo "<td>" . $user['AccountID'] . "</td>";
                        echo "<td>" . $user['Naam'] . "</td>";
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