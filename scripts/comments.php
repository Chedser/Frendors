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

error_reporting(E_ALL);

$user_id = (int) htmlspecialchars($_POST['user_id']); 
$post_id = (int) htmlspecialchars($_POST['post_id']);
$message = htmlspecialchars($_POST['message'],ENT_QUOTES);

if(!empty($user_id) && !empty($post_id) && !empty($message)){

/* УЗНАЕМ ИМЯ ПОЛЬЗОВАТЕЛЯ */
$sql = "SELECT *  FROM `main_info` WHERE `user_id`={$user_id}";	
$query = $connection_handler->prepare($sql);
$query->execute();
$page = $query->fetchAll(PDO::FETCH_ASSOC);
$page = $page[0]['nickname']; 


/* ВСТАВЛЯЕМ КОММЕНТ В ТАБЛИЦУ */
$sql = "INSERT INTO `comments`(`nickname`,`page`,`post_id`,`message`) VALUE ('{$_SESSION['user']}','{$page}',{$post_id},'{$message}')";
$query = $connection_handler->prepare($sql);
$query->execute();

// УЗНАЕМ КОМУ ПРИНАДЛЕЖИТ ПОСТ 
$sql = "SELECT * FROM `wall_user_posts` WHERE `this_id`={$post_id}";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$post_info = $query->fetchAll(PDO::FETCH_ASSOC); 
$post_sender = $post_info[0]['nickname']; 
$post_text = $post_info[0]['message'];

 if($post_sender !== $_SESSION['user']){ // Пост отправил не сессионный. Оповещаем отправителя 

$whose_page = ""; 

// СМОТРИМ НА ЧЬЕЙ СТРАНИЦЕ ОСТАВЛЕН ПОСТ 

/* ПОСТ ОСТАВЛЕН НА НАШЕЙ СТРАНИЦЕ */
if($page === $_SESSION['user']){

$whose_page = "0"; // своя
    
} else if($page !== $_SESSION['user']) { // На чужой

$whose_page = "1"; // ваша

if($post_sender !== $page){
        $whose_page = "{$page}";    
}

}

// ВСТАВЛЯЕМ ОПОВЕЩЕНИЕ В ТАБЛИЦУ  
$sql = "INSERT INTO `notice`(`noticer`,`noticed`,`description`,`type`,`post_sender`,`page`,`post_id`,`post_text`) VALUE 
            ('{$_SESSION['user']}','{$post_sender}','{$whose_page}','comment_post','{$post_sender}','{$page}',{$post_id},'{$message}')";
$query = $connection_handler->prepare($sql);
$query->execute();  

/* ПОСТ ОСТАВЛЕН НА НАШЕЙ СТРАНИЦЕ */
if($page === $_SESSION['user']){

$whose_page = "0"; // своей
    
} else if($page !== $_SESSION['user']) { // На чужой

        $whose_page = "{$page}";    

}

    // ВСТАВЛЯЕМ ОПОВЕЩЕНИЕ В ТАБЛИЦУ ОБЩИХ ОПОВЕЩЕНИЙ 
        $sql = "INSERT INTO `common_notice`(`noticer`,`description`,`type`,`page`,`post_id`,`post_sender`,`post_text`,`comment_text`) VALUE 
                    ('{$_SESSION['user']}','{$whose_page}','comment_user_wall_post','{$page}',{$post_id},'{$post_sender}','{$post_text}','{$message}')";
        $query = $connection_handler->prepare($sql);
        $query->execute();      

 } 

} 

ob_end_flush(); 
?>

