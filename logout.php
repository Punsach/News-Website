<?php
    //Redirects user to login page if they logout
   
        session_unset();
        session_destroy();
        header("Location: login.php");
    
?>