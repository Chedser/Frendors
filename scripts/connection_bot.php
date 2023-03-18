<?php

require_once 'salt.php';

define('DSN', 'mysql:host=localhost;dbname=db');
define('USER', '');
define('PASS', '');

try{
$chb = new PDO(DSN, USER, PASS, array(PDO::ATTR_PERSISTENT => true)); // дескриптор подключения
$chb->prepare("SET NAMES 'utf8'")->execute();
$chb->prepare("SET CHARACTER SET 'utf8'")->execute();
$chb->prepare("SET SESSION collation_connection = 'utf8_bin'")->execute();

}
catch(PDOException $e){
die();
}

?>

