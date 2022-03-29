<?php 
/*               
 *      Name: John Russel Tabelina
 *      Date: March 21, 2022
 *      Description: Shows the Create page of the post.
 */
require('connect.php');
session_start();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Post</title>
    <link rel="stylesheet" href="styles.css" type="text/css">
</head>
<body>

<nav>
  <?php if(isset($_SESSION['username']) && $_SESSION['role'] == 'admin' ) :?>
      <li><a href="index.php" class='active'>Home</a></li>
      <li><a href="create.php" >New Post</a></li>
      <li><a href="#" >Admin</a></li>
      <input type="submit" name="command" value="Log off" />
  <?php elseif(isset($_SESSION['username']) && $_SESSION['role'] == 'user')  : ?>
      <li><a href="index.php" class='active'>Home</a></li>
      <li><a href="create.php" >New Post</a></li>
      <input type="submit" name="command" value="Log off" />
  <?php else: ?>
      <li><a href="index.php" class='active'>Home</a></li>
      <button><a href="login.php">Log-in</a> </button>
      <button><a href="register.php">Register</a> </button>
  <?php endif ?>
</nav>

<div id="wrapper">
    <h1 class="newPosth1"><a href="index.php">RISE - New Post</a></h1>
  <div>
    <form action="complete_post.php" method="post">
      <fieldset>
        <div class="titleAndGame">
            <label for="title">Title</label>
            <input name="title" id="title" />
            <label for="game">Game</label>
            <input name="game" id="game" />
        </div>

        <div class="createContent">
            <label for="content">Content</label>
            <textarea name="content" id="content"></textarea>
          <p>
            <input type="submit" name="command" value="Create" />
          </p>
        </div>
      </fieldset>
    </form>
  </div>
  <div id="footer">
      Copyright 2022 - RISE
  </div>
</div>

</body>
</html>