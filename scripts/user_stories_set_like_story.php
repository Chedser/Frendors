<?php ob_start(); ?>

<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

$story_id = (int) htmlspecialchars($_GET['story_id']);

if(!empty($story_id) && !empty($_SESSION['user'])){
    $current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); 
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();

/* ПРОВЕРЯЕМ СТАВИЛ ЛИ ПОЛЬЗОВАТЕЛЬ ЛАЙК */
$sql = "SELECT * FROM `user_stories_like_under_story` WHERE `story_id`={$story_id}";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$likes_user = $query->fetchAll(PDO::FETCH_ASSOC);         

if(empty($likes_user)){ // Пользователь лайк не ставил
    /* Заносим лайк в БД */
$sql = "INSERT INTO `user_stories_like_under_story`(`liker`,`story_id`) VALUES ('{$_SESSION['user']}',{$story_id})";	
$query = $connection_handler->prepare($sql);
$query->execute();

} else {
    /* Удаляем лайк из базы */
$sql = "DELETE FROM `user_stories_like_under_story` WHERE  `story_id`={$story_id}";	
$query = $connection_handler->prepare($sql); 
$query->execute();

} 

/* Отображаем все лайки на данном посте */    
$sql = "SELECT COUNT(*) AS `likes_count` FROM `user_stories_like_under_story` WHERE `story_id`={$story_id}";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$likes_count = $query->fetchAll(PDO::FETCH_ASSOC);      
$likes_count = $likes_count[0]['likes_count'];

echo $likes_count;
}

?>
 

<?php ob_end_flush(); ?>