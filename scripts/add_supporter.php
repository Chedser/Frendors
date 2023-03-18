<?php
ob_start();
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
error_reporting(0);

if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

$supporter = trim(htmlspecialchars($_POST['supporter']));

if(!empty($supporter) && $_SESSION['user'] === 'Adminto'){

$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();  

// ПРОВЕРЯЕМ СУЩЕСТВУЕТ ЛИ ПОЛЬЗОВАТЕЛЬ
$sql = "SELECT * FROM `main_info` WHERE `nickname`='{$supporter}'";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$user = $query->fetchAll(PDO::FETCH_ASSOC);

$user_id = (int)$user[0]['user_id'];

// ПРОВЕРЯЕМ СУЩЕСТВУЕТ ЛИ ПОЛЬЗОВАТЕЛЬ
$sql = "SELECT * FROM `supporters` WHERE `user`='{$supporter}'";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$supporter_db = $query->fetchAll(PDO::FETCH_ASSOC);

if(!empty($user) && empty($supporter_db)){// ПОЛЬЗОВАТЕЛЬ СУЩЕСТВУЕТ И ЕГО НЕТ В БАЗЕ
 
 // ВСТАВЛЯЕМ ПОЛЬЗОВАТЕЛЯ В БД
    $sql = "INSERT INTO `supporters`(`user`,`id`) VALUES ('" . $supporter . "'," . $user_id . ")";
    $query = $connection_handler->prepare($sql);
    if($query->execute()){
        echo "Пользователь добавлен";
    }
    
    // ОПОВЕЩАЕМ ВСЕХ ПОЛЬЗОВАТЕЛЕЙ 
    $sql = "INSERT INTO `common_notice`(`noticer`,`type`) VALUES ('" . $supporter . "','add_supporter')";
    $query = $connection_handler->prepare($sql);
    $query->execute();

    // ОПОВЕЩАЕМ  ПОЛЬЗОВАТЕЛЯ 
    $sql = "INSERT INTO `notice`(`noticer`,`noticed`,`type`) VALUES ('green_bot','" . $supporter . "','add_supporter')";
    $query = $connection_handler->prepare($sql);
    $query->execute();
    
}else{
    echo "Пользователя не существует либо он уже есть в базе";
}

}

?>

<?php ob_end_flush(); ?>