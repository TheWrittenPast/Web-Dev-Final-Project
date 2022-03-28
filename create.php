<?php 
/*               
 *      Name: John Russel Tabelina
 *      Date: March 21, 2022
 *      Description: Shows the Create page of the post.
 */
require('connect.php');

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Post</title>
    <link rel="stylesheet" href="styles.css" type="text/css">
</head>
<body>
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php">RISE - New Post</a></h1>
        </div> <!-- END div id="header" -->
<ul id="menu">
    <li><a href="index.php" >Home</a></li>
    <li><a href="create.php" class='active'>New Post</a></li>
</ul> <!-- END div id="menu" -->
<div id="all_blogs">
  <form action="complete_post.php" method="post">
    <fieldset>
      <legend>New Post</legend>
      <p>
        <label for="title">Title</label>
        <input name="title" id="title" />
      </p>
      <p>
        <label for="game">Game</label>
        <input name="game" id="game" />
      </p>
      <p>
        <label for="content">Content</label>
        <textarea name="content" id="content"></textarea>
      </p>
      <p>
        <input type="submit" name="command" value="Create" />
      </p>
    </fieldset>
  </form>
</div>
        <div id="footer">
            Copywrong 2022 - No Rights Reserved
        </div> <!-- END div id="footer" -->
    </div> <!-- END div id="wrapper" -->
</body>
</html>