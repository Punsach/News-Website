
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
                    <h1>Edit Comment</h1>
                    <?php
                    require 'database.php';
                $comment_id = $_GET[comment_id];
                $stmt = $mysqli->prepare("select content from comments where comment_id=$comment_id");
                if(!$stmt)
                {
                    printf("Query Prep Failed: %s\n", $mysqli->error);
                    exit;
                }
                 
                $stmt->execute();
                 
                $stmt->bind_result($content);
                 
                echo "<ul>\n";

                while($stmt->fetch()){
                    
                    echo $content;    
                    $currentComment = $content;

                }
                echo "</ul>\n";
                 
                $stmt->close();
                //^That stuff all works, noli tangere
                ?>
                <form method="POST">
                            <p>
                                <label for="comment">Comment:</label>
                                <input type="text" name="comment" id="comment" />
                            </p>
                            <p>
                                <input type="submit" name ="submitComment" id = "submitComment" value="Edit Comment" />
                            </p>
                        </form>

                        <?php
                         if (isset($_POST['submitComment'])){
                        // session_start();
                        $newComment = $_POST['comment'];


                        $stmt = $mysqli->prepare("UPDATE comments SET content='$newComment' where comment_id=$comment_id");
                        if(!$stmt){
                            printf("Query Prep Failed: %s\n", $mysqli->error);
                            exit;
                        }

                        $stmt->execute();

                        $stmt->close();
                        header("Location: guest.php");
                        }           

               
                ?>
                             

                </div></body></html>
