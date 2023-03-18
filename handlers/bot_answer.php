<?php 
ob_start();
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection_bot.php';
$chb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
header("Content-Type: text/html; charset=UTF-8");

$confirmation_token = '68f29b66'; //f5c86e46

$message = htmlspecialchars($_POST['message'],ENT_QUOTES); // Сообщение на стену
$peer_id = htmlspecialchars($_POST['peer_id']); // Стена пользователя, которому отправили сообщение 
//Ключ доступа сообщества
$token = '0234043ba890b7530a378f4586e5cad3166cabed52023a85c5e7effc1866b572070f7c80bb60c26cbbbe1';

if(!empty($message) && !empty($peer_id)){

//С помощью messages.send отправляем ответное сообщение
$request_params = array(
'message' => $response,
'peer_id' => $peer_id,
'access_token' => $token,
'attachment'=>$attachment,
'v' => '5.126',
'random_id' => '0'
);

$get_params = http_build_query($request_params);

file_get_contents('https://api.vk.com/method/messages.send?'. $get_params);

} //if(!empty($page_id) && !empty($post))  

 $chb = null;

ob_end_flush();  
?>