<?php ob_start(); ?>

<?php session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

function session_isset(){ // Пользователь вошел
if(!empty($_SESSION['user'])){ // Пользователь вошел через логин-пароль
return true;
} else {
return false;
}
}

$receiver = htmlspecialchars($_GET['receiver']); // Получатель
$message = htmlspecialchars($_GET['message']);

if(!empty($receiver) && !empty($message)){
$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();    
    
/* СОХРАНЯЕМ СООБЩЕНИЕ В БАЗЕ */    
$sql = "INSERT INTO `private_messages`(`sender`,`receiver`,`message`,`is_readen`) VALUES('{$_SESSION['user']}','{$receiver}','{$message}',1)";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();

// ИЩЕМ СООБЩЕНИЯ 
$sql = "SELECT private_messages.sender, private_messages.message, private_messages.receiver,private_messages.date,private_messages.this_id, additional_info.avatar FROM  `private_messages`" . 
" INNER JOIN additional_info ON private_messages.sender=additional_info.nickname WHERE (`receiver`='{$receiver}' AND `sender`='{$_SESSION['user']}') " .
"OR (`receiver`='{$_SESSION['user']}' AND `sender`='{$receiver}')  ORDER BY private_messages.this_id ASC";
    $query = $connection_handler->prepare($sql);
    $query->execute();
$private_messages = $query->fetchAll(PDO::FETCH_ASSOC);

// ИЩЕМ КОЛИЧЕСТВО СООБЩЕНИЙ ДЛЯ СЕССИОННОГО ПОЛЬЗОВАТЕЛЯ 
$sql = "SELECT COUNT(*) AS `private_messages_count` FROM `private_messages` WHERE (`receiver`='{$receiver}' AND `sender`='{$_SESSION['user']}')" . 
"OR (`receiver`='{$_SESSION['user']}' AND `sender`='{$receiver}')"; // Извлекаем все сообщения на стену из базы 
    $query = $connection_handler->prepare($sql);
    $query->execute();
$private_messages_count = $query->fetchAll(PDO::FETCH_ASSOC); // Получаем двумерный массив строк

$private_messages_count  = $private_messages_count[0]['private_messages_count']; // Количество комментариев    

if($private_messages_count > 0){
    /* ВЫВОДИМ ВСЕ СООБЩЕНИЯ ИЗ БАЗЫ */
for($i = 0; $i < $private_messages_count; $i++){
    
$admin_style = "";
if($private_messages[$i]['sender'] == 'Adminto'){ // Сообщение пришло от админа
    $admin_style = "background-color:yellow; background-color:yellow; padding:2px; border-radius:3px";
            }    
echo '<section
 style = "border-bottom:1px solid white; max-width: 500px; margin-bottom:5px;">
<div>
<div>
 <img src' . ' = "users/' . $private_messages[$i]['avatar'] . '"' . ' style = "border: 1px solid black; border-radius: 10px" width = "50" height = "50" />
<a href = "user.php?zs=' . $private_messages[$i]['sender'] . '"><span style = "position:relative; top: -30px;left:10px' . $admin_style.'">' . $private_messages[$i]['sender'] .'</span></a>
</div>
</div>

<div style = "border-top: 1px solid gray; border-bottom: 1px solid gray;">' .
 '<div class = "message" style = "word-break: break-all; margin-top:3px; margin-bottom:3px;">' . $private_messages[$i]['message'] .'</div>
</div>

<div>
<span style = "color:gray; font-size:15px">' . $private_messages[$i]['date'] .'</span>
</div>

</section>';
          
    
        } // Вы водим сообщения из базы
    }

}

ob_end_flush(); 
?>
