
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" media="screen" href="navigation.css" />
</head>
<body>
  <section>
    <center>
      <div>
        <nav class="nav_bar">
          <div onclick="location.href='index.php';"><a href="index.php">Home</a></div>
          <div onclick="location.href='alleproducten.php';"><a href="alleproducten.php">Producten</a></div>
          <div onclick="location.href='contactpagina.php';"><a href="contactpagina.php">Contact</a></div>
          <div onclick="location.href='winkelmand.php';"><a href="winkelmand.php">Winkelmand</a></div>
          <?php
          session_start();
          if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
              echo "<div class=\"dropdown\">";
              echo "<div style= 'color: black;'>Welkom, " . $_SESSION['user_name'] . "</div>";
              echo "<div class=\"dropdown-content\">";
              echo "<a href=\"logout.php\">Logout</a>";
              echo "</div>";
              echo "</div>";
          } else {
              echo "<div onclick=\"location.href='login.php';\"><a href=\"login.php\">Login</a></div>";
          }
          ?>
        </nav>
      </div>
    </center>
  </section>
</body>
</html>
