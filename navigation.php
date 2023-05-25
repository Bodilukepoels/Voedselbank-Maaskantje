<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" media="screen" href="navigation.css" />
</head>
<body>
  <?php
  session_start();
  include "config.php";

//HIERDOOR ZIE JE GEEN ERRORS, VOOR TROUBLESHOOTING PURPOSES ZET DEZE OP 1
  ini_set('display_errors', 1);
//HIERDOOR ZIE JE GEEN ERRORS, VOOR TROUBLESHOOTING PURPOSES ZET DEZE OP 1

  $naam = $_SESSION['user_name'];

  $query = "SELECT role FROM user WHERE Naam = '$naam'";
  $stmt = $conn->query($query);
  
  if ($stmt && $stmt->rowCount() > 0) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
  }

  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  ?>
  <section>
    <center>
      <div>
        <nav class="nav_bar">
          <div onclick="location.href='index.php';">Home</a></div>
          <div onclick="location.href='alleproducten.php';">Producten</a></div>
          <div onclick="location.href='productentoevoegen.php';">Producten Toevoegen</a></div>
          
        <?php
        if ($row['role'] == "directie") {
            echo '<div onclick="location.href=\'leveranciers.php\';"><a href="leveranciers.php">Leveranciers</a></div>';
        }
        ?>
          <div class="dropdown">
            <div style= 'color: black;'>Welkom, <?php echo $_SESSION['user_name']; ?></div>
            <div class="dropdown-content">
              <a href="logout.php">Logout</a>
            </div>
          </div>
        </nav>
      </div>
    </center>
  </section>
  <?php
  }
  ?>
</body>
</html>
