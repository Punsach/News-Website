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
                <label for="user">Enter your username:</label>
                <input type="text" name="user" id="user" />
            </p>
            <p> 
                <label for="password">Enter your password:</label>
                <input type="password" name="pass" id="pass"/>
            </p>
            <p>
                <input type="submit" name ="loginButton" id = "loginButton" value="Login" />
            </p>
        </form>

        <form method="post" action = "newaccount.php"> 
        <p>
            <input type="submit" name ="newacc" id = "newacc" value="Make Account" />
            </p>
            <p>
            <input type="submit" name ="guest" id = "guest" value = "Continue as Guest"/>
            </p>
        </form>

        <?php
// This is a *good* example of how you can implement password-based user authentication in your web application.

        require 'database.php';
        if(isset($_POST['guest']))
        {
            header("Location: guest.php");
        }


        if(isset($_POST['loginButton'])){
            session_start();
            session_unset();
// Use a prepared statement
            $stmt = $mysqli->prepare("SELECT COUNT(*), id, crypted_password FROM users WHERE username=?");

// Bind the parameter
            $stmt->bind_param('s', $user);
            $user = $_POST['user'];
            $stmt->execute();

// Bind the results
            $stmt->bind_result($cnt, $user_id, $pwd_hash);
            $stmt->fetch();

            $pwd_guess = $_POST['pass'];
// Compare the submitted password to the actual password hash
// In PHP < 5.5, use the insecure: if( $cnt == 1 && crypt($pwd_guess, $pwd_hash)==$pwd_hash){

            if($cnt == 1 && password_verify($pwd_guess, $pwd_hash)){
    // Login succeeded!
                $_SESSION['user_id'] = $user_id;
    // Redirect to your target page
                header("Location: userNews.php");
            } else{
    // Login failed; redirect back to the login screen
            }
        }
        ?>
    </div>
</body>
</html>


