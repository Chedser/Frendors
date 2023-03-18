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

$video_id = (int) htmlspecialchars($_POST['video_id']);

if(!empty($video_id) && $_SESSION['user'] == 'Adminto'){

$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();  

 $sql = "DELETE FROM `common_videos` WHERE `this_id`={$video_id}";	
 $query = $connection_handler->prepare($sql);
 $query->execute();

 $sql = "DELETE FROM `common_videos_likes` WHERE `video_id`={$video_id}";	
  $query = $connection_handler->prepare($sql);
  $query->execute();
  
 $sql = "DELETE FROM `common_videos_comments` WHERE `video_id`={$video_id}";	
 $query = $connection_handler->prepare($sql);
 if($query->execute()){
        echo "Видио удалено";
    } 
}

?>

<?php ob_end_flush(); ?>