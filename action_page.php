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
        $hashedPassword = password_hash($psw, PASSWORD_DEFAULT);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

        $query = "INSERT INTO systemmembers (email, username, psw) VALUES(:email, :username, :psw)";

        $statement = $db->prepare($query);

        $statement->bindvalue(':email', $email);
        $statement->bindvalue(':username',$username);
        $statement->bindvalue(':psw', $hashedPassword);
        if($statement->execute()){
            header("Location:login.php");
            exit();
        }

    }
    if ($_POST['psw'] != $_POST['psw-repeat']){
        $error = "Password needs to match.";
        $link = "register.php";
    }
}

if ($_POST['command']=='Login') {
    if (!empty($_POST['username']) && !empty($_POST['psw']) ){

        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $psw = filter_input(INPUT_POST, 'psw', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $query = "SELECT * FROM systemmembers WHERE username = :username LIMIT 1 ";
        $statement = $db->prepare($query);

        $statement->bindvalue(':username',$username);

        $statement->execute();

        $count = $statement->rowCount();
        $row = $statement->fetch();

        $hashed_Password = $row['psw'];

        if(password_verify($psw, $hashed_Password)){
            if($count ==1 && !empty($row)){
                session_start();
                $_SESSION['username'] = $row['username'];
                $_SESSION['role'] = $row['roles'];
                $_SESSION['user_id'] = $row['user_id'];
                header("Location: index.php");
            }
        }else{
            $error = "Password needs to match.";
            $link = "login.php";
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
<h2> <?= $error ?> </h2>
<p>
    <a href='<?= $link ?>'>Try Again</a> 
</p>

    </div>
</body>
</html>