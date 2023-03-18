<?php
ob_start();
require_once '../scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
header("Content-Type: application/json; charset=UTF-8");
/**
Проверяем существует ли такой ник. Если существует -- 'Занят'. Если не существует -- 'Свободен'.
**/

if(empty($_SERVER['HTTP_REFERER'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

$nick = htmlspecialchars($_GET['nick']); 

if(!empty($nick)){
if(preg_match_all('/[A-Za-zА-ЯабвгдежзийклмнопрстуфхцчшщЪыьэюя0-9]{2,20}/', $nick) == 0){
$response = '{"server_response":"Неверный ввод"}';
echo $response;
exit();    
}
}else {
$response = '{"server_response":"Пусто"}';
echo $response;
exit();    
}

$sql = "SELECT * FROM main_info WHERE nickname = :nickname";
$query = $connection_handler->prepare($sql);
$query->bindParam(':nickname', $nick, PDO::PARAM_STR);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);

if(!empty($result)){
$response = '{"server_response":"Занят"}';
echo $response; //Ник занят
} else {//Ник свободен
    $response = '{"server_response":"Свободен"}';
    echo $response;
} 
$connection_handler = null; // Закрываем соединение с базой данных 
ob_end_flush();
?>
