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
			$stmt = $mysqli->prepare("select story_link, stories.username, title from stories where story_id=$story_id");
			if(!$stmt)
			{
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}
			 
			$stmt->execute();
			 
			$stmt->bind_result($story_link, $story_username, $title);
			 
			echo "<ul>\n";
			

			while($stmt->fetch()){
				// printf("\t<li>%s %s</li>\n",
				// 	htmlspecialchars($first),
				// 	htmlspecialchars($last)
				// );
				echo "<a href='$story_link'>$title</a> ";
				echo "Posted by " . $story_username . "<br>";
				

			}
			echo "</ul>\n";
			 
			$stmt->close();



			$stmt = $mysqli->prepare("select comments.content, comments.username from comments where comments.story_id=$story_id");
			if(!$stmt)
			{
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}
			 
			$stmt->execute();
			 
			$stmt->bind_result( $content, $comment_username);
			 
			echo "<ul>\n";
			

			while($stmt->fetch()){
				// printf("\t<li>%s %s</li>\n",
				// 	htmlspecialchars($first),
				// 	htmlspecialchars($last)
				// );
				
				echo "Comment from " . $comment_username ."<br>" . $content ."<br>";
				

			}
			echo "</ul>\n";
			 
			$stmt->close();
			?>
			<form method="POST">
	                        <p>
	                            <label for="comment">Enter your title:</label>
	                            <input type="text" name="comment" id="comment" />
	                        </p>
	                        <p>
	                            <input type="submit" name ="submitComment" id = "submitComment" value="Submit Comment" />
	                        </p>
	                    </form>

	                    <?php
	                    if (isset($_POST['submitComment'])){
	                    session_start();

	                    require "database.php";
	                    $comment = $_POST['comment'];
	                    $username = $_SESSION['user_id'];

	                    $stmt = $mysqli->prepare("insert into comments (story_id, username, content ) values ('$story_id','$username','$comment')");
	                    if(!$stmt){
	                        printf("Query Prep Failed: %s\n", $mysqli->error);
	                        exit;
	                    }
	                    //echo mysql_error();
	                    //$stmt->bind_param('sss', $username, $link, $title);

	                    $stmt->execute();

	                    $stmt->close();
	                }
	                    ?>

			</div></body></html>