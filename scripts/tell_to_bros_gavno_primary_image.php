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

$image_id = (int)htmlspecialchars($_POST['image_id']);

if(!empty($image_id)){

$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();
    
/* ПРОВЕРЯЕМ СТАВИЛ ЛИ ПОЛЬЗОВАТЕЛЬ ДИЗЛАЙК */
$sql = "SELECT COUNT(*) AS `user_dislikes_count` FROM `primary_album_dislikes` WHERE `image_id`={$image_id} AND `disliker`='{$_SESSION['user']}'";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$user_dislikes_count = $query->fetchAll(PDO::FETCH_ASSOC);
$user_dislikes_count = (int)$user_dislikes_count[0]['user_dislikes_count'];
 
 /* ИЗВЛЕКАЕМ ИНФУ О КАРТИНКЕ */
$sql = "SELECT * FROM `user_images_primary_album` WHERE `this_id`={$image_id}";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);
$link = $result[0]['link'];
$whose_image = $result[0]['user'];
 
 $outp = '{"dislikes_count":';
 
if($user_dislikes_count == 0){ // Пользователь дизлайк не ставил

    /* Заносим лайк в БД */
$sql = "INSERT INTO `primary_album_dislikes`(`image_id`,`disliker`,`link`) VALUES ({$image_id},'{$_SESSION['user']}','{$link}')";	
$query = $connection_handler->prepare($sql);
$query->execute();

/* Отображаем все лайки на данном комменте */    
$sql = "SELECT COUNT(*) AS `dislikes_count` FROM `primary_album_dislikes` WHERE `image_id`={$image_id}";	
$query = $connection_handler->prepare($sql);
$query->execute();
$dislikes_count = $query->fetchAll(PDO::FETCH_ASSOC);      
$dislikes_count = $dislikes_count[0]['dislikes_count'];

$outp .= '"' . $dislikes_count . '",';

}else{
   $outp .= '"null",'; 
}

// ВСТАВЛЯЕМ КАРТИНКУ В ТАБЛИЦУ ПОСТОВ
    $sql = "INSERT INTO `wall_user_posts`(`page_id`,`nickname`,`post_sender_gavno`,`message`,`link`,`multimedia_id`,`whose_multimedia`,`type`) VALUES('{$_SESSION['user']}','{$_SESSION['user']}','{$_SESSION['user']}','{$link}','{$link}',{$image_id},'{$whose_image}','telled_gavno_primary_image')"; 
    $query = $connection_handler->prepare($sql);
    if($query->execute()){
        $outp .= '"status":"true"}';
    }else{
        $outp .= '"status":"false"}';
    } 

echo $outp;

    if($whose_image !== $_SESSION['user']){ // Картинку отправил не сессионный. Оповещаем отправителя 
        
            // ПРОВЕРЯЕМ ЕСТЬ ЛИ УЖЕ ОПОВЕЩЕНИЕ В ТАБЛИЦЕ
            $sql = "SELECT * FROM `notice` WHERE `multimedia_id`={$image_id} AND `is_gavno_teller`=1";
            $query = $connection_handler->prepare($sql);
            $query->execute();  
            $gavno_teller_notice = $query->fetchAll(PDO::FETCH_ASSOC);
            
            if(empty($gavno_teller_notice)){
        
                             // ВСТАВЛЯЕМ ОПОВЕЩЕНИЕ В ТАБЛИЦУ  
                             $sql = "INSERT INTO `notice`(`noticer`,`noticed`,`multimedia_id`,`link`,`type`,`is_gavno_teller`) VALUE ('{$_SESSION['user']}','{$whose_image}',{$image_id},'{$link}','telled_gavno_primary_image',1)";
                            $query = $connection_handler->prepare($sql);
                            $query->execute();  
                    
            }

 // ОПОВЕЩАЕМ ВСЕХ ПОЛЬЗОВАТЕЛЕЙ 
 $sql = "INSERT INTO `common_notice`(`noticer`,`whose_multimedia`,`multimedia_id`,`link`,`type`) VALUE ('{$_SESSION['user']}','{$whose_image}',{$image_id},'{$link}','telled_gavno_primary_image')";
 $query = $connection_handler->prepare($sql);
 $query->execute(); 

    }

   
}

ob_end_flush();

?>


