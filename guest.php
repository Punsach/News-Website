<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>View Articles</title>
	<style type="text/css">
		ul {
			list-style-type: none;
			margin: 0;
			padding: 0;
			overflow: hidden;
			background-color: teal;
		}

		li {
			float: left;
		}

		li a {
			display: block;
			color: white;
			text-align: center;
			padding: 14px 16px;
			text-decoration: none;
		}

		li a:hover {
			background-color: #111;
		}
		h1
		{
			color: black;
			text-align:center;
		}
		body
		{
			width: 760px; /* how wide to make your web page */
			background-color: teal; /* what color to make the background */
			margin: 0 auto;
			padding: 0;
			font:12px/16px Verdana, sans-serif; /* default font */
		}
		div#main
		{
			background-color: white;
			margin: 0;
			padding: 10px;
		}
	</style>
</head>

<body><div id = "main">
	<h1>News Site</h1>
	<ul>
		<li><a class="active" href='guest.php'>Home</a></li>
		<?php
		//Only allows the guest user the option to visit the home page 
		session_start();
		if($_SESSION['guest'] == false)
		{
			?>

			<li><a href='profile.php'>Profile</a></li>
			<li><a href='logout.php'>Logout</a></li>
			<li><a href='createStory.php'>Write Story</a></li>
		</ul>
		<?php

	}
	require 'database.php';

	$stmt = $mysqli->prepare("select story_id, story_link, body, username, title from stories order by story_id");
	if(!$stmt)
	{
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$currentUser = $_SESSION['user_id'];
	//Prints out all of the stories, their author, and gives the option to view the comments 
	$stmt->execute();

	$stmt->bind_result($story_id, $story_link, $body, $username, $title);

	echo "<ul>\n";
	while($stmt->fetch()){
		
			//show story & info
		echo "<a href='$story_link'>$title</a> ";
		echo "Posted by " . $username . "<br>";
		echo $body ."<br>";

			//if user's story, allow edit and delete options
		if($username === $_SESSION['user_id']){
			echo "<a href='editStory.php?story_id=$story_id'>Edit Your Story    </a>" . "<br>";
			echo "<a href='deleteStory.php?story_id=$story_id'>Delete</a>   "."<br>" ;
		}

			//allow anyone viewing comments
		echo "<a href='viewcomments.php?story_id=$story_id'>Comments</a>" . "<br>";
		if($_SESSION['guest'] == false)
		{
  		//allow logged in users to like a story
			echo "<a href='likes.php?username=$currentUser&story_id=$story_id'>Save Story</a> <br><br>";

		}

	}
	echo "</ul>\n";

	$stmt->close();

	?>
</div></body></html>