<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" media="screen" href="navigation.css" />
</head>
<body>
  <?php
  session_start();
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  ?>
  <section>
    <center>
      <div>
        <nav class="nav_bar">
          <div onclick="location.href='index.php';"><a href="index.php">Home</a></div>
          <div onclick="location.href='alleproducten.php';"><a href="alleproducten.php">Producten</a></div>
          <div onclick="location.href='productentoevoegen.php';"><a href="productentoevoegen.php">ProductenToevoegen</a></div>
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