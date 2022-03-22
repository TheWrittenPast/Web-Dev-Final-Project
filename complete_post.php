<?php 
/*               
 *      Name: John Russel Tabelina
 *      Date: February 11, 2022
 *      Description: Completes the action for the post, whether its update, delete, or create.
 */

    require('connect.php');
    
if ($_POST['command']=='Create') {
    if ($_POST && !empty($_POST['title']) && !empty($_POST['content']) && $_POST && !empty($_POST['game']) ) {
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $Game = filter_input(INPUT_POST, 'game', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $query = "INSERT INTO post (title, content, Game) VALUES(:title, :content, :Game)";

        $statement = $db->prepare($query);

        $statement->bindvalue(':title', $title);
        $statement->bindvalue(':content',$content);
        $statement->bindvalue(':Game',$Game);

        if($statement->execute()){
            header("Location:index.php");
            exit();
        }
    }
} 
if ($_POST['command']=='Update') {

    if($_POST && !empty($_POST['title']) && !empty($_POST['content']) && isset($_POST['id']) ){
        // Sanitize user input to escape HTML entities and filter out dangerous characters.
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $Game = filter_input(INPUT_POST, 'game', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // Build the parameterized SQL query and bind the sanitized values to the parameters
        $query = "UPDATE post SET title = :title, content = :content, Game = :Game WHERE Page_id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':title', $title);        
        $statement->bindValue(':content', $content);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->bindvalue(':Game',$Game);

        // Execute the INSERT.
        if($statement->execute()){
            header("Location:index.php");
            exit();
        }
    }
} 
if ($_POST['command']=='Delete') {

    $id = filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
    
    $query = "DELETE FROM post WHERE Page_id = :id LIMIT 1";
    
    $statement = $db->prepare($query);
    
    $statement->bindValue(':id',$id,PDO::PARAM_INT);

    if($statement->execute()){
        header("Location:index.php");
        exit();
    }
}


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title> Wootly Grins</title>
    <link rel="stylesheet" href="styles.css" type="text/css">
</head>
<body>
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php"></a></h1>
        </div>

<h1>An error occured while processing your post.</h1>
  <p>
    Both the title and content must be at least one character.  </p>
<a href="index.php">Return Home</a>

        <div id="footer">
            Copywrong 2022 - No Rights Reserved
        </div> 
    </div>
</body>
</html>