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

/* ПРОВЕРЯЕМ СТАВИЛ ЛИ ПОЛЬЗОВАТЕЛЬ ПАПИРОСУ */
$sql = "SELECT * FROM `777_bottles` WHERE `clicker`='" . $_SESSION['user'] . "' AND `page_id`='{$page_id}'";	
$query = $connection_handler_regards->prepare($sql); //Подготавливаем запрос
$query->execute();
$bottles_777 = $query->fetchAll(PDO::FETCH_ASSOC);      

if(empty($bottles_777)){ // Пользователь папиросы не давал
 
/* Заносим бутылки в БД */
$sql = "INSERT INTO `777_bottles`(`clicker`,`page_id`) VALUES ('{$_SESSION['user']}','{$page_id}')";	
$query = $connection_handler_regards->prepare($sql); //Подготавливаем запрос
$query->execute();    

}else { // Пользователь бутылки давал
   /* Удаляем папирос  из базы */
$sql = "DELETE FROM `777_bottles` WHERE `clicker`='{$_SESSION['user']}' AND `page_id`='{$page_id}'";	
$query = $connection_handler_regards->prepare($sql); //Подготавливаем запрос
$query->execute(); 
}

/* Отображаем все бутылки */    
$sql = "SELECT COUNT(*) AS `777_bottles_count` FROM `777_bottles` WHERE `page_id`='{$page_id}'";	
$query = $connection_handler_regards->prepare($sql); //Подготавливаем запрос
$query->execute();
$bottles_777_count = $query->fetchAll(PDO::FETCH_ASSOC);      
$bottles_777_count = $bottles_777_count[0]['777_bottles_count'];
echo $bottles_777_count; 

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


