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


require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection_tortures.php';
$connection_handler_tortures->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

/* ПРОВЕРЯЕМ СТАВИЛ ЛИ ПОЛЬЗОВАТЕЛЬ ПАПИРОСУ */
$sql = "SELECT * FROM `akagi_kaga` WHERE `clicker`='" . $_SESSION['user'] . "' AND `page_id`='{$page_id}'";	
$query = $connection_handler_tortures->prepare($sql); //Подготавливаем запрос
$query->execute();
$akagi_kaga = $query->fetchAll(PDO::FETCH_ASSOC);      

if(empty($akagi_kaga)){ // Пользователь папиросы не давал
 
/* Заносим папирос в БД */
$sql = "INSERT INTO `akagi_kaga`(`clicker`,`page_id`) VALUES ('{$_SESSION['user']}','{$page_id}')";	
$query = $connection_handler_tortures->prepare($sql); //Подготавливаем запрос
$query->execute();    

}else { // Пользователь папирос давал
   /* Удаляем папирос  из базы */
$sql = "DELETE FROM `akagi_kaga` WHERE `clicker`='{$_SESSION['user']}' AND `page_id`='{$page_id}'";	
$query = $connection_handler_tortures->prepare($sql); //Подготавливаем запрос
$query->execute(); 
}

/* Отображаем все папиросы */    
$sql = "SELECT COUNT(*) AS `akagi_kaga_count` FROM `akagi_kaga` WHERE `page_id`='{$page_id}'";	
$query = $connection_handler_tortures->prepare($sql); //Подготавливаем запрос
$query->execute();
$akagi_kaga_count = $query->fetchAll(PDO::FETCH_ASSOC);      
$akagi_kaga_count = $akagi_kaga_count[0]['akagi_kaga_count'];
echo $akagi_kaga_count; 

$connection_handler_tortures = null;    

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








