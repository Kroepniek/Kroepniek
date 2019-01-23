<?php

	session_start();

	if((empty($_POST['nick'])) || (empty($_POST['pass'])))
	{
		header('Location: login.php');
		exit();
	}
	else
	{
		ValidateLogIn();
	}

	function ValidateLogIn()
	{
		require_once "connect.php";
		
		if ($con->connect_errno!=0)
		{
			$_SESSION['login_error'] = '<span style="color:red;font-size: 16px; position: relative; top: -35px;">Server error, try login later.</span>';
			header('Location: login.php');
		}
		else
		{
			$nick = $_POST['nick'];
			$pass = $_POST['pass'];

			$nick = htmlentities($nick, ENT_QUOTES, "UTF-8");
			$pass = htmlentities($pass, ENT_QUOTES, "UTF-8");
		
			if ($result = @$con->query(
			sprintf("SELECT * FROM Users WHERE nickname='%s'",
			mysqli_real_escape_string($con,$nick))))
			{
				$amount_of_users = $result->num_rows;
				if($amount_of_users>0)
				{
					$record = $result->fetch_assoc();
					if (password_verify($pass, $record['password']))
					{
						if($record['isBanned'] == true)
						{
							$_SESSION['login_error'] = '<span style="color:red;font-size: 20px; position: relative; top: -35px;"><b>Your account is <span style="color:darkred">banned</span>!</b></span>';
							header('Location: login.php');
						}
						else
						{
							$_SESSION['logged_in'] = true;
							$_SESSION['ID'] = $record['ID'];
							$_SESSION['nickname'] = $record['nickname'];
							$_SESSION['email'] = $record['email'];
							$_SESSION['Birth'] = $record['Birth'];
							$_SESSION['RegisterDate'] = $record['RegisterDate'];
							$_SESSION['Street'] = $record['Street'];
							$_SESSION['HouseNumber'] = $record['HouseNumber'];
							$_SESSION['City'] = $record['City'];
							$_SESSION['ZipCode'] = $record['ZipCode'];
							$_SESSION['Country'] = $record['Country'];
							$_SESSION['Phone'] = $record['Phone'];
							$_SESSION['isAdmin'] = $record['isAdmin'];

							$ID = $record['ID'];
							
							unset($_SESSION['login_error']);
							$result->free_result();

							$result = @$con->query(sprintf("SELECT * FROM warnings WHERE ID_ASOS = '$ID'"));
							$record = $result->fetch_assoc();

							$_SESSION['warning_num_rows'] = $result->num_rows;

							echo "<script>console.log( 'result: " . $_SESSION['warning_num_rows'] . "' );</script>";
							for($i = 0; $i < $result->num_rows; $i++)
							{
								$_SESSION['warning_'.$i.'_titel'] = $record['Title'];
								$_SESSION['warning_'.$i.'_message'] = $record['Message'];
								$_SESSION['warning_'.$i.'_warnPoints'] = $record['WarnPoints'];
							}
							header('Location: main.php');
						}
					}
					else
					{
						$_SESSION['login_error'] = '<span style="color:red;font-size: 16px; position: relative; top: -35px;">Incorrect login or password!</span>';
						header('Location: login.php');
					}
				}
				else
				{
					$_SESSION['login_error'] = '<span style="color:red;font-size: 16px; position: relative; top: -35px;">Incorrect login or password!</span>';
					header('Location: login.php');
				}
			}
			$con->close();
		}
	}
?>