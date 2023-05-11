<?php
// Your database connection code here

// Check if a search query is submitted
if (isset($_POST['search'])) {
    $searchTerm = $_POST['search'];

    // Prepare the SQL statement to search for the product by EAN number or name
    $sql = "SELECT * FROM producten WHERE `EAN-Nummer` = :searchTerm OR `naam` LIKE :searchTermLike";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':searchTerm', $searchTerm);
    $stmt->bindValue(':searchTermLike', "%$searchTerm%");

    // Execute the query
    $stmt->execute();

    // Fetch the result
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
        // Product found, display the product information
        foreach ($result as $row) {
            echo "Product Name: " . $row['naam'] . "<br>";
            echo "Product Description: " . $row['beschrijving'] . "<br>";
            echo "Product EAN: " . $row['EAN-Nummer'] . "<br>";
            echo "Product Image: <img src='" . $row['image'] . "'><br>";
            echo "<hr>";
        }
    } else {
        // Product not found
        echo "Product not found.";
    }
}
?>

<!-- HTML form for the search bar -->
<form method="POST">
    <input type="text" name="search" placeholder="Search by EAN number or product name">
    <button type="submit">Search</button>
</form>