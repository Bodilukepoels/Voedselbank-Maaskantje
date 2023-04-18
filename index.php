<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evenementen</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
        <a href="admin_login.php">Admin Login</a>
    <h1>Evenementen</h1>
    <table>
        <thead>
            <tr>
                <th>Naam van het event</th>
                <th>Datum</th>
                <th>Tijd</th>
                <th>Prijs</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once 'config.php';

            $sql = "SELECT * FROM events";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>{$row['name']}</td>
                        <td>{$row['event_date']}</td>
                        <td>{$row['start_time']}</td>
                        <td>{$row['price']}</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>
