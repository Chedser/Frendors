<?php 
ob_start();
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
header("Content-Type: text/html; charset=UTF-8");

if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

$post = htmlspecialchars($_POST['post_message'],ENT_QUOTES); // Сообщение на стену
$group_id = htmlspecialchars($_POST['page_id']); // Стена пользователя, которому отправили сообщение 

if(!empty($group_id) && !empty($post)){

    /* Добавляем сообщение в базу данных */ 
    $data_array = array($group_id, $_SESSION['user'], $post);
    $sql = "INSERT INTO group_posts(group_id,author,text) VALUES(?,?,?) "; 
    $query = $connection_handler->prepare($sql);
    $query->execute($data_array);
    

} //if(!empty($page_id) && !empty($post))  

$connection_handler = null;

ob_end_flush();  
?>