            <!DOCTYPE html>
            <html>
            <head>
               <meta charset="utf-8"/>
               <title>Add Article</title>
               <style type="text/css">
                h1{
                    color: black;
                    text-align:center;
                }
                div.box
                {
                    width: 600px;
                    margin: 0 auto;
                    padding: 25px;
                    background-color: teal;
                    border: 10px solid black;
                    border-style: double;
                }
            </style>
        </head>
        <body>
            <div class = "box">
                <h1>Edit Story</h1>
                    <?php
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
                        $newBody = $_POST['story'];


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
