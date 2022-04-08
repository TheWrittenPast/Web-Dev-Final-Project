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

<?php include('nav.php'); ?>

<div id="wrapper">
    <h1 class="newPosth1"><a href="index.php">RISE - New Post</a></h1>
  <div>
    <form action="complete_post.php" method="post" enctype='multipart/form-data'>
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
            <input type="file" name="image" value="Upload Image" />
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