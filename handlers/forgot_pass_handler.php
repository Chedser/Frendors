
<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(empty($_SERVER['HTTP_REFERER'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

$login = htmlspecialchars($_POST['login']);
$email = htmlspecialchars($_POST['email']);


if(!empty($login) | !empty($email)){

/* ПРОВЕРЯЕМ ЕСТЬ ЛИ ТАКОЙ ПОЛЬЗОВАТЕЛЬ С ТАКИМ ЛОГИНОМ */      
$sql = "SELECT nickname FROM `main_info` WHERE `nickname`='{$login}' AND `email`='{$email}'"; 
$query = $connection_handler->prepare($sql);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC); // Получаем двумерный массив строк*/

if(!empty($result)){ //ПОЛЬЗОВАТЕЛЬ СУЩЕСТВУЕТ

/* ГЕНЕРИРУЕМ ПАРОЛЬ ПОЛЬЗОВАТЕЛЯ, если пользователь существует */
$syms = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 
              'h', 'i', 'j', 'k', 'l', 'm', 'n', 
              'o', 'p', 'q', 'r', 's', 't', 'u',
              'v', 'w', 'x', 'y', 'z', 'A', 'B',
              'C', 'D', 'E', 'F', 'G', 'H', 'I',
              'J', 'K', 'L', 'M', 'N', 'O', 'P', 
              'Q', 'R', 'S', 'T', 'U', 'V', 'W',
              'X', 'Y', 'Z', '0', '1', '2', '3',
              '4', '5', '6', '7', '8', '9');         

$pass_length = 7; // Длина пароля         
$gened_pass = ""; // Сгенерированный пароль
         
for($i = 0; $i < $pass_length; $i++){
$gened_sym = $syms[mt_rand(0,61)]; // Сгенерированный символ
$gened_pass .= $gened_sym; 
}         

echo "Ваш новый пароль: <span style = 'color:red'>" . $gened_pass . "</span>";


/* ХЭШИРУЕМ ПАРОЛЬ ПОЛЬЗОВАТЕЛЯ */    
$options = [ // Массив, на основе, которого будет производиться хэширование
	'salt' => salt(),
	'cost' => 12
	];

$hash = password_hash($gened_pass, PASSWORD_DEFAULT, $options); // Хэшируем пароль пользователя	

/* ВСТАВЛЯЕМ ХЭШ В ТАБЛИЦУ */
$sql = "UPDATE main_info SET password='" . $hash . "'" . " WHERE nickname='{$login}'";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute(); 
} else {
    echo "Неправильная пара логин-email";
} 

} 
?>  
