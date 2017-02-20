<?php 
//Fills the likes table with the saved articles for a user and their username. 
	$currentUser = $_GET['username'];
	$storyID = $_GET['story_id'];
require "database.php";
	$stmt = $mysqli->prepare("insert into likes (username,story_id) values ('$currentUser', '$storyID')");
	if(!$stmt)
	{
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt->execute();

	$stmt->close();
	header("Location: guest.php");

?>