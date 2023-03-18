<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

/* Вставляем имена в массив */
$no_ava_users = array('Цаплис','artemzuru','huy','phallita','patapon','Fufelpro777',
					'Браток','веселыйфуфел','1234','Avianosec228','Черпак','герасим',
					'Petro','Avianosec228','Черпак','герасим','Petro','fuckniga','Butcher',
					'DanSolodov','alexx','Сухарь','fraer','SubarcticTwo87','гшршррр','КапитанКонтрСтарй',
					'Spacew0w','drozdpidr','Шлосхель Баренмейер');
for($i = 0; $i < count($no_ava_users); $i++){
	$sql = "UPDATE `additional_info` SET `avatar`='default_ava.jpg' WHERE `nickname`='{$no_ava_users[$i]}' ";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
}

?>