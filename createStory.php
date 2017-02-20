            <!DOCTYPE html>
            <html>
            <head>
               <meta charset="utf-8"/>
               <title>Write a story</title>
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
                <h1>Write Story</h1>
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
                       <?php } ?>
                    </ul>
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
                            <label for="body">Write your story:</label>
                            <input type="text" name="body" id="body"/>
                        </p>
                        <p>
                            <input type="submit" name ="submitStory" id = "submitStory" value="Submit Story" />
                        </p>
                    </form>

                    <?php
                    if (isset($_POST['submitStory'])){

                        require "database.php";
                        $link = $_POST['link'];
                        $title = $mysqli->real_escape_string($_POST['title']);
                        $body = $mysqli->real_escape_string($_POST['body']);
                        $username = $_SESSION['user_id'];
                       // echo $username . $link . $title;

                        $stmt = $mysqli->prepare("insert into stories (username, story_link, body,title ) values ('$username', '$link','$body', '$title')");
                        if(!$stmt){
                            printf("Query Prep Failed: %s\n", $mysqli->error);
                            exit;
                        }
                    

                        $stmt->execute();

                        $stmt->close();
                        header ("Location:guest.php");
                    }
                    ?>
                </div>
            </body>
            </html>
