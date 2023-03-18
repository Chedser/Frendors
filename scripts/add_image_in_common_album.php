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

if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([a-zA-Z0-9_\-.]{2,256})\.([a-zA-Z]{2,6})[\/]([a-zA-Z0-9_\/\-.?&;%=+])+(png|jpg|jpeg|gif)/is',$link) === false){
    echo "Данный тип ссылок не поддерживается";
    exit();
}

// Узнаем количество картинок, добавленных пользователем
$sql = "SELECT * FROM `common_images` WHERE `user`='{$_SESSION['user']}'";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$user_images = $query->fetchAll(PDO::FETCH_ASSOC);

if(count($user_images) < 3){

// Узнаем количество ВСЕХ картинок
$sql = "SELECT * FROM `common_images`";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$all_images = $query->fetchAll(PDO::FETCH_ASSOC);

$add_image_flag = true;

for($i = 0; $i < count($all_images); $i++){
    
    if($link === $all_images[$i]['link']){
        echo "Одинаковые картинки добавлять нехуй ибо либо вы либо кто-то другой уже добавил такую же картинку";
        $add_image_flag = false;
        break;
    }
    
}

if($add_image_flag){

$sql = "INSERT INTO `common_images`(`user`,`link`) VALUES ('{$_SESSION['user']}','{$link}')";
            $query = $connection_handler->prepare($sql);
            $query->execute();
            
$last_insert_id = $connection_handler->lastInsertId();

 // ОПОВЕЩАЕМ ВСЕХ ПОЛЬЗОВАТЕЛЕЙ 
    $sql = "INSERT INTO `common_notice`(`noticer`,`type`,`whose_multimedia`,`multimedia_id`,`link`) VALUES ('" . $_SESSION['user'] . "','add_common_image','" . $_SESSION['user'] . "'," . $last_insert_id . ",'" . $link . "')";
    $query = $connection_handler->prepare($sql);
    if($query->execute()){
        echo "Картинка добавлена";
    }    

}
    
} else{
    echo "Вы уже добавили 3 картинки. Больше нехуй";
}

}

?>

<?php ob_end_flush(); ?>