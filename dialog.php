<?php
ob_start();
session_start();


require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
error_reporting(1);

//ini_set('display_errors', 'On');

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

$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();    

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

?>

<?php 


$dialog_id = (int)htmlspecialchars($_GET['id']);
/* ИЗВЛЕКАЕМ ПОСЛЕДНИЙ АЙДИ ДАННОГО ДИАЛОГА */
$sql = "SELECT * FROM `dialog_messages` WHERE `dialog`={$dialog_id} ORDER BY `this_id` DESC";
    $query = $connection_handler->prepare($sql);
    $query->execute();
$last_message_id = $query->fetchAll(PDO::FETCH_ASSOC);
$last_message_id = $last_message_id[0]['this_id'];


$isHacked = false;
$hackedContainer = "";
$msgs_container = "";

/* ЗАКРЫВАЕМ ДИАЛОГ ПРИ ОТКРЫТИИ */
if(!empty($dialog_id)){

/* ПРОВЕРЯЕМ ТОГО КТО ОТКРЫЛ ДИАЛОГ */
$sql = "SELECT * FROM `dialogs` WHERE `this_id`={$dialog_id} ORDER BY `this_id` DESC";
    $query = $connection_handler->prepare($sql);
    $query->execute();
$dialog_opener = $query->fetchAll(PDO::FETCH_ASSOC);

if(empty($dialog_opener)){ // Дмалога не существует
    exit();
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
    
    /* ПРОВЕРЯЕМ ТОГО КТО ОТКРЫЛ ДИАЛОГ */
$sql = "SELECT * FROM `additional_info` WHERE `nickname`='green_bot'";
    $query = $connection_handler->prepare($sql);
    $query->execute();
$green_bot = $query->fetchAll(PDO::FETCH_ASSOC);
    
    $isHacked = true;
    
 $hacked_container .=  "<table class = message_container>
   
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

$msgs_container .= "<div class=user__dialog__sended__wrapper>
					<div class=dialog__sended__info>
						<div class=dialog__sended__avatar>
							<a href=user.php?zs={$dialog_messages[$i]['sender']}><img src = users/{$avatar}></a>
						</div>
						<div class=dialog__sended__data>
							<a href=user.php?zs={$dialog_messages[$i]['sender']}>{$dialog_messages[$i]['sender']}</a>
							<p class=messgae__date>" . parseDate($dialog_messages[$i]['date']) . "</p>
						</div>
					</div>
					<div class=dialog__sended__text>
						<p>" . tolink(nl2br($dialog_messages[$i]['message'])) . "</p>
						<div class=dialog__sended__img>
							" . $multimedia  . "
						</div>
					</div>
				</div>";
            } //for($i = 0; $i < $dialog_messages_count; $i++)
    
    
}



} //if(!empty($dialog_id))

	

?>

<!DOCTYPE html>
<html>
<head>
<title>Вдвоем тута</title>
<meta charset = "utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="bootstrap/js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/media.css">

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter40163305 = new Ya.Metrika({
                    id:40163305,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true,
                    trackHash:true,
                    ecommerce:"dataLayer"
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/40163305" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<!-- Rambler counter -->
<script>
    (function (w, d, c) {
    (w[c] = w[c] || []).push(function() {
        var options = {
            project: 4448332,
            element: 'top100_widget'
        };
        try {
            w.top100Counter = new top100(options);
        } catch(e) { }
    });
    var n = d.getElementsByTagName("script")[0],
    s = d.createElement("script"),
    f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src =
    (d.location.protocol == "https:" ? "https:" : "http:") +
    "//st.top100.ru/top100/top100.js";

    if (w.opera == "[object Opera]") {
    d.addEventListener("DOMContentLoaded", f, false);
} else { f(); }
})(window, document, "_top100q");
</script>
<noscript><img src="//counter.rambler.ru/top100.cnt?pid=4448332"></noscript>
<!-- /Rambler counter -->

<!-- Google counter -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-85516784-1', 'auto');
  ga('send', 'pageview');

</script>
<!-- /Google counter -->

<style>
body {
    width: 90%;
    max-width: 1100px;
    margin:0 auto;
    height:100%;
 }

main {
    padding: 10px;
    padding-bottom: 90px;
}

a {
color:blue;    
}

.message_container  {
border-bottom:1px solid white;
border-collapse:separate;
border-spacing: 7px 5px;
margin:0 auto;
}

.message_container td{
vertical-align:top;
}

.nick_date {
width:500px;    
}

.nick {
display:block;    
}

.dialoger_img{
width:50px;
height:50px;
border-radius:5px;
}

.date {
color:gray;    
display:block;
margin-top:-5px;
font-size:10px;
}

.message_content{
max-width:100px;    
word-wrap:break-word;
}

#user_chat_messages{
border-bottom:1px solid black;  
padding-bottom:10px;
height:420px;
overflow-y:scroll;
}

#user_input_container{
padding-left:100px;
padding-top:10px;
 }

#textarea{
  resize:none;  
}

#user_input_wrapper{
}

#message_to_img{
position:relative;
left:10px;
top:-80px;
height:80px;    
width:80px;
border-radius:10px;
margin-bottom:0px;
display:none;
}

#message_to_img:hover{
    transform:scale(1.05);
}

 #message_to_user_online{
color:gray;     
display:block;
margin-left:610px;
margin-top:-30px;
margin-bottom:-15px;
     
 }

.video_under_post, .frendors_page_iframe_under_post{
    width:100%;
    height:350px;
}

.img_under_post{
    display:block;
    max-width:650px;
    max-height:350px;
}

textarea{
          padding:5px;
          border-radius:5px;
          margin-bottom:3px;
   }
 
textarea:focus{
     background-color: #98DDDE;
     box-shadow: 0px 0px 1px #7FFFD4;
}


</style>

</head>

<body onload = "scrollBottom()">

<script type="text/javascript">
var _tmr = window._tmr || (window._tmr = []);
_tmr.push({id: "2824427", type: "pageView", start: (new Date()).getTime()});
(function (d, w, id) {
  if (d.getElementById(id)) return;
  var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;
  ts.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//top-fwz1.mail.ru/js/code.js";
  var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
  if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
})(document, window, "topmailru-code");
</script><noscript><div style="position:absolute;left:-10000px;">
<img src="//top-fwz1.mail.ru/counter?id=2824427;js=na" style="border:0;" height="1" width="1" alt="Рейтинг@Mail.ru" />
</div></noscript>

<main class = "container-fluid">

<div class = "row">
<input type = "hidden" id = "last_insert_message_id" value = "<?php echo $last_message_id; ?>">

<section id = "user_chat_messages">

<?php echo $hacked_container . $msgs_container; ?>

</section>

<section id = user_input_container>

<?php 
$receiver_avatar = "";

/* УЗНАЕМ ОНЛАЙН ЛИ ТОТ С КЕМ ОБЩАЕМСЯ */
$sql = "SELECT * FROM `dialogs` WHERE `joined`='{$_SESSION['user']}'  AND `this_id`={$dialog_id}";
    $query = $connection_handler->prepare($sql); //Подготавливаем запрос
    $query->execute();
    $receiver = $query->fetchAll(PDO::FETCH_ASSOC);
    $receiver = $receiver[0]['initiator'];
$receiver_online = '';
if(!empty($receiver)){ // СЕССИОННЫЙ ПОЛЬЗОВАТЕЛЬ ЯВЛЯЕТСЯ ПРИСОЕДИНЕННЫМ

$sql = "SELECT * FROM `main_info` WHERE `nickname`='{$receiver}'";
    $query = $connection_handler->prepare($sql); //Подготавливаем запрос
    $query->execute();
    $last_action_time = $query->fetchAll(PDO::FETCH_ASSOC);
    $last_action_time = $last_action_time[0]['last_action_time'];

    if(($current_time - $last_action_time) <= 180){
    $receiver_online = "здеся";     
    } 

/* ИЩЕМ АВУ ПОЛУЧАТЕЛЯ */
$sql = "SELECT `avatar`  FROM `additional_info` WHERE `nickname`='{$receiver}'";
    $query = $connection_handler->prepare($sql);
    $query->execute();
$receiver_avatar = $query->fetchAll(PDO::FETCH_ASSOC);
$receiver_avatar = $receiver_avatar[0]['avatar'];
} else {
 /* УЗНАЕМ ОНЛАЙН ЛИ ТОТ С КЕМ ОБЩАЕМСЯ */
$sql = "SELECT * FROM `dialogs` WHERE `initiator`='{$_SESSION['user']}'  AND `this_id`={$dialog_id}";
    $query = $connection_handler->prepare($sql); //Подготавливаем запрос
    $query->execute();
    $receiver = $query->fetchAll(PDO::FETCH_ASSOC);
    $receiver = $receiver[0]['joined']; 
      
      $sql = "SELECT * FROM `main_info` WHERE `nickname`='{$receiver}'";
    $query = $connection_handler->prepare($sql); //Подготавливаем запрос
    $query->execute();
    $last_action_time = $query->fetchAll(PDO::FETCH_ASSOC);
    $last_action_time = $last_action_time[0]['last_action_time'];

    if(($current_time - $last_action_time) <= 180){
    $receiver_online = "здеся";     
    } 

/* ИЩЕМ АВУ ПОЛУЧАТЕЛЯ */
$sql = "SELECT `avatar`  FROM `additional_info` WHERE `nickname`='{$receiver}'";
    $query = $connection_handler->prepare($sql);
    $query->execute();
$receiver_avatar = $query->fetchAll(PDO::FETCH_ASSOC);
$receiver_avatar = $receiver_avatar[0]['avatar'];
  
}
?>

<?php

if(!empty($_SESSION['user'])){
    
echo '<div id = user_input_wrapper>
<textarea  id = textarea rows = "5" style = "width:85%" autofocus = "autofocus" required = "required" maxlength = "3000" onkeypress = "send_message_inside_dialog_enter(event)" >
</textarea>
<div id = "receiver_wrapper" style = "margin-top:10px">

<button type="button"  onclick = "send_message_inside_dialog()" class = "send__message__btn">Ахуенно</button>  
</div>
<a href = "dialogs.php"> Нахуй</a>';

}

?>

</section>    
</div>
</main>    

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

</body>    

</html> 


<?php ob_end_flush(); ?>
