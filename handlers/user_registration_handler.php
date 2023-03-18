<?php 
ob_start();
?>

<?php
require_once '../scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(empty($_SERVER['HTTP_REFERER'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

/* Главные параметры */
$nick = str_replace(" ","_",htmlspecialchars($_POST['nick']));
$email = htmlspecialchars($_POST['email']);
$pass = htmlspecialchars($_POST['pass']);
$pass_confirm = htmlspecialchars($_POST['pass_confirm']);    
$reg_user = true;

/* ПРОВЕРЯЕМ СУЩЕСТВУЕТ ЛИ ТАКОЙ НИК */    
$sql = "SELECT nickname FROM main_info WHERE nickname = :nickname"; 
$query = $connection_handler->prepare($sql);
$query->bindParam(':nickname', $nick, PDO::PARAM_STR);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC); // Получаем двумерный массив строк

$txt = "";    
if(!empty($result)){ //Пользователь с таким ником существует
$txt .= "<p>Пользователь с таким ником существует</p>";
$reg_user = false; // Не регистрируем пользователя
}

/* ПРОВЕРЯЕМ ПУСТОЙ ЛИ НИК */
if(empty($nick)){
$txt .= "<p>Ник не может быть пустым</p>";
$reg_user = false; // Не регистрируем пользователя
}   

/* ПРОВЕРЯЕМ ПОЧТУ */    
if(empty($email)){ //Пришла пустая почта
$txt .= "<p>Почта не может быть пустой</p>";
$reg_user = false;
}

$sql = "SELECT email FROM main_info WHERE email = :email"; //Проверяем существует ли почта в базе данных
$query = $connection_handler->prepare($sql);    
$query->bindParam('email', $email, PDO::PARAM_STR);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);

if(!empty($result)){ //Почта занята
$txt .= "<p>Пользователь с такой почтой уже существует.</p>";
$reg_user = false; // Не регистрируем пользователя
} 

if(empty($pass)){ //Пришел пустой пароль
$txt .= "<p>Пароль не может быть пустым</p>";
$reg_user = false; // Не регистрируем пользователя
} else if(strlen($pass) < 6){ //Длина пароля меньше 6
$txt .= "<p>Длина пароля не может быть меньше 6-ти символов</p>";
$reg_user = false;
}

/* ПРОВЕРЯЕМ ПОДТВЕРЖДЕНИЕ пароля */
if(empty($pass_confirm)){ // Пустое подтверждение пароля
$txt .= "<p>Пароль не подтвержден</p>";
$reg_user = false;
} else if($pass !== $pass_confirm){ // Пароли не совпадают
$txt .= "<p>Пароли не совпадают</p>";
$reg_user = false;
}
    
/* ПАРОЛЬ */
$options = [ // Массив, на основе, которого будет производиться хэширование
	'salt' => salt(),
	'cost' => 12
	];

$hash = password_hash($pass, PASSWORD_DEFAULT, $options); // Хэшируем пароль пользователя	

/* Вставляем главные данные в таблицу */
$data_main = array($nick, $email, $hash,'elephant',1);
$sql_main = "INSERT INTO main_info(nickname,email,password,reg_type,is_new_user) VALUES (?, ?, ?, ?, ?)";	
$query_main = $connection_handler->prepare($sql_main); 

$query_main_execution = $query_main->execute($data_main);

/* Вставляем вспомогательные данные в таблицу */
$sex = htmlspecialchars($_POST['sex']);
$city = htmlspecialchars($_POST['city']);
$age = htmlspecialchars($_POST['age']);
$sp = htmlspecialchars($_POST['sp']);
$education = htmlspecialchars($_POST['education']);
$lifestyle = htmlspecialchars($_POST['lifestyle']);
$body = htmlspecialchars($_POST['body']);
$temper = htmlspecialchars($_POST['temper']);
$religion = htmlspecialchars($_POST['religion']);
$sport = htmlspecialchars($_POST['sport']);
$games = htmlspecialchars($_POST['games']);
$last_insert_id = $connection_handler->lastInsertId(); // Последнее вставленное айди

/* ВСТАВЛЯЕМ ДОПОЛНИТЕЛЬНЫЕ ДАННЫЕ В ТАБЛИЦУ */
$data_additional = array($last_insert_id,$sex, $city, $education, $lifestyle, $body, $temper, $age, $sp, $nick, $religion,$sport,$games);
$sql_additional = "INSERT INTO additional_info(user_id,sex,city,education,lifestyle,body,temper, age, sp, nickname,religion,sport,games) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?)";	
$query_additional = $connection_handler->prepare($sql_additional);
$query_additional->execute($data_additional);

/* СОЗДАЕМ ПАПКУ ДЛЯ ПОЛЬЗОВАТЕЛЯ*/
chdir('../users/');//Переходим в папку users    
$dir = 'zs' . $last_insert_id . '/'; // Папка пользователя 
$upload_file = true; //Флаг загрузки файла   

if(!file_exists($dir)){ // Создаем папку пользователя
mkdir($dir, 0777,true); //.. создаём эту папку
}

$upload_file_name = $dir . basename($_FILES['avatar']['name']); // Файл пользователя   
$max_file_size = $_POST['MAX_FILE_SIZE']; //Размер файла
$upload_file_size = $_FILES['avatar']['size'];
$upload_file_type = $_FILES['avatar']['type'];
$upload_file_tmp_name = $_FILES['avatar']['tmp_name'];   
$mimes = array("image/jpeg","image/png");    

/* ДОБАВЛЯЕМ В СОЗДАННУЮ ПАПКУ АВУ*/
if(!empty($_FILES['avatar']['name'])){ // Пользователь отправил аву 

    if($upload_file_size > $max_file_size){ //Проверяем размер файла
        $txt .= "<p>Размер файла должен быть <= 3мБ</p>";
        $upload_file = false; //Не отправляем файл
        } 

    if(!in_array($upload_file_type,$mimes)){ // Проверяем тип файла
        $txt .= "<p>Данный тип файла не поддерживается.</p>";
        $upload_file = false; //Не отправляем файл
        }    

//ОТПРАВЛЯЕМ ФАЙЛ В ПАПКУ
if($upload_file == true){
    move_uploaded_file($_FILES['avatar']['tmp_name'],$upload_file_name); //Загружаем файл в папку
    $ext = pathinfo($upload_file_name,PATHINFO_EXTENSION);
    $new_ava_name = $dir . "user_ava_". $last_insert_id . "." . $ext; // Новое имя авы
    rename($upload_file_name, $new_ava_name); //Переименовываем файл
    /* Вставляем ссылку на аву в базу данных */
    $sql = "UPDATE additional_info SET avatar=:avatar WHERE user_id={$last_insert_id}"; 
    $query = $connection_handler->prepare($sql);
    $query->bindParam(':avatar', $new_ava_name, PDO::PARAM_STR); // Добавляем новое имя в базу данных
    $query->execute();
    }    
}
else  { // Пользователь не отправил аву. Добавляем дефолтную аву
    /* Вставляем ссылку на аву в базу данных */
    $sql = "UPDATE additional_info SET avatar='default_ava.jpg' WHERE user_id={$last_insert_id}"; 
    $query = $connection_handler->prepare($sql);
    /*$query->bindParam(':avatar', 'default_ava.jpg', PDO::PARAM_STR);*/
    $query->execute();
}


if($reg_user == true){
   session_start();
    $_SESSION['user'] = $nick; // Создаем переменную сессии
    header('Location: ../user.php?zs=' . $nick); // Редиректим на страницу пользователя.
}

ob_end_flush();
?>
