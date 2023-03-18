<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
header("Content-type: text/plain; charset='utf-8'");

if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

header("Content-Type: application/json; charset=UTF-8");

$user_id = (int)htmlspecialchars($_POST['user_id']); //  Тот кто ОТПРАВЛЯЕТ запрос

if(!empty($user_id)){
$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();    
   
$sql = "SELECT * FROM `main_info` WHERE `user_id`={$user_id}";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':user_id', $user_id, PDO::PARAM_STR);
$query->execute(); 
$requester1 = $query->fetchAll(PDO::FETCH_ASSOC); 
$requester1 = $requester1[0]['nickname']; // Тот кто отправил заявку
   
$sql = "SELECT * FROM `friend_requests` WHERE `requester1`='{$requester1}' AND `requester2`='{$_SESSION['user']}'";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':user_id', $user_id, PDO::PARAM_STR);
$query->execute(); 
$request = $query->fetchAll(PDO::FETCH_ASSOC); 

if(!empty($request)){

 $sql = "INSERT INTO `friends`(`friend1`,`friend2`) VALUES (:friend1,:friend2)";	
    $query = $connection_handler->prepare($sql); //Подготавливаем запрос
    $query->bindParam(':friend1', $requester1, PDO::PARAM_STR);
    $query->bindParam(':friend2', $_SESSION['user'] , PDO::PARAM_STR);
    if($query->execute()){
        echo '{"status":"true"}';
    }
    
     $data_array = array($_SESSION['user'], 'add_friend', $requester1);
                        $sql = "INSERT INTO wall_user_posts(nickname,type,page_id) VALUES(?,?,?)"; 
                        $query = $connection_handler->prepare($sql);
                        $query->execute($data_array);
    
    $sql = "DELETE FROM `friend_requests` WHERE `requester1`=:requester1 AND `requester2`=:requester2";	
    $query = $connection_handler->prepare($sql); //Подготавливаем запрос
    $query->bindParam(':requester1', $requester1, PDO::PARAM_STR);
    $query->bindParam(':requester2', $_SESSION['user'], PDO::PARAM_STR);
    $query->execute();

/****************************************************************************************************************/

// ОПОВЕЩАЕМ ПОЛЬЗОВАТЕЛЯ О ТОМ, ЧТО ДОБАВИЛИ ЕГО В ДРУЗЬЯ 
$description = "<a href = user.php?zs={$_SESSION['user']}>{$_SESSION['user']}</a> принял вашу заявку вбратки";

$sql = "INSERT INTO `notice`(`noticer`,`noticed`,`description`,`type`) VALUE ('{$_SESSION['user']}','{$requester2}','{$description}','confirm_friend_request')";
$query = $connection_handler->prepare($sql);
$query->execute();  

// ВСТАВЛЯЕМ ОПОВЕЩЕНИЕ В ТАБЛИЦУ ОБЩИХ ОПОВЕЩЕНИЙ 
        $sql = "INSERT INTO `common_notice`(`noticer`,`description`,`type`,`friend_sender`,`friend_getter`) VALUE ('{$_SESSION['user']}','empty','confirm_friend_request','{$requester1}','{$_SESSION['user']}')";
        $query = $connection_handler->prepare($sql);
        $query->execute();     

}else{
    echo '{"status":"false"}';
}
    
}

?>

