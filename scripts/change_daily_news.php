<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

 if(!empty($_SESSION['user'])){

            $sql = "SELECT * FROM `vips` WHERE `user`='{$_SESSION['user']}'";	
            $query = $connection_handler->prepare($sql); 
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

                if(empty($result)){
                    header('Location: index.php');
                    exit();
                }
}else{
    header('Location: index.php');
    exit();
} 

$header = htmlspecialchars($_POST['header']); 
$link = htmlspecialchars($_POST['link']);


if(!empty($header) && !empty($link)){

$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql);
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();    

if(!preg_match('/(^|[\n ])([\w]*?)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;#:%=+,])*)*)/is',$link)){
    echo "Неверный формат";
    exit();
}

$time_unix = time();

        //Проверяем время последней новости
        $sql = "SELECT * FROM `daily_news` ORDER BY `this_id` DESC";	
        $query = $connection_handler->prepare($sql); 
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $time_unix_in_db = (int)$result[0]['time_unix'];  
        $timedif = $time_unix - $time_unix_in_db;
        
             if($timedif >= 86400){ // Прошло больше суток с момента последнего вопроса
                    
                                        //Проверяем время последней новости
                    $sql = "SELECT * FROM `daily_news` WHERE `link`='{$link}'";	
                    $query = $connection_handler->prepare($sql); 
                    $query->execute();
                    $news_exist = $query->fetchAll(PDO::FETCH_ASSOC);
                    
                    if(empty($news)){
                            $sql = "INSERT INTO `daily_news`(`user`,`link`,`text`,`time_unix`) 
                            VALUES ('" . $_SESSION['user'] . "','" . $link . "','" . $header . "'," . $time_unix . ")";
                            $query = $connection_handler->prepare($sql);
                            if($query->execute()){
                                echo "Новость дня обновлена";
                                      
                                } 
                          
                          }else{

                              echo "Такая новость уже существует";
                              
                          }
                 
             }else{
                 $next_question_time = 86400 - $timedif;
                            
                echo "Следующую новость можно будет добавить через " .  $next_question_time . " секунд";
             }
        
}

?>

