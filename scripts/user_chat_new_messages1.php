<?php 
ob_start();
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
header("Content-type: application/json; charset=utf-8");

if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

$last_message_id = (int) htmlspecialchars($_POST['last_message_id']);

/* Скрипт отдает новые сообщения */

/* Сообщает клиенту ник, сообщение и айди последнего сообщения */

if(!empty($last_message_id)){

    $current_time = time(); // Время захода пользователя на страницу
    $sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
    $query = $connection_handler->prepare($sql); //Подготавливаем запрос
    $query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
    $query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
    $query->execute();   

    /* Проверяем появились ли новые сообщения  */
    /* Сообщения считаются новыми, если  `this_id`>($last_message_id} */

   $sql = "SELECT * FROM `user_chat` WHERE `this_id`>{$last_message_id}"; 	
    $query = $connection_handler->prepare($sql); 
    $query->execute();
    $new_messages = $query->fetchAll(PDO::FETCH_ASSOC); 

        if(!empty($new_messages)){ // Сообщения есть
            
        // Собираем последние сообщения     
       $last_messages_container = '{"new_messages" : [';
        $last_message_id = "";
        
        for($i = 0; $i < count($new_messages); $i++){
        
        $last_message_id = $new_messages[$i]['this_id']; // Последнее айди сообщения
          
        $last_messages_container .= '{"nick":"' . $new_messages[$i]['nickname'] . '" , "message":"' . $new_messages[$i]['message'] . '","id":"' . $new_messages[$i]['this_id'] . '"},';  
            
        }    
 
       $last_messages_container .= '{"last_message_id":"' . $last_message_id . '"}]}';

        echo $last_messages_container; 

     } // if(!empty($new_messages)

else {

echo '{"no_messages":"true"}';    
    
}

}

ob_end_flush();

?>