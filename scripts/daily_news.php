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

$daily_news = htmlspecialchars($_POST['daily_news']);

if(!empty($daily_news) && $_SESSION['user'] === 'Adminto'){

$sql = "INSERT INTO `daily_news`(`text`) VALUES('{$daily_news}')";	
$query = $connection_handler->prepare($sql);
$query->execute();

}

?>

<?php ob_end_flush(); ?>