<?php
ob_start();
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

 if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: ../games/head_answers.php'); 
exit();   
} 


$user_chat_message = htmlspecialchars($_POST['user_chat_message'],ENT_QUOTES);
$last_message_id = (int) htmlspecialchars($_POST['last_message_id']);
$nickname = $_SESSION['user'];

if(!empty($user_chat_message) && !empty($last_message_id)) {
 $current_time = time(); // Время захода пользователя на страницу
    $sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
    $query = $connection_handler->prepare($sql); //Подготавливаем запрос
    $query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
    $query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
    $query->execute();   

// ПРОВЕРЯЕМ ЕСТЬ ЛИ В СООБЩЕНИИ ССЫЛКА
/* $user_chat_message = tolink($user_chat_message); */

/* ВСТАВЛЯЕМ СООБЩЕНИЕ В ТАБЛИЦУ */
$sql = "INSERT INTO `user_chat`(`nickname`,`message`) VALUE ('{$nickname}','{$user_chat_message}')";
$query = $connection_handler->prepare($sql);
$query->execute();

// теперь $last_message_id == 1261 

$last_message_id_for_new_messages = $last_message_id;
$last_message_id_for_response = "";

/* Проверяем появились ли новые сообщения. Если не появились, то отправляем ЭТО сообщение. ЕСли появились, то последние */
    $sql = "SELECT * FROM `user_chat` WHERE `this_id`>" . ++$last_message_id_for_new_messages; 	
    $query = $connection_handler->prepare($sql); 
    $query->execute();
    $new_messages = $query->fetchAll(PDO::FETCH_ASSOC); 
    
    if(empty($new_messages)){ // Новых сообщений нет
    
    $last_message_id_for_response = $last_message_id_for_new_messages;      
    $last_messages_container = '{"new_messages":[{"nick":"' . $_SESSION['user'] . '","message":"' . $user_chat_message . '"},{"last_message_id":"' . $last_message_id_for_response . '"}]}';    


 echo $last_messages_container;

    } else {
        
        
         // Собираем последние сообщения     
       $last_messages_container = '{"new_messages" : [';
       $last_message_id = "";
        
        for($i = 0; $i < count($new_messages); $i++){
        
        $last_message_id = $new_messages[$i]['this_id']; // Последнее айди сообщения
          
        $last_messages_container .= '{"nick":"' . $new_messages[$i]['nickname'] . '" , "message":"' . $new_messages[$i]['message'] . '"},';  
            
        }    
 
       $last_messages_container .= '{"last_message_id":"' . $last_message_id . '"}]}';

        echo $last_messages_container; 
   
    }

/* Удаляем последние сообщения */
    $last_message_id_for_new_messages -= 30;

    $sql = "DELETE FROM `user_chat` WHERE `this_id`<" . $last_message_id_for_new_messages; 	
    $query = $connection_handler->prepare($sql); 
    $query->execute();

/*********************************************************************************************/
    
$user_chat_message = wordwrap($user_chat_message, 70, "\r\n"); 
 
}

ob_end_flush();
?>

