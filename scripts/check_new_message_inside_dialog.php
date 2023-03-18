<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

header("Content-Type: application/json; charset=UTF-8");
$dialog_id = (int) htmlspecialchars($_GET['id']);
$limi = (int) htmlspecialchars($_GET['limi']);

if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user']) || empty($id)){
header('Location: ../games/head_answers.php'); // Редиректим на index.php
exit();   
}

$dialog_exist = "";
if(!empty($dialog_id)){

// ПРОВЕРЯЕМ СУЩЕСТВУЕТ ЛИ ТАКОЙ ДИАЛОГ 
$sql = "SELECT *  FROM `dialogs` WHERE `this_id`={$dialog_id}";
    $query = $connection_handler->prepare($sql);
    $query->execute();
$dialog_exist = $query->fetchAll(PDO::FETCH_ASSOC);

if(empty($dialog_exist)){
exit();     
}    

}else{exit();}

?>


<?php 
 
if(!empty($dialog_id)  &&  !empty($limi)){
 $current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();    

// ИЗВЛЕКАЕМ ПОСЛЕДНИЙ АЙДИ ДАННОГО ДИАЛОГА 
$sql = "SELECT * FROM `private_messages` WHERE `dialog`={$dialog_id} ORDER BY `this_id` DESC LIMIT 1";
    $query = $connection_handler->prepare($sql);
    $query->execute(); 
$last_message_id = $query->fetchAll(PDO::FETCH_ASSOC);
$last_message_id = $last_message_id[0]['this_id'];


if($last_message_id > $limi){ // Новые сообщения в базе есть
$last_message_id_for_json = '{"is_new":"true", last_message_id" : "' . $last_message_id .'"},';

$sql = "UPDATE `dialogs` SET `is_finished`=1 WHERE `this_id`={$dialog_id}";
$query = $connection_handler->prepare($sql);
$query->execute();
  
// ПРОВЕРЯЕМ КОЛИЧЕСТВО СООБЩЕНИЙ В  ДАННОМ ДИАЛОГЕ 
$sql = "SELECT COUNT(*) AS `messages_in_dialog_count` FROM `private_messages` WHERE `dialog`={$dialog_id}";
    $query = $connection_handler->prepare($sql);
    $query->execute();
$messages_in_dialog_count = $query->fetchAll(PDO::FETCH_ASSOC);
$messages_in_dialog_count =  $messages_in_dialog_count[0]['messages_in_dialog_count'];    

if($messages_in_dialog_count > 0){ 

$data .= "[" . $last_message_id_for_json;

for($i = 0; $i < $messages_in_dialog_count; $i++){ // Собираем сообщения в объект JSON
//  ИЩЕМ АВУ ОТПРАВИТЕЛЯ 
$sql = "SELECT `avatar`  FROM `additional_info` WHERE `nickname`='{$messages_in_dialog[$i]['sender']}'";
    $query = $connection_handler->prepare($sql);
    $query->execute();
$avatar = $query->fetchAll(PDO::FETCH_ASSOC);
$avatar = $avatar[0]['avatar'];

$data .= '{"avatar":"' . $avatar . '","sender":"' . $messages_in_dialog[$i]['sender'] . '","date":"' . $messages_in_dialog[$i]['date'] . '","message":"'
. $messages_in_dialog[$i]['message']  . '","message_id":"' . $messages_in_dialog[$i]['this_id'] .  '"}';

}

$data .= "]";

echo $data;

}////if($messages_in_dialog_count > 0)

} // if($last_message_id > $limi)
else { 

echo '[{"is_new":"false"}]';    

}
 
} // if(!empty($dialog_id)  &&  !empty($limi))
?>
