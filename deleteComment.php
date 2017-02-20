<?php
            require 'database.php';
            $commentID = $_GET['comment_id'];

            $stmt = $mysqli->prepare("delete from comments where comments.comment_id=$commentID");
            if(!$stmt)
            {
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
             
            $stmt->execute();
            $stmt->close();
            header("Location: guest.php");
?>