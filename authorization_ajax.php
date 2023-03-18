<?php 
ob_start();
session_start(); 

require_once 'scripts/connection.php';

if(empty($_SERVER['HTTP_REFERER'])){ // Пришли напрямую через строку браузера
header('Location: index.php; Content-type: text/plain; charset=utf-8');
exit();   
}

header("Content-Type: application/json; charset=UTF-8");

$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
$login = addslashes(htmlspecialchars($_POST['user_login']));
$password = addslashes(htmlspecialchars($_POST['user_password']));

$error = "Неверная пара логин-пароль"; 
$enter_user = true;

if(empty($login) || empty($password)){ // Пришел пустой логин
$enter_user = false;
} else if(!empty($login) && !empty($password)) { // Пришел непустой логин
/* ИЩЕМ EMAIL В БАЗЕ ДАННЫХ */    
 $sql = "SELECT nickname FROM main_info where email=:login"; 
    $query = $connection_handler->prepare($sql);
    $query->bindParam(':login', $login, PDO::PARAM_STR);
    $query->execute(); 
$result = $query->fetchAll(PDO::FETCH_ASSOC);
$nickname = $result[0]['nickname'];

if(empty($result)){ // Логин в базе не найден
$enter_user = false;
} else { // Логин в базе найден
/* СРАВНИВАЕМ ЛОГИН И ПАРОЛЬ */
 $sql = "SELECT password from main_info where email=:login"; // Извлекаем пароль из базы данных
    $query = $connection_handler->prepare($sql);
    $query->bindParam(':login', $login, PDO::PARAM_STR);
    $query->execute(); 
$result = $query->fetchAll(PDO::FETCH_ASSOC);

if(!empty($result)){ // Пришел непустой пароль из базы
$hashed_password = $result[0]['password']; // Захэшированный пароль в базе данных
if(!empty($password)){ // Пришел непустой пароль
    if(!password_verify($password, $hashed_password)){ // Если пароль и хэш не совпадают
           $enter_user = false; 
}
            }        
        }
    }    
}   

if($enter_user == false){

echo '{"auth_error":"' . $error . '"}';
} else {

$error = "Верная пара логин-пароль";
echo '{"auth_error":"' . $error . '"}';
    
}

?>

<?php ob_end_flush(); ?>