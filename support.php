<?php ob_start(); ?>

<!DOCTYPE html>

<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

function session_isset(){ // Пользователь вошел
if(!empty($_SESSION['user'])){ // Пользователь вошел через логин-пароль
return true;
} else {
return false;
}
}


function href2obj_post($text) { // Превращение из ссылки в объект под постом

$multimedia_under_post_arr = array();

// Видео с ютуба
     if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)([a-zA-Z0-9\-_]{1,256})/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)([a-zA-Z0-9\-_]{1,256})/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $outp_src = "";
        $multimedia_under_post_for_arr = "";
        
        $hash = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)/is',"",$multimedia_src_arr[0]);
        
        $outp_src = "https://www.youtube.com/embed/" . $hash;
        $multimedia_under_post_for_arr = "<iframe class = 'video_under_post' src = '" . $outp_src . "' height = '200' frameborder = '0' allowfullscreen></iframe>";
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

     } 

/**********************************************************************************************************************************************************************************/
// Видео с вк
if(preg_match('/(^|[\n ])([\w]*?)(\/\/)?(vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=])+/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(\/\/)?(vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=])+/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $multimedia_under_post_for_arr = "<iframe class = 'video_under_post' src = '" . $multimedia_src_arr[0] . "' height = '200' frameborder = '0' allowfullscreen></iframe>";
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

} 


/**********************************************************************************************************************************************************************************/
     
// Картинка   
     if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([a-zA-Z0-9_\-.]{2,256})\.([a-zA-Z]{2,6})[\/]([a-zA-Z0-9_\/\-.?&;%=+])+(png|jpg|jpeg|gif)(\?extra=[a-zA-Z0-9_\-\/\-.?&;%=+]{1,256})?/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([a-zA-Z0-9_\-.]{2,256})\.([a-zA-Z]{2,6})[\/]([a-zA-Z0-9_\/\-.?&;%=+])+(png|jpg|jpeg|gif)(\?extra=[a-zA-Z0-9_\-\/\-.?&;%=+]{1,256})?/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $multimedia_under_post_for_arr = "<img class = 'img_under_comment_post' src = '" . $multimedia_src_arr[0] . "' onerror = this.src='imgs/file_not_found.png' />";  
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


function tolink($text) { // Превращение в ссылку
 
 $text = preg_replace("/(^|[\n ])([\w]*?)(https?:\/\/)(www\.)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;%=+])*)*)/is", "$1$2<a href='$3$4$5' target = _blank>$3$4$5</a>", $text); // http(s)://www.frendors.com
 $text = preg_replace("/(^|[\n ])([\w]*?)(https?:\/\/)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;%=+])*)*)/is", "$1$2<a href='$3$4' target = _blank>$3$4</a>", $text); // http(s)://frendors.com
 $text = preg_replace("/(^|[\n ])([\w]*?)(www\.)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;%=+])*)*)/is", "$1$2<a href='//$4' target = _blank>$3$4</a>", $text); // www.frendors.com
 $text = preg_replace("/(^|[\n ])([\w]*?)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;%=+])*)*)/is", "$1$2<a href='//$3' target = _blank>$3</a>", $text); //frendors.com    
 $text = preg_replace("/(^|[\n ])([\w]*?)(\/\/vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=]{1,256})/","$1$2<a href='//$3$4' target = _blank>$3$4$5</a>", $text);
 $text = preg_replace("/(^|[\n ])([\w]*?)(\[url href=\"?)(https?:\/\/)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;%=+])*)*)(\])([a-zA-Z0-9йцукенгшщзхфывапролджэячсмитьбюЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮ!?@.\s\n]{2,80})+(\"?\[\/url\])/", "$1$2<a href='$4$5' target = _blank>$11</a>" ,$text); 
 $text = preg_replace("/(^|[\n ])([\w]*?)(\[url href=\"?)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;%=+])*)*)(\])([a-zA-Z0-9йцукенгшщзхфывапролджэячсмитьбюЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮ!?@.\s\n]{2,80})+(\"?\[\/url\])/", "$1$2<a href='http://$4' target = _blank>$10</a>" ,$text); 

 $text = preg_replace("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1<a href='mailto:$2@$3' target = _blank>$2@$3</a>", $text);

 return $text;

}


?>

<html>

<head>
<title>Черпаки</title>
<meta charset = "utf-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name = "description" content = "техподдержка Frendors" />
<meta name="keywords" content = "черпаки,зеленый слоник, бердянск,больничка, сергей пахомов, владимир епифанцев,александр маслаев,александр осмоловский,сладкий хлеб,азов,украина,путин,политика" / >
<meta name = "author" content = "Александр Неминуев">

<link rel = "stylesheet" href = "css/normalize.css"  type = "text/css" />
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel = "stylesheet" src = "css/roboto/roboto.css">
<script src="bootstrap/js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

<meta property="og:title" content="Черпаки"/>
<meta property="og:description" content="техподдержка Frendors"/>
<meta property="og:image" content="imgs/header/cherpak.png">
<meta property="og:type" content="article"/>
<meta property="og:url" content= "//frendors.com/support.php" />

<script type="text/javascript" src="//vk.com/js/api/openapi.js?136"></script>
<script type="text/javascript">
  VK.init({apiId: 5757931});
</script>

<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.8&appId=105917036567372";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

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
    font-family:'Roboto';
    width: 100%;
    background-color:#cefdce;
    margin:0 auto;
    height:100%;
    font-size:20px;
}

main {
    padding: 10px;
    border-left:1px solid blue;
    border-right:1px solid blue;
    width:100%;
    padding-bottom: 90px;
    }

header { /* Шапка */

margin-bottom: 5px;
height:80px;
}

header a:active, header a:visited, header a:hover, header span{
color:white;    
}

header li { /* Элементы шапки */
display:inline-block;
margin-right:5px;
text-align:center;
}

.header_items_img {
height:30px;
width:30px;
}

 input[type=text],textarea{
          padding:5px;
          border-radius:5px;
 }
 
  input[type=text]:focus,textarea{
     background-color: #98DDDE;
     box-shadow: 0px 0px 1px #7FFFD4;
}

#preview_div_post_video, 
#preview_frendors_page_iframe,
.video_under_post,
.frendors_page_iframe_under_post{
width:100%;
height:400px;
}

.img_under_comment_post{
    display:block;
    width:100%;
    max-height:300px;
}

</style>

</head>    

<body>

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

<?php 

if(session_isset()){

/* ИЗВЛЕКАЕМ НОВЫЕ АТИВНЫЕ ДИАЛОГИ ГДЕ СЕССИОННЫЙ ЯВЛЯЕТСЯ ПРИСОЕДИНЕННЫМ */
$sql = "SELECT COUNT(*) AS 'new_message_sessioner_joined' FROM `dialogs` WHERE `joined`='{$_SESSION['user']}'  AND `is_finished` = 0";	
$query = $connection_handler->prepare($sql); 
$query->bindParam(':joined', $_SESSION['user'], PDO::PARAM_STR); // Пользователь к к которому зашли. Принимают заявку
$query->execute();
$sessioner_joined_new_message_count = $query->fetchAll(PDO::FETCH_ASSOC);
$sessioner_joined_new_message_count = $sessioner_joined_new_message_count[0]['new_message_sessioner_joined'];         

/* ИЗВЛЕКАЕМ НОВЫЕ АТИВНЫЕ ДИАЛОГИ ГДЕ СЕССИОННЫЙ ЯВЛЯЕТСЯ ИНИЦИАТОРОМ */
$sql = "SELECT COUNT(*) AS 'new_message_sessioner_initiator' FROM `dialogs` WHERE `initiator`='{$_SESSION['user']}'  AND `is_finished_for_initiator` = 0";	
$query = $connection_handler->prepare($sql); 
$query->bindParam(':joined', $_SESSION['user'], PDO::PARAM_STR); // Пользователь к к которому зашли. Принимают заявку
$query->execute();
$sessioner_initiator_new_dialog_count = $query->fetchAll(PDO::FETCH_ASSOC);
$sessioner_initiator_new_dialog_count = $sessioner_initiator_new_dialog_count[0]['new_message_sessioner_initiator'];

$new_dialogs_count = $sessioner_joined_new_message_count + $sessioner_initiator_new_dialog_count;

 $new_dialogs = ""; // НОВЫЕ ДИАЛОГИ    

 if($new_dialogs_count > 0){ // ПОЯВИЛИСЬ НОВЫЕ СООБЩЕНИЯ
    $new_dialogs =  "<span class = 'badge' style='color:blue;'>" . $new_dialogs_count . "</span>";  
    } 

echo 
        '<a href = user.php?zs=' . $_SESSION['user'] . ' >' . $_SESSION['user'] . '</a>';

}

?>

<main class = "container-fluid">
    
<div class = "row" style = "padding:10px">    

<div id="vk_like"></div>
<script type="text/javascript">
    VK.Widgets.Like("vk_like", {type: "button"});
</script>

 <div class=fb-like id = fb_like_top data-href=https://frendors.com/user_videos.php?zs=<?php echo $login; ?> data-layout=button_count data-action=like data-size=small data-show-faces=true data-share=true style = "margin-bottom:5px"></div>

<?php 

if(!empty($_SESSION['user'])){

// ПРОВЕРЯЕМ ЕСТЬ ЛИ ВОПРОСЫ В БАЗЕ
            $sql = "SELECT * FROM `support_questions` WHERE `user`='{$_SESSION['user']}' AND `is_answered`=1";	
            $query = $connection_handler->prepare($sql); 
            $query->execute();
            $is_answered = $query->fetchAll(PDO::FETCH_ASSOC);
    
                if(!empty($is_answered)){ // Считать вопросы просмотренными только тогда, когда есть отвеченные вопросы
            $sql = "UPDATE `support_questions` SET `is_viewed`=1 WHERE `user`='{$_SESSION['user']}'";	
            $query = $connection_handler->prepare($sql); 
            $query->execute();
    }
}else{
    echo "<a href = index.php>Авторизуйтесь, чтобы  стать черпаком</a>";
}

?>


<?php 

$story_input = '';

if(!empty($_SESSION['user']) && $_SESSION['user'] === 'Adminto'){
$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();

$story_input = '<div>
<input  id = "add_supporter_input" style = "resize:none;width:99%;margin-bottom:10px"  maxlength = "100" required = "required"><br />
<button id = "add_supporter_button" type = "button" class="btn btn-primary btn-md" onclick = "add_supporter()">Ахуенно</button>
</div>
<script>

function add_supporter(){
    var add_supporter_input = document.getElementById("add_supporter_input");

    if(add_supporter_input.value == "" || add_supporter_input.value.match(/^\s+$/g)){
       return;
    }
   
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
alert(xmlhttp.response);
window.location.reload();
} 
}

var formData = new FormData();
formData.append("supporter", add_supporter_input.value.trim());

xmlhttp.open("POST", "scripts/add_supporter.php", true);
xmlhttp.send(formData);

}
</script>';
echo $story_input;

/*************************************************************************************************************************************************************/


    
}

?>

<style>
   
   #supporters_container{
     background-color:#ffffcc;
    border:2px solid #ffeb3b;
    border-radius:5px; 
    width:310px; 
    margin-top:10px;
}

#supporters_header{
padding:5px;
border-bottom:1px solid green;
word-wrap:break-word;
height:30px;
}

#supporters_table{
word-wrap:break-word;
}

.supporter_number{
    min-width:10px;
    text-align:center;
    border-right:1px solid black;
    padding:5px;
}

.supporter_name{
    padding:5px;
}

.delete_supporter_a, .ask_question_a{
    font-size:15px;
    color:green;
}

.questionbox, .answerbox{
    border:1px solid black;
    position:absolute;
    background-color:#e7f3fe;
    padding:10px;
    width:60%;
    z-index:1;
    
}

.questionbox_input, .questionbox_textarea,.answerbox_input, .answerbox_textarea{
    width:99%;
}

textarea{
    resize:none;
}

#supporter_questions{
    border-top:1px solid black;
    border-bottom:1px solid black;
}

.avatar{
    width:50px;
    height:50px;
    border:5px;
    display:inline-block;
}

.nick{
    color:blue;
    display:inline-block;
    position:relative;
    top:-10px;
    
}

 .zdesya_img{
    
    width:15px;
    height:15px;
   
}

.date{
    color:gray;
    font-size:12px;
}

.question_container{
    border:1px solid black;
    margin:5px;
}

.question_content{
    border-top:1px dashed black;
    margin:5px;
}

.answer_container{
    border-top:1px solid green;
}

</style>

<?php

/* ТОР10 ПОЛЬЗОВАТЕЛЕЙ */
$sql = "SELECT * FROM `supporters`"; 
    $query = $connection_handler->prepare($sql);
    $query->execute();
$supporters = $query->fetchAll(PDO::FETCH_ASSOC); 

?>

<h1 style = "color:blue;text-align:center;">Техподержка то</h1>
<p style = "color:green;">Здесь можно вопросы какие-нибудь задавать. Чо-нибудь хорошее такое.. Да всякое вобщем. Да вcе что хочешь.<br />
На ваши вопросы будут отвечать и получать ахуительное удовольствие. Кто хочет стать черпаком пишите <a target = _blank href = "user.php?zs=Adminto">такому кабану то</a></p>
<div id = "supporters_container">
<header id ="supporters_header">Черпаки</header>

<table id = "supporters_table">

<?php 

$number = 1;

$delete_supporter_function = "";
$ask_question_function = "";

for($i = 0; $i < count($supporters); $i++){

if($_SESSION['user'] === 'Adminto'){
 $delete_supporter_function = '<td><a class = "delete_supporter_a" href="#"  onclick = delete_supporter(this,"' . $supporters[$i]['id'] . '")>Удалить</a></td>';   
}

if(!empty($_SESSION['user'])){
        
        // ПРОВЕРЯЕМ ЕСТЬ ЛИ СЕССИОННЫЙ В БАЗЕ ПОМОЩНИКОВ. ЗАДАВАТЬ ВОПРОС МОЖЕТ ТОЛЬКО ТОТ КОГО НЕТ В БАЗЕ
    $sql = "SELECT * FROM `supporters` WHERE `user`='" . $_SESSION['user'] . "'"; 
    $query = $connection_handler->prepare($sql);
    $query->execute();
    $supporter = $query->fetchAll(PDO::FETCH_ASSOC); 
        
    if(empty($supporter)){    
        $ask_question_function =  "<td><a href=# class = 'ask_question_a' data-toggle=collapse data-target=#questionbox_" . $supporters[$i]['this_id'] . ">Ну давай спроси</a>
        <div id='questionbox_" . $supporters[$i]['this_id'] . "' class='collapse questionbox'>
        Заголовок<br /><input type = 'text' maxlength='160' id = 'questionbox_input_" . $supporters[$i]['this_id'] . "' class = 'questionbox_input'/><br />
        Содержание<br /><textarea maxlength = '1000' id = 'questionbox_textarea_" . $supporters[$i]['this_id'] . "' class = 'questionbox_textarea'></textarea><br />
        <span id = 'questionbox_errors_span_" . $supporters[$i]['this_id'] . "'></span>
        <button type = 'button' class = 'btn btn-success btn-md' onclick = 'ask_question(" . $supporters[$i]['this_id'] . "," . $supporters[$i]['id'] . ")'>Ахуенно</button>
        </div>
        </td>";
}
}

echo '<tr>
    <td class = "supporter_number">' . $number++ .'</td>
    <td class = "supporter_name"><a href = "user.php?zs=' . $supporters[$i]['user'] . '">' . $supporters[$i]['user'] . '</a></td>' .
      $delete_supporter_function . $ask_question_function .
'</tr>';    
    
}

echo '<script>

function delete_supporter(a, id){
   
    if(id == null || id == ""){
       return;
    }
   
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
this.onclick = null;
a.innerHTML = xmlhttp.response;

} 
}

var formData = new FormData();
formData.append("id", id);

xmlhttp.open("POST", "scripts/delete_supporter.php", true);
xmlhttp.send(formData);

}

function ask_question(container_id,id){
  var questionbox_textarea = document.getElementById("questionbox_textarea_" + container_id);
  var questionbox_input = document.getElementById("questionbox_input_" + container_id);
  var questionbox_errors_span = document.getElementById("questionbox_errors_span_" + container_id);
  var errors_txt = "";
  var ask_question_flag = true;
  
   if(questionbox_textarea.value == "" || questionbox_textarea.value.match(/^\s+$/g)){
       errors_txt +="Где содержание нахуй!?<br />";
       ask_question_flag = false;
    }
    
    if(questionbox_input.value == "" || questionbox_input.value.match(/^\s+$/g)){
       errors_txt +="Где заголовок нахуй!?<br />";
       ask_question_flag = false;
    }
  
  if(ask_question_flag == false){
      questionbox_errors_span.innerHTML = errors_txt;
      return;
  }
  
 var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
questionbox_errors_span.innerHTML = xmlhttp.response + "<br />";
questionbox_input.value = "";
questionbox_textarea.value = "";

} 
}

var formData = new FormData();
formData.append("id",id);
formData.append("header", questionbox_input.value.trim());
formData.append("text", questionbox_textarea.value.trim());

xmlhttp.open("POST", "scripts/ask_question.php", true);
xmlhttp.send(formData);
}

</script>';

?>
        </table>

 </div>

 <?php
  
   // ПРОВЕРЯЕМ СУЩЕСТВУЕТ ЛИ ПОМОЩНИК В БАЗЕ ПОМОЩНИКОВ
    $sql = "SELECT * FROM `supporters` WHERE `user`='{$_SESSION['user']}'";	
    $query = $connection_handler->prepare($sql); 
    $query->execute();
    $supporter = $query->fetchAll(PDO::FETCH_ASSOC);
   
        if(!empty($supporter)){
     
     echo "<div id = 'supporter_questions' style = 'margin-top:10px;'>";

            // ПРОВЕРЯЕМ ЕСТЬ ЛИ ВОПРОСЫ В БАЗЕ
            $sql = "SELECT * FROM `support_questions` WHERE `supporter`='{$_SESSION['user']}' AND `is_answered`=0 ORDER BY `this_id` DESC";	
            $query = $connection_handler->prepare($sql); 
            $query->execute();
            $unanswered_questions = $query->fetchAll(PDO::FETCH_ASSOC);
     
     $questions_outp = "";
     
     for($i = 0; $i < count($unanswered_questions); $i++){

            // ПРОВЕРЯЕМ ЕСТЬ ЛИ ВОПРОСЫ В БАЗЕ
            $sql = "SELECT * FROM `additional_info` WHERE `nickname`='{$unanswered_questions[$i]['user']}'";	
            $query = $connection_handler->prepare($sql); 
            $query->execute();
            $avatar = $query->fetchAll(PDO::FETCH_ASSOC);
            $avatar = $avatar[0]['avatar'];
         
              $sql = "SELECT last_action_time FROM main_info WHERE nickname='{$unanswered_questions[$i]['user']}'"; // Выбираем время последней активности пользователя	
                $query = $connection_handler->prepare($sql); //Подготавливаем запрос
                $query->execute();
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                $last_action_time = $result[0]['last_action_time'];
         
             $current_time = time();
         
         $online = ""; /* Текст, который будет отображаться в месте онлайн */
        if(($current_time - $last_action_time) <= 180){ // Разница <= 180 секунд
            
                /* ПРОВЕРЯЕМ С КАКОГО УСТРОЙСТВА ЗАЩЕЛ ПОЛЬЗОВАТЕЛЬ */
                $sql = "SELECT * FROM `main_info` WHERE `nickname`='{$unanswered_questions[$i]['user']}'"; 	
                $query = $connection_handler->prepare($sql); //Подготавливаем запрос
                $query->execute();
                $user_os = $query->fetchAll(PDO::FETCH_ASSOC);
                $user_os = $user_os[0]['os'];
            
                        if($user_os === 'mobile'){
                                $online = '<img src = imgs/phone.png class = zdesya_img />';
                            }else{
                                    $online = '<img src = imgs/zdesya.png class = zdesya_img />';
                            }
            }
         
         
         $questions_outp .= "<section id = 'question_container_" . $unanswered_questions[$i]['this_id'] . "' class = 'question_container'>
         <div class = 'avatar_nickname_container'>
             <a href = 'user.php?zs=" . $unanswered_questions[$i]['user'] . "'><img class = 'avatar' src = 'users/" . $avatar . "' />" . $online . "</a>
             <a class = nick href = user.php?zs=" . $unanswered_questions[$i]['user'] . ">" . $unanswered_questions[$i]['user'] . "</a><br />
             <span class = 'date'>" . $unanswered_questions[$i]['date'] . "</span>
         </div>
         <div class = 'question_content'>
             <span style = 'text-decoration:underline;'>" . $unanswered_questions[$i]['question_header'] . "</span><br />
        <span>" . tolink($unanswered_questions[$i]['question_text'])  . "</span>
        </div>
        <div class = 'answerbox_button'><a href=# class = 'ask_question_a' data-toggle=collapse data-target=#answerbox_" . $unanswered_questions[$i]['this_id'] . ">Ответить</a></div>
        
            <div id='answerbox_" . $unanswered_questions[$i]['this_id'] . "' class='collapse answerbox'>
            Ответ <textarea maxlength = '1000' id = 'answerbox_textarea_" . $unanswered_questions[$i]['this_id'] . "' class = 'answerbox_textarea'></textarea><br />
            <span id = 'answerbox_errors_span_" . $unanswered_questions[$i]['this_id'] . "'></span>
            <button type = 'button' class = 'btn btn-success btn-md' onclick = 'answer_question(this," . $unanswered_questions[$i]['this_id'] . ")'>Ахуенно</button>
            </div>
        </div>
        
        </section>";

     }
     
     echo $questions_outp;
     
     echo '</div>
    
 <script>    
     function answer_question(button,id){
  var answerbox_textarea = document.getElementById("answerbox_textarea_" + id);
  var answerbox_errors_span = document.getElementById("answerbox_errors_span_" + id);

   if(answerbox_textarea.value == "" || answerbox_textarea.value.match(/^\s+$/g)){
       answerbox_errors_span.innerHTML ="Где ответ нахуй!?<br />";
       return;
    }

 var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
answerbox_errors_span.innerHTML = xmlhttp.response + "<br />";
answerbox_textarea.value = "";
answerbox_errors_span.innerHTML = xmlhttp.response;
button.onclick = null;
setTimeout(window.location.reload(),3000);
} 
}

var formData = new FormData();
formData.append("id",id);
formData.append("text", answerbox_textarea.value.trim());

xmlhttp.open("POST", "scripts/answer_question.php", true);
xmlhttp.send(formData);
}

</script>';
        
        } 
?>


<div id = "answersbox">
   
   <?php 
   
   // ПРОВЕРЯЕМ ЕСТЬ ЛИ ВОПРОСЫ В БАЗЕ
            $sql = "SELECT * FROM `support_questions` WHERE `is_answered`=1 ORDER BY `this_id` DESC";	
            $query = $connection_handler->prepare($sql); 
            $query->execute();
            $answered_questions = $query->fetchAll(PDO::FETCH_ASSOC);
   
    $questions_outp = "";
     
     for($i = 0; $i < count($answered_questions); $i++){

            // ИЩЕМ АВУ
            $sql = "SELECT * FROM `additional_info` WHERE `nickname`='{$answered_questions[$i]['user']}'";	
            $query = $connection_handler->prepare($sql); 
            $query->execute();
            $avatar = $query->fetchAll(PDO::FETCH_ASSOC);
            $user_avatar = $avatar[0]['avatar'];
         
              $sql = "SELECT last_action_time FROM main_info WHERE nickname='{$answered_questions[$i]['user']}'"; // Выбираем время последней активности пользователя	
                $query = $connection_handler->prepare($sql); //Подготавливаем запрос
                $query->execute();
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                $last_action_time = $result[0]['last_action_time'];
         
             $current_time = time();
         
         $online = ""; /* Текст, который будет отображаться в месте онлайн */
        if(($current_time - $last_action_time) <= 180){ // Разница <= 180 секунд
            
                /* ПРОВЕРЯЕМ С КАКОГО УСТРОЙСТВА ЗАЩЕЛ ПОЛЬЗОВАТЕЛЬ */
                $sql = "SELECT * FROM `main_info` WHERE `nickname`='{$answered_questions[$i]['user']}'"; 	
                $query = $connection_handler->prepare($sql); //Подготавливаем запрос
                $query->execute();
                $user_os = $query->fetchAll(PDO::FETCH_ASSOC);
                $user_os = $user_os[0]['os'];
            
                        if($user_os === 'mobile'){
                                $user_online = '<img src = imgs/phone.png class = zdesya_img />';
                            }else{
                                    $user_online = '<img src = imgs/zdesya.png class = zdesya_img />';
                            }
            }
         
/********************************************************************************************************************************************************/   

// ИЩЕМ АВУ
            $sql = "SELECT * FROM `additional_info` WHERE `nickname`='{$answered_questions[$i]['supporter']}'";	
            $query = $connection_handler->prepare($sql); 
            $query->execute();
            $avatar = $query->fetchAll(PDO::FETCH_ASSOC);
            $supporter_avatar = $avatar[0]['avatar'];
         
              $sql = "SELECT last_action_time FROM main_info WHERE nickname='{$answered_questions[$i]['supporter']}'"; // Выбираем время последней активности пользователя	
                $query = $connection_handler->prepare($sql); //Подготавливаем запрос
                $query->execute();
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                $last_action_time = $result[0]['last_action_time'];
         
             $current_time = time();
         
         $online = ""; /* Текст, который будет отображаться в месте онлайн */
        if(($current_time - $last_action_time) <= 180){ // Разница <= 180 секунд
            
                /* ПРОВЕРЯЕМ С КАКОГО УСТРОЙСТВА ЗАЩЕЛ ПОЛЬЗОВАТЕЛЬ */
                $sql = "SELECT * FROM `main_info` WHERE `nickname`='{$answered_questions[$i]['supporter']}'"; 	
                $query = $connection_handler->prepare($sql); //Подготавливаем запрос
                $query->execute();
                $supporter_os = $query->fetchAll(PDO::FETCH_ASSOC);
                $supporter_os = $user_os[0]['os'];
            
                        if($supporter_os === 'mobile'){
                                $supporter_online = '<img src = imgs/phone.png class = zdesya_img />';
                            }else{
                                    $supporter_online = '<img src = imgs/zdesya.png class = zdesya_img />';
                            }
            }
         

/********************************************************************************************************************************************************/ 
         
         $questions_outp .= "<section id = 'question_container_" . $answered_questions[$i]['this_id'] . "' class = 'question_container'>
         <div class = 'avatar_nickname_container'>
             <a href = 'user.php?zs=" . $answered_questions[$i]['user'] . "'><img class = 'avatar' src = 'users/" . $user_avatar . "' />" . $user_online . "</a>
             <a class = nick href = user.php?zs=" . $answered_questions[$i]['user'] . ">" . $answered_questions[$i]['user'] . "</a><br />
             <span class = 'date'>" . $answered_questions[$i]['date'] . "</span>
         </div>
         <div class = 'question_content'>
             <span style = 'color:blue'>Вопрос</span><br />
             <span style = 'text-decoration:underline;'>" . $answered_questions[$i]['question_header'] . "</span><br />
        <span>" . tolink($answered_questions[$i]['question_text'])  . "</span>
        </div>
        <div class = 'answer_container'>
        <div class = 'avatar_nickname_container'>
             <a href = 'user.php?zs=" . $answered_questions[$i]['supporter'] . "'><img class = 'avatar' src = 'users/" . $supporter_avatar . "' />" . $supporter_online . "</a>
             <a class = nick href = user.php?zs=" . $answered_questions[$i]['supporter'] . ">" . $answered_questions[$i]['supporter'] . "</a><br />
         </div>
             <span style = 'color:blue'>Ответ</span><br />
         <span>" . tolink($answered_questions[$i]['answer_text'])  . "</span>
        </div>
       
        </section>";

     }
     
     echo $questions_outp;
   
   
   ?>
    
    
</div>


</div><!-- class=row -->

</main>    

</body>    

</html>    

<?php ob_end_flush(); ?>