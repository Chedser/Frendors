<?php 
ob_start();
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
error_reporting(E_ALL);

if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

?>

<?php 

$straps_count = (int) htmlspecialchars(strip_tags(urlencode($_POST['straps_count'])));

if(!empty($straps_count)){
   
   // регистрационная информация (Идентификатор магазина, пароль #1)
$mrh_login = "tarahtel";
$mrh_pass1 = "DRviXb6b7w7F9F0abFkn"; /* Рабочий DRviXb6b7w7F9F0abFkn Тестовый oKQdkP97bqIj0zSg3Qr7 */
$is_test = 0;

/* ВСТАВЛЯЕМ ПРОБНЫЙ ЗАКАЗ В ТАБЛИЦУ */
$sql = "INSERT INTO `purchasing_counter`(`buyer`,`good`) VALUES('{$_SESSION['user']}','straps')";
    $query = $connection_handler->prepare($sql);
    $query->execute(); 

// номер заказа
$inv_id = $connection_handler->lastInsertId(); 

// описание заказа
$inv_desc = "Покупка погоны";

$out_summ = $straps_count;

// тип товара
$shp_item = "straps";

// язык
$culture = "ru";

// кодировка
$encoding = "utf-8"; 

/* ИЗВЛЕКАЕМ ПОЧТУ ПОКУПАТЕЛЯ */
$sql = "SELECT `email` FROM `main_info` WHERE `nickname`='{$_SESSION['user']}'";
    $query = $connection_handler->prepare($sql);
    $query->execute(); 
$email_sql = $query->fetchAll(PDO::FETCH_ASSOC);
$email_sql = $email_sql[0]['email'];

// Адрес электронной почты покупателя
$Email = $email_sql; // Взять из базы

$shp_login = $_SESSION['user'];

// формирование подписи
$crc  = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1:Shp_email=$Email:Shp_item=$shp_item:Shp_login=$shp_login");
   
  /* echo "Логин: " . $mrh_login . "<br />" . 
   "Пароль: " . $mrh_pass1 . "<br />" .
   "Номер заказа: " . $inv_id . "<br />" .
   "Описание покупки: " . $inv_desc . "<br />" .
   "Логин пользователя: " . $shp_login . "<br />"  .
   "Тип товара: " . $shp_item . "<br />" .
   "Сумма к оплате: " . $out_summ . "<br />" .
   "Культура: " . $culture . "<br />" .
   "Кодировка: " . $encoding . "<br />" .
   "Мыло:" . $Email . "<br />";*/
   
    header("Location: http://auth.robokassa.ru/Merchant/Index.aspx?MrchLogin=" . $mrh_login . 
    "&OutSum=" . $out_summ .
    "&InvId=" . $inv_id .
    "&Desc=" . $inv_desc .
    "&SignatureValue=" . $crc .
    "&Culture=" . $culture . 
    "&Encoding=" . $encoding . 
    "&Shp_email=" . $Email . 
    "&Shp_item=" . $shp_item .
    "&Shp_login=" . $shp_login . 
    "&IsTest=" . $is_test);
}

?>

<?php ob_end_flush(); ?>