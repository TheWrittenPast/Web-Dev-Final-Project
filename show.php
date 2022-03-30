<?php 
/*               
 *      Name: John Russel Tabelina
 *      Date: March 21, 2022
 *      Description: Shows the entire page of the post as well as the posts.
 */

require('connect.php');
session_start();

$_SESSION['page_id'] = $_GET['id'];


if (is_numeric($_GET['id'])) {
  $query = "SELECT * FROM post WHERE Page_id = :id LIMIT 1";

  $statement = $db->prepare($query);
  $id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
  
  $statement->bindValue('id', $id, PDO::PARAM_INT);
  $statement->execute(); 

  $row = $statement->fetch();

  $commentQuery = "SELECT * FROM comments c JOIN post p ON c.page_id = p.Page_id WHERE p.Page_id = :page_id ORDER BY c.date DESC";
  $commentStatement = $db->prepare($commentQuery);
  $commentStatement->bindValue(':page_id', $id);
  $commentStatement->execute();

} else {
  header("location:index.php");
  exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $row['Title']?></title>
    <link rel="stylesheet" href="styles.css" type="text/css">
</head>
<body>

<nav>
        <?php if(isset($_SESSION['username']) && $_SESSION['role'] == 'admin' ) :?>
            <li><a href="index.php" class='active'>Home</a></li>
            <li><a href="create.php" >New Post</a></li>
            <li><a href="#" >Admin</a></li>
            <input type="submit" name="command" value="Search" />
            <form action="action_page.php" method="post">
                <input type="submit" name="command" value="Log off" />
            </form>
        <?php elseif(isset($_SESSION['username']) && $_SESSION['role'] == 'user')  : ?>
            <li><a href="index.php" class='active'>Home</a></li>
            <li><a href="create.php" >New Post</a></li>
            <input type="submit" name="command" value="Search" />
            <form action="action_page.php" method="post">
                <input type="submit" name="command" value="Log off" />
            </form>
        <?php else: ?>
            <li><a href="index.php" class='active'>Home</a></li>
            <button><a href="login.php">Log-in</a> </button>
            <button><a href="register.php">Register</a> </button>
        <?php endif ?>
    </nav>


<div id="wrapper" class="individualPost">
  <h1><a href="index.php">RISE - <?= $row['Title']?></a></h1>
    <div>
        <h2><?= $row['Title']?></a></h2>
        <p>
          <small>
            <?= date('F d, Y, g:i a',strtotime($row['Date']))?> -
            <a href="edit.php?id=<?= $row['Page_id']?>">edit</a>
          </small>
        </p>
        <?= $row['content']?>    
    </div>
  <div id="footer">
    Copyright 2022 - RISE
  </div>
</div>

<section class="comments">
  <h1>Comments</h1>

  <?php if(isset($_SESSION['username'])):?>
    <div class="commentInput">
      <form action="complete_post.php" method="post">
        <input name="comment" type="text">
        <input type="submit" name="command" value="Comment" />
      </form>
    </div>
  <?php endif ?>
 

  <div class="article">
      <?php while($commentRow = $commentStatement->fetch()) :?>
        <?php
          $userid = $commentRow['user_id'];
          $usernameQuery = "SELECT username FROM systemmembers WHERE user_id = $userid";
          $usernameStatement = $db->prepare($usernameQuery);
          $usernameStatement->execute();
          $usernameRow = $usernameStatement->fetch();
        ?>
        <article>
          <h2><?= $usernameRow['username'] ?></a></h2>
          <p><?= $commentRow['Content'] ?></a></p>
          <p> <?= date('F d, Y, g:i a',strtotime($commentRow['date']))?> - <a href="commentsEdit.php?id=<?= $commentRow['id']?>">edit</a> </p>
        </article>
      <?php endwhile ?>
  </div>
</section>



</body>
</html>
