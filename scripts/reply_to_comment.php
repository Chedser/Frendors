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

$user_id = (int) htmlspecialchars($_POST['user_id']);
$post_id = (int) htmlspecialchars($_POST['post']); // айди поста
$comment_id = (int) htmlspecialchars($_POST['comment_id']); // айди поста
$reply_to_comment_text = htmlspecialchars($_POST['message']);

if(!empty($user_id) && !empty($post_id) && !empty($comment_id) && !empty($reply_to_comment_text) ){

/* УЗНАЕМ ИМЯ ПОЛЬЗОВАТЕЛЯ */
$sql = "SELECT *  FROM `main_info` WHERE `user_id`={$user_id}";	
$query = $connection_handler->prepare($sql);
$query->execute();
$page = $query->fetchAll(PDO::FETCH_ASSOC);
$page = $page[0]['nickname']; 

/* УЗНАЕМ ИМЯ ПОЛЬЗОВАТЕЛЯ */
$sql = "SELECT *  FROM `comments` WHERE `this_id`={$comment_id}";	
$query = $connection_handler->prepare($sql);
$query->execute();
$reply_to = $query->fetchAll(PDO::FETCH_ASSOC);
$reply_to = $reply_to[0]['nickname']; 

 /* ВСТАВЛЯЕМ КОММЕНТ В ТАБЛИЦУ */
$sql = "INSERT INTO `comments`(`nickname`,`page`,`post`, `reply_to_comment_id`, `reply_to`, `message`) VALUE ('{$_SESSION['user']}','{$page}',{$post_id},{$comment_id},'{$reply_to}','{$reply_to_comment_text}')";
$query = $connection_handler->prepare($sql);
$query->execute();

/**************************************************************************************************************************************************************/    

 $whose_page = ""; 

// СМОТРИМ НА ЧЬЕЙ СТРАНИЦЕ ОСТАВЛЕН ПОСТ 

// ПОСТ ОСТАВЛЕН НА НАШЕЙ СТРАНИЦЕ 
if($page === $_SESSION['user']){

$whose_page = "своей странице";
    
} else if($page !== $_SESSION['user']) { // На чужой

$whose_page = "вашей странице";

if($reply_to !== $page){
        $whose_page = "странице пользователя <a href = user.php?zs={$page}>{$page}</a>";    
}

}

// Извлекаем текст коммента, на который отвечаем
$sql = "SELECT `message` FROM `comments` WHERE `this_id`={$comment_id}";	
$query = $connection_handler->prepare($sql);
$query->bindParam(':requester2', $login_session, PDO::PARAM_STR); // Пользователь к к которому зашли. Принимают заявку
$query->execute();
$comment_text = $query->fetchAll(PDO::FETCH_ASSOC);
$comment_text = $comment_text[0]['message'];  

// ВСТАВЛЯЕМ ОПОВЕЩЕНИЕ В ТАБЛИЦУ  
$sql = "INSERT INTO `notice`(`noticer`,`noticed`,`description`,`type`,`reply_to`,`page`,`post_id`,`reply_to_comment_id`,`reply_to_comment_text`,`comment_text`) VALUE ('{$_SESSION['user']}','{$reply_to}','{$whose_page}','reply_to','{$reply_to}','{$page}',{$post_id},{$comment_id},'{$reply_to_comment_text}','{$comment_text}')";
$query = $connection_handler->prepare($sql);
$query->execute(); 

} 

ob_end_flush(); 
?>

