<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" media="screen" href="navigation.css" />
  <style>
    .nav_bar {
      position: relative;
      z-index: 900;
    }
  </style>
</head>
<body>
<?php
session_start();
include "config.php";
// HIERDOOR ZIE JE GEEN ERRORS, VOOR TROUBLESHOOTING PURPOSES ZET DEZE OP 1
ini_set('display_errors', 0);
// HIERDOOR ZIE JE GEEN ERRORS, VOOR TROUBLESHOOTING PURPOSES ZET DEZE OP 1

$query = "SELECT * FROM user WHERE naam = :user_name";
$statement = $conn->prepare($query);
$statement->bindValue(':user_name', $_SESSION['user_name']);
$statement->execute();
$row = $statement->fetch(PDO::FETCH_ASSOC);

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
?>
<section>
  <center>
    <div>
      <nav class="nav_bar">
        <div onclick="location.href='index.php';">Home</div>
        <div class="dropdown">
          <div class="hover-button">Overzichten</div>
          <div class="dropdown-content">
            <a href="alleproducten.php">Producten</a>
            <?php 
            if ($row && ($row['role'] >= "2")) {
            echo "<a href='leveranciersoverzicht.php'>Leveranciers</a>";
            echo "<a href='overzichtgezinnen.php'>Gezinnen</a>";
            echo "<a href='overzichtgebruikers.php'>Gebruikers</a>"; 
          } 
          ?>
          </div>
        </div>
        
        <div class="dropdown">
          <div class="hover-button">Toevoegen</div>
          <div class="dropdown-content">
            <a href="productentoevoegen.php">Producten Bewerken</a>
            <?php 
            if ($row && ($row['role'] >= "2")) {
              echo "<a href='leverancierstoevoegen.php'>Leveranciers Toevoegen</a>";
              echo "<a href='gezintoevoegen.php'>Gezinnen Toevoegen</a>";
            }
            ?>
          </div>
        </div>
        <div onclick="location.href='samenstellen.php';">Voedselpakket</div>
        <div class="dropdown">
          <div style="color: black;">Welkom, <?php echo $_SESSION['user_name']; ?></div>
          <div class="dropdown-content">
            <a href="profiel.php">Profiel</a>
            <a href="logout.php">Uitloggen</a>
          </div>
        </div>
      </nav>
    </div>
  </center>
</section>
<?php
}
?>