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

$link = trim(htmlspecialchars($_POST['link']));

if(!empty($link)){

$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();  

//Проверяем есть ли такая ссылка таблице
 if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)([a-zA-Z0-9\-_]{1,256})/is', $link) === false &&
    preg_match('/(^|[\n ])([\w]*?)(\/\/vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=])+/is', $link) === false /* &&
     preg_match('/(^|[\n ])([\w]*?)(\/\/pornhub\.com\/view_video\.php\?viewkey=)([a-zA-Z0-9&-=])+/is', $link) === false */ &&
     preg_match('/(^|[\n ])([\w]*?)(\/\/)?((rt\.)?pornhub\.com\/view_video\.php\?viewkey=)([a-zA-Z0-9&-=])+/is', $link) === false){
    echo "Данный тип ссылок не поддерживается";
    exit();
} 

// Узнаем количество видио, добавленных пользователем
$sql = "SELECT * FROM `common_videos` WHERE `user`='{$_SESSION['user']}'";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$user_videos = $query->fetchAll(PDO::FETCH_ASSOC);

if(count($user_videos) < 3){

// Узнаем количество ВСЕХ картинок
$sql = "SELECT * FROM `common_videos`";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$all_videos = $query->fetchAll(PDO::FETCH_ASSOC);

$add_video_flag = true;

for($i = 0; $i < count($all_videos); $i++){

    if($link === $all_videos[$i]['link']){
        echo "Одинаковые видио добавлять нехуй ибо либо вы либо кто-то другой уже добавил такую же картинку";
        $add_video_flag = false;
        break;
    }
    
}

if($add_video_flag){

// ВСТАВЛЯЕМ ВИДЕО В ТАБЛИЦУ
$sql = "INSERT INTO `common_videos`(`user`,`link`) VALUES ('{$_SESSION['user']}','{$link}')";
            $query = $connection_handler->prepare($sql);
            $query->execute();

$last_insert_id = $connection_handler->lastInsertId();

 // ОПОВЕЩАЕМ ВСЕХ ПОЛЬЗОВАТЕЛЕЙ 
    $sql = "INSERT INTO `common_notice`(`noticer`,`type`,`whose_multimedia`,`multimedia_id`,`link`) VALUES ('" . $_SESSION['user'] . "','add_common_video','" . $_SESSION['user'] . "'," . $last_insert_id . ",'" . $link . "')";
    $query = $connection_handler->prepare($sql);
    if($query->execute()){
        echo "Видио добавлено";
    }

}
    
} else{
    echo "Вы уже добавили 3 видио. Больше нехуй";
}

}

?>

<?php ob_end_flush(); ?>