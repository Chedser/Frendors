<?php
ob_start();
require_once '../scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
header("Content-Type: application/json; charset=UTF-8");
/**
Проверяем существует ли такой ник. Если существует -- 'Ник занят'. Если не существует -- 'Ник свободен'.
Если длина полученной строки 2< -- 'Длина ника не может быть меньше двух символов'
**/
if(empty($_SERVER['HTTP_REFERER'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

$nick_to_find = htmlspecialchars($_GET['nick_to_find']); //Получаем запрос из формы. 
/* Проверяем длину строки */

if(strlen($nick_to_find) == 0){ // Если длина строки 2<
$response = '{"server_response":"Поле для ника пусто"}';
echo $response;
exit();
}
else if(strlen($nick_to_find) == 1){
$response = '{"server_response":"Ник не может состоять из одного символа"}';
echo $response;
exit();
}
else if(preg_match_all('/[a-zA-Z0-9а-яА-Я]{2,20}/', $nick_to_find) == 0){
$response = '{"server_response":"Формат ника не прошел проверку"}';
echo $response;
exit();    
}

$sql = "SELECT * FROM main_info WHERE nickname = :nickname";
$query = $connection_handler->prepare($sql);
$query->bindParam(':nickname', $nick_to_find, PDO::PARAM_STR);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC); // Получаем двумерный массив строк

if(!empty($result)){ //Возвращен непустой массив
$response = '{"server_response":"Ник занят"}';
echo $response; //Ник занят
} else {//Ник свободен
    $response = '{"server_response":"Ник свободен"}';
    echo $response;
} 
$connection_handler = null; // Закрываем соединение с базой данных 
ob_end_flush();
?>