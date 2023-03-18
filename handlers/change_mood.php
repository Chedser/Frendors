<?php
ob_start();
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
header('Content-type: text/plain; charset=utf-8');

if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

$mood = $_GET['mood'];

if(!empty($mood)){

$sql = "UPDATE `additional_info` SET `mood`='{$mood}' WHERE `nickname`='{$_SESSION['user']}'";
$query = $connection_handler->prepare($sql);    
if($query->execute()) {
switch($mood){
   case 'ahuenno': $mood = 'Ахуенно';
                   break;
    case 'smeyus': $mood = 'Сижу и смеюсь';
                   break;               
    case 'horoshee': $mood = 'Хорошее сразу';
                   break;               
    case 'kak_ptichka': $mood = 'Как птичка гадит';
                   break;               
    case 'kak_zemlya': $mood = 'Как земля';
                   break;
    case 'ploho_stalo': $mood = 'Плохо стало';
                   break;               
    case 'vsyo_ravno': $mood = 'Да мне вообще все равно';
                   break;
    default: $mood = 'Любое';               
    
}};
echo $mood;
}

?>