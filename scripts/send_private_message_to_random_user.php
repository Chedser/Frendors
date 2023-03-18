<?php
ob_start();

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

$message = htmlspecialchars($_POST['message']);

if(!empty($message) && !empty($_SESSION['user'])){
$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();    

/* ВЫБИРАЕМ ВСЕХ ПОЛЬЗОВАТЕЛЕЙ ИЗ БАЗЫ  */
$sql = "SELECT * FROM `main_info`";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$users = $query->fetchAll(PDO::FETCH_ASSOC);

/* КОЛИЧЕСТВО ПОЛЬЗОВАТЕЛЕЙ В БАЗЕ */
$sql = "SELECT COUNT(*) AS users_count FROM main_info";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$users_count = $query->fetchAll(PDO::FETCH_ASSOC);
$users_count = $users_count[0]['users_count'];

/* СОБИРАЕМ ВСЕ id в массив */
$users_array = array();
for($i = 0; $i < $users_count; $i++ ){
array_push($users_array,$users[$i]['user_id']);
    }

/* ВЫБИРАЕМ СЛУЧАЙНЫЙ АЙДИ */
$random_user_id = $users_array[mt_rand(0,count($users_array) - 1)];

/* ВЫБИРАЕМ ПОЛЬЗОВАТЕЛЯ СО СЛУЧАЙНЫМ АЙДИ */
$sql = "SELECT nickname  FROM main_info WHERE `user_id`='{$random_user_id}'";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$random_user = $query->fetchAll(PDO::FETCH_ASSOC);
$random_user = $random_user[0]['nickname'];

while($random_user === $_SESSION['user']){
/* ВЫБИРАЕМ СЛУЧАЙНЫЙ АЙДИ */
$random_user_id = $users_array[mt_rand(0,count($users_array) - 1)];

/* ВЫБИРАЕМ ПОЛЬЗОВАТЕЛЯ СО СЛУЧАЙНЫМ АЙДИ */
$sql = "SELECT nickname  FROM main_info WHERE `user_id`='{$random_user_id}'";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$random_user = $query->fetchAll(PDO::FETCH_ASSOC);
$random_user = $random_user[0]['nickname'];    
}


/* ПРОВЕРЯЕМ ЕСТЬ ЛИ ДИАЛОГ С ДАННЫМ ПОЛЬЗОВАТЕЛЕМ */
$sql = "SELECT * FROM `dialogs` WHERE (`initiator`='{$_SESSION['user']}' AND `joined`='{$random_user}') OR (`initiator`='{$random_user}' AND `joined`='{$_SESSION['user']}')";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$dialogs_with_user = $query->fetchAll(PDO::FETCH_ASSOC);

if(empty($dialogs_with_user)){ // ДИАЛОГ ЕЩЕ НЕ БЫЛ НАЧАТ
/* ДОБАВЛЯЕМ ДИАЛОГ В ТАБЛИЦУ dialogs */    
$sql = "INSERT INTO `dialogs`(`initiator`,`joined`,`last_message`) VALUES('{$_SESSION['user']}','{$random_user}','{$message}')";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$dialog_id = $connection_handler->lastInsertId();

/* ИЗВЛЕКАЕМ ДАТУ НАЧАЛА ДИАЛОГА ИЗ ТАБЛИЦЫ dialogs*/
$sql = "SELECT `date` FROM `dialogs` WHERE `initiator`='{$_SESSION['user']}' AND `joined`='{$random_user}'";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$date_begin_dialog = $query->fetchAll(PDO::FETCH_ASSOC);
$date_begin_dialog = $date_begin_dialog[0]['date'];

/* ВСТАВЛЯЕМ ДАТУ НАЧАЛА ДИАЛОГА В ТАБЛИЦУ `date_of_new_dialog` */
$sql = "INSERT INTO `date_of_new_dialog`(`dialog`) VALUES('{$dialog_id}')";	
$query = $connection_handler->prepare($sql); 
$query->execute();

/* ДОБАВЛЯЕМ УЧАСТНИКА В ТАБЛИЦУ dialogers */    
$sql = "INSERT INTO `dialogers`(`dialog`,`dialoger`,`last_message`) VALUES({$dialog_id},'{$random_user}','{$message}')";	
$query = $connection_handler->prepare($sql); 
$query->execute();

/* ДОБАВЛЯЕМ CООБЩЕНИЕ В БАЗУ `dialog_messages` */    
$sql = "INSERT INTO `dialog_messages`(`sender`, `dialog`, `message`) VALUES ('{$_SESSION['user']}',{$dialog_id},'{$message}')";	
$query = $connection_handler->prepare($sql); 
$query->execute();    
echo "Сообщение отправлено";

} else { // ДИАЛОГ УЖЕ БЫЛ НАЧАТ
/* УЗНАЕМ АЙДИ ДИАЛОГА*/
$sql = "SELECT * FROM `dialogs` WHERE (`initiator`='{$_SESSION['user']}' AND `joined`='{$random_user}') OR (`initiator`='{$random_user}' AND `joined`='{$_SESSION['user']}')";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$dialog_id = $query->fetchAll(PDO::FETCH_ASSOC);
$dialog_id = $dialog_id[0]['this_id'];

/* ДОБАВЛЯЕМ CООБЩЕНИЕ В БАЗУ `dialog_messages` */    
$sql = "INSERT INTO `dialog_messages`(`sender`, `dialog`, `message`) VALUES ('{$_SESSION['user']}',{$dialog_id},'{$message}')";	
$query = $connection_handler->prepare($sql); 
$query->execute();    

/* ОБНОВЛЯЕМ СООБЩЕНИЕ В ТАБЛИЦЕ  dialogers */    
$sql = "UPDATE `dialogers` SET `last_message`='{$message}', `is_finished`=0 WHERE `dialog`={$dialog_id}";	
$query = $connection_handler->prepare($sql); 
$query->execute();

/* ОБНОВЛЯЕМ ПОСЛЕДНЕЕ СООБЩЕНИЕ В ДИАЛОГЕ */    
$sql = "UPDATE `dialogs` SET `last_message`='{$message}', `is_finished`=0 WHERE `this_id`={$dialog_id} ";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
echo "Сообщение отправлено";   
    }

}

ob_end_flush();
?>





