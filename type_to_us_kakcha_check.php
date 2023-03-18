<?php
ob_start();
 session_start(); 
// предотвращаем кэширование на стороне пользователя
  	header("Expires: Wed, 1 Jan 1997 00:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
    header("Content-type: text/plain;charset=utf-8");

if(empty($_SERVER['HTTP_REFERER'])){
    exit();
} 

$kakcha_input = htmlspecialchars($_POST['kakcha_input']);

if(!empty($kakcha_input)){

    if(!hash_equals($_SESSION['kakcha_fr'],crypt($kakcha_input,'outheaded'))){
        echo "false";
    } 

}

ob_end_flush();
?>
