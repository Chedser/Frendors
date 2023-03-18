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

 if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)([a-zA-Z0-9\-_]{1,256})/is', $link) === false &&
    preg_match('/(^|[\n ])([\w]*?)(\/\/vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=])+/is', $link) === false &&
    preg_match('/(^|[\n ])([\w]*?)(\/\/)?((rt\.)?pornhub\.com\/view_video\.php\?viewkey=)([a-zA-Z0-9&-=])+/is', $link) === false &&
    preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(ru.)?(redtube\.com\/)([0-9]{1,256})+/is',$link) === false
    ){
    exit();
}

$sql = "INSERT INTO `user_videos`(`user`,`link`) VALUES ('{$_SESSION['user']}','{$link}')";
            $query = $connection_handler->prepare($sql);
            if($query->execute()) {
                echo "Видио добавлено";
            }

}

?>

<?php ob_end_flush(); ?>