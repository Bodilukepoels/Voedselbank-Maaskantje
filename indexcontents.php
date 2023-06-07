<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
<div style="color: black; box-shadow: 2px 2px 2px 2px; padding: 15px;" class="container">
    <h2>Welkom, <?php echo $_SESSION['user_name']; ?>!</h2>  
    <a href="logout.php"><h1>Logout</h1></a>
</div>
<br><br>

<<<<<<< Updated upstream
<?php
include "config.php";

// Retrieve the current food package
try {
    $stmt = $conn->prepare("SELECT * FROM voedselpakket ORDER BY id DESC LIMIT 1");
    $stmt->execute();
    $package = $stmt->fetch();

    if ($package) {
        $packageId = $package['id'];
        $packageName = $package['naam'];

        echo '<a href="food_package_details.php?package_id=' . $packageId . '">';
        echo '<h2>Huidige voedselpakket: ' . $packageName . '</h2>';
        echo '<div style="text-align: center;">';
        echo '<img src="https://cdn.pixabay.com/photo/2012/04/24/16/17/box-40302_960_720.png" width="200px" style="cursor: pointer;">';
        echo '<p>Klik hier om de details van het voedselpakket te bekijken</p>';
        echo '</div>';
        echo '</a>';
    } else {
        echo '<p>Er is momenteel geen voedselpakket beschikbaar.</p>';
    }
} catch (PDOException $e) {
    echo '<p>Fout bij het ophalen van het voedselpakket: ' . $e->getMessage() . '</p>';
}
?>
=======
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
	<div style="color: black; box-shadow: 2px 2px 2px 2px; padding: 15px;" class="container">
	<h2>Welkom, <?php echo $_SESSION['user_name']; ?>!</h2>  
	<a href="logout.php"><h1>Logout</h1></a>
	</div>
	<br><br>
<a href="food_package_details.php">
    <div style="text-align: center;">
        <img src="https://cdn.pixabay.com/photo/2012/04/24/16/17/box-40302_960_720.png" width="200px" style="cursor: pointer;">
        <p>Klik hier om de details van het voedselpakket te bekijken</p>
    </div>
</a>
>>>>>>> Stashed changes
