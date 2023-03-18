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

/* ПРОВЕРЯЕМ ЕСТЬ ЛИ ДИЗЛАЙКИ ПСОЛЕ ТОГО КАК ПОЛЬЗОВАТЕЛЬ ОТМЕНИЛ ЛАЙК */    
$sql = "SELECT * FROM `dislikes` WHERE `page`='{$page}' AND `post_id`={$post_id}";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$dislikes_count = $query->fetchAll(PDO::FETCH_ASSOC);      

if(count($dislikes_count) > 0){ //Лайки после улаоения есть

$dislikes_count = '[{"dislikes_count": "' . count($dislikes_count) . '"},';

//  ИЗВЛЕКАЕМ ПОСЛЕДНИХ 4-Х ЛАЙКЕРОВ 
$sql = "SELECT * FROM `dislikes` WHERE `post_id`={$post_id} AND `page`='{$page}' ORDER BY `date` DESC LIMIT 4";
$query = $connection_handler->prepare($sql); 
$query->execute();
$dislikers = $query->fetchAll(PDO::FETCH_ASSOC);      

$dislikers_imgs_output = $dislikes_count;

for($i = 0; $i < count($dislikers); $i++){
    
    //  ИЗВЛЕКАЕМ АВУ ЛАЙКЕРА 
$sql = "SELECT `avatar` FROM `additional_info` WHERE `nickname`='{$dislikers[$i]['disliker']}'";
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$disliker_img = $query->fetchAll(PDO::FETCH_ASSOC);
$disliker_img = $disliker_img[0]['avatar'];
    
$dislikers_imgs_output .= '{"disliker_img":"' . $disliker_img .  '","disliker_name":"' . $dislikers[$i]['disliker'] . '"},'; 

}

// Убираем последнюю запятую 
$dislikers_imgs_output = substr($dislikers_imgs_output, 0, -1);
 
$dislikers_imgs_output .= "]"; 
    
echo $dislikers_imgs_output;    


} else { //if(count($likes_count) > 0)

echo '[{"dislikes_count": "0"}]';
    
}

   
} // if(!empty($page) && !empty($post_id))
ob_end_flush();

?>


