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

<?php include('nav.php'); ?>


<div id="wrapper" class="individualPost">
  <h1><a href="index.php">RISE - <?= $row['Title']?></a></h1>
    <div>
        <h2><?= $row['Title']?></a></h2>
        <p>
          <small>
            <?php if(isset($_SESSION['username']) && $row['Create_By'] == $_SESSION['username'] || isset($_SESSION['role']) && $_SESSION['role'] == 'admin' ) :?>
              <?= date('F d, Y, g:i a',strtotime($row['Date']))?> - <a href="edit.php?id=<?= $row['Page_id']?>">edit</a>
            <?php else :?>
              <p> <?= date('F d, Y, g:i a',strtotime($row['Date']))?> </p>
            <?php endif ?>
          </small>
        </p>
        <?= $row['content']?>
        <br>
        <img src="uploads/medium/medium_<?= $row['image']?>" alt="<?= $row['image']?>"> 
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

          <?php if(isset($_SESSION['username']) && $commentRow['user_id'] == $_SESSION['user_id'] || isset($_SESSION['role']) && $_SESSION['role'] == 'admin' ) :?>
            <p> <?= date('F d, Y, g:i a',strtotime($commentRow['date']))?> - <a href="commentsEdit.php?id=<?= $commentRow['id']?>">edit</a> </p>
          <?php else :?>
            <p> <?= date('F d, Y, g:i a',strtotime($commentRow['date']))?> </p>
          <?php endif ?> 
        </article>
      <?php endwhile ?>
  </div>
</section>



</body>
</html>
