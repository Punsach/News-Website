            <!DOCTYPE html>
            <html>
            <head>
               <meta charset="utf-8"/>
               <title>Add Article</title>
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
        <body>
            <div class = "box">
                <h1>Edit Story</h1>
                <ul>
        <li><a class="active" href='guest.php'>Home</a></li>
        <?php
        session_start();
        if($_SESSION['guest'] == false)
        {
            ?>
            
            <li><a href='profile.php'>Profile</a></li>
            <li><a href='logout.php'>Logout</a></li>
            <li><a href='createStory.php'>Write Story</a></li>
        </ul>
                    <?php }
                    require 'database.php';
                $story_id = $_GET[story_id];
                $stmt = $mysqli->prepare("select body from stories where story_id=$story_id");
                if(!$stmt)
                {
                    printf("Query Prep Failed: %s\n", $mysqli->error);
                    exit;
                }
                 
                $stmt->execute();
                 
                $stmt->bind_result($body);
                 
                echo "<ul>\n";

                while($stmt->fetch()){
                    
                    echo $body;    
                    $currentBody = $body;

                }
                echo "</ul>\n";
                 
                $stmt->close();
                //^That stuff all works, noli tangere
                ?>
                <form method="POST">
                            <p>
                                <label for="story">Story:</label>
                                <input type="text" name="story" id="story" />
                            </p>
                            <p>
                                <input type="submit" name ="submitStory" id = "submitStory" value="Edit Story" />
                            </p>
                        </form>

                        <?php
                         if (isset($_POST['submitStory'])){
                        // session_start();
                        $newBody = $mysqli->real_escape_string($_POST['story']);


                        $stmt = $mysqli->prepare("UPDATE stories SET body='$newBody' where story_id=$story_id");
                        if(!$stmt){
                            printf("Query Prep Failed: %s\n", $mysqli->error);
                            exit;
                        }

                        $stmt->execute();

                        $stmt->close();
                        header("Location: guest.php");
                        }           

               
                ?>
            </div>
        </body>
        </html>
