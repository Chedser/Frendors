<?php 
ob_start();
session_start(); 

require_once 'scripts/connection.php';

if(empty($_SERVER['HTTP_REFERER'])){ // Пришли напрямую через строку браузера
header('Location: index.php');
exit();   
}

header('Content-type:text/html; charset=utf-8');

$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
$login = addslashes(htmlspecialchars($_POST['user_login']));
$password = addslashes(htmlspecialchars($_POST['user_password']));

$error = "Неверная пара логин-пароль"; 
$enter_user = true;

if(empty($login) && empty($password)){ // Пришел пустой логин
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

if(!empty($result)){ // Пришел непустой ответ
$hashed_password = $result[0]['password']; // Захэшированный пароль в базе данных
if(!empty($password)){ // Пришел непустой пароль
    if(password_verify($password, $hashed_password)){ // Если пароль и хэш совпадают
            $_SESSION['user'] = $nickname; // Создаем переменную сессии
         
             setcookie("user", $nickname, time()+60*60*24*30);   
            
            header('Location: user.php?zs=' . $nickname); // Редиректим на страницу пользователя.
            exit();
      
}else { //Неверный пароль
$enter_user = false;   
                } //  Неверный пароль
            }        
        }
    }    
}   

if($enter_user == false){
echo $error . " <a href = # onclick = window.history.go(-1)>Назад</a>";

}

?>

<?php ob_end_flush(); ?>