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
	<?php

		for($i = 0; $i < $_SESSION['warning_num_rows']; $i++)
		{
			echo '<div class="warning">';
			echo '<p>'.$_SESSION["warning_".$i."_Title"]["Title"].'			'.$_SESSION["warning_".$i."_WarnPoints"]["WarnPoints"].'</p>';
			echo '<div>'.$_SESSION["warning_".$i."_Message"]["Message"].'</div>';
			echo '</div>';
		}
		
	?>
	</div>
</body>
</html>