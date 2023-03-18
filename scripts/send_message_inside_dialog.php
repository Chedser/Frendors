<?php
ob_start();
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
error_reporting(E_ALL);


$dialog_id = (int) htmlspecialchars($_POST['id']);
$message = htmlspecialchars($_POST['message'],ENT_QUOTES);
$limi = (int) htmlspecialchars($_POST['limi']);

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

if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

 if(!empty($dialog_id) && !empty($message)  &&  !empty($limi)) {
$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();

// ОБНОВЛЯЕМ ПОСЛЕДНЕЕ СООБЩЕНИЕ В ДИАЛОГЕ    
$sql = "UPDATE `dialogs` SET `last_message`='{$message}', `whose_last_message`='{$_SESSION['user']}' WHERE `this_id`={$dialog_id} ";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();

// ИЗВЛЕКАЕМ ПОСЛЕДНИЙ АЙДИ СООБЩЕНИЯ ДАННОГО ДИАЛОГА 
$sql = "SELECT * FROM `dialog_messages` WHERE `dialog`={$dialog_id} ORDER BY `this_id` DESC LIMIT 1";
    $query = $connection_handler->prepare($sql);
    $query->execute(); 
$last_message_id = $query->fetchAll(PDO::FETCH_ASSOC);
$last_message_id = $last_message_id[0]['this_id'];

// ДОБАВЛЯЕМ CООБЩЕНИЕ В БАЗУ `dialog_messages`  
$sql = "INSERT INTO `dialog_messages`(`sender`,`message`,`dialog`) VALUES ('{$_SESSION['user']}', '{$message}',{$dialog_id})";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();

/* ПРОВЕРЯЕМ КЕМ ЯВЛЯЕТСЯ СЕССИОННЫЙ | ИНИЦИАТОРОМ ЛИБО ПРИСОЕДИНЕННЫМ*/
$sql = "SELECT * FROM `dialogs` WHERE `this_id`={$dialog_id} ORDER BY `this_id` DESC LIMIT 1";
    $query = $connection_handler->prepare($sql);
    $query->execute(); 
$dialog_owner = $query->fetchAll(PDO::FETCH_ASSOC);

/**********************************************************************************************************************/
if($dialog_owner[0]['initiator'] === $_SESSION['user']){

$sql = "UPDATE `dialogs` SET `is_finished`=0, `is_finished_for_initiator`=1  WHERE `this_id`={$dialog_id}";
$query = $connection_handler->prepare($sql);
$query->execute();

$sql = "UPDATE `dialogers` SET `is_finished`=0, `is_finished_for_initiator`=1  WHERE `dialog`={$dialog_id}";
$query = $connection_handler->prepare($sql);
$query->execute();

    
} else if ($dialog_owner[0]['joined'] === $_SESSION['user']){
    $sql = "UPDATE `dialogs` SET `is_finished`=1, `is_finished_for_initiator`=0  WHERE `this_id`={$dialog_id}";
$query = $connection_handler->prepare($sql);
$query->execute();

$sql = "UPDATE `dialogers` SET `is_finished`=1, `is_finished_for_initiator`=0  WHERE `dialog`={$dialog_id}";
$query = $connection_handler->prepare($sql);
$query->execute();
}

/***********************************************************************************************************************/

$last_message_id = $connection_handler->lastInsertId();
$last_message_id = '{"last_message_id":"' . $last_message_id .'"},';

 }
?>

<?php ob_end_flush(); ?>
