<?php 
ob_start();
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
header("Content-type: text/plain; charset='utf-8'");

if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

$user_id = htmlspecialchars($_POST['user_id']); // Страница пользователя кто ПРИНИМАЕТ запрос

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
$requester2 = $query->fetchAll(PDO::FETCH_ASSOC); 
$requester2 = $requester2[0]['nickname'];
 
 $sql = "DELETE FROM `friend_requests` WHERE `requester1`='{$_SESSION['user']}' AND `requester2`='{$requester2}'";	
    $query = $connection_handler->prepare($sql); //Подготавливаем запрос
    $query->execute(); 
}
ob_end_flush();

?>