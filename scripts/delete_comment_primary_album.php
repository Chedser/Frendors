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

$comment_id = (int)htmlspecialchars($_POST['comment_id']);

if(!empty($comment_id)){

/* ВСТАВЛЯЕМ КОММЕНТ В ТАБЛИЦУ */
$sql = "DELETE FROM `comments_primary_album` WHERE `this_id`=" . $comment_id;
$query = $connection_handler->prepare($sql);
$query->execute();

}

ob_end_flush(); 
?>

