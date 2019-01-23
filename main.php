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
	<link rel="icon" href="images/logo.png" type="image/gif">
	<title>Kroepniek</title>
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
				<li><a href="profile.php" style="width: 120px;">My profile</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</nav>
	</header>
	<div id="container">
		<h1 class="fade-in one">Evening, <?= $_SESSION['nickname'];?></h1>
		<h2 class="fade-in two">Enjoy.</h2>
	</div>
</body>
</html>