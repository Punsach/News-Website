<!DOCTYPE html>
		<html>
		    <head>
		        <meta charset="utf-8"/>
		        <title>View Comments</title>
		        <style type="text/css">
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
		                background-color: #FFF;
		                margin: 0;
		                padding: 10px;
		            }
		        </style>
		    </head>
		    
		    <body><div id = "main">
		    <h1>Comments</h1>
		    <?php
		    require 'database.php';
		$story_id = $_GET[story_id];
		$stmt = $mysqli->prepare("select story_link, username, title from stories where story_id=$story_id");
		if(!$stmt)
		{
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
		 
		$stmt->execute();
		 
		$stmt->bind_result($story_link, $username, $title);
		 
		echo "<ul>\n";
		while($stmt->fetch()){
			// printf("\t<li>%s %s</li>\n",
			// 	htmlspecialchars($first),
			// 	htmlspecialchars($last)
			// );
			echo "<a href='$story_link'>$title</a> ";
			echo "Posted by " . $username;
		}
		echo "</ul>\n";
		 
		$stmt->close();

		?>