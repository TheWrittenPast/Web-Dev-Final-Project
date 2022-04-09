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

    $query = "SELECT * FROM systemmembers WHERE user_id = :id LIMIT 1";
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
    <h1 class="newPosth1"><a href="index.php">RISE - New Post</a></h1>
  <div>
    <form action="complete_post.php" method="post">
      <fieldset>
        <div class="users">
            <label for="email">Email</label>
            <input name="email" id="email" value= '<?= $row['email']?>' />
            <label for="username">Username</label>
            <input name="username" id="username" value= '<?= $row['username']?>' />
            <select name="roles" >
              <option value="<?= $row['roles']?>"><?= $row['roles'] ?>
              <?php if($row['roles'] == 'admin' ) :?>
                <option value="user">User</option>
              <?php else :?>
                <option value="admin">Admin</option>
              <?php endif ?>
            </select>
        </div>
      <p>
        <input type="hidden" name="id" value=<?= $row['user_id']?> />
        <input type="submit" name="command" value="Update User" />
        <input type="submit" name="command" value="Delete User" onclick="return confirm('Are you sure you wish to delete this post?')" />
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
