<?php

	session_start();
	
	if ($_SESSION['isAdmin']==false)
	{
		header('Location: profile.php');
		exit();
	}

	if (!isset($_SESSION['logged_in']))
	{
		header('Location: login.php');
		exit();
	}

	$selectedUserID = 0;

	require_once "connect.php";

	$con = @new mysqli($host, $db_username, $db_password, $db_name);
	
	if ($con->connect_errno!=0)
	{
		$_SESSION['admin_error'] = '<span style="color:red;font-size: 16px; position: relative; top: -35px;">Server error, try login later.</span>';
		header('Location: admin.php');
	}
	else
	{
	
		if ($result = @$con->query(
		sprintf("SELECT * FROM Users")))
		{
			$amount_of_users = $result->num_rows;
			if($amount_of_users>0)
			{
				$record = $result->fetch_all();

				for($i = 0; $i < $amount_of_users; $i++)
				{
					$table_row[$i]['ID'] = $record[$i][0];
					$table_row[$i]['nickname'] = $record[$i][1];
					$table_row[$i]['name'] = $record[$i][2];
					$table_row[$i]['lastname'] = $record[$i][3];
					$table_row[$i]['email'] = $record[$i][5];
					$table_row[$i]['RegisterDate'] = $record[$i][6];
					$table_row[$i]['isAdmin'] = $record[$i][14];
					$table_row[$i]['isBanned'] = $record[$i][15];
				}
						
				unset($_SESSION['admin_error']);
				$result->free_result();
				
			}
			else
			{
				
				$_SESSION['admin_error'] = '<span style="color:red;font-size: 16px; position: relative; top: -35px;">Nothing to show.</span>';
				header('Location: login.php');
				
			}
			
		}
		
		$con->close();
	}

	if(isset($_POST['send_command']))
	{
		$com = $_POST['command'];
		if(substr($com, 0, 6) == "UPDATE")
		{
			$con = @new mysqli($host, $db_username, $db_password, $db_name);
		
			if ($con->connect_errno!=0)
			{
				$_SESSION['admin_error'] = '<span style="color:red;font-size: 16px; position: relative; top: -35px;">Server error, try login later.</span>';
			}
			else
			{
				$command = @$con->query(sprintf($com));
			}
			header('Location: admin.php');
		}
		else if(substr($com, 0, 6) == "INSERT")
		{
			$con = @new mysqli($host, $db_username, $db_password, $db_name);
		
			if ($con->connect_errno!=0)
			{
				$_SESSION['admin_error'] = '<span style="color:red;font-size: 16px; position: relative; top: -35px;">Server error, try login later.</span>';
			}
			else
			{
				$command = @$con->query(sprintf($com));
			}
			header('Location: admin.php');
			
		}
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
		background-image: url("images/wallpaper5.jpg");
	}
	</style>
	<script src="jquery-3.3.1.min.js"></script>
	<script>
		var selectedUserID;

		function SelectUser(userID)
		{
			selectedUserID = userID;

			$("#row-border").css("border", "2.5px solid #295529");
			$("#row-border").css("background-color", "#29552944");
			$("#row-border").css("top", ((userID*31)+5) + "px");

			var temp = $('#Command').val();
			if(temp.slice(-1) != " ")
			{
				temp = (temp.slice(0, -1));
			}
			$('#Command').val(temp + selectedUserID);
		}

		function GetIdByPos()
		{
			var pos = $("#row-border").css("top");
			var onlyNumber = pos.slice(0, -2);
			var id = (onlyNumber - 5)/31;
			SelectUser(id);
		}

		function nav_Ban()
		{
			$('#Command').val("UPDATE users SET isBanned = 1 WHERE ID = ");
		}

		function nav_Unban()
		{
			$('#Command').val("UPDATE users SET isBanned = 0 WHERE ID = ");
		}

		function nav_Warn()
		{
			$('#Command').val("INSERT INTO warnings VALUES (NULL, "+selectedUserID+", 'Titel', 'Content', 0)");
		}

		function nav_Admin()
		{
			$('#Command').val("UPDATE users SET isAdmin = 1 WHERE ID = ");
		}

		function nav_UnsetAdmin()
		{
			$('#Command').val("UPDATE users SET isAdmin = 0 WHERE ID = ");
		}

	</script>
</head>
<body>
	<header id="header" class="fade-in hd">
		<div id="logo">
			<a href="index.php">
			Kroepniek
			<img src="images/logo.png" width="50" height="50" style="margin-top: -5px;" align="top">
			</a>
		</div>
		<span id="logo-admin">Admin</span>

		<nav id="main-nav">
			<ul>
				<li><a href="main.php" style="width: 120px;">Go back</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</nav>
	</header>
	<div id="container" class="fade-in one">
		<div id="admin-nav">
			<span class="admin-nav-element" onclick="nav_Ban()">Ban</span>
			<span class="admin-nav-element" onclick="nav_Unban()">Unban</span>
			<span class="admin-nav-element" onclick="nav_Warn()">Warn</span>
			<span class="admin-nav-element" onclick="nav_Admin()">Set Admin</span>
			<span class="admin-nav-element" onclick="nav_UnsetAdmin()">Unset Admin</span>
		</div>
		<div id="users-table">
			<div id="row-border" onclick="GetIdByPos()"></div>
			<?php
				echo '<table id="users-table-table" style="position: relative; top: -27px;">';
					echo '<tr>';
						echo '<th style="width: 15px; text-align: center">ID</th>';
						echo '<th style="width: 220px; text-align: center">Nickname</th>';
						echo '<th style="width: 220px; text-align: center">E-mail</th>';
						echo '<th style="width: 320px; text-align: center">Register Date</th>';
						echo '<th style="width: 50px; text-align: center">Admin</th>';
						echo '<th style="width: 50px; text-align: center">Banned</th>';
					echo '</tr>';
					for($j = 0; $j < $amount_of_users; $j++)
					{
						echo '<tr id="row-by-ID_'.$table_row[$j]['ID'].'" onclick="SelectUser('.$table_row[$j]['ID'].')">';
							echo '<td style="text-align: center">'.$table_row[$j]['ID'].'</td>';
							echo '<td style="text-align: left; padding-left: 8px; max-width: 220px; overflow: hidden; text-overflow: ellipsis">'.$table_row[$j]['nickname'].'</td>';
							echo '<td style="text-align: left; padding-left: 8px; max-width: 220px; overflow: hidden; text-overflow: ellipsis">'.$table_row[$j]['email'].'</td>';
							echo '<td style="text-align: center; padding-left: 8px; max-width: 320px; overflow: hidden; text-overflow: ellipsis">'.$table_row[$j]['RegisterDate'].'</td>';
							echo '<td style="text-align: center;'.($table_row[$j]['isAdmin'] ? ' color: darkgreen"><b>True</b>' : ' color: darkred"><b>False</b>').'</td>';
							echo '<td style="text-align: center;'.($table_row[$j]['isBanned'] ? ' color: darkgreen"><b>True</b>' : ' color: darkred"><b>False</b>').'</td>';
						echo '</tr>';
					}
				echo '</table>';
			?>
			<form method="post">
				<input type="text" id="Command" name="command" spellcheck="false">
				<input type="submit" id="Send_Command" name="send_command" value="Send">
			</form>
		</div>
	</div>
</body>
</html>