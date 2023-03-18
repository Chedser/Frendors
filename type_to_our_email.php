<?php
ob_start();

if(empty($_SERVER['HTTP_REFERER'])){
    exit();
} 


$typer_name = htmlspecialchars($_POST['typer_name']);
$typer_email = htmlspecialchars($_POST['typer_email']);
$typer_message = htmlspecialchars($_POST['typer_message']);

if(!empty($typer_name) && !empty($typer_email) && !empty($typer_message)){
    
    $typer_message = wordwrap($typer_message, 70, "\r\n");
    
    if(mail('adminto@frendors.com','Сообщение от пользователя frendors - ' . $typer_name . ' | ' . $typer_email,$typer_message)){
            echo "Сообщение отправлено";        
    };

}

ob_end_flush();
?>
