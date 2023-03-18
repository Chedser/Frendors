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

$id = (int) htmlspecialchars($_POST['id']); // Айди помощника
$header = htmlspecialchars($_POST['header']);
$text = htmlspecialchars($_POST['text']);

if(!empty($id) && !empty($header) && !empty($text) ){

$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();  

/****************************************************************************************************/

$time_unix = time();

// ПРОВЕРЯЕМ СУЩЕСТВУЕТ ЛИ ПОЛЬЗОВАТЕЛЬ В ГЛАВНОЙ БАЗЕ
$sql = "SELECT * FROM `main_info` WHERE `user_id`={$id}";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$user = $query->fetchAll(PDO::FETCH_ASSOC);
$user = $user[0]['nickname'];

    if(!empty($user) && $_SESSION['user'] !== $user){
     
             // ПРОВЕРЯЕМ ЕСТЬ ЛИ ВОПРОСЫ К ПОЛЬЗОВАТЕЛЮ
        $sql = "SELECT * FROM `user_questions` WHERE `user`='{$user}' ORDER BY `this_id` DESC";	
        $query = $connection_handler->prepare($sql); 
        $query->execute();
        $user_questions = $query->fetchAll(PDO::FETCH_ASSOC);
        
            if(empty($user_questions)){
        
                     // ВСТАВЛЯЕМ ПОЛЬЗОВАТЕЛЯ В БД
                    $sql = "INSERT INTO `user_questions`(`asker`,`user`,`question_header`,`question_text`,`time_unix`) 
                    VALUES ('" . $_SESSION['user'] . "','" . $user  . "','" . $header . "','" . $text . "'," . $time_unix . ")";
                    $query = $connection_handler->prepare($sql);
                    if($query->execute()){
                        echo "Вопрос задали нахуй! Вы получите оповещение об ответе";
                } 
        
          }else{
              $time_unix_in_db = $user_questions[0]['time_unix'];
              $timedif = $time_unix - $time_unix_in_db;
     
                          if($timedif >= 86400){ // Прошло больше суток с момента последнего вопроса
                            // ВСТАВЛЯЕМ ПОЛЬЗОВАТЕЛЯ В БД
                            $sql = "INSERT INTO `user_questions`(`asker`,`user`,`question_header`,`question_text`,`time_unix`) 
                            VALUES ('" . $_SESSION['user'] . "','" . $user . "','" . $header . "','" . $text . "'," . $time_unix . ")";
                            $query = $connection_handler->prepare($sql);
                            if($query->execute()){
                                echo "Вопрос задали нахуй! Вы получите оповещение об ответе";
                                      
                                } 
                          
                          }else{
                              $next_question_time = 86400 - $timedif;
                            
                              echo "Следующий вопрос можно будет задать через " .  $next_question_time . " секунд";
                              
                          }
              
          } 
        
    }

}

/****************************************************************************************************/




?>

<?php ob_end_flush(); ?>