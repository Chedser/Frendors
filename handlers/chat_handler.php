<?php
ob_start();
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
ini_set('display_errors', 'Off');

if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

$message = $_GET['message'];

if(!empty($message) && !empty($_SESSION['user'])){

/* ВСТАВЛЯЕМ СООБЩЕНИЕ В ТАБЛИЦУ chat  */
$data_insert = array($_SESSION['user'], $message);
$sql = "INSERT INTO chat(nickname, message) VALUES(?,?)"; 
    $query = $connection_handler->prepare($sql);
    $query->execute($data_insert); 

/* ВСТАВЛЯЕМ СООБЩЕНИЕ В ТАБЛИЦУ random_phrases_common_chat  */
$sql = "INSERT INTO `random_phrases_common_chat`(`phrase`) VALUES('{$message}')"; 
    $query = $connection_handler->prepare($sql);
    $query->execute($data_insert); 
    
/* ИЗВЛЕКАЕМ СЛУЧАЙНУЮ ФРАЗУ ИЗ ТАБЛИЦЫ random_phrases_common_chat  */
$sql = "SELECT * FROM `random_phrases_common_chat`"; 
    $query = $connection_handler->prepare($sql);
    $query->execute($data_insert);     
$random_phrases =  $query->fetchAll(PDO::FETCH_ASSOC);   
$random_phrase = $random_phrases[mt_rand(0,count($random_phrases) - 1)]['phrase'];    

/* ВСТАВЛЯЕМ СЛУЧАЙНУЮ ФРАЗУ В ТАБЛИЦУ chat  */
$sql = "INSERT INTO chat(nickname, message) VALUES('green_bot','{$random_phrase}')"; 
    $query = $connection_handler->prepare($sql);
    $query->execute($data_insert); 

}

ob_end_flush();
$connection_handler = null;
?>