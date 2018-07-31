<?php
	error_reporting(0);
	include("connect.php");
	include("functions.php");

	if(logged_in())
	{
		header("location:profile.php");
		exit();
	}

	$error = "";

	if(isset($_POST['submit']))
	{

	    $username = mysqli_real_escape_string($con, $_POST['username']);
	    $password = mysqli_real_escape_string($con, $_POST['password']);
	    $checkBox = isset($_POST['keep']);

		if(username_exists($username,$con))
		{
			$result = mysqli_query($con, "SELECT password FROM usersinfo WHERE username='$username'");
			$retrievepassword = mysqli_fetch_assoc($result);
			
			if(!password_verify($password, $retrievepassword['password']))
			{
				$error = "Password is incorrect";
			}
			else
			{
				$res = mysqli_query($con, "SELECT * FROM usersinfo WHERE username='$username'");
				$row = mysqli_fetch_array($res, MYSQLI_ASSOC);
				//execution time exceeding problem
				if(mysqli_num_rows($res) == 1){
				$_SESSION['username'] = $row['username'];
				$_SESSION['email'] = $row['email'];
				$_SESSION['firstname'] = $row['firstname'];
				$_SESSION['lastname'] = $row['lastname'];
				}
				if($checkBox == "on")
				{
					setcookie("username",$username, time()+3600);
				}

				header("location: profile.php");
			}


		}
		else
		{
			$error = "Username Does not exist";
		}
	}

?>

<!doctype html>

<html>

	<head>

	<title>Docket App - Log In</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link href='https://fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="login.css" />
	<link rel="icon" href="icon.png" />
	</head>


	<body>
		<nav class="navbar navbar-inverse">
		<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="#"><img src="icon.png"  style="position:relative; top:-20%; width:25pt; height:25pt;"></a>
		</div>
		<ul class="nav navbar-nav navbar-left">
		<li><a href="profile.php" style="font-size:15pt;"> Docket | Make your Life productive once again.</a></li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li><a href="view.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
			<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Log In</a></li>
		</ul>
		</div>
	</nav>
		<div id="error" style=" <?php  if($error !=""){ ?>  display:block; <?php } ?> "><?php echo $error; ?></div>
		<form method="POST" action="login.php">

		  <input id="input-1" type="text" placeholder="crazy32" name="username" required />
		  <label for="input-1">
		    <span class="label-text">Username</span>
		    <span class="nav-dot"></span>
		    <div class="signup-button-trigger">Log In</div>
		  </label>

		  <input id="input-2" type="password" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;" name="password" required />
		  <label for="input-2">
		    <span class="label-text">Password</span>
		    <span class="nav-dot"></span>
		  </label>

		  <input id="input-3" type="checkbox" name="keep"/>
		  <label for="input-3">
		  <span class="label-text" style=" text-align:center;">Keep me logged in</span>
		  <span class="nav-dot"></span>
		  </label>

		  <button type="submit" name="submit">Log In</button>
		  <p class="tip">Press Tab</p>
		  <div class="signup-button">Log In</div>
		</form>
	</body>
</html>
