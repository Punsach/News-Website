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
                <label for="user">Enter your username:</label>
                <input type="text" name="user" id="user" />
            </p>
            <p> 
                <label for="pass">Enter your password:</label>
                <input type="password" name="pass" id="pass"/>
            </p>
            <p>
                <input type="submit" name ="loginButton" id = "loginButton" value="Login" />
            </p>
            <p>
            <input type="submit" name ="guest" id = "guest" value = "Continue as Guest"/>
            </p>
        </form>

        <form method="post" action = "newaccount.php"> 
        <p>
            <input type="submit" name ="newacc" id = "newacc" value="Make Account" />
            </p>
        </form>

        <?php 
         session_start();
        session_unset();
        $_SESSION['guest'] = true; 
        require 'database.php';
        if(isset($_POST['guest']))
        {
            $_SESSION['guest'] = true; 
            header("Location: guest.php");
        }


        if(isset($_POST['loginButton']))
        {

            $user = "";
// Use a prepared statement

            $stmt = $mysqli->prepare("SELECT COUNT(*), username, password FROM users WHERE username=?");

// Bind the parameter
            $user = htmlentities($_POST['user']);
            
            $stmt->bind_param('s', $user);
            echo "WE DID SOMETHING";
            $stmt->execute();

// Bind the results
            $stmt->bind_result($cnt, $username, $pwd_hash);
            $stmt->fetch();

            $pwd_guess = htmlentities($_POST['pass']);
            
            if( password_verify($pwd_guess, $pwd_hash))
            {        
                $_SESSION['user_id'] = $username;
                $_SESSION['guest'] = false; 
                header("Location: guest.php");
            } 
            else
            {   
                header("Location: login.php");
                
            }
        }
        ?>
    </div>
</body>
</html>
