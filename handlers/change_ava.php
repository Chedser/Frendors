<?php
ob_start();
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
header('Content-type: text/plain; charset=utf-8');

if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

if(!empty($_FILES)){
 
$sql = "SELECT user_id FROM main_info WHERE nickname = :nickname"; // Ищем id пользователя в базе
$query = $connection_handler->prepare($sql);    
$query->bindParam('nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);
$user_id = $result[0]['user_id'];

$upload_file = true; //Флаг загрузки файла    

$max_file_size = $_POST['MAX_FILE_SIZE']; //Размер файла
$upload_file_size = $_FILES['ava_file']['size'];
$upload_file_type = $_FILES['ava_file']['type'];
$upload_file_name = $_FILES['ava_file']['name'];
$upload_file_tmp_name = $_FILES['ava_file']['tmp_name'];   
$mimes = array("image/jpeg","image/png","image/gif");    

$txt = "";
if($upload_file_size > $max_file_size){ //Проверяем размер файла
        $txt .= "<p>Размер файла должен быть <= 3мБ</p>";
        $upload_file = false; //Не отправляем файл
        } 

    if(!in_array($upload_file_type,$mimes)){ // Проверяем тип файла
        $txt .= "<p>Данный тип файла не поддерживается.</p>";
        $upload_file = false; //Не отправляем файл
        }    

//ОТПРАВЛЯЕМ ФАЙЛ В ПАПКУ
if($upload_file == true){
    chdir("../users"); // Переходим в папку users
    $dir = 'zs' . $user_id . '/'; // Папка пользователя
    
    /*************************************************************************/
    
    if(!file_exists($dir)){
        mkdir($dir);
    }
    
     /*************************************************************************/
    
    $upload_file_name = $dir . basename($upload_file_name); // Файл пользователя  
    $ext = pathinfo($upload_file_name,PATHINFO_EXTENSION);
    $new_ava_name = $dir . "user_ava_". $user_id . "." . $ext;
    
    clearstatcache();
   move_uploaded_file($upload_file_tmp_name, $upload_file_name);
    rename($upload_file_name, $new_ava_name);
    $sql = "UPDATE additional_info SET avatar=:avatar WHERE user_id={$user_id}"; 
    $query = $connection_handler->prepare($sql);
    $query->bindParam(':avatar', $new_ava_name, PDO::PARAM_STR); // Добавляем новое имя в базу данных
    if($query->execute()){ 
    header("Location: ../user.php?zs={$_SESSION['user']}"); 
    exit();
    }
}

} else {
   echo "Файл не отправлен. Я не ебу почему";
}

ob_end_flush();
     
?>