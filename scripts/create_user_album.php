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

$name = trim(htmlspecialchars($_POST['name']));
$description = trim(htmlspecialchars($_POST['description']));

if(!empty($name)){

$sql = "INSERT INTO `user_albums`(`user`,`name`,`description`) VALUES ('{$_SESSION['user']}','{$name}','{$description}')";
            $query = $connection_handler->prepare($sql);
            if($query->execute()) {
                echo "Альбом создан";
            }

}

?>

<?php ob_end_flush(); ?>