<?php 
/*               
 *      Name: John Russel Tabelina
 *      Date: March 21, 2022
 *      Description: Home page for blog.
 */
require('connect.php');
$limit = 3;
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
    <nav>
        <button><a href="login.php">Log-in</a> </button>
        <button><a href="register.php">Register</a> </button>
        <li><a href="index.php" class='active'>Home</a></li>
        <li><a href="create.php" >New Post</a></li>

    <select name="games">
        <option value="all">All</option>
        <?php while($row = $gameStatement->fetch()) :?>
            <option value="<?= $row['Game']?>"><?= $row['Game'] ?></option>
        <?php endwhile ?>
    </select>

    </nav>

    <h1><a href="index.php">RISE - Home Page</a></h1>

</header>

<section id="posts">

    <?php if($statement->rowCount() > 0) :?>
            <div class="article">
                <?php while($row = $statement->fetch()) :?>
                    <article>
                        <h2> <a href="show.php?id=<?= $row['Page_id']?>"> <?= $row['Title'] ?> </a> </h2>
                        <p> <?= date('F d, Y, g:i a',strtotime($row['Date']))  ?> - <a href="edit.php?id=<?= $row['Page_id']?>">edit</a></p>
                    <!-- <p>Created By: <?= $row['Create_By']?></p> -->
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