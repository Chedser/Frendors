<?php 

$old_pass = $_GET['old_pass']; // Старый пароль
$new_pass = $_GET['new_pass']; // Новый пароль
$nickname = $_GET['nickname'];
header("Content-Type: application/json; charset=UTF-8");

if(empty($_SERVER['HTTP_REFERER'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

if(!empty($old_pass)){ // Пришел непустой пароль

require_once '../scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
$sql = "SELECT password from main_info WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $nickname, PDO::PARAM_STR);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);
$pass_hash = $result[0]['password'];

$response = "";    
if(password_verify($old_pass, $pass_hash)){ // Пользователь указал правильный пароль
    if(empty($new_pass)){ // Пришел пустой новый пароль
    $response = '{"server_response":"Укажите новый пароль"}';
    echo $response;
    exit();    
} else if(strlen($new_pass) < 6) {
$response = '{"server_response":"Длина пароля должна быть >= 6 символов"}';
echo $response;
exit();        
} 

if($old_pass === $new_pass){
$response = '{"server_response":"Нахуя его менять то?"}';
echo $response;
exit();
}
 
// Хэшируем новый пароль 
$options = [ // Массив, на основе, которого будет производиться хэширование
	'salt' => salt(),
	'cost' => 12
	];

$hash_pass = password_hash($new_pass, PASSWORD_DEFAULT, $options); // Хэшируем новый пароль пользователя	

// Вставляем новый пароль 
$data = array($hash_pass, $nickname);
$sql = "UPDATE main_info SET password=? WHERE nickname=?";	
$query = $connection_handler->prepare($sql); //Подготавливаем
$query->execute($data);
    $response = '{"server_response":"Пароль изменен"}';
    echo $response;
    exit();
}else { // Cтарый пароль указан неверно
    $response = '{"server_response":"Старый пароль указан неверно"}';
    echo $response;
    exit();
    }   
}  else {
    $response = '{"server_response":"Укажите старый пароль"}';
    echo $response;
    exit();
}

?>