<?php 
ob_start();
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
header("Content-Type: application/json; charset=UTF-8");

$group_name = htmlspecialchars($_POST['name']); //Получаем запрос из формы. 

 if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: ../games/head_answers.php'); 
exit();   
} 

if(!empty($group_name)){

$response = "";    
    
    if(strlen($group_name) == 0){ // Если длина строки 2<
        $response = '{"server_response":"empty"}';
    }else{

           try{
            $sql = "INSERT INTO `group_info`(`admin`,`name`) VALUE ('{$_SESSION['user']}','{$group_name}')";
            $query = $connection_handler->prepare($sql);
            $query->execute(); 
            
            $group_id = $connection_handler->lastInsertId();
             $sql = "INSERT INTO `group_members`(`group_id`,`member`,`is_admin`) VALUE ({$group_id},'{$_SESSION['user']}',1)";
            $query = $connection_handler->prepare($sql);
            $query->execute(); 
            
            $response ='{"server_response":"success"}';
           
                     // ОПОВЕЩАЕМ ВСЕХ ПОЛЬЗОВАТЕЛЕЙ 
            $sql = "INSERT INTO `common_notice`(`noticer`,`type`,`group_id`,`group_name`) VALUES ('" . $_SESSION['user'] . "','create_group',{$group_id},'{$group_name}')";
            $query = $connection_handler->prepare($sql);
            $query->execute();
                }catch(Exception $e){
                    $response = '{"server_response":"unknoun_error"}';
                }
                

$connection_handler = null; // Закрываем соединение с базой данных 
}

  
 echo $response;
        
    }
ob_end_flush();
?>