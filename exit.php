<?php 
session_start();

if(empty($_SERVER['HTTP_REFERER'])){
header('Location: index.php');
exit();   
}

if(!empty($_SESSION['user']) || !empty($_COOKIE['user'])){ // Пользователь уже вошел в систему
unset($_SESSION['user']);
setcookie('user','',time()-3600);
session_destroy();
header('Location: index.php');
exit();    
   
}

?>