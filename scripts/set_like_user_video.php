<?php
ob_start();
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
header("Content-Type: application/json; charset=UTF-8");

if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: ../games/head_answers.php'); 
exit();   
}


$video_id = (int)htmlspecialchars($_POST['video_id']);

if(!empty($video_id)){

$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();
    
/* ПРОВЕРЯЕМ СТАВИЛ ЛИ ПОЛЬЗОВАТЕЛЬ ЛАЙК */
$sql = "SELECT COUNT(*) AS `user_likes_count` FROM `user_videos_likes` WHERE `video_id`={$video_id} AND `liker`='{$_SESSION['user']}'";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$user_likes_count = $query->fetchAll(PDO::FETCH_ASSOC);
$user_likes_count = (int)$user_likes_count[0]['user_likes_count'];
 
if($user_likes_count == 0){ // Пользователь лайк не ставил
    
    /* ПРОВЕРЯЕМ СТАВИЛ ЛИ ПОЛЬЗОВАТЕЛЬ ДИЗЛАЙК */
$sql = "SELECT COUNT(*) AS `user_dislikes_count` FROM `user_videos_dislikes` WHERE `video_id`={$video_id} AND `disliker`='{$_SESSION['user']}'";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$user_dislikes_count = $query->fetchAll(PDO::FETCH_ASSOC);
$user_dislikes_count = (int)$user_dislikes_count[0]['user_dislikes_count'];
    
    if($user_dislikes_count == 0){
    
    /* Заносим лайк в БД */
$sql = "INSERT INTO `user_videos_likes`(`video_id`,`liker`) VALUES ({$video_id},'{$_SESSION['user']}')";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
}

} else {
    /* Удаляем лайк из базы */
$sql = "DELETE FROM `user_videos_likes` WHERE  `video_id`={$video_id} AND `liker`='{$_SESSION['user']}'";	
$query = $connection_handler->prepare($sql); 
$query->execute();

} 

/* Отображаем все лайки на данном комменте */    
$sql = "SELECT COUNT(*) AS `likes_count` FROM `user_videos_likes` WHERE `video_id`=" . $video_id;	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$likes_count = $query->fetchAll(PDO::FETCH_ASSOC);      
$likes_count = $likes_count[0]['likes_count'];

echo $likes_count;

}

ob_end_flush();

?>


