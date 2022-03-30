<?php 
/*               
 *      Name: John Russel Tabelina
 *      Date: March 21, 2022
 *      Description: Home page
 */
require('connect.php');
session_start();
// SQL is written as a String.
$query = "SELECT * FROM post ORDER BY date DESC";
$gameSet = "SELECT * FROM games";

// A PDO::Statement is prepared from the query.
$statement = $db->prepare($query);
$gameStatement = $db->prepare($gameSet);

// Execution on the DB server is delayed until we execute().
$statement->execute(); 
$gameStatement->execute(); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css" />
    <title>RISE</title>
</head>
<body>

<header>
    <?php include('nav.php'); ?>

    <h1 class="homePage"><a href="index.php">RISE - Home</a></h1>

</header>

<section id="posts">

    <?php if($statement->rowCount() > 0) :?>
            <div class="article">
                <?php while($row = $statement->fetch()) :?>
                    <article>
                        <h2> <a href="show.php?id=<?= $row['Page_id']?>"> <?= $row['Title'] ?> </a> </h2>
                        <p>
                            <small>
                                Created By: <?= $row['Create_By']?>
                            </small>
                        </p>
                        <?php if(isset($_SESSION['username']) && $row['Create_By'] == $_SESSION['username'] || isset($_SESSION['role']) && $_SESSION['role'] == 'admin' ) :?>
                            <p> <?= date('F d, Y, g:i a',strtotime($row['Date']))  ?> - <a href="edit.php?id=<?= $row['Page_id']?>">edit</a></p>
                        <?php else :?>
                        <p> <?= date('F d, Y, g:i a',strtotime($row['Date']))?> </p>
                        <?php endif ?> 
                    <p>
                        <small>
                            <?php if(strlen($row['content'] <= 200 )) :?>
                                <?= substr($row['content'], 0, 200) ?>  ... <a href="show.php?id=<?= $row['Page_id']?>">Read more</a>
                            <?php else :?>
                                    <?= $row['content'] ?>
                            <?php endif ?>
                        </small>
                    </p> 
                </article>
                <?php endwhile ?>
            </div>
    <?php else: ?>
            <p>There are no reviews.</p>
    <?php endif ?>

</section>

</body>
</html>