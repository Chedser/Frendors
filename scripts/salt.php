<?php
function salt(){
$arr = array('A', 'a', 'B', 'b', 'C', 'c', 'D', 'd', 'E', 'e',
			 'F', 'f', 'G', 'g', 'H', 'h', 'I', 'i', 'J', 'j',	
			 'K', 'k', 'L', 'l', 'M', 'm', 'N', 'n', 'O', 'o',
			 'P', 'p', 'Q', 'q', 'R', 'r', 'S', 's', 'T', 't',	
			 'U', 'u', 'V', 'v', 'W', 'w', 'X', 'x', 'Y', 'y', 'Z', 'z',
			 '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
			 
$salt_length = 	mt_rand(15,20); // Длина строки для соли		 
shuffle($arr); // Перемешиваем массив
$txt = ""; //Строка для хранения соли
$arr_length = count($arr);
for($i = 0; $i < count($arr); $i++){
	$rand_ind = mt_rand(0,$arr_length - 1); // Случайный индекс
	$txt .= $arr[$rand_ind];	
}
return $txt;
}
?>