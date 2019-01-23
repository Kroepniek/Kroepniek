<?php

	session_start();
	
	if ((isset($_SESSION['logged_in'])) && ($_SESSION['logged_in']==true))
	{
		header('Location: main.php');
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
		background-image: url("images/wallpaper4.gif");
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
	</header>
	<div id="container">
		<div id="loginForm" class="fade-in one">
			Login
			<form name="loginForm" action="logining.php" method="post" onsubmit="return validateForm(this)">
				<input type="text" name="nick" spellcheck="false" placeholder="Nickname" required autofocus />
				<input type="password" name ="pass" spellcheck="false" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;" required />
				<input type="submit" value="Login"/>
			</form>
			<script src="js/validating.js"></script>
				<?php
					if(isset($_SESSION['login_error']))	echo $_SESSION['login_error']; unset($_SESSION['login_error']);
				?>
		</div>
	</div>
</body>
</html>