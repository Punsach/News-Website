<?php
//Script to delete the comment if the user chooses to do so by removing it from the table
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