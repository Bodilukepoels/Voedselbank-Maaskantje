
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
