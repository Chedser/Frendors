<?php
ob_start();
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
error_reporting(0);

if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

$post = (int)htmlspecialchars($_POST['post']);
$comment = (int)htmlspecialchars($_POST['comment']);

if(!empty($post) & empty($comment)){
 /*  УДАЛЯЕМ КОММЕНТЫ С ПОСТА   */    
$sql = "DELETE FROM `comments` WHERE `post_id`={$post}";
$query = $connection_handler->prepare($sql);
$query->execute();
   
 /*  УДАЛЯЕМ ЛАЙКИ С ПОСТА   */    
$sql = "DELETE FROM `likes` WHERE `post_id`={$post}";
$query = $connection_handler->prepare($sql);
$query->execute();  

/*  УДАЛЯЕМ ДИЗЛАЙКИ С ПОСТА   */    
$sql = "DELETE FROM `dislikes` WHERE `post_id`={$post}";
$query = $connection_handler->prepare($sql);
$query->execute();   
   
/*  УДАЛЯЕМ ПОСТ   */    
$sql = "DELETE FROM `wall_user_posts` WHERE `this_id`={$post}";
$query = $connection_handler->prepare($sql);
$query->execute();

}else if(empty($post) & !empty($comment)){
    /*  УДАЛЯЕМ КОММЕНТ   */    
    $sql = "DELETE FROM `comments` WHERE `this_id`={$comment}";
    $query = $connection_handler->prepare($sql);
    $query->execute();
}

?>

<?php ob_end_flush(); ?>