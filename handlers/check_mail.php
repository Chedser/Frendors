<?php 
ob_start();
require_once '../scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
header("Content-Type: application/json; charset=UTF-8");
/**
Проверяем существует ли такая почта ник. Если существует -- 'Почта занята'. Если не существует -- 'Почта свободна'.
Если длина полученной строки 2< -- 'Длина ника не может быть меньше двух символов'
**/

$mail_to_find = htmlspecialchars($_GET['mail_to_find']); //Получаем запрос из формы. 
/* Проверяем длину строки */

if(empty($_SERVER['HTTP_REFERER'])){
header('Location: ../games/head_answers.php'); 
exit();   
}


if(strlen($mail_to_find) == 0){ // Если длина строки 2<
$response = '{"server_response":"Поле для почты пусто"}';
echo $response;
exit();
}


$sql = "SELECT * FROM main_info WHERE email = :email";
$query = $connection_handler->prepare($sql);
$query->bindParam(':email', $mail_to_find, PDO::PARAM_STR);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC); // Получаем двумерный массив строк

if(!empty($result)){ //Возвращен непустой массив
$response = '{"server_response":"Почта занята"}';
echo $response; //Почта занята
} else {//Почта свободна
    $response = '{"server_response":"Почта свободна"}';
    echo $response;
} 

$connection_handler = null; // Закрываем соединение с базой данных 
ob_end_flush();
?>