            <!DOCTYPE html>
            <html>
            <head>
             <meta charset="utf-8"/>
             <title>File Sharing Site Login</title>
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
                    <h1>LOGIN</h1>
                    <form method="POST">
                        <p>
                            <label for="content">Edit comment to:</label>
                            <input type="text" name="content" id="content" />
                        </p>
                        <p>
                            <input type="submit" name ="submitComment" id = "submitComment" value="Edit Comment" />
                        </p>
                    </form>

                    <?php
                    if (isset($_POST['submitComment'])){
                    session_start();

                    require "database.php";
                    $content = $_POST['content'];
                    $username = $_SESSION['user_id'];
                   

                    $stmt = $mysqli->prepare("update comments SET content=$content WHERE comment_id=$_GET['comment_id']");
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
                    </div>
                </body>
            </html>
