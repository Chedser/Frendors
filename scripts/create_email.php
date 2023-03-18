<?php
ob_start();

if(empty($_SERVER['HTTP_REFERER'])){
    exit();
} 

$email_name = htmlspecialchars($_POST['email_name']);
$email_password = htmlspecialchars($_POST['email_password']);
$email_password_confirm = htmlspecialchars($_POST['email_password_confirm']);

if(!empty($email_name) && !empty($email_password) && !empty($email_password_confirm)){

    if($email_password !== $email_password_confirm){
        
        echo "<span>Пароли не совпадают</span><br />";
        echo "<a href = 'index.php'> <<< Назад </a>";
        exit();
    }
    
    if(strlen($email_password) < 6 || strlen($email_password) > 20){
        
        echo "<span>Длина пароля должна быть 6-20 символов</span><br />";
        echo "<a href = 'index.php'> <<< Назад </a>";
        exit();
        
    }
    
    $create_email_beget_answer = file_get_contents('https://api.beget.ru/api/mail/createMailbox?login=chedse6e&' .
'passwd=yeGV3TgC&input_format=json&output_format=json&' . 
'input_data=' . urlencode('{"domain":"frendors.com","mailbox":"' . $email_name . '","mailbox_password":"' . $email_password . '"}'));

if(stripos($create_email_beget_answer,"true") !== false){ // Почта создана

    header('Location: https://webmail.beget.com/');
    exit();
}else{
    echo "<span>Email существует. Придумайте другой</span><br />";
    echo "<a href = 'index.php'> <<< Назад </a>";
    exit();
}

}

ob_end_flush();
?>
