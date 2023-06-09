<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overzicht producten</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php
        include "navigation.php";
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    ?>
    <br>
    <CENTER><h1 style="color: black;">Overzicht producten</h1>
    <form method="GET" action="search.php">
    Search: <input type="text" name="query">
    <input type="submit" value="Search">
</form>
    <div class="table-responsive mt-4">
        <table class="table table-striped">
        <tr>
            <th>ID</th>
            <th>Naam</th>
            <th>Beschrijving</th>
            <th>Categorie</th>
            <th>Voorraad</th>
            <th>EAN Nummer</th>
        </tr>
        </div>
        </CENTER>
<?php
        include 'config.php';

        $sql = "SELECT * FROM producten";
        $search = "";
        $filtercategory = "";
        $params = [];

        if (isset($_GET['search']) && $_GET['search'] != '') {
            $search = "%" . $_GET['search'] . "%";
            $sql .= " WHERE (naam LIKE :search OR beschrijving LIKE :search)";
            $params[':search'] = $search;
        }

        if (isset($_GET['filtercategory']) && $_GET['filtercategory'] != '') {
            $filtercategory = $_GET['filtercategory'];
            $sql .= empty($search) ? " WHERE " : " AND ";
            $sql .= "categorie = :filtercategory";
            $params[':filtercategory'] = $filtercategory;
        }

        if (isset($_GET['sortname']) && $_GET['sortname'] == "1") {
            $sql .= " ORDER BY naam ASC";
        }

        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute($params);
            $products = $stmt->fetchAll();

            foreach ($products as $product) {
                echo "<tr>";
                echo "<td>" . $product['id'] . "</td>";
                echo "<td>" . $product['naam'] . "</td>";
                echo "<td>" . $product['beschrijving'] . "</td>";
                echo "<td>" . $product['categorie'] . "</td>";
                echo "<td>" . $product['voorraad'] . "</td>";
                echo "<td>" . $product['EAN_Nummer'] . "</td>";
                echo "</tr>";
            }
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>" . $e->getMessage() . "</div>";
        }
    }
    ?>
    </table>
</body>
</html>
