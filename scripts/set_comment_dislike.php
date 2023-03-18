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

$page = htmlspecialchars($_GET['page']);
$post_id = (int)htmlspecialchars($_GET['post_id']);
$comment_id = (int)htmlspecialchars($_GET['comment_id']);

if(!empty($page) && !empty($post_id) && !empty($comment_id)){
    $current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();
    
/* ПРОВЕРЯЕМ СТАВИЛ ЛИ ПОЛЬЗОВАТЕЛЬ ЛАЙК */
$sql = "SELECT * FROM `comments_dislikes` WHERE `post_id`={$post_id} AND `comment_id`={$comment_id}";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$comment_dislikes = $query->fetchAll(PDO::FETCH_ASSOC);         
 
if(empty($comment_dislikes)){ // Пользователь лайк не ставил

       /* ПРОВЕРЯЕМ СТАВИЛ ЛИ ПОЛЬЗОВАТЕЛЬ ЛАЙК */
    $sql = "SELECT * FROM `comments_likes` WHERE `post_id`={$post_id} AND `comment_id`={$comment_id}";	
    $query = $connection_handler->prepare($sql); //Подготавливаем запрос
    $query->execute();
    $comment_likes = $query->fetchAll(PDO::FETCH_ASSOC);         
 
 if(empty($comment_likes)){
   
    /* Заносим лайк в БД */
$sql = "INSERT INTO `comments_dislikes`(`liker`,`page`,`post_id`,`comment_id`) VALUES ('{$_SESSION['user']}','{$page}',{$post_id},{$comment_id})";	
$query = $connection_handler->prepare($sql); 
$query->execute();

}

} else {
    /* Удаляем лайк из базы */
$sql = "DELETE FROM `comments_dislikes` WHERE  `post_id`={$post_id} AND `comment_id`={$comment_id}";	
$query = $connection_handler->prepare($sql); 
$query->execute();

} 

/* Отображаем все дизлайки на данном комменте */    
$sql = "SELECT COUNT(*) AS `comment_dislikes_count` FROM `comments_dislikes` WHERE `post_id`={$post_id} AND `comment_id`={$comment_id}";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$comment_dislikes_count = $query->fetchAll(PDO::FETCH_ASSOC);      
$comment_dislikes_count = $comment_dislikes_count[0]['comment_dislikes_count'];

echo $comment_dislikes_count;

}

ob_end_flush();

?>


