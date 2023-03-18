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

$image_id = trim(htmlspecialchars($_POST['image_id']));
$image_of_user_album = trim(htmlspecialchars($_POST['image_of_user_album']));

if(!empty($image_id)){

$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();  

$which_album = "user_images_primary_album";

if($image_of_user_album !== 'true'){ // Добавлено из первичного альбома

 $sql = "SELECT * FROM `{$which_album}` WHERE `this_id`={$image_id}";
        $query = $connection_handler->prepare($sql);
        $query->execute();
        $image_info = $query->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($image_info)){
            
            $sql = "INSERT INTO `user_images_primary_album`(`user`,`link`) VALUES ('{$_SESSION['user']}','" . $image_info[0]['link'] . "')";
            $query = $connection_handler->prepare($sql);
            if($query->execute()) {
                echo "Картинка добавлена";
            } else{
                
                echo "Добавить в первичный";
                
            }
         
        }

} else{ // Из созданного альбома
    
    $which_album = "images_in_user_album";
    
     $sql = "SELECT * FROM `{$which_album}` WHERE `this_id`={$image_id}";
        $query = $connection_handler->prepare($sql);
        $query->execute();
        $image_info = $query->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($image_info)){
            
            $sql = "INSERT INTO `user_images_primary_album`(`user`,`link`) VALUES ('{$_SESSION['user']}','" . $image_info[0]['link'] . "')";
            $query = $connection_handler->prepare($sql);
            if($query->execute()) {
                echo "Картинка добавлена";
            } else{
                
                echo "Добавить в первичный";
                
            }
         
        }
    
}
    
    
    
}

?>

<?php ob_end_flush(); ?>