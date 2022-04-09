<?php 
/*               
 *      Name: John Russel Tabelina
 *      Date: March 21, 2022
 *      Description: Completes the action for the post, whether its update, delete, or create.
 */

    require 'php-image-resize-master\lib\ImageResize.php';
    require 'php-image-resize-master\lib\ImageResizeException.php';
    use \Gumlet\ImageResize;

    require('connect.php');
    session_start();
    
if ($_POST['command']=='Create') {
    if ($_POST && !empty($_POST['title']) && !empty($_POST['content']) && $_POST && !empty($_POST['game']) ) {

        function file_upload_path($original_filename, $upload_subfolder_name = 'uploads') {
            $current_folder = dirname(__FILE__);
            $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
            return join(DIRECTORY_SEPARATOR, $path_segments);
         }
     
         function file_is_an_image($temp_path, $new_path) {
             $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
             $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];
             
             $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
             $actual_mime_type        = mime_content_type($temp_path);
             
             $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
             $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);
             
             return $file_extension_is_valid && $mime_type_is_valid;
         }
         
         $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
         $upload_error_detected = isset($_FILES['image']) && ($_FILES['image']['error'] > 0);
    
        if($image_upload_detected){

            $file_filename = $_FILES['image']['name'];
            $temporary_path = $_FILES['image']['tmp_name'];
            $new_file_path = file_upload_path($file_filename);
    
            if(getimagesize($temporary_path)){
                $actual_file_extension = pathinfo($new_file_path, PATHINFO_EXTENSION);
                $medium_resize = new ImageResize($temporary_path);
                $medium_resize->resizeToWidth(900);
                $imageMed = file_upload_path($medium_resize->save('uploads/medium/medium_'. $file_filename));

                $small_resize = new ImageResize($temporary_path);
                $small_resize->resizeToWidth(50);
                $imageSmall = file_upload_path($small_resize->save('uploads/thumbnail/thumbnail_' . $file_filename));
            }
    
            if(file_is_an_image($temporary_path, $new_file_path)){
                move_uploaded_file($temporary_path, $new_file_path);
            } else {
                $file_filename = null;
            }
        }

        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $Game = filter_input(INPUT_POST, 'game', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $user = $_SESSION['username'];

        $query = "INSERT INTO post (title, content, Game, Create_By, image) 
                        VALUES(:title, :content, :Game, :user, :image)";

        $statement = $db->prepare($query);

        $statement->bindvalue(':title', $title);
        $statement->bindvalue(':content',$content);
        $statement->bindvalue(':Game',$Game);
        $statement->bindvalue(':user',$user);
        $statement->bindvalue(':image',$file_filename);

        if($statement->execute()){
            header("Location:index.php");
            exit();
        }
    }
}

if ($_POST['command']=='Update') {

    if($_POST && !empty($_POST['title']) && !empty($_POST['content']) && isset($_POST['id']) ){

        function file_upload_path($original_filename, $upload_subfolder_name = 'uploads') {
            $current_folder = dirname(__FILE__);
            $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
            return join(DIRECTORY_SEPARATOR, $path_segments);
         }
     
         function file_is_an_image($temp_path, $new_path) {
             $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
             $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];
             
             $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
             $actual_mime_type        = mime_content_type($temp_path);
             
             $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
             $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);
             
             return $file_extension_is_valid && $mime_type_is_valid;
         }
         
         $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
         $upload_error_detected = isset($_FILES['image']) && ($_FILES['image']['error'] > 0);
    
        if($image_upload_detected){

            $file_filename = $_FILES['image']['name'];
            $temporary_path = $_FILES['image']['tmp_name'];
            $new_file_path = file_upload_path($file_filename);
    
            if(getimagesize($temporary_path)){
                $actual_file_extension = pathinfo($new_file_path, PATHINFO_EXTENSION);
                $medium_resize = new ImageResize($temporary_path);
                $medium_resize->resizeToWidth(900);
                $imageMed = file_upload_path($medium_resize->save('uploads/medium/medium_'. $file_filename));

                $small_resize = new ImageResize($temporary_path);
                $small_resize->resizeToWidth(300);
                $imageSmall = file_upload_path($small_resize->save('uploads/thumbnail/thumbnail_' . $file_filename));
            }
    
            if(file_is_an_image($temporary_path, $new_file_path)){
                move_uploaded_file($temporary_path, $new_file_path);
            } else {
                $file_filename = null;
            }
        }

        if(is_null($file_filename) && isset($_SESSION['image'])){
            $file_filename = $_SESSION['image'];
        }

        // Sanitize user input to escape HTML entities and filter out dangerous characters.
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $Game = filter_input(INPUT_POST, 'game', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // Build the parameterized SQL query and bind the sanitized values to the parameters
        $query = "UPDATE post 
                  SET title = :title, 
                  content = :content, 
                  Game = :Game, 
                  image = :image 
                  WHERE Page_id = :id";

        $statement = $db->prepare($query);
        $statement->bindValue(':title', $title);        
        $statement->bindValue(':content', $content);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->bindvalue(':Game',$Game);
        $statement->bindvalue(':image',$file_filename);

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

if ($_POST['command']=='Delete Image') {

    $id = filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
    $file_filename = null;
    
    $query = "UPDATE post 
            SET image = :image
            WHERE Page_id = :id";
    
    $statement = $db->prepare($query);
    
    $statement->bindValue(':id',$id,PDO::PARAM_INT);
    $statement->bindvalue(':image',$file_filename);

    if($statement->execute()){
        $imageName = $_SESSION['image'];
        unlink('uploads/' . $imageName);
        unlink('uploads/medium/medium_' . $imageName);
        unlink('uploads/thumbnail/thumbnail_' . $imageName);
        header("Location:index.php");
        exit();
    }
}


if ($_POST['command']=='Comment') {
    if ($_POST && !empty($_POST['comment'])) {

        $currentUser = $_SESSION['username'];

        $usernameQuery = "SELECT user_id FROM systemmembers WHERE username = '$currentUser'";

        $usernameStatement = $db->prepare($usernameQuery);
        $usernameStatement->execute();
        $usernameRow = $usernameStatement->fetch();

        $content = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $userId = $usernameRow['user_id'];
        $pageId = $_SESSION['page_id'];
        $query = "INSERT INTO comments (Content, user_id, page_id) VALUES(:Content, :user_id, :page_id)";

        $statement = $db->prepare($query);

        $statement->bindvalue(':Content',$content);
        $statement->bindvalue(':user_id',$userId);
        $statement->bindvalue(':page_id',$pageId);

        if($statement->execute()){
            header("Location:show.php?id=". $_SESSION['page_id']);
            exit();
        }
    }
}

if ($_POST['command']=='Update Comment') {

    if($_POST && !empty($_POST['content']) && isset($_POST['id']) ){
        // Sanitize user input to escape HTML entities and filter out dangerous characters.
        $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

        // Build the parameterized SQL query and bind the sanitized values to the parameters
        $query = "UPDATE comments SET content = :content WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':content', $content);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        // Execute the INSERT.
        if($statement->execute()){
            header("Location:show.php?id=". $_SESSION['page_id']);
            exit();
        }
    }
}

if ($_POST['command']=='Delete Comment') {

    $id = filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
    
    $query = "DELETE FROM comments WHERE id = :id LIMIT 1";
    
    $statement = $db->prepare($query);
    
    $statement->bindValue(':id',$id,PDO::PARAM_INT);

    if($statement->execute()){
        header("Location:show.php?id=". $_SESSION['page_id']);
        exit();
    }
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title> RISE - Error</title>
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
            Copyright 2022 - RISE
        </div>
    </div>
</body>
</html>