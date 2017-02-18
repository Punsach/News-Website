		<!DOCTYPE html>
		<html>
		    <head>
		        <meta charset="utf-8"/>
		        <title>User Info Page</title>
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
		    <h1>News Site</h1>
		    <?php
		    require 'database.php';
		 
		$stmt = $mysqli->prepare("select story_link, user_id, title from stories order by story_id");
		if(!$stmt)
		{
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
		 
		$stmt->execute();
		 
		$stmt->bind_result($story_link, $user_id, $title);
		 
		echo "<ul>\n";
		while($stmt->fetch()){
			// printf("\t<li>%s %s</li>\n",
			// 	htmlspecialchars($first),
			// 	htmlspecialchars($last)
			// );
			echo "<a href='$story_link'>$title</a> ";
			echo "Posted by " . $user_id;
		}
		echo "</ul>\n";
		 
		$stmt->close();

		?>