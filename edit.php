<?php 
/*               
 *      Name: John Russel Tabelina
 *      Date: March 21, 2022
 *      Description: Shows the edit page of the post.
 */

require('connect.php');
session_start();
if($_GET && is_numeric($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT * FROM post WHERE Page_id = :id LIMIT 1";
    $statement = $db->prepare($query);

    $statement->bindValue('id', $id, PDO::PARAM_INT);
    $statement->execute();

    $row = $statement->fetch();
} else {
    $row = false;
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="styles.css" />
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
            <input name="title" id="title" value= '<?= $row['Title']?>' />
            <label for="game">Game</label>
            <input name="game" id="game" value= '<?= $row['Game']?>' />
        </div>

        <div class="createContent">
            <label for="content">Content</label>
            <textarea name="content" id="content"><?= $row['content'] ?></textarea>
          <p>
          <input type="hidden" name="id" value=<?= $row['Page_id']?> />
                <input type="submit" name="command" value="Update" />
                <input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this post?')" />
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
