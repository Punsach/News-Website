<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>New User Page</title>
	<style type="text/css">
		body{
			width: 760px; /* how wide to make your web page */
			background-color: teal; /* what color to make the background */
			margin: 0 auto;
			padding: 0;
			font:12px/16px Verdana, sans-serif; /* default font */
		}
		div#main{
			background-color: #FFF;
			margin: 0;
			padding: 10px;
		}
	</style>
</head>
<body><div id="main">

	<form method="POST">
		<p>
			<label for="user">Enter your username:</label>
			<input type="text" name="user" id="user" />
		</p>
		<p> 
			<label for="password">Enter your password:</label>
			<input type="password" name="pass" id="pass"/>
		</p>
		<p>
			<input type="submit" name ="new" id = "new" value="Create Account" />
		</p>
	</form>
	<?php
	require 'database.php';
	//Allows user to create an account and hashes the password, then stores it in table
	if(isset($_POST['new']))
	{
		$username = $_POST['user'];
		$password = $_POST['pass'];
		$hashedpassword = password_hash($password,PASSWORD_DEFAULT);

		$stmt = $mysqli->prepare("insert into users (username,password ) values ('$username', '$hashedpassword')");
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}

		$stmt->bind_param('ss', $username, $hashedpassword);

		$stmt->execute();

		$stmt->close();
		header ("Location:login.php");
	}

	?>

</div></body>
</html>

