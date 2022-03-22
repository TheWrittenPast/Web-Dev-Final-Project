<?php 
/*               
 *      Blog Assignment
 *      Name: John Russel Tabelina
 *      Date: February 11, 2022
 *      Description: Home page for blog.
 */
require('connect.php');

// SQL is written as a String.
$query = "SELECT * FROM blog ORDER BY time DESC LIMIT 5";

// A PDO::Statement is prepared from the query.
$statement = $db->prepare($query);

// Execution on the DB server is delayed until we execute().
$statement->execute(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css" />
    <title>Blog</title>
</head>
<body>

<div id="wrapper">
        <div id="header">
            <h1><a href="index.php">The Past Is Written - Home</a></h1>
        </div> <!-- END div id="header" -->
<ul id="menu">
    <li><a href="index.php" class='active'>Home</a></li>
    <li><a href="create.php" >New Post</a></li>
</ul> <!-- END div id="menu" -->
<div id="all_blogs">

<?php if($statement->rowCount() > 0) :?>
        <div class="blog_post">
            <?php while($row = $statement->fetch()) :?>
                <h2> <a href="show.php?id=<?= $row['id']?>"> <?= $row['title'] ?> </a> </h2>
                <p> <?= date('F d, Y, g:i a',strtotime($row['time']))  ?> - <a href="edit.php?id=<?= $row['id']?>">edit</a></p>
            <p>
                <small>
                    <?php if(strlen($row['content'] <= 200 )) :?>
                        <?= substr($row['content'], 0, 200) ?>  ... <a href="show.php?id=<?= $row['id']?>">Read more</a>
                    <?php else :?>
                        <?= $row['content'] ?>
                    <?php endif ?>
                </small>
            </p> 
                
             
            <?php endwhile ?>
        </div>
    <?php else: ?>
            <p>There are no tweets.</p>
    <?php endif ?>

</div>

<div id="footer">
            Copywrong 2022 - No Rights Reserved
        </div> <!-- END div id="footer" -->
</div>

</body>
</html>