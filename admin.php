<?php 
/*               
 *      Name: John Russel Tabelina
 *      Date: March 21, 2022
 *      Description: select
 */

require('connect.php');
session_start();

$queryMembers = "SELECT * FROM systemmembers ORDER BY user_id DESC";
$memberStatement = $db->prepare($queryMembers);
$memberStatement->execute();


$gameQuery = "SELECT * FROM games ORDER BY id DESC";
$gameStatements = $db->prepare($gameQuery);
$gameStatements->execute(); 

$postQuery = "SELECT * FROM post ORDER BY Page_id DESC";
$postStatement = $db->prepare($postQuery);
$postStatement->execute(); 

$commentQuery = "SELECT * FROM comments ORDER BY id DESC";
$commentStatement = $db->prepare($commentQuery);
$commentStatement->execute(); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css" />
    <title>Administrative View</title>
</head>
<body>

<header>
    <?php include('nav.php'); ?>
    <h1 class="homePage">Welcome To Administrative View <i><?=$_SESSION['username']?></i> </h1>
</header>
    
<section id="posts">

<div class="adminHeaders">
    <h1>System Members</h1>
</div>

<div class="article_members">
        <?php while($row = $memberStatement->fetch()) :?>
            <article>
                <h1>ID: <?= $row['user_id']?></h1>
                <p>Email: <?= $row['email']?> </p>
                <p>Username: <?= $row['username']?> </p>
                <p>Role: <?= $row['roles']?> </p>
                <p><a href="editUsers.php?id=<?= $row['user_id']?>">Edit</a></p>
            </article>
        <?php endwhile ?>
    </div>

<div class="adminHeaders">
    <h1>Categories / Games</h1>
</div>

    <div class="article_games">
        <?php while($row = $gameStatements->fetch()) :?>
            <article>
                <h1>ID: <?= $row['id']?></h1>
                <p>Game: <?= $row['Game']?> </p>
                <p><a href="editCategory.php?id=<?= $row['id']?>">Edit</a></p>
            </article>
        <?php endwhile ?>
            <article class="newGame">
                <h1>New Game Category</h1>
                <form action="complete_post.php" method="post">
                    <input name="game">
                    <input type="submit" name="command" value="Add Game" />
                </form>
            </article>
    </div>

<div class="adminHeaders">
    <h1>Posts</h1>
</div>

    <div class="article_post">
        <?php while($row = $postStatement->fetch()) :?>
            <article>
                <h1>ID: <?= $row['Page_id']?></h1>
                <p>Title: <?= $row['Title']?> </p>
                <p>Content: <?= substr($row['content'], 0, 20) ?>...</p>
                <p>Date: <?= $row['Date']?> </p>
                <p>Create_By: <?= $row['Create_By']?> </p>
                <p>Game: <?= $row['Game']?> </p>
                <?php if(!empty($row['image']) ) :?>
                    <p>Image: </p>
                    <img src="uploads/thumbnail/thumbnail_<?= $row['image']?>" alt="">
                <?php else :?>
                    <p>Image: No Image </p>
                <?php endif ?>
                <p><a href="edit.php?id=<?= $row['Page_id']?>">edit</a></p>
            </article>
        <?php endwhile ?>
    </div>

<div class="adminHeaders">
    <h1>Comments</h1>
</div>

    <div class="article_comment">
    <?php while($row = $commentStatement->fetch()) :?>
            <article>
                <h1>ID: <?= $row['id']?></h1>
                <p>Content: <?= $row['Content']?> </p>
                <p>User_Id: <?= $row['user_id']?> </p>
                <p>Date: <?= $row['date']?> </p>
                <p>Page_Id: <?= $row['page_id']?> </p>
                <p><a href="commentsEdit.php?id=<?= $row['id']?>">edit</a></p>
            </article>
        <?php endwhile ?>
    </div>

</section>

</body>
</html>