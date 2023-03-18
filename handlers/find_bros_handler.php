<?php 
ob_start();
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

$online = htmlspecialchars($_POST['online']);
$sorting = htmlspecialchars($_POST['sorting']);

if(!empty($online) && !empty($sorting)){

$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();    

$response = '';

if($online === "false"){ // Отображаем всех пользователей

$sql = "SELECT main_info.nickname, main_info.last_action_time AS last_action_time,  additional_info.avatar FROM main_info INNER JOIN additional_info ON main_info.user_id=additional_info.user_id ORDER BY `{$sorting}` DESC";
    $query = $connection_handler->prepare($sql);
    $query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);
    
$sql = "SELECT COUNT(user_id) AS num_rows FROM main_info"; // Извлекаем всех братков
    $query = $connection_handler->prepare($sql);
    $query->execute();
$num_rows = $query->fetchAll(PDO::FETCH_ASSOC); // Получаем двумерный массив строк
 
$users_count  = $num_rows[0]['num_rows']; // Количество братков   

if($users_count > 0){
    
$response = '{"users":[';

for($i = 0; $i < $users_count; $i++ ){ // Отображаем пользователей
    if(!empty($result[$i]['avatar']) && !empty($result[$i]['nickname'])){    

$wait_for_add_friend = 'true'; // Кнопка ждем подтверждения
$doebat = 'true';
$button = 'vbratki'; // Кнопка уничтожить/вбратки
$online = 'true';

if(($current_time - $result[$i]['last_action_time']) > 180){
$online = 'false';     
 }

/* ПРОВЕРЯЕМ ЕСТЬ ЛИ ЗАПРОСЫ В ДРУЗЬЯ */
$sql = "SELECT * FROM `friend_requests` WHERE (`requester1`='" . $_SESSION['user'] . "' AND `requester2`='" . $result[$i]['nickname'] . "') OR (`requester1`='" . $result[$i]['nickname'] . "' AND `requester2`='" . $_SESSION['user'] . "')";
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$requests = $query->fetchAll(PDO::FETCH_ASSOC);    

/* ПРОВЕРЯЕМ ЯВЛЯЕМСЯ ЛИ ДРУЗЬЯМИ */
$sql = "SELECT * FROM `friends` WHERE (`friend1`='" . $_SESSION['user'] . "' AND `friend2`='" . $result[$i]['nickname'] . "') OR (`friend1`='" . $result[$i]['nickname'] . "' AND `friend2`='"  . $_SESSION['user'] . "')";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$friend = $query->fetchAll(PDO::FETCH_ASSOC);

/* Проверяем является ли данный пользователь сессионным пользователем */
if($result[$i]['nickname'] === $_SESSION['user']){ // Отображаем только аву и ник
$wait_for_add_friend = 'false';
$button = 'sessioner';
$doebat = 'false';
} else if(!empty($requests)) { // Проверяем отправляли ли ему заявку в друзья или он отправлялю Отправляем  кнопу ДОЕБАТЬ И кнопку ОТМЕНИТЬ
  $button = 'cancel_request';
} else { // Отображаем кнопки вбратки/уничтожить и ДОЕБАТЬ
$wait_for_add_friend = 'false';    
    // ПРОВЕРЯЕМ ЯВЛЯЕМСЯ ЛИ ДРУЗЬЯМИ    
    if(!empty($friend)){ // Являемся друзьями. Отображаем кнопу УНИЧТОЖИТЬ
      $button = 'delete_friend';  
    }
}

$response .= '{"nick":"' . $result[$i]['nickname'] . '","avatar":"' . $result[$i]['avatar'] . '","online":"' . $online . '","wait_for_add_friend":"' . $wait_for_add_friend . '","button":"' . $button . '","doebat":"' . $doebat . '"},';

            }
        }
    
    $response .= '{"users_count":"' . $users_count . '"}';
    
}
} // все пользователи

/****************************************************************************************************************************************************************************************************************/

else if($online === "true") { // ИЩЕМ ТЕХ КТО ОНЛАЙН

$sql = "SELECT main_info.nickname, main_info.last_action_time AS last_action_time,  additional_info.avatar FROM main_info INNER JOIN additional_info ON main_info.user_id=additional_info.user_id ORDER BY `{$sorting}` DESC";
    $query = $connection_handler->prepare($sql);
    $query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);
    
$sql = "SELECT COUNT(user_id) AS num_rows FROM main_info"; // Извлекаем всех братков
    $query = $connection_handler->prepare($sql);
    $query->execute();
$num_rows = $query->fetchAll(PDO::FETCH_ASSOC); // Получаем двумерный массив строк
 
$users_count  = $num_rows[0]['num_rows']; // Количество братков   
$users_online = 0;

if($users_count > 0){

for($i = 0; $i < $users_count; $i++ ){ // Количество пользователей онлайн
   
    if(!empty($result[$i]['avatar']) && !empty($result[$i]['nickname'])){    

if(($current_time - $result[$i]['last_action_time']) <= 180){
++$users_online;
        }
    }
}

$response = '{"users":[';

for($i = 0; $i < $users_count; $i++ ){ // Отображаем пользователей
   
    if(!empty($result[$i]['avatar']) && !empty($result[$i]['nickname'])){    

$wait_for_add_friend = true; // Кнопка ждем подтверждения

if(($current_time - $result[$i]['last_action_time']) <= 180){

$doebat = 'true';
$button = 'vbratki'; // Кнопка уничтожить/вбратки
$online = 'true';

/* ПРОВЕРЯЕМ ЕСТЬ ЛИ ЗАПРОСЫ В ДРУЗЬЯ */
$sql = "SELECT * FROM `friend_requests` WHERE (`requester1`='" . $_SESSION['user'] . "' AND `requester2`='" . $result[$i]['nickname'] . "') OR (`requester1`='" . $result[$i]['nickname'] . "' AND `requester2`='" . $_SESSION['user'] . "')";
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$requests = $query->fetchAll(PDO::FETCH_ASSOC);    

/* ПРОВЕРЯЕМ ЯВЛЯЕМСЯ ЛИ ДРУЗЬЯМИ */
$sql = "SELECT * FROM `friends` WHERE (`friend1`='" . $_SESSION['user'] . "' AND `friend2`='" . $result[$i]['nickname'] . "') OR (`friend1`='" . $result[$i]['nickname'] . "' AND `friend2`='"  . $_SESSION['user'] . "')";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$friend = $query->fetchAll(PDO::FETCH_ASSOC);

/* Проверяем является ли данный пользователь сессионным пользователем */
if($result[$i]['nickname'] === $_SESSION['user']){ // Отображаем только аву и ник
$wait_for_add_friend = 'false';
$button = 'sessioner';
$doebat = 'false';
} else if(!empty($requests)) { // Проверяем отправляли ли ему заявку в друзья или он отправлялю Отправляем только кнопу ДОЕБАТЬ.
  $button = 'cancel_request';
} else { // Отображаем кнопки вбратки/уничтожить и ДОЕБАТЬ
$wait_for_add_friend = 'false';    
    // ПРОВЕРЯЕМ ЯВЛЯЕМСЯ ЛИ ДРУЗЬЯМИ    
    if(!empty($friend)){ // Являемся друзьями. Отображаем кнопу УНИЧТОЖИТЬ
      $button = 'delete_friend';  
    }
}

$response .= '{"nick":"' . $result[$i]['nickname'] . '","avatar":"' . $result[$i]['avatar'] . '","online":"' . $online . '","wait_for_add_friend":"' . $wait_for_add_friend . '","button":"' . $button . '","doebat":"' . $doebat . '"},';

                }// if(($current_time - $result[$i]['last_action_time']) <= 180)
            } //   if(!empty($result[$i]['avatar']) && !empty($result[$i]['nickname']))
        } // for($i = 0; $i < $users_count; $i++ )
    
    $response .= '{"users_count":"' . $users_online . '"}';
    
    }  // if($users_count > 0)
} // ($online === "true")

$response .= ']}';

echo $response;

} // if(!empty($online))
ob_end_flush();
?>