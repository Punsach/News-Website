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
                    background-color: green;
                    border: 10px solid black;
                    border-style: double;
                }
            </style>
            </head>
            <body>
                <div class = "box">
                    <h1>LOGIN</h1>
                    <form method="POST">
                        <p>
                            <label for="title">Enter your title:</label>
                            <input type="text" name="title" id="title" />
                        </p>
                        <p> 
                            <label for="link">Enter your link (Please include full link, including "https://":</label>
                            <input type="text" name="link" id="link"/>
                        </p>
                        <p>
                            <input type="submit" name ="submitStory" id = "submitStory" value="Submit Story" />
                        </p>
                    </form>

                    <?php
                    if (isset($_POST['submitStory'])){
                    session_start();

                    require "database.php";
                    $link = $_POST['link'];
                    $title = $_POST['title'];
                    $username = $_SESSION['user_id'];
                    echo $username . $link . $title;

                    $stmt = $mysqli->prepare("insert into stories (username,story_link,title ) values ('$username', '$link','$title')");
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
