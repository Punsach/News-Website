<?php
            require 'database.php';
            $storyID = $_GET['story_id'];

            $stmt = $mysqli->prepare("delete from stories where story_id=$storyID");
            if(!$stmt)
            {
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
             
            $stmt->execute();
            $stmt->close();

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