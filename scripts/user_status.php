<?php

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
header("Content-type: text/plain; charset='utf-8'");

if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

$user_status = htmlspecialchars($_POST['user_status']);

if(!empty($user_status)){
/* ВСТАВЛЯЕМ СООБЩЕНИЕ В ТАБЛИЦУ */
$sql = "INSERT INTO `user_status`(`page`,`status`) VALUE ('{$_SESSION['user']}','{$user_status}')";
$query = $connection_handler->prepare($sql);
$query->execute();

/* ИЗВЛЕКАЕМ ПОСЛЕДНИЙ СТАТУС ИЗ ТАБЛИЦЫ */
$sql = "SELECT * FROM `user_status` WHERE `page`='{$_SESSION['user']}' ORDER BY this_id DESC";
$query = $connection_handler->prepare($sql);
$query->execute();
$last_user_status = $query->fetchAll(PDO::FETCH_ASSOC);
$last_user_status = $last_user_status[0]['status'];
echo  $last_user_status;     

/*$sql = "INSERT INTO `wall_user_posts`(`page_id`,`message`) VALUES('{$_SESSION['user']}','{$user_status}')";
$query = $connection_handler->prepare($sql);
$query->execute();*/
}
?>
