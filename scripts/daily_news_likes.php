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

$daily_news_id = (int) htmlspecialchars($_POST['daily_news_id']);

if(!empty($_SESSION['user']) && !empty($daily_news_id)){ // Ставим лайк

$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();

/* ПРОВЕРЯЕМ СТАВИЛ ЛИ ПОЛЬЗОВАТЕЛЬ ЛАЙК */
$sql = "SELECT * FROM `daily_news_likes` WHERE `liker`='{$_SESSION['user']}' AND `news_id`={$daily_news_id}";	
$query = $connection_handler->prepare($sql);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);      

if(empty($result)){ // Не ставил

/* ПРОВЕРЯЕМ СТАВИЛ ЛИ ПОЛЬЗОВАТЕЛЬ ДИЗЛАЙК */
$sql = "SELECT * FROM `daily_news_dislikes` WHERE `disliker`='{$_SESSION['user']}' AND `news_id`={$daily_news_id}";	
$query = $connection_handler->prepare($sql);
$query->execute();
$dislikes = $query->fetchAll(PDO::FETCH_ASSOC); 

/* ПРОВЕРЯЕМ СТАВИЛ ЛИ ПОЛЬЗОВАТЕЛЬ БЕЗРАЗЛИЧИЕ */
$sql = "SELECT * FROM `daily_news_indifferent` WHERE `indifferenter`='{$_SESSION['user']}' AND `news_id`={$daily_news_id}";	
$query = $connection_handler->prepare($sql);
$query->execute();
$indifferents = $query->fetchAll(PDO::FETCH_ASSOC);  

    if(empty($dislikes) && empty($indifferents)){
    
    $sql = "INSERT INTO `daily_news_likes`(`liker`,`news_id`) VALUES ('{$_SESSION['user']}',{$daily_news_id})";	
    $query = $connection_handler->prepare($sql); 
    $query->execute();
    
    }    
    
} else { // Ставил
   
$sql = "DELETE FROM `daily_news_likes` WHERE `liker`='{$_SESSION['user']}' AND `news_id`={$daily_news_id}";	
$query = $connection_handler->prepare($sql); 
$query->execute();
    
}

/* ВОЗВРАЩАЕМ ВСЕ ЛАЙКИ */    
$sql = "SELECT COUNT(*) AS `daily_news_likes_count` FROM `daily_news_likes` WHERE `news_id`='{$daily_news_id}'";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$daily_news_likes_count_all = $query->fetchAll(PDO::FETCH_ASSOC);      
$daily_news_likes_count_all = $daily_news_likes_count_all[0]['daily_news_likes_count'];

echo $daily_news_likes_count_all;

} 

ob_end_flush();

?>


