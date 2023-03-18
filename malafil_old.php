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

function tolink($text) { // Превращение в ссылку
 
 $text = preg_replace("/(^|[\n ])([\w]*?)((ht|f)tp(s)?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", "$1$2<a href='$3' target = _blank>$3</a>", $text);
 $text = preg_replace("/(^|[\n ])([\w]*?)((www|ftp)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a href='http://$3' target = _blank>$3</a>", $text); 
 $text = preg_replace("/(^|[\n ])([\w]*?)(\.[^ \,\"\t\n\r<]*)/is", "<a href='http://$0' target = _blank>$0</a>", $text); 
 $text= preg_replace("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1<a href='mailto:$2@$3' target = _blank>$2@$3</a>", $text);
 
 return $text;
}

?>

<html>

<head>
<title>Malafil</title>
<meta charset = "utf-8" />

<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name = "description" content = "Хорошие истории просто" />
    <meta name="keywords" content = "История,зеленый слоник, бердянск,больничка, сергей пахомов, владимир епифанцев,александр маслаев,александр осмоловский,сладкий хлеб,азов,украина,путин,политика" / >
    <meta name = "author" content = "Александр Неминуев">

<link rel = "stylesheet" href = "css/normalize.css"  type = "text/css" />
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel = "stylesheet" src = "css/roboto/roboto.css">
<script src="bootstrap/js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

<meta property="og:title" content="Какую ты мне щас историю расскажешь еще?"/>
<meta property="og:description" content="Хорошие истории просто"/>
<meta property="og:image" content="users/user_page_logo.png">
<meta property="og:type" content="article"/>
<meta property="og:url" content= "//frendors.com/malafil.php" />


<script type="text/javascript" src="//vk.com/js/api/openapi.js?136"></script>
<script type="text/javascript">
  VK.init({apiId: 5757931});
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
    font-size:20px;
    width: 100%;
    background-color:#cefdce;
    margin:0 auto;
    height:100%;
}

main {
    padding: 10px;
    border-left:1px solid blue;
    border-right:1px solid blue;
    width:100%;
     padding-bottom: 90px;
    }
    
    input[type=text],input[type=password],input[type=email],textarea{
          padding:5px;
          border-radius:5px;
 }
 
  input[type=text]:focus,input[type=password]:focus,input[type=email]:focus,input[type=checkbox]:focus,textarea:focus{
     background-color: #98DDDE;
     box-shadow: 0px 0px 1px #7FFFD4;
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

header li:hover {

background: #9dd53a; /* Old browsers */
background: -moz-linear-gradient(top,  #9dd53a 0%, #a1d54f 50%, #80c217 51%, #7cbc0a 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top,  #9dd53a 0%,#a1d54f 50%,#80c217 51%,#7cbc0a 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom,  #9dd53a 0%,#a1d54f 50%,#80c217 51%,#7cbc0a 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#9dd53a', endColorstr='#7cbc0a',GradientType=0 ); /* IE6-9 */

}

header li:active {

background: #7cbc0a; /* Old browsers */
background: -moz-linear-gradient(top, #7cbc0a 0%, #80c217 49%, #a1d54f 50%, #9dd53a 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top, #7cbc0a 0%,#80c217 49%,#a1d54f 50%,#9dd53a 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom, #7cbc0a 0%,#80c217 49%,#a1d54f 50%,#9dd53a 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#7cbc0a', endColorstr='#9dd53a',GradientType=0 ); /* IE6-9 */

}

.header_items_img {
height:30px;
width:30px;
}

.likes_dislikes_container {
color:blue; 
margin-bottom:10px;
}

.likes_container, .dislikes_container  {
padding:5px;
border-radius:5px;
width:120px;
}

.videocontainer {
  display:inline-block; 
  width:300px;
  word-break:break-all; 
  margin:10px;  
}

.avatar{
    width:80px;
    height:80px;
    border-radius:5px;
    display:block;
    float:left;
    margin-right:10px;
}

.disc_container{
    width:100%;
    margin-bottom:10px;
}

.disc_container:hover{
    background-color:white;
    opacity:0.7;
    cursor:pointer;
}

.disc_name{
    color:blue;
    font-size:25px;
    text-decoration:underline;
}

.disc_author{
    font-size:20px;
    
}

.disc_text{
    width:100%;
    max-height:60px;
    overflow: hidden;
    word-wrap:break-word;
}

.likes_story_container{
  float:left;
  display:inline-block;
  border-radius:5px;
  margin-right:10px;
  padding:5px;
}

.dislikes_story_container{
  display:inline-block;
  border-radius:5px;
  margin-right:10px;
  padding:5px;
}

.like_img, .dislike_img {
    width:30px;
    height:30px;
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
$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();

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

echo '<a href = user.php?zs=' . $_SESSION['user'] . '>' . $_SESSION['user'] . '</a>';

}

?>

<main class = "container-fluid">

<div class = "row" style = "padding:5px">

<div id="vk_like"></div>
<script type="text/javascript">
    VK.Widgets.Like("vk_like", {type: "button"});
</script>

<?php


$story_input = '';

if(session_isset()){
    $story_input = '<h3 style = "color:blue;text-decoration:underline;">Напишите свою историю здеся</h3><h4 style = "color:blue;">Заголовок</h4>
<input type = "text" id = "disc_topic" maxlength = "1000" style="width:100%" autofocus = "autofocus" required = "required" oninput = "show_disc_textarea()" /><br />
<div id = "disc_container" style = "display:none;"><h4 style = "color:blue;">История</h4>
<textarea id = "disc_textarea" style = "resize:none;width:100%" rows = "4" maxlength = "3000" required = "required"></textarea><br />
<span id = "errors_span"></span>
<button type = "button" class="btn btn-primary" onclick = "send_disc_topic()">Ахуенно</button>
</div>
<hr />';

    echo $story_input;
    
}

?>


<span style = "color:green">Какую ты мне сейчас историю расскажешь еще?</span>

<hr />

<?php 

/* Отобразить темы историй*/

$sql = "SELECT * FROM `common_discussions` ORDER BY `this_id` DESC";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$discussions = $query->fetchAll(PDO::FETCH_ASSOC);

if(!empty($discussions)){
for($i = 0; $i < count($discussions);$i++){

$name = $discussions[$i]['name'];
$text = $discussions[$i]['text'];
$author = $discussions[$i]['author'];
$id = $discussions[$i]['this_id'];
$date = $discussions[$i]['date'];

$sql = "SELECT * FROM `additional_info` WHERE `nickname`='{$author}'";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$avatar = $query->fetchAll(PDO::FETCH_ASSOC);
$avatar = $avatar[0]['avatar'];

if(strlen($name) > 80){
     $name = mb_substr($name,0,80);
    $name .= " >>>";
}

if(strlen($text) > 200){
    $text = mb_substr($text,0,200);
    $text .= " >>>";
}

$sql = "SELECT COUNT(*) AS `likes_count` FROM `common_discussions_likes_under_story` WHERE `story_id`={$id}";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$likes_count_story = $query->fetchAll(PDO::FETCH_ASSOC);
$likes_count_story = $likes_count_story[0]['likes_count']; 

$sql = "SELECT COUNT(*) AS `dislikes_count` FROM `common_discussions_dislikes_under_story` WHERE `story_id`={$id}";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$dislikes_count_story = $query->fetchAll(PDO::FETCH_ASSOC);
$dislikes_count_story = $dislikes_count_story[0]['dislikes_count']; 

$discussion_container = "<section class = 'disc_container' id = 'disc_container_{$id}' onclick = window.location.replace('story.php?id={$id}')>
<div><a href = 'user.php?zs={$author}'><img class = 'avatar' src = 'users/{$avatar}'/></a>
<div><a title = '{$name}' class = 'disc_name' href = 'story.php?id={$id}'>{$name}</a><br />
<a href = 'user.php?zs={$author}' class = 'disc_author'>$author</a><br />
<span>{$date}</span>
</div>
</div>" .
"<div style='height:1px; background:black;margin-left:5px;' ></div>
<div class = 'disc_text'>" . tolink($text) . "</div>
<div style='height:1px; background:white;margin-top:5px;' ></div>

    </div>
</section>";

echo $discussion_container;

}
    
}

?>

<script>

function show_disc_textarea(){
    var disc_container = document.getElementById("disc_container");
    disc_container.style.display = "block";
}

function send_disc_topic(){
  var disc_topic = document.getElementById("disc_topic");
  var disc_textarea = document.getElementById("disc_textarea");
  var errors_span = document.getElementById("errors_span");
  var errors_txt = "";
  var send_story_flag = true;

   if(disc_topic.value === ""){
    errors_txt += "Где название нахуй!?<br />";
    send_story_flag = false;
    }
    
    if(disc_topic.value.match(/^\s+$/g)){
    errors_txt += "Одни пробелы в названии  нахуй!?<br />";
send_story_flag = false;
    }
    
    if(disc_textarea.value.match(/^\s+$/g)){
     errors_txt += "Одни пробелы в истории  нахуй!?<br />";
   send_story_flag = false;
}

if(disc_textarea.value === ""){
     errors_txt +="Где история нахуй!?<br />";
    send_story_flag = false;
    } 

if(send_story_flag == false){
    errors_span.innerHTML = errors_txt;
    return;
}


var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
    disc_topic.value = "";
    disc_textarea.value = "";
    errors_span.innerHTML = xmlhttp.response + "<br />";
    setTimeout(window.location.reload(),3000);

} 
}

var formData = new FormData();
formData.append('name', disc_topic.value.trim());
formData.append('text', disc_textarea.value.trim());

xmlhttp.open("POST", "scripts/common_discussions.php", true);
xmlhttp.send(formData);

}

</script>

</div><!-- class = row -->

</main>    

<!-- <script>

  var  success_video_uploading_button = document.getElementById('success_video_uploading_button'); // Кнопка после удачной загрузки видоса
  var  MAX_FILE_SIZE = document.getElementById('MAX_FILE_SIZE');   // Максимальный размер файла
  var errors_video_uploading = document.getElementById('errors_video_uploading');
  var videofile_info = document.getElementById('videofile_info');
  var txt_videofile_info = ""; // Информация о видеофайле
  var txt_videofile_errors = ""; // Ошибки
  var upload_video_flag = true; // Флаг загрузки видео
  var success_video_uploading = document.getElementById('success_video_uploading');
  var videofile = document.getElementById("video_file").files[0]; // Файл видео   
  var video_description = document.getElementById('video_description');

function check_file(){
      var videofile = document.getElementById("video_file").files[0]; // Файл видео   
var accept = ['video/mpeg','video/mp4','video/ogg','video/quicktime','video/webm','video/x-flv','video/3gpp','video/3gpp2']; // Список поддерживаемых файлов
 
 /* Проверяем поддерживается ли формат видео */
  if(accept.indexOf(videofile.type) == -1){
    txt_videofile_errors = "Данный формат видео не поддерживается <br />";
    upload_video_flag = false;
    }else if(videofile.size > 104857600){
    txt_videofile_errors = "Размер видео должен быть <= 100 Мб <br />";
    upload_video_flag = false;
        }

if(txt_videofile_errors !== ""){ // Ошибки есть
    errors_video_uploading.innerHTML = txt_videofile_errors;
    upload_video_flag = false;
    return;
} else { // Ошибок нет

txt_videofile_info += "Имя: " + videofile.name + "<br />";
txt_videofile_info += "Размер: " + Math.ceil(((videofile.size/1024)/1024) * 10) / 10 + " Мб<br />";
txt_videofile_info += "Тип: " + videofile.type + "<br />"; 

videofile_info.innerHTML = txt_videofile_info;

}

}

function upload_video(){ // Загружаем видео
var video_name = document.getElementById('video_name'); 

if(video_name.value === ""){
    alert("Видео без названия! Ты чо мудак штоль совсем!?");
    return;
} 
  
 if(upload_video == false){
     return;
 } else {
var videofile = document.getElementById("video_file").files[0]; // Файл видео 
var result_video_uploading = document.getElementById('result_video_uploading');

var video_name = document.getElementById('video_name'); 
var video_description = document.getElementById('video_description');

var progressBar = $('#progressbar');

var formData = new FormData();
    formData.append('videofile', videofile);
    formData.append('MAX_FILE_SIZE', MAX_FILE_SIZE.value);
    formData.append('video_name',video_name.value);
    formData.append('video_description',video_description.innerHTML);
    
    $.ajax({
      url: "common_videofiles/upload_common_videofile.php",
      type: "POST",
      contentType: false,
      processData: false,
      data: formData,
      dataType: 'html',
      xhr: function(){
        var xhr = $.ajaxSettings.xhr(); // получаем объект XMLHttpRequest
        xhr.upload.addEventListener('progress', function(evt){ // добавляем обработчик события progress (onprogress)
          if(evt.lengthComputable) { // если известно количество байт
            // высчитываем процент загруженного
            var percentComplete = Math.ceil(evt.loaded / evt.total * 100);
            // устанавливаем значение в атрибут value тега <progress>
            // и это же значение альтернативным текстом для браузеров, не поддерживающих <progress>
            progressBar.val(percentComplete).text('Загружено ' + percentComplete + '%');
            result_video_uploading.innerHTML = percentComplete + "%";
          if(percentComplete == 100){
            success_video_uploading_button.style.display = "block";  
                }
            }
        }, false);
        return xhr;
      },
      success: function(response){
         success_video_uploading.innerHTML = response;      
        }
    });
}

}

</script> -->


</body>    

</html>    

<?php ob_end_flush(); ?>