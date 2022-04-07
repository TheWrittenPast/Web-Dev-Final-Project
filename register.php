<?php 
/*               
 *      Name: John Russel Tabelina
 *      Date: March 21, 2022
 *      Description: Registration page
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
    <title>Register</title>
</head>
<body>

    <?php include('nav.php'); ?>

<div id="wrapper">
    <form action="action_page.php" method="post">
        <div class="container">

            <h1>Register</h1>
            <p>Please fill in this form to create an account.</p>

            <label for="email"><b>Email</b></label>
            <input type="email" placeholder="Enter Email" name="email" id="email" required>

            <label for="username"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="username" id="username" required>

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="psw" id="psw" required>

            <label for="psw-repeat"><b>Repeat Password</b></label>
            <input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" required>

            <p>
                <input class="registerbtn" type="submit" name="command" value="Register" />
            </p>
        </div>

        <div class="container signin">
            <p>Already have an account? <a href="login.php">Sign in</a></p>
        </div>
    </form> 
    <div id="footer">
        Copyright 2022 - RISE
    </div> 
</div>

</body>
</html>