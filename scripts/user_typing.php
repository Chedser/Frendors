<?php 
ob_start();
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
header("Content-Type: application/json; charset=UTF-8");

if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

$typing_status = (int)htmlspecialchars($_POST['typing_status'],ENT_QUOTES); 

if($typing_status == 0 || $typing_status == 1){
    
    $current_time = time(); // Время захода пользователя на страницу
    $sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
    $query = $connection_handler->prepare($sql); //Подготавливаем запрос
    $query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
    $query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
    $query->execute();    


    /* УЗНАЕМ ЕСТЬ ЛИ ПОЛЬЗОВАТЕЛЬ В ТАБЛИЦЕ */
    $sql = "SELECT * FROM `users_typing` WHERE `user_typing` = '{$_SESSION['user']}'"; 	
    $query = $connection_handler->prepare($sql); 
    $query->execute();
    $users_typing = $query->fetchAll(PDO::FETCH_ASSOC);

    if(empty($users_typing)){ // Пользавателя в базе нет
    
    $sql = "INSERT INTO `users_typing`(`user_typing`,`is_typing`) VALUES('{$_SESSION['user']}',{$typing_status})";	
    $query = $connection_handler->prepare($sql); 
    $query->execute();     

    } else { // В базе есть
        
    $sql = "UPDATE `users_typing` SET `is_typing`={$typing_status} WHERE `user_typing`='{$_SESSION['user']}'";	
    $query = $connection_handler->prepare($sql); 
    $query->execute();   
        
    }

    /* ИЗВЛЕКАЕМ ПЕЧАТАЮЩИХ ПОЛЬЗОВАТЕЛЕЙ  */
    $sql = "SELECT * FROM `users_typing` WHERE `is_typing`=1"; 	
    $query = $connection_handler->prepare($sql); 
    $query->execute();
    $users_typing = $query->fetchAll(PDO::FETCH_ASSOC);

    $outp = "";
    
    if(!empty($users_typing)){
        
        // Проверяем один ли там сессионный пользователь
        if(count($users_typing) == 1){ // Если один, то проверяем является ли сессионным
                
                if($users_typing[0]['user_typing'] === $_SESSION['user']){ // Набирает только сессионный
                    $outp = '{"no_users":"true"}';
                } else {
            
                    $outp = '{"no_users":"false","users_typing":[{"nick":"' . $users_typing[0]['user_typing'] . '"}]}';            
                    
                }
                
              
                
                    } else { // Количество пользователей больше одного
                        
                        $outp = '{"no_users":"false","users_typing":[';
                        
                        for($i = 0; $i < count($users_typing); $i++){
                         
                             if($users_typing[$i]['user_typing'] === $_SESSION['user']){
                                 continue;
                             }
                            
                            $outp .= '{"nick":"' . $users_typing[$i]['user_typing'] . '"},';
                            
                        }
                        
                        $outp = substr($outp, 0, -1);
                        $outp .= "]}";                    
                    } 
        
    } else{ // Пользователей нет
       
       $outp = '{"no_users":"true"}';
    }
    
 echo $outp;    
    
} 

ob_end_flush();

?>