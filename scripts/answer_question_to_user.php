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

$id = (int) htmlspecialchars($_POST['id']);
$text =  htmlspecialchars($_POST['text']);

if(!empty($id) && !empty($text)){

$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();  


//  ОТВЕЧАЕМ НА ВОПРОС
$sql = "UPDATE `user_questions` SET `answer_text`='{$text}',`is_answered`=1 WHERE `this_id`={$id}";	
$query = $connection_handler->prepare($sql); 
if($query->execute()){
    echo "На вопрос ответили нахуй! Пользователь получит оповещение";
}

}

?>

<?php ob_end_flush(); ?>