            <!DOCTYPE html>
            <html>
            <head>
             <meta charset="utf-8"/>
             <title>Edit Comment</title>
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
                    border: 10px dotted black;
                    border-style: double;
                }
            </style>
            </head>
            <body>
                <div class = "box">
                    <h1>Edit Comment</h1>
                    <?php
                    require 'database.php';
                    $comment_id = $_GET['comment_id'];
                   
                    
                    $stmt = $mysqli->prepare("select content from comments WHERE comment_id=$comment_id");

                    if(!$stmt){
                        printf("Query Prep Failed: %s\n", $mysqli->error);
                        exit;
                    }

                    ?>
                    


                   <!--  <form method="POST">
                        <p>
                            <label for="content">Edit comment to:</label>
                            <input type="text" name="content" id="content" />
                        </p>
                        <p>
                            <input type="submit" name ="submitComment" id = "submitComment" value="Edit Comment" />
                        </p>
                    </form> -->

                    <?php
                    if (isset($_POST['submitComment'])){
                   

                    require "database.php";
                    $content = $_POST['content'];
                    $username = $_SESSION['user_id'];
                   

                    $stmt = $mysqli->prepare("update comments SET content=$content WHERE comment_id=$_GET['comment_id']");
                    if(!$stmt){
                        printf("Query Prep Failed: %s\n", $mysqli->error);
                        exit;
                    }
                    
                    $stmt->execute();
             
                    $stmt->bind_result( $content);

                    while($stmt->fetch()){
                        echo "Edit comment:" . "<br>";
                        echo $content;
                    }

                    $stmt->close();
                }
                    ?>
                    </div>
                </body>
            </html>
