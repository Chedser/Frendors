<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
header("Content-type: text/plain; charset='utf-8'");

if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

$user_id = (int) htmlspecialchars($_POST['user_id']); //  Тот кто ОТПРАВЛЯЕТ запрос

if(!empty($user_id)){
$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();    

$sql = "SELECT * FROM `main_info` WHERE `user_id`={$user_id}";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':user_id', $user_id, PDO::PARAM_STR);
$query->execute(); 
$friend1 = $query->fetchAll(PDO::FETCH_ASSOC); 
$friend1 = $friend1[0]['nickname']; // Тот кто отправил заявку

    $sql = "DELETE FROM `friend_requests` WHERE `requester1`=:requester1 AND `requester2`=:requester2";	
    $query = $connection_handler->prepare($sql); //Подготавливаем запрос
    $query->bindParam(':requester1', $friend1, PDO::PARAM_STR);
    $query->bindParam(':requester2', $_SESSION['user'], PDO::PARAM_STR);
    $query->execute();

/********************************************************************************************************************/

/* Оповещаем пользователя о том, отклонили заявку */
$description = "Пользователь <a href = {$_SESSION['user']}>{$_SESSON['user']}</a> отклонил вашу заявку вбратки";

$sql = "INSERT INTO `notice`(`noticer`,`noticed`,`description`,`type`) VALUE ('{$_SESSION['user']}','{$friend1}','{$description}','deny_friend_request')";
$query = $connection_handler->prepare($sql);
$query->execute();  

}

?>

