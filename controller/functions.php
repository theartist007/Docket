<?php

	function email_exists($email, $con)
	{
		$result = mysqli_query($con,"SELECT * FROM usersinfo WHERE email='$email'");
		$row = mysqli_fetch_array($result);

		if(mysqli_num_rows($result) == 1)
		{
			return true;
		}
		else
		{
			return false;
		}

	}

	function logged_in()
	{
			if(isset($_SESSION['username']) || isset($_COOKIE['username']))
			{
				return true;
			}
			else
			{
				return false;
			}
	}

	function check_username($username, $con)
	{
		$result = mysqli_query($con,"SELECT * FROM usersinfo WHERE username='$username'");
		$row = mysqli_fetch_array($result);

		if(mysqli_num_rows($result) == 1)
		{
			return true;
		}
		else
		{
			return false;
		}

	}
?>
