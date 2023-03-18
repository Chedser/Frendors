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

$post_id = (int)htmlspecialchars($_POST['post']);

if(!empty($post_id) && !empty($_SESSION['user'])){
 /*  УДАЛЯЕМ КОММЕНТЫ С ПОСТА   */    
$sql = "DELETE FROM `group_posts` WHERE `this_id`={$post_id}";
$query = $connection_handler->prepare($sql);
if($query->execute()){echo "Нихуя не действует";};

}

?>

<?php ob_end_flush(); ?>