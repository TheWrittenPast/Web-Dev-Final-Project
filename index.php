<?php 
/*               
 *      Name: John Russel Tabelina
 *      Date: March 21, 2022
 *      Description: Home page
 */
require('connect.php');
session_start();

if(isset($_POST['navCommand'])) {
    if(isset($_POST['games']) || isset($_POST['keyword']) ) {
        if($_POST['games'] == 'All' && !isset($_POST['keyword']) ){
            $query = "SELECT * FROM post ORDER BY date DESC";
        } elseif($_POST['games'] == 'All' && isset($_POST['keyword']) ){
            $keyword = $_POST['keyword'];
            $query = "SELECT * FROM post WHERE content LIKE '%$keyword%' ORDER BY date DESC";
        }
        else {
            $selectedGame = $_POST['games'];
            $keyword = $_POST['keyword'];
            $query = "SELECT * FROM post WHERE Game = '$selectedGame' AND content LIKE '%$keyword%' ORDER BY date DESC";
        }
    }
    if(isset($_POST['keyword'])){
        
    }
} else{
    $query = "SELECT * FROM post ORDER BY date DESC";
}

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

    <?php if(isset($_SESSION['username']))  : ?>
        <h1 class="homePage"><a href="index.php">RISE - Home</a></h1>
        <h2> Welcome <?= $_SESSION['username'] ?> </h2>
    <?php else :?>
        <h1 class="homePage"><a href="index.php">RISE - Home</a></h1>
    <?php endif ?>


</header>

<section id="posts">

    <?php if($statement->rowCount() >= 1) :?>
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
                            <?= substr($row['content'], 0, 199) ?>
                            <?php if(strlen($row['content']) > 199 ) :?>
                                ... <a href="show.php?id=<?= $row['Page_id']?>">Read more</a>
                            <?php endif ?>
                        </small>
                    </p>
                    <?php if($row['image'] != null ) :?>
                        <p> <a href="show.php?id=<?= $row['Page_id']?>">View Image</a> </p>
                    <?php endif ?>
                </article>
                <?php endwhile ?>
            </div>
    <?php else: ?>
            <p>There are no reviews.</p>
    <?php endif ?>

</section>

</body>
</html>