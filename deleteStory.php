<?php
            require 'database.php';
            $storyID = $_GET['story_id'];
            //Deletes the story from the table
            $stmt = $mysqli->prepare("delete from stories where story_id=$storyID");
            if(!$stmt)
            {
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
             
            $stmt->execute();
            $stmt->close();
            //Deletes the comments corresponding to that story
            $stmt = $mysqli->prepare("delete from comments where story_id=$storyID");
            if(!$stmt)
            {
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
             
            $stmt->execute();
            $stmt->close();
            header("Location: guest.php");
    ?>