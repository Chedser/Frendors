<?php
ob_start();
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
error_reporting(0);

if(empty($_SERVER['HTTP_REFERER'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

header("Content-type: application/json; charset='utf-8'");

$image_id = (int) htmlspecialchars($_POST['image_id']);
$next_image_id = (int) htmlspecialchars($_POST['next_image_id']);
$prev_image_id = (int) htmlspecialchars($_POST['prev_image_id']);
$after_deleting =  htmlspecialchars($_POST['after_deleting']);

if(!empty($image_id) && !empty($next_image_id) && !empty($after_deleting)){

$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();  

        if($after_deleting === "false"){ // Картинку не удаляли
             $sql = "SELECT * FROM `common_images` WHERE `this_id`={$image_id}";	
            $query = $connection_handler->prepare($sql);
            $query->execute();
            $image_info = $query->fetchAll(PDO::FETCH_ASSOC);
         
            if(!empty($image_info)){ // Такая картинка существует
            
            $sql = "SELECT * FROM `common_images` WHERE `this_id`<{$image_id} ORDER BY `this_id` DESC";	
            $query = $connection_handler->prepare($sql);
            $query->execute();
            $next_image = $query->fetchAll(PDO::FETCH_ASSOC);
            
            if(!empty($next_image)){ 
                
                echo '{"image_id":"' . $next_image[0]['this_id'] . '"}';
                
            }else{
                
                echo '{"image_id":"' . $image_id . '"}';
                
            }
        
        }
        
    } else{ // Картинку удалили

            $sql = "SELECT * FROM `common_images` WHERE `this_id`={$next_image_id}";	
            $query = $connection_handler->prepare($sql);
            $query->execute();
            $image_info = $query->fetchAll(PDO::FETCH_ASSOC);
               
            if(!empty($image_info)){ // Картинки есть
                  echo '{"image_id":"' . $image_info[0]['this_id'] . '"}';
               } else{ // Картинок нет
                   echo '{"image_id":"empty"}';
            }
    }

}

if(!empty($image_id) && !empty($prev_image_id) && !empty($after_deleting)){

$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();  

        if($after_deleting === "false"){ // Картинку не удаляли
             $sql = "SELECT * FROM `common_images` WHERE `this_id`={$image_id}";	
            $query = $connection_handler->prepare($sql);
            $query->execute();
            $image_info = $query->fetchAll(PDO::FETCH_ASSOC);
         
            if(!empty($image_info)){ // Такая картинка существует
            
            $sql = "SELECT * FROM `common_images` WHERE `this_id`>{$image_id} ORDER BY `this_id` DESC";	
            $query = $connection_handler->prepare($sql);
            $query->execute();
            $prev_image = $query->fetchAll(PDO::FETCH_ASSOC);
            
            if(!empty($prev_image)){ 
                
                echo '{"image_id":"' . $prev_image[0]['this_id'] . '"}';
                
            }else{
                
                echo '{"image_id":"' . $image_id . '"}';
                
            }
        
        }
        
    } else{ // Картинку удалили

            $sql = "SELECT * FROM `common_images` WHERE `this_id`={$prev_image_id}";	
            $query = $connection_handler->prepare($sql);
            $query->execute();
            $image_info = $query->fetchAll(PDO::FETCH_ASSOC);
               
            if(!empty($image_info)){ // Картинки есть
                  echo '{"image_id":"' . $image_info[0]['this_id'] . '"}';
               } else{ // Картинок нет
                   echo '{"image_id":"empty"}';
            }
    }

}
?>

<?php ob_end_flush(); ?>