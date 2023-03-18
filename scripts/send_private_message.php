<?php
ob_start();
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

$login = htmlspecialchars($_POST['user_id']); 
$message = htmlspecialchars($_POST['message'],ENT_QUOTES);

if(!empty($login) && !empty($message)){
$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); 
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();    

$dialoger = "";

if($login !== $_SESSION['user']){
    $dialoger = $login; 
} else {
    $dialoger = 'Adminto';
    
}

/* ПРОВЕРЯЕМ ЕСТЬ ЛИ ДИАЛОГ С ДАННЫМ ПОЛЬЗОВАТЕЛЕМ */
$sql = "SELECT * FROM `dialogs` WHERE (`initiator`='{$_SESSION['user']}' AND `joined`='{$dialoger}') 
 OR (`initiator`='{$dialoger}' AND `joined`='{$_SESSION['user']}')";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$dialogs_with_user = $query->fetchAll(PDO::FETCH_ASSOC);

        if(empty($dialogs_with_user)){ // ДИАЛОГ ЕЩЕ НЕ БЫЛ НАЧАТ
        /* ДОБАВЛЯЕМ ДИАЛОГ В ТАБЛИЦУ dialogs */    
        $sql = "INSERT INTO `dialogs`(`initiator`,`joined`,`last_message`,`whose_last_message`) 
         VALUES('{$_SESSION['user']}','{$dialoger}','{$message}','{$_SESSION['user']}')";	
        $query = $connection_handler->prepare($sql); 
        $query->execute();
        $dialog_id = $connection_handler->lastInsertId();
        
        /* ИЗВЛЕКАЕМ ДАТУ НАЧАЛА ДИАЛОГА ИЗ ТАБЛИЦЫ dialogs*/
        $sql = "SELECT `date` FROM `dialogs` WHERE `initiator`='{$_SESSION['user']}' AND `joined`='{$dialoger}'";	
        $query = $connection_handler->prepare($sql); 
        $query->execute();
        $date_begin_dialog = $query->fetchAll(PDO::FETCH_ASSOC);
        $date_begin_dialog = $date_begin_dialog[0]['date'];
        
        /* ВСТАВЛЯЕМ ДАТУ НАЧАЛА ДИАЛОГА В ТАБЛИЦУ `date_of_new_dialog` */
        $sql = "INSERT INTO `date_of_new_dialog`(`dialog`) VALUES('{$dialog_id}')";	
        $query = $connection_handler->prepare($sql); 
        $query->execute();
        
        /* ДОБАВЛЯЕМ УЧАСТНИКА В ТАБЛИЦУ dialogers */    
        $sql = "INSERT INTO `dialogers`(`dialog`,`dialoger`,`last_message`) VALUES({$dialog_id},'{$dialoger}','{$message}')";	
        $query = $connection_handler->prepare($sql); 
        $query->execute();
        
        /* ДОБАВЛЯЕМ CООБЩЕНИЕ В БАЗУ `dialog_messages` */    
        $sql = "INSERT INTO `dialog_messages`(`sender`, `dialog`, `message`) VALUES ('{$_SESSION['user']}',{$dialog_id},'{$message}')";	
        $query = $connection_handler->prepare($sql); 
        if($query->execute()){    
            echo "Сообщение отправлено";
        }

} else { // ДИАЛОГ УЖЕ БЫЛ НАЧАТ
            /* УЗНАЕМ АЙДИ ДИАЛОГА*/
            $sql = "SELECT * FROM `dialogs` WHERE (`initiator`='{$_SESSION['user']}' AND `joined`='{$dialoger}') 
            OR (`initiator`='{$dialoger}' AND `joined`='{$_SESSION['user']}')";	
            $query = $connection_handler->prepare($sql); 
            $query->execute();
            $dialog_id = $query->fetchAll(PDO::FETCH_ASSOC);
            $dialog_id = $dialog_id[0]['this_id'];
            
            /* ДОБАВЛЯЕМ CООБЩЕНИЕ В БАЗУ `dialog_messages` */    
            $sql = "INSERT INTO `dialog_messages`(`sender`, `dialog`, `message`) VALUES ('{$_SESSION['user']}',{$dialog_id},'{$message}')";	
            $query = $connection_handler->prepare($sql); 
            $query->execute();    
            
            /* ОБНОВЛЯЕМ СООБЩЕНИЕ В ТАБЛИЦЕ  dialogers    
            $sql = "UPDATE `dialogers` SET `last_message`='{$message}', `is_finished`=0 WHERE `dialog`={$dialog_id}";	
            $query = $connection_handler->prepare($sql); 
            $query->execute(); */
            
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
            
            
            /* ОБНОВЛЯЕМ ПОСЛЕДНЕЕ СООБЩЕНИЕ В ДИАЛОГЕ */    
            $sql = "UPDATE `dialogs` SET `last_message`='{$message}',`whose_last_message`='{$_SESSION['user']}' WHERE `this_id`={$dialog_id} ";	
            $query = $connection_handler->prepare($sql); //Подготавливаем запрос
            $query->execute();
            echo "Сообщение отправлено";   
    }

}
ob_end_flush();
?>

