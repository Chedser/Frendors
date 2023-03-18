<?php

header("Content-type: text/html; charset=utf-8");

define('DSN_regards', 'mysql:host=localhost;dbname=db');
define('USER_regards', '');
define('PASS_regards', '');

try{
$connection_handler_regards = new PDO(DSN_regards, USER_regards, PASS_regards, array(PDO::ATTR_PERSISTENT => true)); // дескриптор подключения
$connection_handler_regards->prepare("SET NAMES 'utf8'")->execute();
$connection_handler_regards->prepare("SET CHARACTER SET 'utf8'")->execute();
$connection_handler_regards->prepare("SET SESSION collation_connection = 'utf8_bin'")->execute();
}
catch(PDOException $e){
exit();
}
?>

