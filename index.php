<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voedselbank Maaskant</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
    include 'navigation.php';

    ?>
    <h1>Voedselbank Maaskant</h1>
    <table>
        <thead>
            <tr>
                <th>Product naam</th>
                <th>beschrijving</th>
                <th>vooraad</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once 'config.php';

            $sql = "SELECT * FROM producten";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>{$row['naam']}</td>
                        <td>{$row['beschrijving']}</td>
                        <td>{$row['voorraad']}</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>
