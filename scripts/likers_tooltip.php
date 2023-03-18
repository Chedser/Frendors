<?php
ob_start();
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
header("Content-type: text/plain; charset='utf-8'");

if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

$page = htmlspecialchars($_GET['page']);
$post_id = (int) htmlspecialchars($_GET['post_id']);

if(!empty($page) && !empty($post_id)){

/*  ИЩЕМ 10 ПОСЛЕДНИХ ЛАЙКЕРОВ НА ПОСТЕ   */    
$sql = "SELECT * FROM `likes` WHERE `page`='{$page}' AND `post_id`={$post_id} ORDER BY `date` DESC LIMIT 4";
$query = $connection_handler->prepare($sql);
$query->execute();
$likers = $query->fetchAll(PDO::FETCH_ASSOC);

$likers_output = "";  

for($i = 0; $i < count($likers); $i){

/* ИЩЕМ АВУ ЛАЙКЕРА */
$sql = "SELECT * FROM `additional_info` WHERE `nickname`='{$likers[$i]['liker']}' ";
$query = $connection_handler->prepare($sql);
$query->execute();
$liker_avatar = $query->fetchAll(PDO::FETCH_ASSOC);
$liker_avatar = $liker_avatar[0]['avatar'];

$likers_output .= '<a href = "user.php?zs=' . $likers[$i]['liker'] . '"><img class = "post_liker_img" src = "users/' .  $liker_avatar . '"  />';    
    
}

echo $likers_output;
}

ob_end_flush(); 
?>

