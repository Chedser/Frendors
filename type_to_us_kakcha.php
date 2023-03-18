<?php
ob_start();
 session_start(); 
// предотвращаем кэширование на стороне пользователя
  	header("Expires: Wed, 1 Jan 1997 00:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
    header("Content-type: image/png");

if(empty($_SERVER['HTTP_REFERER'])){
    exit();
} 

// ГЕНЕРИРУЕМ ПАРОЛЬ ПОЛЬЗОВАТЕЛЯ, если пользователь существует 
 $syms = array('0', '1', '2', '3',
              '4', '5', '6', '7', '8', '9');     

$syms_count = mt_rand(3,4); // Количество символов, которое будет отображаться на какче
$kakcha_str = "";
$font = 'firestarter.ttf'; // Шрифт

//создаем изображение
$image = imagecreatefrompng("imgs/kakcha_bg.png");
 // выделяем цвет
$green = imagecolorallocate($image,0,255,0);

for($i = 0; $i < $syms_count; $i++ ){
    $sym_index = mt_rand(0, count($syms) - 1); // Выбираем индекс
    $sym = $syms[$sym_index];
    $kakcha_str .= $sym;   
} 

$_SESSION['kakcha_fr'] = crypt($kakcha_str,'outheaded'); 

// Отрисовываем изображение
imagefttext($image, 25, 0, 80, 30, $green, $font,  $kakcha_str);

imagepng($image);
imagedestroy($image);

ob_end_flush();
?>
