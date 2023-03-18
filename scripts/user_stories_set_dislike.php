<?php ob_start(); ?>

<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

$story_id = htmlspecialchars($_POST['story_id']);

if(!empty($story_id)){
    $current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();
    
/* ПРОВЕРЯЕМ СТАВИЛ ЛИ ПОЛЬЗОВАТЕЛЬ ДИЗЛАЙК */
$sql = "SELECT * FROM `user_stories_dislikes` WHERE `story_id`={$story_id} AND `disliker`='{$_SESSION['user']}'";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$dislikes_user = $query->fetchAll(PDO::FETCH_ASSOC); 

/* ПРОВЕРЯЕМ СТАВИЛ ЛИ ПОЛЬЗОВАТЕЛЬ ЛАЙК */
$sql = "SELECT * FROM `user_stories_likes` WHERE `story_id`={$story_id} AND `liker`='{$_SESSION['user']}'";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$likes_user = $query->fetchAll(PDO::FETCH_ASSOC);   
 
if(empty($dislikes_user) && empty($likes_user)){ // Пользователь лайк не ставил
    /* Заносим лайк в БД */
$sql = "INSERT INTO `user_stories_dislikes`(`disliker`,`story_id`) VALUES ('{$_SESSION['user']}',{$story_id})";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();

}

/* Отображаем все лайки на данном посте */    
$sql = "SELECT COUNT(*) AS `dislikes_count` FROM `user_stories_dislikes` WHERE `story_id`={$story_id}";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$dislikes_count = $query->fetchAll(PDO::FETCH_ASSOC);      
$dislikes_count = $dislikes_count[0]['dislikes_count'];

echo $dislikes_count;

}

?>

<?php ob_end_flush(); ?>