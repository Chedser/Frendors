<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
header("Content-type: text/plain; charset='utf-8'");

if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

$user_to_delete = htmlspecialchars($_POST['user_id']); // Страница пользователя кого удаляем
$reason = htmlspecialchars($_POST['reason']); // Причина удаления

if(!empty($user_to_delete) && !empty($reason)){

$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();    

 $sql = "DELETE FROM `friends` WHERE (friend1=:friend1 AND friend2=:friend2) OR (friend1=:friend3 AND friend2=:friend4)";	
    $query = $connection_handler->prepare($sql); 
    $query->bindParam(':friend1', $_SESSION['user'], PDO::PARAM_STR);
    $query->bindParam(':friend2', $user_to_delete, PDO::PARAM_STR);
    $query->bindParam(':friend3', $user_to_delete, PDO::PARAM_STR);
    $query->bindParam(':friend4', $_SESSION['user'], PDO::PARAM_STR);
    $query->execute();

$kostil_for_reason = $reason;

$sql = "INSERT INTO `deleted_friends`(`deleter`,`deleted`,`reason`) VALUES('{$_SESSION['user']}','{$user_to_delete}','{$reason}')";	
$query = $connection_handler->prepare($sql); 
if($query->execute()){ echo "Пользователь получит сообщение, что вы удалили его из братков";}; 

$reason_for_description = "";
  
/* Уведомляем пользователя о том что его удалили  */
switch($kostil_for_reason){
    case 'doebal': $reasоn_for_description = "его доебали";
    break;
    case 'fufel': $reasоn_for_description = "фуфел";
    break;
    case 'pidr': $reasоn_for_description = "пидр";
    break;
}

$description = "Пользователь <a href = {$friend1}>{$friend1}</a> убрал вас из братков, потому что считает что вы " . $reasоn_for_description;

$sql = "INSERT INTO `notice`(`noticer`,`noticed`,`description`,`type`) VALUES('{$friend1}','{$user_to_deletes}','{$description}','delete_friend')";	
$query = $connection_handler->prepare($sql); 
$query->execute(); 




}

?>

