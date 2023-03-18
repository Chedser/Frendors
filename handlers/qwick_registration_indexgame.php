<?php 
ob_start();
?>

<?php
require_once '../scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
header("Content-type:text/plain;charset=utf-8");

if(empty($_SERVER['HTTP_REFERER'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

/* Главные параметры */
$nick = str_replace(" ","_",htmlspecialchars($_POST['nick']));
$email = htmlspecialchars($_POST['email']);
$pass = htmlspecialchars($_POST['pass']);
$pass_confirm = htmlspecialchars($_POST['pass_confirm']);    

/* ПРОВЕРЯЕМ ПУСТОЙ ЛИ НИК */
if(!empty($nick)){ // ПРИШЕЛ НЕПУСТОЙ НИК

/* ПРОВЕРЯЕМ СУЩЕСТВУЕТ ЛИ ТАКОЙ НИК */    
$sql = "SELECT nickname FROM main_info WHERE nickname = :nickname"; 
$query = $connection_handler->prepare($sql);
$query->bindParam(':nickname', $nick, PDO::PARAM_STR);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC); 

if(!empty($result)){ // НИК ЗАНЯТ
echo "Ник занят";
exit();
} else {  // НИК СВОБОДЕН

/* ПРОВЕРЯЕМ ПОЧТУ */    
if(empty($email)){ //Пришла пустая почта
echo  "Пустой email";
exit();
} else { // НЕПУСТАЯ ПОЧТА
/* ПРОВЕРЯЕМ СУЩЕСТВУЕТ ЛИ ПОЧТА В БАЗЕ ДАННЫХ */
$sql = "SELECT email FROM main_info WHERE email = :email"; //Проверяем существует ли почта в базе данных
$query = $connection_handler->prepare($sql);    
$query->bindParam('email', $email, PDO::PARAM_STR);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);

if(!empty($result)){ //Почта занята
echo "Email занят";
exit();
} //Почта занята  
else {
/* ПРОВЕРЯЕМ ПАРОЛЬ */    

if(empty($pass)){ //Пришел пустой пароль
echo "Пустой пароль";
exit();
} else if(strlen($pass) < 6){ //Длина пароля меньше 6
echo "Длина пароля < 6";
exit();
} else {

/* ПРОВЕРЯЕМ ПОДТВЕРЖДЕНИЕ пароля */
if(empty($pass_confirm)){ // Пустое подтверждение пароля
echo "Пустое подтверждение парол";
exit();
} else if($pass !== $pass_confirm){ // Пароли не совпадают
echo "Пароли не совпадают";
exit();
} // Пароли не совпадают  
  else {
/* ПАРОЛЬ */
$options = [ // Массив, на основе, которого будет производиться хэширование
	'salt' => salt(),
	'cost' => 12
	];

$hash = password_hash($pass, PASSWORD_DEFAULT, $options); // Хэшируем пароль пользователя	

/* Вставляем главные данные в таблицу */
$data_main = array($nick, $email, $hash,'elephant',1);
$sql_main = "INSERT INTO main_info(nickname,email,password,reg_type,is_new_user) VALUES (?, ?, ?, ?, ?)";	
$query_main = $connection_handler->prepare($sql_main); //Подготавливаем запрос

$query_main_execution = $query_main->execute($data_main);

/* СОЗДАЕМ ПАПКУ ДЛЯ ПОЛЬЗОВАТЕЛЯ*/
chdir('../users/');//Переходим в папку users    
$dir = 'zs' . $last_insert_id . '/'; // Папка пользователя 

if(!file_exists($dir)){ // Создаем папку пользователя
mkdir($dir, 0777,true); //.. создаём эту папку
}

/* ИЗВЛЕКАЕМ АЙДИ ПОЛЬЗОВАТЕЛЯ ИЗ БАЗЫ */
/** Будет использоваться при восстановлении пароля **/    
$sql = "SELECT user_id from main_info WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $nick, PDO::PARAM_STR);
$query->execute();
$user_id = $query->fetchAll(PDO::FETCH_ASSOC);
$user_id = $user_id[0]['user_id'];

/* Добавляем инфу в таблицу additional_info для авы*/    
$sql = "INSERT INTO `additional_info`(`nickname`,`user_id`) VALUES ('{$nick}',{$user_id})";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();

 echo "Поздравляем! Вы зарегестрированы!";     

                      } // Пароли совпадают 
                   } // Пришел непустой пароль
            } // Email свободен
    
        } // НЕПУСТАЯ ПОЧТА
    
} // НИК СВОБОДЕН     

} else { //ПРИШЕЛ ПУСТОЙ НИК
  echo "Пустой ник";  
exit();
}   

ob_end_flush();
?>
