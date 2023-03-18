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
<title>Випы</title>
<meta charset = "utf-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel = "stylesheet" href = "css/normalize.css"  type = "text/css" />
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel = "stylesheet" src = "css/roboto/roboto.css">
<script src="bootstrap/js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

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

<?php 

if(!empty($_SESSION['user'])){

            $sql = "SELECT * FROM `vips` WHERE `user`='{$_SESSION['user']}'";	
            $query = $connection_handler->prepare($sql); 
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
                if(empty($result)){
                    header('Location: index.php');
                    exit();
                }
}else{
    header('Location: index.php');
    exit();
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
<input  id = "add_vip_input" style = "resize:none;width:99%;margin-bottom:10px"  maxlength = "100" required = "required"><br />
<button id = "add_vip_button" type = "button" class="btn btn-primary btn-md" onclick = "add_vip()">Ахуенно</button>
</div>
<script>

function add_vip(){
    var add_vip_input = document.getElementById("add_vip_input");

    if(add_vip_input.value == "" || add_vip_input.value.match(/^\s+$/g)){
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
formData.append("vip", add_vip_input.value.trim());

xmlhttp.open("POST", "scripts/add_vip.php", true);
xmlhttp.send(formData);

}
</script>';
echo $story_input;

/*************************************************************************************************************************************************************/

}

?>

<style>
   
   #vips_container{
     background-color:#ffffcc;
    border:2px solid #ffeb3b;
    border-radius:5px; 
    width:310px; 
    margin-top:10px;
}

#vip_header{
padding:5px;
border-bottom:1px solid green;
word-wrap:break-word;
height:30px;
}

#vips_table{
word-wrap:break-word;
}

.vip_number{
    min-width:10px;
    text-align:center;
    border-right:1px solid black;
    padding:5px;
}

.vip_name{
    padding:5px;
}

.delete_vip_a,{
    font-size:15px;
    color:green;
}

textarea{
    resize:none;
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
$sql = "SELECT * FROM `vips`"; 
    $query = $connection_handler->prepare($sql);
    $query->execute();
$vips = $query->fetchAll(PDO::FETCH_ASSOC); 

?>

<?php 

if($_SESSION['user'] === 'Adminto'){

        echo '<table id = "vips_table">';
        
        $number = 1;
        
        $delete_vip_function = "";
        
        for($i = 0; $i < count($vips); $i++){
        
        if($_SESSION['user'] === 'Adminto'){
         $delete_vip_function = '<td><a class = "delete_vip_a" href="#"  onclick = delete_vip(this,"' . $vips[$i]['id'] . '")>Удалить</a></td>';   
        }
        
        echo '<tr>
            <td class = "vip_number">' . $number++ .'</td>
            <td class = "vip_name"><a href = "user.php?zs=' . $vips[$i]['user'] . '">' . $vips[$i]['user'] . '</a></td>' 
         . $delete_vip_function .
        '</tr>';    
            
        }
        
        echo '</table>';
        
        echo '<script>
        
        function delete_vip(a, id){
           
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
        
        xmlhttp.open("POST", "scripts/delete_vip.php", true);
        xmlhttp.send(formData);
        
        }
        
        
        </script>';
}

?>

<section id = "daily_news_section" style = "border:1px solid black;margin:10px;padding:5px;">
<h1 color = "blue">Новость дня</h1>
<span style = "color:gray;font-size:15px;">формат ссылки [домен]/[путь к файлу (a-zA-Z0-9_/-.?&;#%=+)]</span><br />
Заголовок <input  id = "daily_news_header" style = "width:99%;margin-bottom:10px;padding:5px;"  maxlength = "160" required = "required">
Ссылка<br /><input id = "daily_news_link" style = "width:99%;padding:5px" maxlength = "300" reqiured = "required">
<span id = "daily_news_errors_span" style = "display:block;margin-bottom:5px"></span>
<button type = "button" class="btn btn-primary btn-md" onclick = "add_daily_news()">Ахуенно</button>

<script>

function add_daily_news(){
    var daily_news_header = document.getElementById("daily_news_header");
    var daily_news_link = document.getElementById("daily_news_link");
    var daily_news_errors_span = document.getElementById("daily_news_errors_span");
    var errors_txt = "";
    var send_flag = true;
    
    if(daily_news_header.value == "" || daily_news_header.value.match(/^\s+$/g)){
        errors_txt += "Пустой заголовок<br />";
        send_flag = false;
    }
    
    if(daily_news_link.value == "" || !daily_news_link.value.match(/(^|[\n ])([\w]*?)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;#:%=+,])*)*)/ig)){
        errors_txt += "Ссылка не соответствует формату<br />";
        send_flag = false;
    }
    
    if(send_flag == false){
       daily_news_errors_span.innerHTML = errors_txt;
       return;
    }
    
    var xmlhttp = new XMLHttpRequest();
    
    xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
daily_news_header.value = "";
daily_news_link.value = "";
daily_news_errors_span.innerHTML = xmlhttp.response;
  
    } 
}

var formData = new FormData();
formData.append('header', daily_news_header.value.trim());
formData.append('link', daily_news_link.value.trim());

xmlhttp.open("POST", "scripts/change_daily_news.php", true);
xmlhttp.send(formData);
    
}

</script>

</section>

<section id = "daily_news_section" style = "border:1px solid black;margin:10px;padding:5px;">
<h1 color = "blue">Видио дня</h1>
<span style = "color:gray;font-size:15px;">формат видио<br />
ВК <a href = "//vk.com/video_ext.php?oid=-1964347&id=31878524&hash=28f536f0e589b7de" target = "_blank">//vk.com/video_ext.php?oid=-1964347&id=31878524&hash=28f536f0e589b7de</a><br />
Ютуба <a href = "https://www.youtube.com/watch?v=amEoQtlJ2lE" target = "_blank">https://www.youtube.com/watch?v=amEoQtlJ2lE</a>
</span><br />
Ссылка<br /><input id = "daily_video_link" style = "width:99%;padding:5px" maxlength = "300" reqiured = "required">
<span id = "daily_video_errors_span" style = "display:block;margin-bottom:5px"></span>
<button type = "button" class="btn btn-primary btn-md" onclick = "add_daily_video()">Ахуенно</button>

<script>

function add_daily_video(){
    var daily_video_link = document.getElementById("daily_video_link");
    var daily_video_errors_span = document.getElementById("daily_video_errors_span");

    if(!daily_video_link.value.match(/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)([a-zA-Z0-9\-_]{1,256})/ig) && 
        !daily_video_link.value.match(/(^|[\n ])([\w]*?)(\/\/vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=])+/ig)){
         daily_video_errors_span.innerHTML = "Ссылка не соответствует формату<br />";
        return;
    }
    
    var xmlhttp = new XMLHttpRequest();
    
    xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
daily_video_link.value = "";
daily_video_errors_span.innerHTML = xmlhttp.response;
  
    } 
}

var formData = new FormData();
formData.append('link', daily_video_link.value.trim());

xmlhttp.open("POST", "scripts/change_daily_video.php", true);
xmlhttp.send(formData);
    
}

</script>

</section>

<section id = "daily_image_section" style = "border:1px solid black;margin:10px;padding:5px;">
<h1 color = "blue">Картинка дня</h1>
Ссылка<br /><input id = "daily_image_link" style = "width:99%;padding:5px" maxlength = "300" reqiured = "required">
<span id = "daily_image_errors_span" style = "display:block;margin-bottom:5px"></span>
<button type = "button" class="btn btn-primary btn-md" onclick = "add_image_video()">Ахуенно</button>

<script>

function add_image_video(){
    var daily_image_link = document.getElementById("daily_image_link");
    var daily_image_errors_span = document.getElementById("daily_image_errors_span");

    if(!daily_image_link.value.match(/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([a-zA-Z0-9_\-.]{2,256})\.([a-zA-Z]{2,6})[\/]([a-zA-Z0-9_\/\-.?&;%=+])+(png|jpg|jpeg|gif)/ig)){
         daily_image_errors_span.innerHTML = "Ссылка не соответствует формату<br />";
        return;
    }
    
    var xmlhttp = new XMLHttpRequest();
    
    xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
daily_image_link.value = "";
daily_image_errors_span.innerHTML = xmlhttp.response;
  
    } 
}

var formData = new FormData();
formData.append('link', daily_image_link.value.trim());

xmlhttp.open("POST", "scripts/change_daily_image.php", true);
xmlhttp.send(formData);
    
}

</script>

</section>


</div><!-- class=row -->

</main>    

</body>    

</html>    

<?php ob_end_flush(); ?>