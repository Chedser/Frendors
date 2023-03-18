<?php
ob_start();
session_start();

if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

$page_id = htmlspecialchars($_GET['page_id']);

if(!empty($page_id) && ($page_id != $_SESSION['user'])){

if($page_id === $_SESSION['user']){
        exit();
    }


require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection_regards.php';
$connection_handler_regards->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

/* ПРОВЕРЯЕМ СТАВИЛ ЛИ ПОЛЬЗОВАТЕЛЬ ПРЕМИЮ */
$sql = "SELECT * FROM `premium` WHERE `clicker`='" . $_SESSION['user'] . "' AND `page_id`='{$page_id}'";	
$query = $connection_handler_regards->prepare($sql); //Подготавливаем запрос
$query->execute();
$premium = $query->fetchAll(PDO::FETCH_ASSOC);      

if(empty($premium)){ // Пользователь папиросы не давал
 
/* Заносим бутылки в БД */
$sql = "INSERT INTO `premium`(`clicker`,`page_id`) VALUES ('{$_SESSION['user']}','{$page_id}')";	
$query = $connection_handler_regards->prepare($sql); //Подготавливаем запрос
$query->execute();    

}else { // Пользователь бутылки давал
   /* Удаляем папирос  из базы */
$sql = "DELETE FROM `premium` WHERE `clicker`='{$_SESSION['user']}' AND `page_id`='{$page_id}'";	
$query = $connection_handler_regards->prepare($sql); //Подготавливаем запрос
$query->execute(); 
}

/* Отображаем всю премию */    
$sql = "SELECT COUNT(*) AS `premium_count` FROM `premium` WHERE `page_id`='{$page_id}'";	
$query = $connection_handler_regards->prepare($sql); //Подготавливаем запрос
$query->execute();
$premium_count = $query->fetchAll(PDO::FETCH_ASSOC);      
$premium_count = $premium_count[0]['premium_count'];
echo $premium_count; 

$connection_handler_regards = null;    

require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();
$connection_handler = null;
}

ob_end_flush();
?>




