<?php

	function Logout()
	{
		session_start();
		
		session_unset();
		
		header('Location: index.php');
	}

	Logout();

?>