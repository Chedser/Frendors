<?php ob_start(); ?>

<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

$story_id = htmlspecialchars($_POST['story_id']);
$text = htmlspecialchars($_POST['text'],ENT_QUOTES);

if(!empty($story_id) && !empty($text)){
/* Выводим комменты */
$sql = "INSERT INTO `user_stories_posts`(`author`,`story_id`,`text`) VALUES('{$_SESSION['user']}','{$story_id}','{$text}')";	
$query = $connection_handler->prepare($sql); 
$query->execute();

/*********************************************************************************************/
    
$text = wordwrap($text, 70, "\r\n"); 
 
}
?>

<?php ob_end_flush(); ?>