<?php
/*               
 *      Name: John Russel Tabelina
 *      Date: March 21, 2022
 *      Description: Completes the action of registering, logging in, and logging off.
 */

require('connect.php');

if ($_POST['command']=='Register') {
    if (!empty($_POST['email']) && !empty($_POST['username']) 
                && !empty($_POST['psw']) && !empty($_POST['psw-repeat']) && $_POST['psw'] == $_POST['psw-repeat'] ){
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $psw = filter_input(INPUT_POST, 'psw', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

        $query = "INSERT INTO systemmembers (email, username, psw) VALUES(:email, :username, :psw)";

        $statement = $db->prepare($query);

        $statement->bindvalue(':email', $email);
        $statement->bindvalue(':username',$username);
        $statement->bindvalue(':psw', $psw);

        if($statement->execute()){
            header("Location:login.php");
            exit();
        }
    }
}

if ($_POST['command']=='Login') {
    if (!empty($_POST['username']) && !empty($_POST['psw']) ){

        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $psw = filter_input(INPUT_POST, 'psw', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $query = "SELECT * FROM systemmembers WHERE username = :username AND psw = :psw LIMIT 1 ";
        $statement = $db->prepare($query);

        $statement->bindvalue(':username',$username);
        $statement->bindvalue(':psw', $psw);

        $statement->execute();

        $count = $statement->rowCount();
        $row = $statement->fetch();

        if($count ==1 && !empty($row)){
            session_start();
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['roles'];
            $_SESSION['user_id'] = $row['user_id'];
            header("Location: index.php");
        }
    }    
}

if ($_POST['command']== 'Log off'){    
    session_start();
    // Unset all of the session variables
    $_SESSION = array();
    session_destroy();
    
    header("Location: index.php");
    exit;
}



?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title> Whoops</title>
    <link rel="stylesheet" href="styles.css" type="text/css">
</head>
<body>
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php"></a></h1>
        </div>

<h1>An error occured while processing.</h1>
<a href="index.php">Return Home</a>
        <div id="footer">
            Copyright 2022 - RISE
        </div> 
    </div>
</body>
</html>