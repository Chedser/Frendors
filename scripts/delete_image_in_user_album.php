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
$album_id = (int) htmlspecialchars($_POST['album_id']);

if(!empty($image_id) && !empty($album_id) ){

 $sql = "DELETE FROM `images_in_user_album` WHERE `this_id`={$image_id}";	
    $query = $connection_handler->prepare($sql);
    $query->execute();
    
    $sql = "INSERT INTO `deleted_images_in_user_album`(`album_id`,`image_id`,`user`) VALUES ({$album_id},{$image_id},'{$_SESSION['user']}')";	
    $query = $connection_handler->prepare($sql);
    if($query->execute()){
        echo "Картинка удалена";
    } 
    
}

?>

<?php ob_end_flush(); ?>