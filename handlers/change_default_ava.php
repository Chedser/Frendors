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

if(empty($_FILES['default_ava_file']['name'])){ // Файл не отправлен
header("Location:{$_SERVER['HTTP_REFERER']}");
exit();    
} 

$upload_file = true; //Флаг загрузки файла   
 
$max_file_size = $_POST['MAX_FILE_SIZE']; //Размер файла
$upload_file_size = $_FILES['default_ava_file']['size'];
$upload_file_type = $_FILES['default_ava_file']['type'];
$upload_file_tmp_name = $_FILES['default_ava_file']['tmp_name'];   
$mimes = array("image/jpeg");    

$txt = "";
if($upload_file_size > $max_file_size){ //Проверяем размер файла
        $txt .= "<p>Размер файла должен быть <= 30мБ</p>";
        $upload_file = false; //Не отправляем файл
        } 

    if(!in_array($upload_file_type,$mimes)){ // Проверяем тип файла
        $txt .= "<p>Данный тип файла не поддерживается.</p>";
        $upload_file = false; //Не отправляем файл
        }    

//ОТПРАВЛЯЕМ ФАЙЛ В ПАПКУ
if($upload_file == true){
    chdir("../users"); // Переходим в папку users
    $upload_file_name = basename($_FILES['default_ava_file']['name']); // Файл пользователя  
    $ext = pathinfo($upload_file_name,PATHINFO_EXTENSION);
    $new_ava_name = "default_ava." . $ext;
    
    clearstatcache();
    if(move_uploaded_file($upload_file_tmp_name, $upload_file_name)){echo "Норм";} else {echo "Не норм";};
    rename($upload_file_name, $new_ava_name);
   
ob_end_flush();
exit();    
} 
     
?>