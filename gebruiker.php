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
                <th>Naam</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once 'config.php';

            $sql = "SELECT * FROM user";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>{$row['Naam']}</td>

                      </tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>
