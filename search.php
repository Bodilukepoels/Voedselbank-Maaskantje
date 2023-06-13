<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overzicht producten</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<style>
        .bg-light {
            color: black;
        }
</style>
    <?php
        include "navigation.php";
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    ?>
    <br>
    <CENTER><h1 style="color: black;">Zoek resultaten</h1>
    <form method="GET" action="search.php">
    Search: <input type="text" name="query">
    <input type="submit" value="Search">
 
    <div class="table-responsive mt-4">
        <table class="table table-striped">
        <tr>
            <th>Naam</th>
            <th>Categorie</th>
            <th>EAN Nummer</th>
        </tr>
        <?php
        include 'config.php';

        // Retrieve the search query from the form submission
        $query = $_GET['query'];

        try {
            // Prepare the SQL statement
            $sql = "SELECT * FROM producten WHERE naam LIKE :query OR categorie LIKE :query OR EAN_Nummer = :query";

            // Prepare the query statement
            $stmt = $conn->prepare($sql);

            // Bind the query parameter
            $stmt->bindParam(':query', $query);

            // Execute the SQL statement
            $stmt->execute();

            // Fetch the search results
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($results) > 0) {
                foreach ($results as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['naam'] . "</td>";
                    echo "<td>" . $row['categorie'] . "</td>";
                    echo "<td>" . $row['EAN_Nummer'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>Geen resultaten gevonden</td></tr>";
            }
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }

        // Close the database connection
        $conn = null;
        ?>
        </table>
    </div>
</body>
</html>
<?php
        }
?>
 