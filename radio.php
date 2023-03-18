<?php ob_start(); ?>

<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
ini_set('display_errors', 'On');
function session_isset(){ // Пользователь вошел
if(!empty($_SESSION['user'])){ // Пользователь вошел через логин-пароль
return true;
} else {
return false;
}
}

if(session_isset()){
$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute(); 
    
}

$facebook_client_id = '105917036567372';
$facebook_client_secret = '9aabc3fc9c30da1a922f615a1dbf2687';

$hashed_string = $facebook_client_id . $facebook_client_secret;

$fb_hash = crypt($hashed_string,'babushka_Misha');

/* ОС пользователя */
if(session_isset()){ 
 $user_os = strtolower($_SERVER['HTTP_USER_AGENT']);
 $user_os_in_bd = "";
if(stripos($user_os,'android') !== false || stripos($user_os,'mobile') !== false || stripos($user_os,'iphone') !== false || stripos($user_os,'ipod') !== false || stripos($user_os,'ipad') !== false )  {
     $user_os_in_bd = "mobile";
  }else {
    $user_os_in_bd = "not_mobile";
} 

 // ВСТАВЛЯЕМ ОС В ТАБЛИЦУ 
        $sql = "UPDATE `main_info` SET `os`='$user_os_in_bd' WHERE `nickname`='{$_SESSION['user']}'";
        $query = $connection_handler->prepare($sql);
        $query->execute();  
}

?>

<!DOCTYPE html>
<html>

<head>
<title>Radio</title>
<meta charset = "utf-8" />
<link rel = "stylesheet" href = "css/normalize.css"  type = "text/css" />
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel = "stylesheet" src = "css/roboto/roboto.css">
<script src="bootstrap/js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name = "description" content = "Radio outminded" />
<meta name="keywords" content = "radio, outmind, crazy, outstanding" / >
<meta name = "author" content = "Frendors">

<meta property="og:title" content="Radio"/>
<meta property="og:description" content="Radio outminded"/>
<meta property="og:image" content="universe.jpg">
<meta property="og:type" content="article"/>
<meta property="og:url" content= "//frendors.com/radio.php">

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

 <!-- Put this script tag to the <head> of your page -->
<script type="text/javascript" src="https://vk.com/js/api/openapi.js?159"></script>
<script type="text/javascript" src="//vk.com/js/api/openapi.js?136"></script>
<script type="text/javascript" src="//vk.com/js/api/openapi.js?137"></script>
<script type="text/javascript" src="//vk.com/js/api/openapi.js?167"></script>
<script type=text/javascript>
  VK.init({apiId: 6686305, 
  onlyWidgets: true});
</script>

<script type='text/javascript'>
  VK.init({apiId: 5757931});
</script>

<script type='text/javascript'>
        
        VK.Widgets.Auth('vk_auth', {
            width: '200px', 
            onAuth: function(data) {
         var user_id = data['uid'];
         var first_name =  data['first_name'];
         var last_name = data['last_name'];
         var hash = data['hash'];
        
         var first_last_name = first_name + '_' + last_name;
         
         window.location.replace('vk_registration.php?vk_name=' + first_last_name + '&user_id=' + user_id + '&a_cho_tam=' + hash);
                
        } 
        
        });
        
        </script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script>
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
    
    FB.api('/me', function(response) {

window.location.replace("facebook_auth.php?name=" + response.name.replace(" ","_") + "&id=" + response.id + "&a_cho_tam=<?php echo $fb_hash; ?>");

    });


    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into Facebook.';
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
  FB.init({
    appId      : '105917036567372',
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v6.0' // use graph api version 2.8
  });

  // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

</script>

<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '105917036567372',
      xfbml      : true,
      version    : 'v6.0'
    });
  };

</script>

<?php

if (!session_isset()){

echo "<script type='text/javascript'>
  VK.init({apiId: 5757931});
</script>

<script type='text/javascript'>
        
        VK.Widgets.Auth('vk_auth', {
            width: '200px', 
            onAuth: function(data) {
         var user_id = data['uid'];
         var first_name =  data['first_name'];
         var last_name = data['last_name'];
         var hash = data['hash'];
        
         var first_last_name = first_name + '_' + last_name;
         
         window.location.replace('vk_registration.php?vk_name=' + first_last_name + '&user_id=' + user_id + '&a_cho_tam=' + hash);
                
        } 
        
        });
        
        </script>";
}

?>

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

.audio_img {
  width:100px;
  height:100px;
  cursor:pointer;
}

.audio_img:hover{
    transform:scale(1.1);
}

</style>

</head>    

<body onload = "play_radio();">

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
//$query->bindParam(':joined', $_SESSION['user'], PDO::PARAM_STR); // Пользователь к к которому зашли. Принимают заявку
$query->execute();
$sessioner_joined_new_message_count = $query->fetchAll(PDO::FETCH_ASSOC);
$sessioner_joined_new_message_count = $sessioner_joined_new_message_count[0]['new_message_sessioner_joined'];         

/* ИЗВЛЕКАЕМ НОВЫЕ АТИВНЫЕ ДИАЛОГИ ГДЕ СЕССИОННЫЙ ЯВЛЯЕТСЯ ИНИЦИАТОРОМ */
$sql = "SELECT COUNT(*) AS 'new_message_sessioner_initiator' FROM `dialogs` WHERE `initiator`='{$_SESSION['user']}'  AND `is_finished_for_initiator` = 0";	
$query = $connection_handler->prepare($sql); 
//$query->bindParam(':joined', $_SESSION['user'], PDO::PARAM_STR); // Пользователь к к которому зашли. Принимают заявку
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
<!-- Modal -->
<div id="upload_audio_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style = "width:610px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" title = "Загрузить">Новое аудио</h4>
      </div>
      <div class="modal-body">
        
        <div>
    <h4 style = "text-align:center">Загружаем аудио</h4>
    <p style = "display:block; margin-left: 5px">Только mp3 </p>
    <p>Не закрывайте окно пока не появится кнопка "Ахуенно"</p>
    <p style = "display:block; margin-left: 5px"><= 16мБ </p>
    <form id = "upload_audio_form" >
    <input id = "MAX_FILE_SIZE" type="hidden" value="16000000" />
    Исполнитель<br />
    <input value = "" type = "text" maxlength = "80" autofocus="autofocus" id = "audio_author" size = "60" /><br /><br /> 
     Название<br />
    <input value = "" type = "text" maxlength = "80" id = "audio_name" size = "60" /><br /><br />
    Описание<br />
    <textarea maxlength = "1000" id = "audio_description" style = "resize:none" cols = "60" rows = "5"></textarea><br />
    <progress id="progressbar" value="0" max="100"></progress><span id = "progress_percents"></span>
    <input type = "file" style = "margin-bottom: 5px" id = "audio_file" accept = "audio/mp3" onchange = "check_file();" /><br />
   
    <p id = "audiofile_info"></p>
    <p id = "result_audio_uploading"></p>
    <button type = "button" id = "upload_button" onclick = "upload_audio();">Загрузить</button>
    </form>    
    <p style = "display:block; margin-left: 5px" id = "errors_audio_uploading"> </p>
     <p id = "success_audio_uploading"></p>
    <button id = "success_audio_uploading_button" style = "display:none;" type = "button" class="btn btn-primary btn-sm" data-dismiss="modal">Ахуенно</button>
</div>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      </div>
    </div>

  </div>
</div>    

<?php 

 // ищем количество аудио в базе 
    $sql = "SELECT COUNT(*) AS `audio_count` FROM  `audios`"; 
    $query = $connection_handler->prepare($sql);
    $query->execute(); 
    $audios = $query->fetchAll(PDO::FETCH_ASSOC);
    $audios_count = $audios[0]['audio_count'];
?>

<p><?php echo $audios_count; ?> audios </p>
<div id = "radio" style = "margin-bottom:10px;"><img class = "audio_img"  src = "imgs/audio_buttons/pause.png" onclick = "pause(this)"/>
<img class = "audio_img"  src = "imgs/audio_buttons/next.png" onclick = "next()"/> <img class = "audio_img"  src = "imgs/audio_buttons/volume.png" onclick = "mute(this);"/>
<meter id = "volume_meter" value="9" min="0" max="9"></meter>
<input type="range" id="volume_ranger" min = "0" max = "100" value="100" style = "width:170px;cursor:pointer" onchange = "change_volume_ranger(this)">
Playing: <span id = "audio_author_span">?</span> - <span id = "audio_name_span">?</span> | <a id = "download_link" href = "#" download>download</a>
</div>

<?php 

if($_SESSION['user'] == 'Adminto'){
    echo '<button class="btn btn-success btn-small" tilte = "Загрузить новое аудио" data-toggle="modal" data-target="#upload_audio_modal">Добавить аудио</button>';
} 

?>    


 
    <div class="w3-container" style = "margin-top:10px">
                        <div id = "unauthed_topnav_container">

                    <div id="vk_auth" style = "margin-bottom:10px;"></div>
                     
                    <div class="fb-login-button" data-size="medium" style = "margin-top:5px;"
                            data-button-type="continue_with" data-layout="default"  
                            data-auto-logout-link="false" data-use-continue-as="true" data-onlogin="checkLoginState()">
                    </div>
                   
                </div>
        </div>

 <!-- Put this div tag to the place, where the Comments block will be -->
<div id="vk_comments" style = "margin-top:10px;"></div>
<script type="text/javascript">
VK.Widgets.Comments("vk_comments", {limit: 20, attach: "*"});
</script>

     

</div><!-- class=row -->

</main>    

<script>

<?php 

 // ищем количество аудио в базе 
    $sql = "SELECT * FROM  `audios`"; 
    $query = $connection_handler->prepare($sql);
    $query->execute(); 
    $audios = $query->fetchAll(PDO::FETCH_ASSOC);
?>

/* ПРОИГРЫВАТЕЛЬ */

var rand_audio = new Audio();
var volume_meter = document.getElementById("volume_meter");
var volume_ranger = document.getElementById("volume_ranger");
var audio_author_span = document.getElementById("audio_author_span");
var audio_name_span = document.getElementById("audio_name_span");
var download_link = document.getElementById("download_link");

function play_radio(){
var rand_number = Math.floor(Math.random()*<?php  echo count($audios);  ?>) + 1; // Число для случайного трэка


rand_audio.src = "common_audiofiles/" + rand_number + "_audio.mp3";
rand_audio.canPlayType("audio/mp3");
rand_audio.load();
rand_audio.play();

function resp_to_json(response){ 
var json_obj = JSON.parse(response); 
audio_author_span.innerHTML = json_obj[0];
audio_name_span.innerHTML = json_obj[1];
download_link.href = "common_audiofiles/" + rand_number + "_audio.mp3";
    
}  

var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      resp_to_json(xmlhttp.response);
    } 
}

xmlhttp.open("GET", "common_audiofiles/playing_audio_info.php?audio_number=" + rand_number, true);  
xmlhttp.send();    

rand_audio.onended = function(){
    play_radio();
};
    
}    

/*is_muted = false;*/
function mute(button){
if(rand_audio.muted == false){
     button.src = "imgs/audio_buttons/muted.png"; 
    rand_audio.muted = true;
} else {
        button.src = "imgs/audio_buttons/volume.png"; 
        rand_audio.muted = false;
            }
}
 
is_paused = false;
function pause(button){
    
if(is_paused == false){
  rand_audio.pause();  
   is_paused = true;
   button.src = "imgs/audio_buttons/play.png";
} else {
    rand_audio.play();
       button.src = "imgs/audio_buttons/pause.png";
    is_paused = false;
}   
} 

function next(){
    play_radio();
}

function change_volume_ranger(ranger){
  rand_audio.volume = ranger.value / 100;
  volume_meter.value = ranger.value / 10;
}
 
/* ЗАГРУЗКА АУДИО */

 var  success_audio_uploading_button = document.getElementById('success_audio_uploading_button'); // Кнопка после удачной загрузки видоса
  var  MAX_FILE_SIZE = document.getElementById('MAX_FILE_SIZE');   // Максимальный размер файла
  var errors_audio_uploading = document.getElementById('errors_audio_uploading');
  var audiofile_info = document.getElementById('audiofile_info');
  var txt_audiofile_info = ""; // Информация о видеофайле
  var txt_audiofile_errors = ""; // Ошибки
  var upload_audio_flag = true; // Флаг загрузки видео
  var success_audio_uploading = document.getElementById('success_audio_uploading');
  var audiofile = document.getElementById("audio_file").files[0]; // Файл аудио   
  var audio_description = document.getElementById('audio_description');
  var audio_name = document.getElementById('audio_name'); 

function check_file(){
      var audiofile = document.getElementById("audio_file").files[0]; // Файл видео   
var accept = ['audio/mp3']; // Список поддерживаемых файлов
 
 /* Проверяем поддерживается ли формат аудио */
  if(accept.indexOf(audiofile.type) == -1){
    txt_audiofile_errors = "Данный формат аудио не поддерживается <br />";
    upload_audio_flag = false;
    }else if(audiofile.size > 16000000){
    txt_audiofile_errors = "Размер аудио должен быть <= 16 Мб <br />";
    upload_audio_flag = false;
        }

if(audio_author.value === "" || audio_name.value === ""){
    txt_audiofile_errors = "Пустой исполнитель или название <br />";  
}

if(txt_audiofile_errors !== ""){ // Ошибки есть
    errors_audio_uploading.innerHTML = txt_audiofile_errors;
    upload_audio_flag = false;
    return;
} else { // Ошибок нет

txt_audiofile_info += "Имя: " + audiofile.name + "<br />";
txt_audiofile_info += "Размер: " + Math.ceil(((audiofile.size/1024)/1024) * 10) / 10 + " Мб<br />";
txt_audiofile_info += "Тип: " + audiofile.type + "<br />"; 

audiofile_info.innerHTML = txt_audiofile_info;

}

}

function upload_audio(){ // Загружаем аудио
var audio_name = document.getElementById('audio_name'); 
var audio_author = document.getElementById('audio_author');
var audiofile = document.getElementById("audio_file").files[0]; // Файл аудио   
var upload_button = document.getElementById("upload_button");

var accept = ['audio/mp3','audio/mpeg']; // Список поддерживаемых файлов
 
 /* Проверяем поддерживается ли формат аудио */
 if(audiofile != null){
  if(accept.indexOf(audiofile.type) == -1){
    alert("Это должно быть аудио! Ты чо мудак штоль совсем, блять!?");
    return;
    }else if(audiofile.size > 16000000){
    alert("Размер аудио должен быть <= 16 МБ нахуй!");
    return;
        }
} else {
    alert("Выберите аудио нахуй!");
    return;
}

if(audio_name.value === ""){
    alert("Аудио без названия! Ты чо мудак штоль совсем!?");
    return;
} 

if(audio_author.value === ""){
    alert("У аудио нет автора! Ты чо мудак штоль совсем!?");
    return;
} 

 if(upload_audio == false){
     return;
 } else {
var audiofile = document.getElementById("audio_file").files[0]; // Файл видео 
var result_audio_uploading = document.getElementById('result_audio_uploading');

var audio_author = document.getElementById('audio_author');
var audio_name = document.getElementById('audio_name'); 
var audio_description = document.getElementById('audio_description');

var progressBar = $('#progressbar');

var formData = new FormData();
    formData.append('audiofile', audiofile);
    formData.append('MAX_FILE_SIZE', MAX_FILE_SIZE.value);
    formData.append('audio_author',audio_author.value);
    formData.append('audio_name',audio_name.value);
    formData.append('page','radio.php');
    formData.append('audio_description',audio_description.innerHTML);
    
    $.ajax({
      url: "common_audiofiles/upload_common_audiofile.php",
      type: "POST",
      contentType: false,
      processData: false,
      data: formData,
      dataType: 'html',
      xhr: function(){
        upload_button.style.display = "none";  
        var xhr = $.ajaxSettings.xhr(); // получаем объект XMLHttpRequest
        xhr.upload.addEventListener('progress', function(evt){ // добавляем обработчик события progress (onprogress)
          if(evt.lengthComputable) { // если известно количество байт
            // высчитываем процент загруженного
            var percentComplete = Math.ceil(evt.loaded / evt.total * 100);
            // устанавливаем значение в атрибут value тега <progress>
            // и это же значение альтернативным текстом для браузеров, не поддерживающих <progress>
            progressBar.val(percentComplete).text('Загружено ' + percentComplete + '%');
            result_audio_uploading.innerHTML = percentComplete + "%";
          if(percentComplete == 100){
            success_audio_uploading_button.style.display = "block";  
                }
            }
        }, false);
        return xhr;
      },
      success: function(response){
         success_audio_uploading.innerHTML = response;      
        }
    });
}

}

</script>

</body>    

</html>    

<?php ob_end_flush(); ?>