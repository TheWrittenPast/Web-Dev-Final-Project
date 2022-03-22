<?php 
/*               
 *      Name: John Russel Tabelina
 *      Date: February 11, 2022
 *      Description: Shows the entire page of the post.
 */

require('connect.php');
if ($_GET && is_numeric($_GET['id'])) {

  $query = "SELECT * FROM post WHERE Page_id = :id LIMIT 1";
  $statement = $db->prepare($query);

  $id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
  
  $statement->bindValue('id', $id, PDO::PARAM_INT);
  $statement->execute(); 

  $row = $statement->fetch();
} else {
  header("location:index.php");
  exit();
}


?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Stung Eye - Nut Wootly Grins</title>
    <link rel="stylesheet" href="styles.css" type="text/css">
</head>
<body>
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php">The Past Is Written - <?= $row['Title']?></a></h1>
        </div> <!-- END div id="header" -->
<ul id="menu">
    <li><a href="index.php" >Home</a></li>
    <li><a href="create.php" >New Post</a></li>
</ul> <!-- END div id="menu" -->
  <div id="all_blogs">
    <div class="blog_post">
      <h2><?= $row['Title']?></a></h2>
      <p>
        <small>

        <?= date('F d, Y, g:i a',strtotime($row['Date']))?> -
        <a href="edit.php?id=<?= $row['Page_id']?>">edit</a>
        </small>
      </p>
      <div class='blog_content'>
      <?= $row['content']?>    
    </div>
    </div>
  </div>
        <div id="footer">
            Copywrong 2022 - No Rights Reserved
        </div> <!-- END div id="footer" -->
    </div> <!-- END div id="wrapper" -->
</body>
</html>
