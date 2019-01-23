<?php
	session_start();

	if (!isset($_POST['col']))
	{
		header('Location: index.php');
	}

	require_once "connect.php";
	
	if ($con->connect_errno!=0)
	{
		echo "Server error, try later";
	}
	else
	{
		CheckIfSame($_POST['col'], $_POST['val'], $_POST['id'], $con);
	}

	function CheckIfSame($col, $val, $ID, $con)
	{
		$id = intval($ID);

		$sql = "SELECT $col FROM Users WHERE ID = $id";
		$result = $con->query($sql);
		$row = $result->fetch_assoc();

		if ($val != $row[$col])
		{
			switch ($col) {
				case "email":
					try 
					{
						$email = $val;
						$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
						
						if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
						{
							throw new Exception("wrong");
						}
					} 
					catch (Exception $e) 
					{
						echo "It's not a valid email";
						$con->close();
						exit;
					}
				break;
				case "Birth":
					try 
					{
						$date = new DateTime($val);
					} 
					catch (Exception $e) 
					{
						echo "It's not a valid date";
						$con->close();
						exit;
					}
				break;
				case "Street":
					try 
					{
						if (is_numeric($val))
						{
							throw new Exception("wrong");
						}
					} 
					catch (Exception $e) 
					{
						echo "It's not a valid street name";
						$con->close();
						exit;
					}
				break;
				case "HouseNumber":
					try 
					{
						if (!is_numeric(substr($val, 0, strlen($val)-1)))
						{
							throw new Exception("wrong");
						}
					} 
					catch (Exception $e) 
					{
						echo "It's not a valid house number";
						$con->close();
						exit;
					}
				break;
				case "City":
					try 
					{
						if (is_numeric($val))
						{
							throw new Exception("wrong");
						}
					} 
					catch (Exception $e) 
					{
						echo "It's not a valid date";
						$con->close();
						exit;
					}
				break;
				case "ZipCode":
					try 
					{
						if (strlen($val) != 6)
						{
							throw new Exception("wrong");
						}
					} 
					catch (Exception $e) 
					{
						echo "It's not a valid zip code";
						$con->close();
						exit;
					}
				break;
				case "Country":
					try 
					{
						if (is_numeric($val))
						{
							throw new Exception("wrong");
						}
					} 
					catch (Exception $e) 
					{
						echo "It's not a valid date";
						$con->close();
						exit;
					}
				break;
				case "Phone":
					try 
					{
						if (!is_numeric($val) && strlen($val) < 9)
						{
							throw new Exception("wrong");
						}
					} 
					catch (Exception $e) 
					{
						echo "It's not a valid phone number";
						$con->close();
						exit;
					}
				break;
			}

			EditDB($_POST['col'], $_POST['val'], $_POST['id'], $con);
			UpdateSession($_POST['col'], $_POST['val']);
		}
		else
		{
			echo "There is nothing changed";
			$con->close();
		}
	}

	function EditDB($col, $val, $ID, $con)
	{
		$id = intval($ID);
		
		$sql = "UPDATE Users SET $col = '$val' WHERE ID = $id";

		if ($con->query($sql) === TRUE)
		{
			echo $col." updated successfully";
		} else 
		{
			echo "Query error, try later";
		}

		$con->close();
	}

	function UpdateSession($col, $val)
	{
		$_SESSION[$col] = $val;
	}
?>