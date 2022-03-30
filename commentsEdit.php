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

    $query = "SELECT * FROM comments c
              JOIN post p ON c.page_id = p.Page_id
              JOIN Games g ON p.Game = g.Game
              WHERE c.id = :id LIMIT 1";
    $statement = $db->prepare($query);

    $statement->bindValue('id', $id, PDO::PARAM_INT);
    $statement->execute();

    $row = $statement->fetch();

    $userId = $row['user_id'];
    $userQuery = "SELECT username FROM systemmembers WHERE user_id = '$userId'";
    $userStatement = $db->prepare($userQuery);
    $userStatement->execute();
    $userRow = $userStatement->fetch();

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
  
  <?php include('nav.php'); ?>

<div id="wrapper">
    <h1 class="newPosth1"><a href="index.php">RISE - Edit Comment</a></h1>
  <div>
    <form action="complete_post.php" method="post">
      <fieldset>
        <div class="titleAndGame">
            <label for="title">Comment By:</label>
            <label class="commentBy"><?= $userRow['username']?></label>
            <label for="title">Game:</label>
            <label class="commentBy"><?= $row['Game']?></label>
        </div>

        <div class="createContent">
            <label for="content">Content</label>
            <textarea name="content" id="content"><?= $row['Content'] ?></textarea>
          <p>
          <input type="hidden" name="id" value=<?=$id?> />
                <input type="submit" name="EditCommand" value="Update" />
                <input type="submit" name="EditCommand" value="Delete" onclick="return confirm('Are you sure you wish to delete this post?')" />
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
