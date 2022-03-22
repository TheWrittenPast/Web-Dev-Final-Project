<?php 
/*               
 *      Blog Assignment
 *      Name: John Russel Tabelina
 *      Date: February 11, 2022
 *      Description: Shows the edit page of the post.
 */

require('connect.php');

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
    <?php if($row) :?>
        <div id="wrapper">
            <div id="header">
                <h1><a href="index.php">The Past Is Written - Edit Post </a></h1>
            </div> <!-- END div id="header" -->
    <ul id="menu">
        <li><a href="index.php" >Home</a></li>
        <li><a href="create.php" >New Post</a></li>
    </ul> <!-- END div id="menu" -->
    <div id="all_blogs">
        <form action="complete_post.php" method="post">
            <fieldset>
                <legend>Edit Blog Post</legend>
                    <p>
                        <label for="title">Title</label>
                        <input name="title" id="title" value= '<?= $row['Title']?>' />
                    </p>
                    <p>
                        <label for="game">Game</label>
                        <input name="game" id="game" value= '<?= $row['Game']?>' />
                    </p>
                    <p>
                        <label for="content">Content</label>
                            <textarea name="content" id="content"><?= $row['content'] ?></textarea>
                    </p>
                
            <p>
                <input type="hidden" name="id" value=<?= $row['Page_id']?> />
                <input type="submit" name="command" value="Update" />
                <input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this post?')" />
            </p>
            </fieldset>
        </form>
    </div>
            <div id="footer">
                Copywrong 2022 - No Rights Reserved
            </div> <!-- END div id="footer" -->
        </div> <!-- END div id="wrapper" -->
    <?php else : ?>
        <?php header("Location: index.php"); ?>
    <?php endif ?>
</body>
</html>
