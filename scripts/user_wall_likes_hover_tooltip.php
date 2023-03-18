<?php
ob_start();
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
header("Content-Type: application/json; charset=UTF-8");

if(empty($_SERVER['HTTP_REFERER'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

$page = htmlspecialchars($_GET['page']);
$post_id = htmlspecialchars($_GET['post_id']);

if(!empty($page) && !empty($post_id)){ // Ставим лайк
$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();

$sql = "SELECT * FROM `likes` WHERE `page`='{$page}' AND `post_id`='{$post_id}'";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$likes_count = $query->fetchAll(PDO::FETCH_ASSOC);      

if(count($likes_count) > 0){ 

$likes_count = '[{"likes_count": "' . count($likes_count) . '"},';

//  ИЗВЛЕКАЕМ ПОСЛЕДНИХ 4-Х ЛАЙКЕРОВ 
$sql = "SELECT * FROM `likes` WHERE `post_id`={$post_id} AND `page`='{$page}' ORDER BY `date` DESC LIMIT 4";
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$likers = $query->fetchAll(PDO::FETCH_ASSOC);      

$likers_imgs_output = $likes_count;

for($i = 0; $i < count($likers); $i++){
    
    //  ИЗВЛЕКАЕМ АВУ ЛАЙКЕРА 
$sql = "SELECT `avatar` FROM `additional_info` WHERE `nickname`='{$likers[$i]['liker']}'";
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$liker_img = $query->fetchAll(PDO::FETCH_ASSOC);
$liker_img = $liker_img[0]['avatar'];
    
$likers_imgs_output .= '{"liker_img":"' . $liker_img .  '","liker_name":"' . $likers[$i]['liker'] . '"},'; 

}

// Убираем последнюю запятую 
$likers_imgs_output = substr($likers_imgs_output, 0, -1);
 
$likers_imgs_output .= "]"; 
    
echo $likers_imgs_output;    


} else { //if(count($likes_count) > 0)

echo '[{"likes_count": "0"}]';
    
}

     
} // if(!empty($page) && !empty($liker) && !empty($post_id))
ob_end_flush();

?>


