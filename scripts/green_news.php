<?php
ob_start();
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
error_reporting(E_ALL);
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
header("Content-type: text/plain; charset='utf-8'");

if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

$green_news = htmlspecialchars($_POST['anonimous_text']);

if(!empty($green_news)){
$sender = "";
    if(!empty($_SESSION['user'])){ // Отправил авторизованный пользователь
$sender = $_SESSION['user'];    
} else {$sender = "Anonimous";}    

/* ВСТАВЛЯЕМ СООБЩЕНИЕ В ТАБЛИЦУ */
$sql = "INSERT INTO `green_news`(`sender`,`message`) VALUE ('{$sender}','{$green_news}')";
$query = $connection_handler->prepare($sql);
$query->execute();

/* ИЗВЛЕКАЕМ ПОСЛЕДНИЙ СТАТУС ИЗ ТАБЛИЦЫ */
$sql = "SELECT * FROM `green_news` ORDER BY date DESC";
$query = $connection_handler->prepare($sql);
$query->execute();
$last_green_news = $query->fetchAll(PDO::FETCH_ASSOC);
$last_green_news = $last_green_news[0]['message'];

echo  $last_green_news;     
ob_end_flush();
}
?>


