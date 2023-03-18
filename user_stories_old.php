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
 
 $text = preg_replace("/(^|[\n ])([\w]*?)((ht|f)tp(s)?:\/\/[\w]+[^\"\n\r\t<]*)/is", "$1$2<a href='$3' target = _blank>$3</a>", $text);
 $text = preg_replace("/(^|[\n ])([\w]*?)((www|ftp)\.[^\"\t\n\r<]*)/is", "$1$2<a href='http://$3' target = _blank>$3</a>", $text); 
 $text = preg_replace("/(^|[\n ])([\w]*?)(\.[^\"\t\n\r<]*)/is", "<a href='http://$0' target = _blank>$0</a>", $text); 
 $text= preg_replace("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1<a href='mailto:$2@$3' target = _blank>$2@$3</a>", $text);
 
 return $text;
}

?>

<html>

<head>
<title>Истории</title>
<meta charset = "utf-8" />
<link rel = "stylesheet" href = "css/normalize.css"  type = "text/css" />
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel = "stylesheet" src = "css/roboto/roboto.css">
<script src="bootstrap/js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>

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

<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

<style>

body {
    font-family:'Roboto';
    width: 99%;
    background-color:#cefdce;
    margin:0 auto;
    height:100%;
    font-size:20px;
    font-weight:bold;
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

.header_items_img {
height:30px;
width:30px;
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

.likes_dislikes_story_container{
color:blue;
margin-bottom:10px;
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

}

?>

<main class = "container-fluid">

<div class = "row">

<?php

$user = $_GET['zs'];

 $sql = "SELECT * FROM `main_info` WHERE `nickname`='{$user}'";	
 $query = $connection_handler->prepare($sql); 
 $query->execute();
 $result = $query->fetchAll(PDO::FETCH_ASSOC);

if(!empty($user) && $user == $_SESSION['user']){ // Сидим на своей странице и смотрим свои истории. Свои истории может отправлять только сессионный

         $sql = "SELECT * FROM `main_info` WHERE `nickname`='{$user}'";	
         $query = $connection_handler->prepare($sql); 
         $query->execute();
         $result = $query->fetchAll(PDO::FETCH_ASSOC);

$story_input = "";

        if(!empty($result)){
            $story_input = '<h3 style = "color:blue;text-decoration:underline;">Напишите свою историю здеся</h3><h4 style = "color:blue;">Заголовок</h4>
        <input type = "text" id = "story_topic" maxlength = "1000" style = "width:100%" autofocus = "autofocus" required = "required" oninput = "show_story_textarea()" /><br />
        <div id = "story_container" style = "display:none;"><h4 style = "color:blue;">История</h4>
        <textarea id = "story_textarea" style = "resize:none;width:100%" rows = "4" maxlength = "3000" required = "required"></textarea><br />
        <span id = "story_errors_span"></span><br />
        <button type = "button" class="btn btn-primary" onclick = "send_story()">Ахуенно</button>
        </div>
        <hr />';
}
    echo $story_input;

}
  echo "<a href = user.php?zs={$user}>&lt;&lt; {$user}</a>";
?>
<style>

.story_container{
    margin-bottom:10px;
}

.story_container:hover{
    background-color:white;
    opacity:0.7;
    cursor:pointer;
}

.story_name{
    color:blue;
    font-size:25px;
    text-decoration:underline;
}

.story_author{
    font-size:20px;
}

.story_text{
    max-height:60px;
    overflow: hidden;
    word-wrap:break-word;
}

.story_date {
    color:gray;
    font-size:12px;
}

</style>

<?php 

/* Отобразить темы историй*/
if(!empty($user)){

$sql = "SELECT * FROM `user_stories` WHERE `author`='{$user}' ORDER BY `this_id` DESC";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$user_stories = $query->fetchAll(PDO::FETCH_ASSOC);

if(!empty($user_stories)){
for($i = 0; $i < count($user_stories);$i++){

$name = $user_stories[$i]['name'];
$text = $user_stories[$i]['text'];
$author = $user_stories[$i]['author'];
$id = $user_stories[$i]['this_id'];
$date = $user_stories[$i]['date'];

$sql = "SELECT * FROM `additional_info` WHERE `nickname`='{$author}'";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$avatar = $query->fetchAll(PDO::FETCH_ASSOC);
$avatar = $avatar[0]['avatar'];

$sql = "SELECT COUNT(*) AS `likes_count` FROM `user_stories_like_under_story` WHERE `story_id`={$id}";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$likes_count_story = $query->fetchAll(PDO::FETCH_ASSOC);
$likes_count_story = $likes_count_story[0]['likes_count']; 

$sql = "SELECT COUNT(*) AS `dislikes_count` FROM `user_stories_dislike_under_story` WHERE `story_id`={$id}";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$dislikes_count_story = $query->fetchAll(PDO::FETCH_ASSOC);
$dislikes_count_story = $dislikes_count_story[0]['dislikes_count']; 

if(strlen($name) > 80){
     $name = mb_substr($name,0,80);
    $name .= " >>>";
}

if(strlen($text) > 200){
    $text = mb_substr($text,0,200);
    $text .= " >>>";
}

$stories_container = "<section class = 'story_container' id = 'story_container_{$id}' onclick = window.location.replace('user_story.php?id={$id}')>
<div><a title = '{$name}' class = 'story_name' href = 'user_story.php?id={$id}'>{$name}</a><br />
<span class = 'story_date'>{$date}</span>
</div>
</div>
<div style='height:1px; background:black;margin-left:5px;' ></div>
<div class = 'story_text'>" . tolink($text) . "</div>
<div style='height:1px; background:white;margin-top:5px;' ></div>
<div class = 'likes_dislikes_story_container'>" .
    "<div class = 'likes_story_container' ><img class = 'like_img' src = 'imgs/like.png' /> Ахуенно | <span id = likes_story_counter_span_" . $id . ">"  . $likes_count_story  . "</span></div>
    <div class = dislikes_story_container   ><img class = dislike_img src = imgs/dislike.png /> Гавно! | <span id = dislikes_story_counter_span_" . $id . ">" . $dislikes_count_story . "</span></div>
    </div>
    </div>
</section>";

echo $stories_container;

}
    
}

}

?>

<script>

function show_story_textarea(){
    var story_container = document.getElementById("story_container");
    story_container.style.display = "block";
}

function send_story(){
  var story_topic = document.getElementById("story_topic");
  var story_textarea = document.getElementById("story_textarea");
  var story_errors_span = document.getElementById("story_errors_span");
  var errors_txt = "";
  var send_story_flag = true;

   if(story_topic.value === ""){
    errors_txt += "Где название нахуй!?<br />";
    send_story_flag = false;
    }
    
    if(story_topic.value.match(/^\s+$/g)){
    errors_txt += "Одни пробелы в названии  нахуй!?<br />";
send_story_flag = false;
    }
    
    if(story_textarea.value.match(/^\s+$/g)){
     errors_txt += "Одни пробелы в истории  нахуй!?<br />";
   send_story_flag = false;
}

if(story_textarea.value === ""){
     errors_txt +="Где история нахуй!?<br />";
    send_story_flag = false;
    } 

if(send_story_flag == false){
    story_errors_span.innerHTML = errors_txt;
    return;
}

var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
story_topic.value = "";
story_textarea.value = "";
story_errors_span.innerHTML = xmlhttp.response;
setTimeout(window.location.reload(),3000);
} 
}

var formData = new FormData();
formData.append('name', story_topic.value.trim());
formData.append('text', story_textarea.value.trim());

xmlhttp.open("POST", "scripts/write_user_story.php", true);
xmlhttp.send(formData);

}

</script>

<div><!-- class=row -->

</main>    

</body>    

</html>    

<?php ob_end_flush(); ?>