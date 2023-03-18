<?php
ob_start();
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
error_reporting(0);

function session_isset(){ // Пользователь вошел
if(!empty($_SESSION['user'])){ // Пользователь вошел через логин-пароль
return true;
} else {
return false;
}
}

if(empty($_SESSION['user'])){ 
header('Location: index.php'); // Редиректим на index.php
exit();   
}
function tolink($text) { // Превращение в ссылку
 
 $text = preg_replace("/(^|[\n ])([\w]*?)(https?:\/\/)(www\.)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;%=+#])*)*)/is", "$1$2<a href='//$4$5' target = _blank>$3$4$5</a>", $text); // http(s)://www.frendors.com
 $text = preg_replace("/(^|[\n ])([\w]*?)(https?:\/\/)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;%=+#])*)*)/is", "$1$2<a href='//$4' target = _blank>$3$4</a>", $text); // http(s)://frendors.com
 $text = preg_replace("/(^|[\n ])([\w]*?)(www\.)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;%=+#])*)*)/is", "$1$2<a href='//$4' target = _blank>$3$4</a>", $text); // www.frendors.com
 $text = preg_replace("/(^|[\n ])([\w]*?)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;%=+#])*)*)/is", "$1$2<a href='//$3' target = _blank>$3</a>", $text); //frendors.com    
 $text = preg_replace("/(^|[\n ])([\w]*?)(\/\/vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=]{1,256})/","$1$2<a href='//$3$4' target = _blank>$3$4$5</a>", $text);


 $text = preg_replace("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1<a href='mailto:$2@$3' target = _blank>$2@$3</a>", $text);

 return $text;

}

 function parseDate($date){
  
  $result = "";
  
    
   if(preg_match('/(\d{4})-(\d{2})-(\d{2})\s(\d{2}):(\d{2}):(\d{2})/is',$date,$matches) === 1){
        $year = $matches[1];
      $month = $matches[2];
       $day = $matches[3];
       $hour = $matches[4];
       $min = $matches[5];
    
       
       switch($month){
           case '01': $month = 'янв';  break;
           case '02': $month = 'фев';  break;
           case '03': $month = 'мар';  break;
           case '04': $month = 'апр';  break;
           case '05': $month = 'мая';  break;
           case '06': $month = 'июн';  break;
           case '07': $month = 'июн';  break;
           case '08': $month = 'июл';  break;
           case '09': $month = 'авг';  break;
           case '10': $month = 'сен';  break;
           case '11': $month = 'ноя';  break;
           case '12': $month = 'дек';  break;
           
       }
       
            if($hour[0] == '0'){
           
           $hour =  substr($hour, 1);
           
       }
       
            if($day[0] == '0'){
           
           $day =  substr($day, 1);
           
       }
       
       $result = $day . ' ' . $month . ' ' . $year . ' ' . $hour . ':' . $min;
       
   }
   
   return $result;
    
} 

function href2obj($text) { // Превращение из ссылки в объект под постом

$multimedia_under_post_arr = array();

// Видео с ютуба
     if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)([a-zA-Z0-9\-_]{1,256})/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)([a-zA-Z0-9\-_]{1,256})/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $outp_src = "";
        $multimedia_under_post_for_arr = "";
        
        $hash = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)/is',"",$multimedia_src_arr[0]);
        
        $outp_src = "https://www.youtube.com/embed/" . $hash;
        $multimedia_under_post_for_arr = "<iframe class = 'video_under_post' src = '" . $outp_src . "' frameborder = '0'></iframe>";
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

     } 
     
     // Видео с xvideo
     if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([m\.]*)?(xvideos\.com\/video)([0-9]{1,8})([\/])([a-zA-Z0-9\-_]{1,256})/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([m\.]*)?(xvideos\.com\/video)([0-9]{1,8})([\/])([a-zA-Z0-9\-_]{1,256})/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $outp_src = "";
        $multimedia_under_post_for_arr = "";
        
        $hash = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([m\.]*)?(xvideos\.com\/video)/is',"",$multimedia_src_arr[0]);
        
        $outp_src = "https://www.xvideos.com/embedframe/" . $hash; 
        $multimedia_under_post_for_arr = '<iframe class = "video_under_post" src=' . $outp_src . ' frameborder=0 height=200 allowfullscreen=allowfullscreen></iframe>';
         array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);
        
     } 
     
     
     
     // Видео с редтуба
     if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(ru.)?(redtube\.com\/)([0-9]{1,256})/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(ru.)?(redtube\.com\/)([0-9]{1,256})/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $outp_src = "";
        $multimedia_under_post_for_arr = "";
        
        $hash = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(ru.)?(redtube\.com\/?)/is',"",$multimedia_src_arr[0]);
        
        $outp_src = "https://embed.redtube.com/?id=" . $hash;
        $multimedia_under_post_for_arr = "<iframe class = 'video_under_post' src = '" . $outp_src . "' height = '200' frameborder = '0' allowfullscreen></iframe>";
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

     } 


/**********************************************************************************************************************************************************************************/
// Видео с вк
if(preg_match('/(^|[\n ])([\w]*?)(\/\/)?(vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=])+/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(\/\/)?(vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=])+/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $multimedia_under_post_for_arr = "<iframe class = 'video_under_post' src = '" . $multimedia_src_arr[0] . "' frameborder = '0'></iframe>";
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

} 


/**********************************************************************************************************************************************************************************/
     
// Картинка   
     if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([a-zA-Z0-9_\-.]{2,256})\.([a-zA-Z]{2,6})[\/]([a-zA-Z0-9_\/\-.?&;%=+])+(png|jpg|jpeg|gif)(\?extra=[a-zA-Z0-9_\-\/\-.?&;%=+]{1,256})?/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([a-zA-Z0-9_\-.]{2,256})\.([a-zA-Z]{2,6})[\/]([a-zA-Z0-9_\/\-.?&;%=+])+(png|jpg|jpeg|gif)(\?extra=[a-zA-Z0-9_\-\/\-.?&;%=+]{1,256})?/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $outp_src = "";
        $multimedia_under_post_for_arr = "";
       
        $multimedia_under_post_for_arr = "<img class = 'img_under_post' src = '" . $multimedia_src_arr[0] . "' onerror = this.src='imgs/file_not_found.png' />";
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

     } 

// FD страница   
     if(preg_match('/(^|[\n ])([w]*?)(https?:\/\/)?(www\.)?(frendors\.com[\/]?)+(([a-zA-Z0-9\.=_\-\?&]{8,256}))?/is',$text) === 1){ 

        preg_match('/(^|[\n ])([w]*?)(https?:\/\/)?(www\.)?(frendors\.com[\/]?)+(([a-zA-Z0-9\.=_\-\?&]{8,256}))?/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $outp_src = "";
        $multimedia_under_post_for_arr = "";
        
        $outp_src = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?/is',"https://",$multimedia_src_arr[0]);

        $multimedia_under_post_for_arr = "<iframe class = 'frendors_page_iframe_under_post' src = '" . $outp_src . "'></iframe>";
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

     }      


$multimedia_relult = "";


for($i = 0; $i < count($multimedia_under_post_arr); $i++){
    
    $multimedia_result .= $multimedia_under_post_arr[$i];
    
}

 return $multimedia_result;

} 

if(!empty($_SESSION['user'])){
    
$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();  
    
}

 
$dialog_id = (int)htmlspecialchars($_GET['id']);
/* ИЗВЛЕКАЕМ ПОСЛЕДНИЙ АЙДИ ДАННОГО ДИАЛОГА */
$sql = "SELECT * FROM `dialog_messages` WHERE `dialog`={$dialog_id} ORDER BY `this_id` DESC";
    $query = $connection_handler->prepare($sql);
    $query->execute();
$last_message_id = $query->fetchAll(PDO::FETCH_ASSOC);
$last_message_id = $last_message_id[0]['this_id'];


?>

<?php 

$hack_container = "";

$isHacked = false;

/* ЗАКРЫВАЕМ ДИАЛОГ ПРИ ОТКРЫТИИ */
if(!empty($dialog_id)){

/* ПРОВЕРЯЕМ ТОГО КТО ОТКРЫЛ ДИАЛОГ */
$sql = "SELECT * FROM `dialogs` WHERE `this_id`={$dialog_id} ORDER BY `this_id` DESC";
    $query = $connection_handler->prepare($sql);
    $query->execute();
$dialog_opener = $query->fetchAll(PDO::FETCH_ASSOC);

if(empty($dialog_opener)){ // Дмалога не существует
header('Location: index.php');
}

if($dialog_opener[0]['joined'] === $_SESSION['user']){ // СЕССИОННЫЙ ПРИСОЕДИНЕННЫЙ ОТКРЫЛ
 /* ЗАКРЫВАЕМ ДИАЛОГ В ТАБЛИЦЕ dialogs */  
 $sql = "UPDATE `dialogs` SET `is_finished`=1 WHERE `this_id`={$dialog_id}";
    $query = $connection_handler->prepare($sql);
    $query->execute();

 /* ЗАКРЫВАЕМ ДИАЛОГ В ТАБЛИЦЕ `dialogers`*/  
 $sql = "UPDATE `dialogers` SET `is_finished`=1 WHERE `dialog`={$dialog_id}";
    $query = $connection_handler->prepare($sql);
    $query->execute();    
} else if($dialog_opener[0]['initiator'] === $_SESSION['user']) {
    
    /* ЗАКРЫВАЕМ ДИАЛОГ В ТАБЛИЦЕ dialogs */  
 $sql = "UPDATE `dialogs` SET `is_finished_for_initiator`=1 WHERE `this_id`={$dialog_id}";
    $query = $connection_handler->prepare($sql);
    $query->execute();

 /* ЗАКРЫВАЕМ ДИАЛОГ В ТАБЛИЦЕ `dialogers`*/  
 $sql = "UPDATE `dialogers` SET `is_finished_for_initiator`=1 WHERE `dialog`={$dialog_id}";
    $query = $connection_handler->prepare($sql);
    $query->execute();    
}else{
    
    $isHacked = true;
    
    /* ПРОВЕРЯЕМ ТОГО КТО ОТКРЫЛ ДИАЛОГ */
$sql = "SELECT * FROM `additional_info` WHERE `nickname`='green_bot'";
    $query = $connection_handler->prepare($sql);
    $query->execute();
$green_bot = $query->fetchAll(PDO::FETCH_ASSOC);
    
    $hack_container = "<table class = message_container>
   
<tr>

<td>
<img  class = dialoger_img src = users/" . $green_bot[0]['avatar'] . " />
</td>    
<td class = nick_date>
<a class = nick href = user.php?zs=green_bot>green_bot</a>
</td>    
</tr>
<tr>
<td style = border-right:1px solid green></td>
<td class = message_content>Нехуй чужие переписки читать, пудель</td>
</tr>
<tr>
<td></td>
</tr>
</table>";
    
}
    
}
 
 ?>

<?php

$dialogs_container = "";

if(!$isHacked){
    
    /* ИЗВЛЕКАЕМ СООБЩЕНИЯ ИЗ ДИАЛОГА */
$sql = "SELECT * FROM `dialog_messages` WHERE `dialog`={$dialog_id} ORDER BY `this_id`ASC";
    $query = $connection_handler->prepare($sql);
    $query->execute();
$dialog_messages = $query->fetchAll(PDO::FETCH_ASSOC);

/* ПРОВЕРЯЕМ ДИАЛОГ */

for($i = 0; $i < count($dialog_messages); $i++){

/* ИЗВЛЕКАЕМ АВАТВР ОТПРАВИТЕЛЯ */
$sql = "SELECT `avatar`  FROM `additional_info` WHERE `nickname`='{$dialog_messages[$i]['sender']}'";
    $query = $connection_handler->prepare($sql);
    $query->execute();
$avatar = $query->fetchAll(PDO::FETCH_ASSOC);
$avatar = $avatar[0]['avatar'];

$multimedia = href2obj($dialog_messages[$i]['message']);

$dialogs_container .= "<div class=user__dialog__sended__wrapper>
					<div class=dialog__sended__info>
						<div class=dialog__sended__avatar>
							<a href = user.php?zs={$dialog_messages[$i]['sender']}><img src=users/{$avatar}></a>
						</div>
						<div class=dialog__sended__data>
							<a href=user.php?zs={$dialog_messages[$i]['sender']}>{$dialog_messages[$i]['sender']}</a>
							<p class=messgae__date>" . parseDate($dialog_messages[$i]['date']) . "</p>
						</div>
					</div>
					<div class=dialog__sended__text>
						<p>" . tolink(nl2br($dialog_messages[$i]['message'])) . "</p>
						<div class=dialog__sended__img>
							{$multimedia}
						</div>
					</div>
				</div>";
            } 

}


?>

<!DOCTYPE html>
<html>
<head>
	<title>user__dialog</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/media.css">
	<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;700&display=swap" rel="stylesheet">

<script>

/* Вспомогательные функции  */
function scrollBottom(){
    var messages = document.getElementById('user_chat_messages');
messages.scrollTop = messages.scrollHeight;
} 

function update_messages(){
 setInterval(check_new_messages(),1000);   

}

function moveCaretToStart(inputObject)
{
if (inputObject.selectionStart)
{
 inputObject.setSelectionRange(0,0);
 inputObject.focus();
}
}


/* Главная функция */

function send_message_inside_dialog(){

var textarea = document.getElementById('textarea'); // Туда пользователь вводит сообщение

var messages = document.getElementById('user_chat_messages'); // Здесь отображаются все сообщения
var last_insert_message_id = document.getElementById('last_insert_message_id'); // Здесь будет храниться последнее айди сообщения

/*
messages_container += '<table class = message_container id=' + arr[i].message_id + '><tr>' +
 '<td>' +
'<img  class = dialoger_img src = users/' + arr[i].avatar +  ' />' +
'</td>' +    
'<td class = nick_date>' +
 '<a class = nick href = user.php?zs=' + arr[i].sender + '>' + arr[i].sender + '</a>' +
'<span class = date>' +  arr[i].date + '</span>' +
'</td>' +    
'</tr>' +
'<tr>' +
'<td style = "border-right:1px solid green"></td>' +
'<td class = message_content>' + arr[i].message + '</td>' +
'</tr>' +    
'</table>';  */      


if(textarea.value === "" || textarea.value.match(/^\s+$/g)){
return;    
}

var xmlhttp = new XMLHttpRequest();

xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
 moveCaretToStart(textarea); 
window.location.reload();
textarea.value = "";    
scrollBottom();
    } 
}

var form_data = new FormData();
form_data.append('id','<?php echo $dialog_id; ?>');
form_data.append('message', textarea.value);
form_data.append('limi', last_insert_message_id.value );
xmlhttp.open("POST", "scripts/send_message_inside_dialog.php", true);  
xmlhttp.send(form_data);    

}

/*********************************************************************************************************************/

function check_new_messages(){ // ПРОВЕРЯЕМ ЕСТЬ ЛИ НОВЫЕ СООБЩЕНИЯ В БАЗЕ

var last_insert_message_id = document.getElementById('last_insert_message_id'); // Здесь будет храниться последнее айди сообщения
 var xmlhttp = new XMLHttpRequest();   
var textarea = document.getElementById('textarea');  
xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
/*parse_response_to_json(xmlhttp.response);*/
alert(xmlhttp.response);
scrollBottom();
        } 
    }
 
xmlhttp.open("GET", "scripts/check_new_message_inside_dialog.php?limi=" + last_insert_message_id.value + "&id=<?php echo  $dialog_id; ?>" , true);  
xmlhttp.send();    
}

function send_message_inside_dialog_enter(event){
 var char = event.which || event.keyCode;    
if(char == 13) {
send_message_inside_dialog();    
}      
}

</script>

</head>
<body onload = "scrollBottom()">
<input type = "hidden" id = "last_insert_message_id" value = "<?php echo $last_message_id; ?>">
	<div class="user__dialog">
		<div class="container">
			<div class="user__dialog__wrapper">
			
		<?php echo $hacked_container; ?>
		<?php echo $dialogs_container; ?>
	
			
				<div class="dialog__title">
					<h2>Пиши</h2>
				</div>
				<div class="dialog__textarea">
					<textarea></textarea>
				</div>
				<div class="dialog__btn__wrapper">
					<button class="send__message__btn">Отправить</button>
				</div>
				<div class="dialog__return__link">
					<a href="#">Нахуй</a>
				</div>
			</div>
		</div>
	</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="js/script.js"></script>	
</body>
</html>
<?php ob_end_flush(); ?>
