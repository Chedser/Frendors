<?php 
ob_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(empty($_SERVER['HTTP_REFERER'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

$question = $_GET['question']; // Вопрос голове


if(!empty($question)){
$answer = mt_rand(0,4); // Ответ от головы
switch($answer){ // Преобразуем число в символы для сохранения в базе данных
    case 0: $answer = "no";
        break;
    case 1: $answer = "yes";    
        break;
    case 2: $answer = "undefined";    
            break;
    case 3: $answer = "hui";    
            break;    
}

/* ВСТАВЛЯЕМ ВОПРОС ПОЛЬЗОВАТЕЛЯ И ОТВЕТ ГОЛОВЫ В БАЗУ ДАННЫХ */    
$sql = "INSERT INTO `head_answers`(`question`,`answer`) VALUES (:question,:answer) "; 
    $query = $connection_handler->prepare($sql);
    $query->bindParam(':question', $question, PDO::PARAM_STR);
    $query->bindParam(':answer', $answer, PDO::PARAM_STR);
    $query->execute();
}

ob_end_flush();
?>