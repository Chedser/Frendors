<?php

header("Content-type: text/html; charset=utf-8");

define('DSN', 'mysql:host=localhost;dbname=db');
define('USER', '');
define('PASS', '');

try{
$connection_handler_games = new PDO(DSN, USER, PASS, array(PDO::ATTR_PERSISTENT => true)); // дескриптор подключения
$connection_handler_games->prepare("SET NAMES 'utf8'")->execute();
$connection_handler_games->prepare("SET CHARACTER SET 'utf8'")->execute();
$connection_handler_games->prepare("SET SESSION collation_connection = 'utf8_bin'")->execute();
}
catch(PDOException $e){
exit();
}

?>

