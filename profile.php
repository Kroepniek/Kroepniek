<?php

	session_start();
	
	if (!isset($_SESSION['logged_in']))
	{
		header('Location: login.php');
		exit();
	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="description" content="Kroepniek - All in one">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Bubblegum+Sans" rel="stylesheet">
	<link rel="icon" href="images/logo.png" type="image/gif">
	<title>Kroepniek</title>
	<style>
	body
	{
		background-image: url("images/wallpaper2.jpg");
	}
	</style>
</head>
<body>
	<header id="header" class="fade-in hd">
		<div id="logo">
			<a href="index.php">
			Kroepniek
			<img src="images/logo.png" width="50" height="50" style="margin-top: -5px;" align="top">
			</a>
		</div>

		<nav id="main-nav">
			<ul>
				<li><a href="main.php" style="width: 120px;">Go back</a></li>
				<?php if($_SESSION['isAdmin'] == true) echo '<li><a href="admin.php" style="width: 120px; color: darkred">Admin</a></li>'; ?>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</nav>
	</header>
	<div id="container">
		<div id="user-info">
		<?php
			echo '<br>';
			echo 'Nickname:<br>';
			echo '<input type="text" name="nickname" value="'.$_SESSION["nickname"].'"></input><div class="edit-user" onclick="EditUserInfo(2, false,'.$_SESSION["ID"].')">Edit</div><br><br>';
			echo 'E-mail:<br>';
			echo '<input type="text" name="email" value="'.$_SESSION["email"].'"></input><div class="edit-user" onclick="EditUserInfo(7, false,'.$_SESSION["ID"].')">Edit</div><br><br>';
			echo 'Birth date:<br>';
			echo '<input type="text" name="Birth" value="'.$_SESSION["Birth"].'"></input><div class="edit-user" onclick="EditUserInfo(12, false,'.$_SESSION["ID"].')">Edit</div><br><br>';
			echo 'Register date:<br>';
			echo '<input type="text" name="RegisterDate" value="'.$_SESSION["RegisterDate"].'" disabled></input><br><br>';
			echo 'Street and House number:<br>';
			echo '<input type="text" name="Street" value="'.$_SESSION["Street"].'"></input><input type="text" name="HouseNumber" value="'.$_SESSION["HouseNumber"].'"></input><div class="edit-user" onclick="EditUserInfo(21, 22,'.$_SESSION["ID"].')">Edit</div><br><br>';
			echo 'City and Zip Code:<br>';
			echo '<input type="text" name="City" value="'.$_SESSION["City"].'"></input><input type="text" name="ZipCode" value="'.$_SESSION["ZipCode"].'"></input><div class="edit-user" onclick="EditUserInfo(27, 28,'.$_SESSION["ID"].')">Edit</div><br><br>';
			echo 'Country:<br>';
			echo '<input type="text" name="Country" value="'.$_SESSION["Country"].'"></input><div class="edit-user" onclick="EditUserInfo(33, false,'.$_SESSION["ID"].')">Edit</div><br><br>';
			echo 'Phone number:<br>';
			echo '<input type="text" name="Phone" value="'.$_SESSION["Phone"].'"></input><div class="edit-user" onclick="EditUserInfo(38, false,'.$_SESSION["ID"].')">Edit</div><br><br>';
		?>
		<div id="user-edit-error"></div>
		</div>
		<script src="js/EditingUser.js"></script>
	</div>
</body>
</html>