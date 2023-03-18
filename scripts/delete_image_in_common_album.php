<?php
ob_start();
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
error_reporting(0);

if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

$image_id = (int) htmlspecialchars($_POST['image_id']);

if(!empty($image_id) && $_SESSION['user'] === 'Adminto'){

 $sql = "DELETE FROM `common_images_likes` WHERE `image_id`={$image_id}";	
 $query = $connection_handler->prepare($sql);
 $query->execute();
 
 $sql = "DELETE FROM `common_images_comments` WHERE `image_id`={$image_id}";	
 $query = $connection_handler->prepare($sql);
 $query->execute();
    
 $sql = "DELETE FROM `common_images` WHERE `this_id`={$image_id}";	
    $query = $connection_handler->prepare($sql);
    if($query->execute()){
        echo "Картинка удалена";
    }
    
}

?>

<?php ob_end_flush(); ?>