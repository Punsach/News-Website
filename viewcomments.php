<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>View Comments</title>
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

	<h1>Comments</h1>
	<ul>
		<li><a class="active" href='guest.php'>Home</a></li>
		<?php
		//Generates all the comments, indicates which comments are yours by allowing you to edit them, and allows you to submit comments if you are the logged in user. 
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
	require 'database.php';
	$story_id = $_GET[story_id];
	$stmt = $mysqli->prepare("select story_link, stories.username, title from stories where story_id=$story_id");
	if(!$stmt)
	{
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	
	$stmt->execute();
	
	$stmt->bind_result($story_link, $story_username, $title);
	
	echo "<ul>\n";
	
//Links to the story 
	while($stmt->fetch()){

		echo "<a href='$story_link'>$title</a> ";
		echo "Posted by " . $story_username . "<br>"."<br>";
		

	}
	echo "</ul>\n";
	
	$stmt->close();
	


	$stmt = $mysqli->prepare("select comments.content, comments.username, comments.comment_id from comments where comments.story_id=$story_id");
	if(!$stmt)
	{
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	
	$stmt->execute();
	
	$stmt->bind_result( $content, $comment_username, $comment_id);
	
	echo "<ul>\n";
	//Allows corresponding user to edit and delete their stuff 

	while($stmt->fetch()){

		
		echo "Comment from " . $comment_username ."<br>" . $content ."<br>"."<br>";
		if ($comment_username==$_SESSION['user_id']){
			//if you're the author, give option to edit comment
			echo "<a href='editComments.php?comment_id=$comment_id'>Edit Your Comment  </a>";
			echo "<a href='deleteComment.php?comment_id=$comment_id'>Delete</a>"."<br>" ;
		}

	}
	echo "</ul>\n";
	
	$stmt->close();
	?>
	<?php
	//Form for comments if you're logged in
	if($_SESSION['guest'] !== true){
		?>
		<form method="POST">
			<p>
				<label for="comment">Comment:</label>
				<input type="text" name="comment" id="comment" />
			</p>
			<input type="hidden" name ="token" value = "<?php echo $_SESSION['token'];?>" />
			<p>
				<input type="submit" name ="submitComment" id = "submitComment" value="Submit Comment" />
			</p>
		</form>

		<?php
		if (isset($_POST['submitComment'])){
			session_start();
			if(!hash_equals($_SESSION['token'], $_POST['token'])){
				die("Request forgery detected");
			}
			require "database.php";
			$comment =  $mysqli->real_escape_string($_POST['comment']);
			$username = $_SESSION['user_id'];

			$stmt = $mysqli->prepare("insert into comments (story_id, username, content) values ('$story_id','$username','$comment')");
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}

			$stmt->execute();

			$stmt->close();
			header("Refresh: 0");
		}
	}
	?>

	

</div></body></html>