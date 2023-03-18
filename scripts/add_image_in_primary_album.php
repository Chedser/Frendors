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

if(!preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([a-zA-Z0-9_\-.]{2,256})\.([a-zA-Z]{2,6})[\/]([a-zA-Z0-9_\/\-.?&;%=+])+(png|jpg|jpeg|gif)/is',$link)){
    echo "Данный тип ссылок не поддерживается";
}

$sql = "INSERT INTO `user_images_primary_album`(`user`,`link`) VALUES ('{$_SESSION['user']}','{$link}')";
            $query = $connection_handler->prepare($sql);
            $query->execute();
      
    $image_id = $connection_handler->lastInsertId();

    // ОПОВЕЩАЕМ ВСЕХ ПОЛЬЗОВАТЕЛЕЙ 
    $sql = "INSERT INTO `common_notice`(`noticer`,`multimedia_id`,`type`,`link`) VALUES ('" . $_SESSION['user'] . "'," . $image_id . ",'add_image_in_primary_album','" . $link . "')";
    $query = $connection_handler->prepare($sql);
     if($query->execute()) {
                echo "Картинка добавлена";
            }

}

?>

<?php ob_end_flush(); ?>