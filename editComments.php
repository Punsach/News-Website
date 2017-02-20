
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>View Comments</title>
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

<body><div id = "main">
    <h1>Edit Comment</h1>
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
        <?php
        //Allows the user to edit the comment, assuming it is their own comment 
    }
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
        $currentComment = $mysqli->real_escape_string($content);

    }
    echo "</ul>\n";

    $stmt->close();

    ?>
    <form method="POST">
        <p>
            <label for="comment">Comment:</label>
            <input type="text" name="comment" id="comment" />
        </p>
        <input type="hidden" name ="token" value = "<?php echo $_SESSION['token'];?>" />
        <p>
            <input type="submit" name ="submitComment" id = "submitComment" value="Edit Comment" />
        </p>
    </form>

    <?php
    if (isset($_POST['submitComment'])){
       if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Request forgery detected");
    }
    $newComment = $_POST['comment'];

    //Updates the table with the new comment 
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
