<?php
ob_start();
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
header("Content-Type: application/json; charset=UTF-8");

if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: ../games/head_answers.php'); 
exit();   
}


$user_id = (int)htmlspecialchars($_POST['user_id']);

if(!empty($user_id)){

$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); 
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();
 
/* ИЩЕМ АЙДИ ПОЛЬЗОВАТЕЛЯ */
$sql = "SELECT * from main_info WHERE `user_id`={$user_id}";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);
$user_id = $result[0]['user_id'];
$marked = $result[0]['nickname'];
    
if($marked === $_SESSION['user']){
    exit();
}    
    
/* ПРОВЕРЯЕМ СТАВИЛ ЛИ ПОЛЬЗОВАТЕЛЬ ЛАЙК */
$sql = "SELECT * FROM `mark_as_pidor` WHERE `marked_id`={$user_id}";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$marked_count = $query->fetchAll(PDO::FETCH_ASSOC);
$marked_count = count($marked_count);
 
if($marked_count == 0){ // Пользователь лайк не ставил

    /* Заносим лайк в БД */
$sql = "INSERT INTO `mark_as_pidor`(`marker`,`marked`,`marked_id`) VALUES ('{$_SESSION['user']}','{$marked}',{$user_id})";	
$query = $connection_handler->prepare($sql);
$query->execute();

 // ВСТАВЛЯЕМ ОПОВЕЩЕНИЕ В ТАБЛИЦУ  
    $sql = "INSERT INTO `notice`(`noticer`,`noticed`,`type`) VALUE ('{$_SESSION['user']}','{$marked}','marked_as_pidor')";
    $query = $connection_handler->prepare($sql);
    $query->execute();  
                           
    /* Отображаем все лайки на данном комменте */    
$sql = "SELECT *  FROM `main_info` WHERE `user_id`={$user_id}";	
$query = $connection_handler->prepare($sql);
$query->execute();
$pidor = $query->fetchAll(PDO::FETCH_ASSOC);
$pidor = $pidor[0]['nickname']; 

       /* Добавляем сообщение в базу данных */ 
    $data_array = array($_SESSION['user'], 'mark_as_pidor', $pidor);
    $sql = "INSERT INTO wall_user_posts(nickname,type,page_id) VALUES(?,?,?) "; 
    $query = $connection_handler->prepare($sql);
    $query->execute($data_array);

} 

/* Отображаем все лайки на данном комменте */    
$sql = "SELECT COUNT(*) AS `mark_as_pidor_count` FROM `mark_as_pidor` WHERE `marked_id`={$user_id}";	
$query = $connection_handler->prepare($sql);
$query->execute();
$mark_as_pidor_count = $query->fetchAll(PDO::FETCH_ASSOC);      
$mark_as_pidor_count = $mark_as_pidor_count[0]['mark_as_pidor_count'];

echo $mark_as_pidor_count;

}

ob_end_flush();

?>


