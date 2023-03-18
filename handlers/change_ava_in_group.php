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

$link = trim(htmlspecialchars($_POST['image']));
$group_id = $_POST['group_id'];

if(!empty($link) && !empty($group_id)){

$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();  

if(!preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([a-zA-Z0-9_\-.]{2,256})\.([a-zA-Z]{2,6})[\/]([a-zA-Z0-9_\/\-.?&;%=+])+(png|jpg|jpeg|gif)/is',$link)){
    echo "Данный тип ссылок не поддерживается";
}

$sql = "UPDATE  `group_info` SET `avatar`='{$link}' WHERE `this_id`={$group_id}";
            $query = $connection_handler->prepare($sql);
            if($query->execute()){
                echo "Картинка добавлена";
            }

}

?>

<?php ob_end_flush(); ?>