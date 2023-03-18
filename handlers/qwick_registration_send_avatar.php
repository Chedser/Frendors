<?php
ob_start();
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
header('Content-type: text/plain; charset=utf-8');

if(empty($_SERVER['HTTP_REFERER'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

$nick = htmlspecialchars($_POST['nick']);
$max_file_size = $_POST['MAX_FILE_SIZE'];
$avatar = htmlspecialchars($_FILES['avatar']);

if(!empty($nick) && !empty($avatar) && !empty($max_file_size)){

$sql = "SELECT user_id FROM main_info WHERE nickname = :nickname"; // Ищем id пользователя в базе
$query = $connection_handler->prepare($sql);    
$query->bindParam('nickname', $nick, PDO::PARAM_STR);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);
$user_id = $result[0]['user_id'];

if(!empty($user_id)){

$avatar_size = $avatar['size'];
$avatar_type = $avatar['type'];
$avatar_tmp_name = $avatar['tmp_name'];   
$avatar_name = $avatar['name']; 
$mimes = array("image/jpeg","image/png","image/gif");

if($avatar_size > $max_file_size){ //Проверяем размер файла
        echo "Размер файла должен быть <= 5 мБ</p>";
        exit();
} else
        if(!in_array($avatar_type,$mimes)){ // Проверяем тип файла
        echo "Данный тип файла не поддерживается";
        exit();
        }    

//ОТПРАВЛЯЕМ ФАЙЛ В ПАПКУ
    chdir("../users"); // Переходим в папку users
    $dir = 'zs' . $user_id . '/'; // Папка пользователя
    $upload_file_name = $dir . basename($avatar_name); // Файл пользователя  
    $ext = pathinfo($upload_file_name,PATHINFO_EXTENSION);
    $new_ava_name = $dir . "user_ava_". $user_id . "." . $ext;
    
    clearstatcache();
   if(move_uploaded_file($avatar_name, $upload_file_name)){echo "Ава загружена";};
    rename($upload_file_name, $new_ava_name);
    $sql = "UPDATE `additional_info` SET `avatar`=:avatar WHERE `nickname`='{$nick}'"; 
    $query = $connection_handler->prepare($sql);
    $query->bindParam(':avatar', $new_ava_name, PDO::PARAM_STR); // Добавляем новое имя в базу данных
    $query->execute();

} // if(!empty($user_id))

} //if(!empty($nick) && !empty($avatar) && !empty($max_file_size))
 
 ob_end_flush();
?>