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

/* ПРОВЕРЯЕМ СТАВИЛ ЛИ ПОЛЬЗОВАТЕЛЬ ДИЗЛАЙК */
$sql = "SELECT * FROM `user_stories_dislike_under_story` WHERE `story_id`={$story_id}";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$dislikes_user = $query->fetchAll(PDO::FETCH_ASSOC);         

if(empty($dislikes_user)){ // Пользователь дизлайк не ставил
    /* Заносим дизлайк в БД */
$sql = "INSERT INTO `user_stories_dislike_under_story`(`disliker`,`story_id`) VALUES ('{$_SESSION['user']}',{$story_id})";	
$query = $connection_handler->prepare($sql);
$query->execute();

} else {
    /* Удаляем дизлайк из базы */
$sql = "DELETE FROM `user_stories_dislike_under_story` WHERE  `story_id`={$story_id}";	
$query = $connection_handler->prepare($sql); 
$query->execute();

} 

/* Отображаем все лайки на данном посте */    
$sql = "SELECT COUNT(*) AS `dislikes_count` FROM `user_stories_dislike_under_story` WHERE `story_id`={$story_id}";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$dislikes_count = $query->fetchAll(PDO::FETCH_ASSOC);      
$dislikes_count = $dislikes_count[0]['dislikes_count'];

echo $dislikes_count;
}

?>
 

<?php ob_end_flush(); ?>