<?php

header("Content-type: text/html; charset=utf-8");

define('DSN_tortures', 'mysql:host=localhost;dbname=db');
define('USER_tortures', '');
define('PASS_tortures', '');

try{
$connection_handler_tortures = new PDO(DSN_tortures, USER_tortures, PASS_tortures, array(PDO::ATTR_PERSISTENT => true)); // дескриптор подключения
$connection_handler_tortures->prepare("SET NAMES 'utf8'")->execute();
$connection_handler_tortures->prepare("SET CHARACTER SET 'utf8'")->execute();
$connection_handler_tortures->prepare("SET SESSION collation_connection = 'utf8_bin'")->execute();

}
catch(PDOException $e){
exit();
}
?>


