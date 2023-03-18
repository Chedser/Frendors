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

$users_to_search = htmlspecialchars($_POST['users_to_search']);
$sorting = htmlspecialchars($_POST['sorting']);

if(!empty($users_to_search) && !empty($sorting)){

    $current_time = time(); // Время захода пользователя на страницу
    $sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
    $query = $connection_handler->prepare($sql); //Подготавливаем запрос
    $query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
    $query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
    $query->execute();   
    
    $sql = "SELECT * FROM `main_info` WHERE UPPER(`nickname`) LIKE UPPER('" . $users_to_search . "%') ORDER BY `{$sorting}` DESC"; 	
    $query = $connection_handler->prepare($sql); 
    $query->execute();
    $founded_users = $query->fetchAll(PDO::FETCH_ASSOC); 
    
    $response = "";
    
        if(count($founded_users) > 0){ // Пользователи
        
        $response = '{"users":[';
          
        for($i = 0; $i < count($founded_users); $i++){
        
          $sql = "SELECT `avatar` FROM `additional_info` WHERE `nickname`='" . $founded_users[$i]['nickname'] . "'"; 	
          $query = $connection_handler->prepare($sql); 
          $query->execute();
          $avatar = $query->fetchAll(PDO::FETCH_ASSOC);
          $avatar = $avatar[0]['avatar'];
          
          $wait_for_add_friend = 'true'; // Кнопка ждем подтверждения
          $doebat = 'true';
          $button = 'vbratki'; // Кнопка уничтожить/вбратки
          $online = 'true';
          
        if(($current_time - $founded_users[$i]['last_action_time']) > 180){
            $online = 'false';     
         }    
         
             /* ПРОВЕРЯЕМ ЕСТЬ ЛИ ЗАПРОСЫ В ДРУЗЬЯ */
            $sql = "SELECT * FROM `friend_requests` WHERE (`requester1`='" . $_SESSION['user'] . "' AND `requester2`='" . $founded_users[$i]['nickname'] . "') OR (`requester1`='" . $founded_users[$i]['nickname'] . "' AND `requester2`='" . $_SESSION['user'] . "')";
            $query = $connection_handler->prepare($sql); //Подготавливаем запрос
            $query->execute();
            $requests = $query->fetchAll(PDO::FETCH_ASSOC);    
            
            /* ПРОВЕРЯЕМ ЯВЛЯЕМСЯ ЛИ ДРУЗЬЯМИ */
            $sql = "SELECT * FROM `friends` WHERE (`friend1`='" . $_SESSION['user'] . "' AND `friend2`='" . $founded_users[$i]['nickname'] . "') OR (`friend1`='" . $founded_users[$i]['nickname'] . "' AND `friend2`='"  . $_SESSION['user'] . "')";	
            $query = $connection_handler->prepare($sql); //Подготавливаем запрос
            $query->execute();
            $friend = $query->fetchAll(PDO::FETCH_ASSOC); 
         
                    /* Проверяем является ли данный пользователь сессионным пользователем */
            if($founded_users[$i]['nickname'] === $_SESSION['user']){ // Отображаем только аву и ник
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
$response .= '{"nick":"' . $founded_users[$i]['nickname'] . '","avatar":"' . $avatar . '","online":"' . $online . '","wait_for_add_friend":"' . $wait_for_add_friend . '","button":"' . $button . '","doebat":"' . $doebat . '","id":"' .  $founded_users[$i]['user_id'] .  '"},';
        } //   for($i = 0; $i < count($founded_users); $i++)
  $response .= '{"users_count":"' . count($founded_users) . '"}]}';
   } //if(count($founded_users) > 0)
    
      else { // Пользователей не найдено
        $response .= '{"users":[{},{"users_count":"0"}]}';
   }

echo $response;    


}

ob_end_flush();
?>

