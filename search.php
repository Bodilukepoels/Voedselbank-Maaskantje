<?php
// Database connection details
$servername = "your_servername";
$username = "your_username";
$password = "your_password";
$dbname = "producten";

// Create a connection to the database
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the search query from the form submission
$query = $_GET['query'];

// Prepare the SQL statement
$sql = "SELECT * FROM products WHERE name LIKE '%$naam%' OR category LIKE '%$query%' OR ean_number = '$query'";

// Execute the SQL statement
$result = mysqli_query($conn, $sql);

// Display the search results
while ($row = mysqli_fetch_assoc($result)) {
    // Display the product information
    echo "Naam: " . $row['naam'] . "<br>";
    echo "Categorie: " . $row['categorie'] . "<br>";
    echo "EAN Nummer: " . $row['EAN-Nummer'] . "<br><br>";
}

// Close the database connection
mysqli_close($conn);
?>
