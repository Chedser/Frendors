<?php 
ob_start();
require_once '../scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
header("Content-Type: application/json; charset=UTF-8");
/**
Проверяем существует ли такая почта ник. Если существует -- 'Почта занята'. Если не существует -- 'Почта свободна'.
Если длина полученной строки 2< -- 'Длина ника не может быть меньше двух символов'
**/

$mail = htmlspecialchars($_GET['mail']); //Получаем запрос из формы. 

if(empty($_SERVER['HTTP_REFERER'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

if(!empty($mail)){
   if(preg_match_all('/[A-Za-z0-9@+.+]/', $mail) == 0){
$response = '{"server_response":"Неверный ввод"}';
echo $response;
exit();  
}
}else{
$response = '{"server_response":"Пусто"}';
echo $response; //Пусто    
exit();
}

$sql = "SELECT * FROM main_info WHERE email = :email";
$query = $connection_handler->prepare($sql);
$query->bindParam(':email', $mail, PDO::PARAM_STR);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC); // Получаем двумерный массив строк

if(!empty($result)){ //Возвращен непустой массив
$response = '{"server_response":"Занят"}';
echo $response; //Почта занята
} else {//Почта свободна
    $response = '{"server_response":"Свободен"}';
    echo $response;
} 

$connection_handler = null; // Закрываем соединение с базой данных 
ob_end_flush();
?>

