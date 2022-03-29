<?php 
/*               
 *      Name: John Russel Tabelina
 *      Date: March 23, 2022
 *      Description: Login page
 */
require('connect.php');




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css" />
    <title>Login</title>
</head>
<body>
    <div id="wrapper">
        <form action="action_page.php" method="post">
            <div class="container">
                <h1>Login</h1>

                <label for="username"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="username" id="username" required>

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="psw" id="psw" required>

                <p>
                    <input class="registerbtn" type="submit" name="command" value="Login" />
                </p>
            </div>

            <div class="container signin">
                <p>Don't have an account? <a href="register.php">Register</a></p>
            </div>
        </form> 
    </div>
</body>
</html>