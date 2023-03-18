<?php
ob_start();
header("Content-type: image/png");

$width = 100;
$height = 30;

$img = imagecreate($width,$height);

$white = imagecolorallocate($img,0xFF,0xFF,0xFF);

/* Цвета */
$first_color_component_red = rand(0,255);
$first_color_component_green = rand(0,255);
$first_color_component_blue = rand(0,255);

$first_color = imagecolorallocate($img,$first_color_component_red,$first_color_component_green,$first_color_component_blue);

$second_color_component_red = rand(0,255);
$second_color_component_green = rand(0,255);
$second_color_component_blue = rand(0,255);

$second_color = imagecolorallocate($img,$second_color_component_red,$second_color_component_green,$second_color_component_blue);

$third_color_component_red = rand(0,255);
$third_color_component_green = rand(0,255);
$third_color_component_blue = rand(0,255);

$third_color = imagecolorallocate($img,$third_color_component_red,$third_color_component_green,$third_color_component_blue);

$colors = array($first_color, $second_color, $third_color);

/* Первая линия */
$color = rand(0,2);

$rand_x_begin = rand(5,10);
$rand_y_begin = rand(2,4);
$rand_x_end = rand(5,10);
$rand_y_end = rand(2,4);

imageline($img,$rand_x_begin,$height/$rand_y_begin,$width - $rand_x_end,$height/$rand_y_end,$colors[$color]);

/* Вторая линия */
$color = rand(0,2);

$rand_x_begin = rand(5,10);
$rand_y_begin = rand(2,4);
$rand_x_end = rand(5,10);
$rand_y_end = rand(2,4);

imageline($img,$rand_x_begin,$height/$rand_y_begin,$width - $rand_x_end,$height/$rand_y_end,$colors[$color]);

/* Третья линия */
$color = rand(0,2);

$rand_x_begin = rand(5,10);
$rand_y_begin = rand(2,4);
$rand_x_end = rand(5,10);
$rand_y_end = rand(2,4);

imageline($img,$rand_x_begin,$height/$rand_y_begin,$width - $rand_x_end,$height/$rand_y_end,$colors[$color]);

/* Четвертая линия */
$color = rand(0,2);

$rand_x_begin = rand(5,10);
$rand_y_begin = rand(2,4);
$rand_x_end = rand(5,10);
$rand_y_end = rand(2,4);

imageline($img,$rand_x_begin,$height/$rand_y_begin,$width - $rand_x_end,$height/$rand_y_end,$colors[$color]);

/* Пятая линия */
$color = rand(0,2);

$rand_x_begin = rand(5,10);
$rand_y_begin = rand(2,4);
$rand_x_end = rand(5,10);
$rand_y_end = rand(2,4);

imageline($img,$rand_x_begin,$height/$rand_y_begin,$width - $rand_x_end,$height/$rand_y_end,$colors[$color]);

/* Символы на какче*/
$arr = array('A', 'a', 'B', 'b', 'C', 'c', 'D', 'd', 'E', 'e',
			 'F', 'f', 'G', 'g', 'H', 'h', 'I', 'i', 'J', 'j',	
			 'K', 'k', 'L', 'l', 'M', 'm', 'N', 'n',
			 'P', 'p', 'Q', 'q', 'R', 'r', 'S', 's', 'T', 't',	
			 'U', 'u', 'V', 'v', 'W', 'w', 'X', 'x', 'Y', 'y', 'Z', 'z',
			  '1', '2', '3', '4', '5', '6', '7', '8', '9');
		 
shuffle($arr); // Перемешиваем массив
$txt = ""; //Строка для хранения
$arr_length = count($arr);
for($i = 0; $i < 5; $i++){
	$rand_ind = mt_rand(0,$arr_length - 1); // Случайный индекс
	$txt .= $arr[$rand_ind];	
	}
	
define("F_SIZE", 15);
define("F_ANGLE",0);
define("F_FONT","segoe.ttf");

$start_x = 10;
$start_y = 15;
$black = imagecolorallocate($img,0,0,0);	
	
imageTTFtext($img, F_SIZE, F_ANGLE, $start_x, $start_y,$black,F_FONT,$txt);
	
imagepng($img);
ob_end_flush();

?>


