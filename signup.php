<?php

	session_start();
	
	if (isset($_POST['email']))
	{
		ValidateSignUp();
	}

	function ValidateSignUp()
	{
		$validating_OK=true;
		
		$nick = $_POST['nick'];
		
		if ((strlen($nick)<3) || (strlen($nick)>20))
		{
			$validating_OK=false;
			$_SESSION['er_nickname']="Nickname length between 3 and 20 symbols required.";
		}

		$name = $_POST['name'];
		
		if ((strlen($name)<3) || (strlen($name)>20))
		{
			$validating_OK=false;
			$_SESSION['er_name']="Name length between 3 and 20 symbols required.";
		}
		
		if (ctype_alpha($name)==false)
		{
			$validating_OK=false;
			$_SESSION['er_name']="Name only from letters required.";
		}
		$lastname = $_POST['lastname'];
		
		if ((strlen($lastname)<3) || (strlen($lastname)>20))
		{
			$validating_OK=false;
			$_SESSION['er_lastname']="Lastname length between 3 and 20 symbols required.";
		}
		
		if (ctype_alpha($lastname)==false)
		{
			$validating_OK=false;
			$_SESSION['er_lastname']="Lastname only from letters required.";
		}
		
		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		{
			$validating_OK=false;
			$_SESSION['er_email']="Insert correct e-mail.";
		}
		
		$pass = $_POST['pass'];
		$repeat_pass = $_POST['repeat_pass'];
		
		if ((strlen($pass)<8) || (strlen($pass)>20))
		{
			$validating_OK=false;
			$_SESSION['er_password']="Password length between 8 and 20 symbols required.";
		}
		if ($pass!=$repeat_pass)
		{
			$validating_OK=false;
			$_SESSION['er_password']="Passwords doesn't match!";
		}	
		$pass_hash = password_hash($pass, PASSWORD_DEFAULT);		
		
		$secret = "6LdqnXYUAAAAALU7ZoWG3-nXnAgkB4Fwkp5jl7_r";
		
		$check_bot = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
		
		$bot_answer = json_decode($check_bot);
		
		if ($bot_answer->success==false)
		{
			$validating_OK=false;
			$_SESSION['er_bot']="Confirm you are not a bot!";
		}		
		
		$_SESSION['fr_nickname'] = $nick;
		$_SESSION['fr_name'] = $name;
		$_SESSION['fr_lastname'] = $lastname;
		$_SESSION['fr_email'] = $email;
		$_SESSION['fr_password'] = $pass;
		$_SESSION['fr_repeat_password'] = $repeat_pass;
		
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try 
		{
			if ($con->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				$result = $con->query("SELECT ID FROM users WHERE email='$email'");
		
				if (!$result) throw new Exception($con->error);
				
				$amount_mails = $result->num_rows;
				if($amount_mails>0)
				{
					$validating_OK=false;
					$_SESSION['er_email']="Account with this emial already exists.";
				}		

				$result = $con->query("SELECT ID FROM users WHERE nickname='$nick'");
					
				if (!$result) throw new Exception($con->error);
					
				$amount_nicknames = $result->num_rows;
				if($amount_nicknames>0)
				{
					$validating_OK=false;
					$_SESSION['er_nickname']="Account with this nickname already exists.";
				}
				
				if ($validating_OK==true)
				{
					if ($con->query("INSERT INTO users VALUES (NULL, '$nick', '$name', '$lastname', '$pass_hash', '$email', 0, 0)"))
					{
						$_SESSION['success_signup']=true;
					
						unset($_SESSION['login_error']);
						header('Location: login.php');
					}
					else
					{
						throw new Exception($con->error);
					}	
				}
				
				$con->close();
			}		
		}
		catch(Exception $e)
		{
			$_SESSION['signup_error'] = '<span style="color:red;font-size: 16px; display: block; margin-bottom: -16px;">Server error, try login later.'.$e.'</span>';
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
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<style>
	body
	{
		background-image: url("images/wallpaper4.gif");
	}
	</style>
</head>
<body>
	<header id="header" class="fade-in hd-signup">
		<div id="logo">
			<a href="index.php">
			Kroepniek
			<img src="images/logo.png" width="50" height="50" style="margin-top: -5px;" align="top">
			</a>
		</div>
	</header>
	<div id="container">
		<div id="loginForm" class="fade-in one-signup" style="margin-top: 50px; height: auto; width: 350px;">
			Sign Up
			<form name="loginForm" method="post">
				<input type="text" name="nick" spellcheck="false" placeholder="Nickname" value="<?php
				if (isset($_SESSION['fr_nickname']))
				{
					echo $_SESSION['fr_nickname'];
					unset($_SESSION['fr_nickname']);
				}
				?>" autofocus />
				<span style="color:red;font-size: 16px; display: block; margin-bottom: -16px;">
				<?php
					if(isset($_SESSION['er_nickname']))
					{
						echo $_SESSION['er_nickname'];
						unset($_SESSION['er_nickname']);
					}
				?>
				</span>

				<input type="text" name="name" spellcheck="false" placeholder="Name" value="<?php
				if (isset($_SESSION['fr_name']))
				{
					echo $_SESSION['fr_name'];
					unset($_SESSION['fr_name']);
				}
				?>" autofocus />
				<span style="color:red;font-size: 16px; display: block; margin-bottom: -16px;">
				<?php
					if(isset($_SESSION['er_name']))
					{
						echo $_SESSION['er_name'];
						unset($_SESSION['er_name']);
					}
				?>
				</span>

				<input type="text" name="lastname" spellcheck="false" placeholder="Lastname" value="<?php
				if (isset($_SESSION['fr_lastname']))
				{
					echo $_SESSION['fr_lastname'];
					unset($_SESSION['fr_lastname']);
				}
				?>" autofocus />
				<span style="color:red;font-size: 16px; display: block; margin-bottom: -16px;">
				<?php
					if(isset($_SESSION['er_lastname']))
					{
						echo $_SESSION['er_lastname'];
						unset($_SESSION['er_lastname']);
					}
				?>
				</span>

				<input type="email" name="email" spellcheck="false" placeholder="E-mail" value="<?php
				if (isset($_SESSION['fr_email']))
				{
					echo $_SESSION['fr_email'];
					unset($_SESSION['fr_email']);
				}
				?>" />
				<span style="color:red;font-size: 16px; display: block; margin-bottom: -16px;">
				<?php
					if(isset($_SESSION['er_email']))
					{
						echo '<span style="color:red;font-size: 16px; display: block; margin-bottom: -16px;">'.$_SESSION['er_email'].'</span>';
						unset($_SESSION['er_email']);
					}	
				?>
				</span>

				<input type="password" name="pass" spellcheck="false" placeholder="Your password" value="<?php
				if (isset($_SESSION['fr_password']))
				{
					echo $_SESSION['fr_password'];
					unset($_SESSION['fr_password']);
				}
				?>" />
				<input type="password" name="repeat_pass" spellcheck="false" placeholder="Repeat password" value="<?php
				if (isset($_SESSION['fr_repeat_password']))
				{
					echo $_SESSION['fr_repeat_password'];
					unset($_SESSION['fr_repeat_password']);
				}
				?>" />
				<span style="color:red;font-size: 16px; display: block; margin-bottom: -16px;">
				<?php
					if(isset($_SESSION['er_password']))
					{
						echo '<span style="color:red;font-size: 16px; display: block; margin-bottom: -16px;">'.$_SESSION['er_password'].'</span>'; 
						unset($_SESSION['er_password']);
					}
				?>
				</span>
				<div style="margin-left: 25px; margin-top: 30px;">
					<div class="g-recaptcha" data-sitekey="6LdqnXYUAAAAAKE-doHw4LMV74ITA_JJPgBe9e0M"></div>
					<span style="color:red;font-size: 16px; display: block; margin-bottom: -16px;">
					<?php
						if (isset($_SESSION['er_bot']))
						{
							echo '<span style="color:red;font-size: 16px; display: block; margin-bottom: -16px;">'.$_SESSION['er_bot'].'</span>';
							unset($_SESSION['er_bot']);
						}
					?>
					</span>
				</div>
				<input type="submit" name="signup" value="Sign Up"/>
			</form>
			<?php
					if(isset($_SESSION['signup_error']))	echo $_SESSION['signup_error']; unset($_SESSION['signup_error']);
			?>
		</div>
	</div>
</body>
</html>