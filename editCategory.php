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

    $query = "SELECT * FROM games WHERE id = :id LIMIT 1";
    $statement = $db->prepare($query);

    $statement->bindValue('id', $id, PDO::PARAM_INT);
    $statement->execute();

    $row = $statement->fetch();
} else {
    $row = false;
}

$_SESSION['user_id'] = $_GET['id'];

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
    <h1 class="newPosth1"><a href="index.php">RISE - Edit Category/Game</a></h1>
  <div>
    <form action="complete_post.php" method="post">
      <fieldset>
        <div class="users">
            <label for="game">Game</label>
            <input name="game" id="game" value= '<?= $row['Game']?>' />
        </div>
      <p>
        <input type="hidden" name="id" value=<?= $row['id']?> />
        <input type="submit" name="command" value="Update Game" />
        <input type="submit" name="command" value="Delete Game" onclick="return confirm('Are you sure you wish to delete this post?')" />
      </p>
      </fieldset>
    </form>
  </div>
  <div id="footer">
      Copyright 2022 - RISE
  </div>
</div>




</body>
</html>
