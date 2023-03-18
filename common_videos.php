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

$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();  

?>

 <?php 

    $add_video_a = "";
    
    if(!empty($_SESSION['user'])){
        $add_video_a = ' <a role="button" data-toggle="modal" data-target="#add_video_modal" style = "font-size:16px;">Вылаживать</a>';
    }

$sql = "SELECT *  FROM `common_videos` ORDER BY `this_id` DESC";	
$query = $connection_handler->prepare($sql);
$query->execute();
$videos = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<html>

<head>
<title>Общие видио</title>
<meta charset = "utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name = "description" content = "Общее видио" />
    <meta name="keywords" content = "видео,зеленый слоник, бердянск,больничка, сергей пахомов, владимир епифанцев,александр маслаев,александр осмоловский,сладкий хлеб,азов,украина,видео" / >
    <meta name = "author" content = "Frendors">

<meta property="og:title" content="Общее видио"/>
<meta property="og:description" content="Хорошие видио просто"/>
<meta property="og:image" content="index_logo.png">
<meta property="og:type" content="article"/>
<meta property="og:url" content= "//frendors.com/common_videos.php" />

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

a{
    color:blue;
}

#add_video_modal{
 margin-top:200px;
}

input[type=text],textarea{
          padding:5px;
          border-radius:5px;
}

textarea{
    resize: none;
 }

input[type=text]:focus,textarea:focus{
     background-color: #98DDDE;
     box-shadow: 0px 0px 1px #7FFFD4;
} 


.send_comment_form{
 position:relative;
 left:5px;
 margin-top:3px;
}

input[type=text]:focus,textarea:focus{
     background-color: #98DDDE;
     box-shadow: 0px 0px 1px #7FFFD4;
} 

.user_video{
    width:100%;
    height:100%;
}

.comments_container{

}

.comments{
    position:relative;
    left:5px;
    max-height:200px;
    word-wrap:break-word;
    overflow-y: auto;
    margin-bottom:10px;
}

.comment_date{
    color:gray;
    font-size:12px;
    position:relative;
    
}

.comment_text{
    
}

.comment_container{
    border-bottom:1px dashed white;
}

.avatar{
    width:50px;
    height:50px;
    border-radius:5px;
}

.nickname{
    position:relative;
    top:-10px;
    left:5px;
    font-weight:bold;
    display:inline-block;
    color:blue;
    font-size:18px;
}

.nickname:hover{
    text-decoration:underline;
}

.avatar_nick_date_container{
    border-bottom:1px solid black;
    padding-bottom:5px;
}

.common_video_container{
    border-bottom:1px dashed white;
    min-height:255px;
    margin-bottom:10px;
    cursor:pointer;
}

.video_date{
    color:gray;
    font-size:12px;
}

.video_container{
    height:255px;
}

.zdesya_img{
    width:15px;
    height:15px;
    margin-left:-12px;
}

.video_under_comment,
.img_under_comment, 
.frendors_page_iframe_under_comment{
    width:380px;
    height:300px;
}

.ahuenno_video_span{
    display:inline-block;
    color: blue;
    padding:3px;
    border-radius:3px;
    cursor:pointer;
}

.ahuenno_video_span:hover{
   background: #9dd53a; /* Old browsers */
   background: -moz-linear-gradient(top,  #9dd53a 0%, #a1d54f 50%, #80c217 51%, #7cbc0a 100%); /* FF3.6-15 */
   background: -webkit-linear-gradient(top,  #9dd53a 0%,#a1d54f 50%,#80c217 51%,#7cbc0a 100%); /* Chrome10-25,Safari5.1-6 */
   background: linear-gradient(to bottom,  #9dd53a 0%,#a1d54f 50%,#80c217 51%,#7cbc0a 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
   filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#9dd53a', endColorstr='#7cbc0a',GradientType=0 ); /* IE6-9 */
}

.ahuenno_video_span:active{
    background: #7cbc0a; /* Old browsers */
    background: -moz-linear-gradient(top, #7cbc0a 0%, #80c217 49%, #a1d54f 50%, #9dd53a 100%); /* FF3.6-15 */
    background: -webkit-linear-gradient(top, #7cbc0a 0%,#80c217 49%,#a1d54f 50%,#9dd53a 100%); /* Chrome10-25,Safari5.1-6 */
    background: linear-gradient(to bottom, #7cbc0a 0%,#80c217 49%,#a1d54f 50%,#9dd53a 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#7cbc0a', endColorstr='#9dd53a',GradientType=0 ); /* IE6-9 */
}

.img_ahuenno, .img_gavno{
    width:30px;
    height:30px;
}

.gavno_video_span{
    display:inline-block;
    color: blue;
    padding:3px;
    border-radius:3px;
    cursor:pointer;
}

.gavno_video_span:hover{
    background: #f3e2c7; /* Old browsers */
    background: -moz-linear-gradient(top, #f3e2c7 0%, #c19e67 50%, #b68d4c 51%, #e9d4b3 100%); /* FF3.6-15 */
    background: -webkit-linear-gradient(top, #f3e2c7 0%,#c19e67 50%,#b68d4c 51%,#e9d4b3 100%); /* Chrome10-25,Safari5.1-6 */
    background: linear-gradient(to bottom, #f3e2c7 0%,#c19e67 50%,#b68d4c 51%,#e9d4b3 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f3e2c7', endColorstr='#e9d4b3',GradientType=0 ); /* IE6-9 */
}

.gavno_video_span:active{
    background: #e9d4b3; /* Old browsers */
    background: -moz-linear-gradient(top, #e9d4b3 0%, #b68d4c 49%, #c19e67 50%, #f3e2c7 100%); /* FF3.6-15 */
    background: -webkit-linear-gradient(top, #e9d4b3 0%,#b68d4c 49%,#c19e67 50%,#f3e2c7 100%); /* Chrome10-25,Safari5.1-6 */
    background: linear-gradient(to bottom, #e9d4b3 0%,#b68d4c 49%,#c19e67 50%,#f3e2c7 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e9d4b3', endColorstr='#f3e2c7',GradientType=0 ); /* IE6-9 */
}

.ahuenno_gavno_under_video_container{
    
}


.rating_video{
    
    width:290px;
    height:190px;
    border-radius:5px;
    
}

#rating_video_container{
    margin:10px 0;
}

.rating_video_container{
    display:inline-block;
    margin-left:7px;
}

.likes_count_span{
    position:relative;
    display:block;
    margin-top:3px;
}

.fb-like{
    margin-right:30px;
}

#fb_like_top{
    margin-top:5px;
}

#vk_auth{
    margin-top:5px;
    margin-bottom:5px;
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

}

?>
    <main>


<?php 

$whose_videos = "";

if(empty($_SESSION['user'])){
    $whose_videos = "<a href = index.php target = _blank>frendors.com</a>";
}else{
    $whose_videos = "<a href = user.php?zs=" .  $_SESSION['user'] . "> <<< " . $_SESSION['user'] . "</a>"; 
}

echo $whose_videos;

$sql = "SELECT *  FROM `common_videos`";	
$query = $connection_handler->prepare($sql);
$query->execute();
$videos_count = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<div id="vk_like_top"></div>
<script type="text/javascript">
    VK.Widgets.Like("vk_like_top", {type: "button"});
</script>
<div class=fb-like id = fb_like_top data-href=https://frendors.com/common_videos.php data-layout=button_count data-action=like data-size=small data-show-faces=true data-share=true></div>

<?php 

if(empty($_SESSION['user'])){
    
    echo '<div id=vk_auth></div><script type=text/javascript>
        
        VK.Widgets.Auth("vk_auth", {
            width: "200px", 
            onAuth: function(data) {
         var user_id = data["uid"];
         var first_name =  data["first_name"];
         var last_name = data["last_name"];
         var hash = data["hash"];
        
         var first_last_name = first_name + "_" + last_name;
         
         window.location.replace("vk_registration.php?vk_name=" + first_last_name + "&user_id=" + user_id + "&a_cho_tam=" + hash);
                
        } 
        
        });
        
        </script>
        <fb:login-button scope="public_profile,email" onlogin="checkLoginState();" id = "facebook_login_button">
        </fb:login-button>';
    
}

?>


<h1 style = "color:blue;text-align:center;position:relative;top:20px;">Видио <?php echo count($videos_count) . " " . $add_video_a; ?></h1>
<p style = "color:green">Хорошие видио просто</p>
<h1>TOP10 | Ахуенно блять ахуенно</h1>

<!-- Modal -->
<div id="add_video_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Вылаживаем видио</h4>
      </div>
      <div class="modal-body">
          <p>ВНИМАНИЕ! Разрешается добавлять не более 3-х видио<br />
          Удалить видио может только <a href = "user.php?zs=Adminto" target = "_blank">Adminto</a><br />
          И нехуй по сто раз на кнопку нажимать: ждите пока окошко выскочит</p>
          <span>Список разрешенных ссылок:<span>
           <ul>
               <li>ВК <a href = "//vk.com/video_ext.php?oid=-1964347&id=31878524&hash=28f536f0e589b7de" target = "_blank">//vk.com/video_ext.php?oid=-1964347&id=31878524&hash=28f536f0e589b7de</a></li>
               <li>Ютуба <a href = "https://www.youtube.com/watch?v=amEoQtlJ2lE" target = "_blank">https://www.youtube.com/watch?v=amEoQtlJ2lE</a></li>
           </ul>
          Ссылка <input type = "text" maxlength = "300" size = "65" id = "video_link_input" required = "required" /><br />
        <span id = "video_errors" style = "color:red;display:none">Данный тип ссылок не поддерживается</span><br />
     <button type="button" class="btn btn-success" style = "position:relative;top:10px;" onclick = "add_video()" >Вылаживать</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Нахуй</button>
      </div>
    </div>

  </div>
</div>  

<?php 

echo "<div id = rating_video_container>";

      $sql = "SELECT * FROM `common_videos_likes`";	
      $query = $connection_handler->prepare($sql);
      $query->execute();
      $likes = $query->fetchAll(PDO::FETCH_ASSOC);

      $likes = array_values($likes);

if(count($likes) == 0){
    echo "<span style = 'color:blue;font-size:20px;'>Добавьте видио и пролайкайте, чтобы.. блять я заебался этот код уже писать весь день! короче поняли нахуй</span>";
}

$rating = array();



for($i = 0; $i < count($likes); $i++){

    array_push($rating, $likes[$i]['video_id']);
}

$rating = array_count_values($rating); // Извлекаем значения



// Функция сравнения
function cmp($a, $b) {
    if ($a == $b) {
        return 0;
    }
    return ($a > $b) ? -1 : 1;
}

uasort($rating, 'cmp'); // Сортируем массив по значениям



$i = 0;

foreach($rating as $key => $value){

$i++;

if($i == 11){
    break;
}

$sql = "SELECT *  FROM `common_videos` WHERE `this_id`={$key}";	
$query = $connection_handler->prepare($sql);
$query->execute();
$link = $query->fetchAll(PDO::FETCH_ASSOC);

$outp_src = $link[0]['link'];

if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)([a-zA-Z0-9\-_]{1,256})/is',$link[0]['link']) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)([a-zA-Z0-9\-_]{1,256})/is',$link[0]['link'], $multimedia_src_arr);  // Возвращает совпадение

        $hash = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)/is',"",$multimedia_src_arr[0]);
        
        $outp_src = "https://www.youtube.com/embed/" . $hash;
}

 // Видео с порнхаба
     if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?((rt\.)?pornhub\.com\/view_video\.php\?viewkey=)([a-zA-Z0-9\-_]{1,256})/is',$link[0]['link']) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(rt\.)?(www.)?((rt\.)?pornhub\.com\/view_video\.php\?viewkey=)([a-zA-Z0-9\-_]{1,256})/is',$link[0]['link'], $multimedia_src_arr);  // Возвращает совпадение 
        
        $hash = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(rt\.)?(www.)?(pornhub\.com\/view_video\.php\?viewkey=)/is',"",$multimedia_src_arr[0]);
        
        $outp_src = "https://www.pornhub.com/embed/" . $hash;
       
       
     } 
     

echo '<section class = rating_video_container>
        <iframe src=' . $outp_src . ' class = rating_video frameborder=0 allowfullscreen /></iframe>
        <span class = "badge likes_count_span" >' . $value . '</span>
      </section>';    

} 

echo "</div>"; 
?>

<div style = "border:1px dashed white;margin-top:10px;margin-bottom:10px;"></div> 

<script>

function add_video(){
    
    var video_link_input = document.getElementById("video_link_input");
    var video_errors = document.getElementById("video_errors");

    if(video_link_input.value == ""){
        return;
    }
    
    if(!video_link_input.value.match(/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)([a-zA-Z0-9]{1,256})/ig) && 
       !video_link_input.value.match(/(^|[\n ])([\w]*?)(\/\/)?(vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=])+/ig) &&
       !video_link_input.value.match(/(^|[\n ])([\w]*?)(\/\/)?((rt\.)?pornhub\.com\/view_video\.php\?viewkey=)([a-zA-Z0-9&-=])+/ig) 
       ){
       video_errors.style.display = "block"; 
    }else{
        
       var xmlhttp = new XMLHttpRequest();
       
       xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {

            alert(xmlhttp.response);
            window.location.reload();
            
            } 
        }
        
  var formData = new FormData();
  formData.append('link', video_link_input.value.trim());

   xmlhttp.open('POST', 'scripts/add_common_video.php', true);
   xmlhttp.send(formData);
   
    }
    
}

function delete_video(this_obj,video_id){

     var xmlhttp = new XMLHttpRequest();
       
       xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {

     this_obj.innerHTML = xmlhttp.response;
      
            } 
        }
        
  var formData = new FormData();
  formData.append('video_id', video_id);

   xmlhttp.open('POST', 'scripts/delete_common_video.php', true);
   xmlhttp.send(formData);

}

function add_video_from_common_page(obj,video_id){
    
           var xmlhttp = new XMLHttpRequest();
       
       xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {

            obj.innerHTML = xmlhttp.response;
            obj.onclick = null;
            
            } 
        }
        
  var formData = new FormData();
  formData.append('video_id', video_id);

   xmlhttp.open('POST', 'scripts/add_video_from_common_page.php', true);
   xmlhttp.send(formData);

}

</script>

<div id = "videos_container">

<script>

function tell_to_bros(a_href,id){
  var ahuenno_count_span = document.getElementById("ahuenno_count_span_" + id);  

if(id == null || id == ""){
   return; 
}

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {

if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
         
        a_href.onclick = null;
        
        var response = JSON.parse(xmlhttp.response);
        
        if(response.likes_count !== "null"){
            ahuenno_count_span.innerHTML = response.likes_count;
        }
       
       if(response.status === "true"){
            a_href.innerHTML = "Братки видят";  
       }else{
           a_href.innerHTML = "Хуйня какая-то";
       }
        
    } 
}

var formData = new FormData();
formData.append('video_id', id);

xmlhttp.open('POST', 'scripts/tell_to_bros_common_video.php', true);
xmlhttp.send(formData);

}
</script>

<?php 

function youtube_name($hash){
    
    $html = file_get_contents('https://www.youtube.com/watch?v=' . $hash);
    $dom = new DomDocument();
    $ies = libxml_use_internal_errors(true);
    $dom->loadHTML('<?xml encoding="UTF-8">' . $html);
    libxml_use_internal_errors($ies);
    return $dom->getElementById('eow-title')->nodeValue;
    
}

function tolink($text) { // Превращение в ссылку
 
 $text = preg_replace("/(^|[\n ])([\w]*?)(https?:\/\/)(www\.)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;%=+])*)*)/is", "$1$2<a href='$3$4$5' target = _blank>$3$4$5</a>", $text); // http(s)://www.frendors.com
 $text = preg_replace("/(^|[\n ])([\w]*?)(https?:\/\/)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;%=+])*)*)/is", "$1$2<a href='$3$4' target = _blank>$3$4</a>", $text); // http(s)://frendors.com
 $text = preg_replace("/(^|[\n ])([\w]*?)(www\.)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;%=+])*)*)/is", "$1$2<a href='//$4' target = _blank>$3$4</a>", $text); // www.frendors.com
 $text = preg_replace("/(^|[\n ])([\w]*?)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;%=+])*)*)/is", "$1$2<a href='//$3' target = _blank>$3</a>", $text); //frendors.com    
 $text = preg_replace("/(^|[\n ])([\w]*?)(\/\/vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=]{1,256})/","$1$2<a href='//$3$4' target = _blank>$3$4$5</a>", $text);
 $text = preg_replace("/(^|[\n ])([\w]*?)(\[url href=)(https?:\/\/)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;%=+])*)*)(\])([a-zA-Z0-9йцукенгшщзхфывапролджэячсмитьбюЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮ!?@.\s\n]{2,80})+(\[\/url\])/", "$1$2<a href='$4$5' target = _blank>$11</a>" ,$text); 
 $text = preg_replace("/(^|[\n ])([\w]*?)(\[url href=)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;%=+])*)*)(\])([a-zA-Z0-9йцукенгшщзхфывапролджэячсмитьбюЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮ!?@.\s\n]{2,80})+(\[\/url\])/", "$1$2<a href='http://$4' target = _blank>$10</a>" ,$text); 

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
        $multimedia_under_post_for_arr = "<iframe class = 'video_under_comment' src = '" . $outp_src . "' frameborder = '0'></iframe>";
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

     } 

/**********************************************************************************************************************************************************************************/
// Видео с вк
if(preg_match('/(^|[\n ])([\w]*?)(\/\/)?(vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=])+/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(\/\/)?(vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=])+/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $multimedia_under_post_for_arr = "<iframe class = 'video_under_comment' src = '" . $multimedia_src_arr[0] . "' frameborder = '0'></iframe>";
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

} 

// Видео с вк
if(preg_match('/(^|[\n ])([\w]*?)(\/\/)?(vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=])+/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(\/\/)?(vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=])+/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $multimedia_under_post_for_arr = "<iframe class = 'video_under_comment' src = '" . $multimedia_src_arr[0] . "' frameborder = '0'></iframe>";
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

} 

 // Видео с порнхаба
     if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(rt\.)?(www.)?(pornhub\.com\/view_video\.php\?viewkey=)([a-zA-Z0-9\-_]{1,256})/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(rt\.)?(www.)?(pornhub\.com\/view_video\.php\?viewkey=)([a-zA-Z0-9\-_]{1,256})/is',$text, $multimedia_src_arr);  // Возвращает совпадение 
        
        $multimedia_under_post_for_arr = "<iframe class = 'video_under_comment' src = '" . $multimedia_src_arr[0] . "' frameborder = '0'></iframe>";
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

     } 
     

/**********************************************************************************************************************************************************************************/
     
// Картинка   
     if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([a-zA-Z0-9_\-.]{2,256})\.([a-zA-Z]{2,6})[\/]([a-zA-Z0-9_\/\-.?&;%=+])+(png|jpg|jpeg|gif)(\?extra=[a-zA-Z0-9_\-\/\-.?&;%=+]{1,256})?/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([a-zA-Z0-9_\-.]{2,256})\.([a-zA-Z]{2,6})[\/]([a-zA-Z0-9_\/\-.?&;%=+])+(png|jpg|jpeg|gif)(\?extra=[a-zA-Z0-9_\-\/\-.?&;%=+]{1,256})?/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $multimedia_under_post_for_arr = "<img class = 'img_under_comment' src = '" . $multimedia_src_arr[0] . "' onerror = this.src='imgs/file_not_found.png' />";  
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

     }      

// FD страница   
     if(preg_match('/(^|[\n ])([w]*?)(https?:\/\/)?(www\.)?(frendors\.com[\/]?)+(([a-zA-Z0-9\.=_\-\?&]{8,256}))?/is',$text) === 1){ 

        preg_match('/(^|[\n ])([w]*?)(https?:\/\/)?(www\.)?(frendors\.com[\/]?)+(([a-zA-Z0-9\.=_\-\?&]{8,256}))?/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $outp_src = "";
        $multimedia_under_post_for_arr = "";
        
        $outp_src = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?/is',"https://",$multimedia_src_arr[0]);

        $multimedia_under_post_for_arr = "<iframe class = 'frendors_page_iframe_under_comment' src = '" . $outp_src . "'></iframe>";
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

     }      

$multimedia_relult = "";

for($i = 0; $i < count($multimedia_under_post_arr); $i++){
    
    $multimedia_result .= $multimedia_under_post_arr[$i];
    
}

 return $multimedia_result;

}


$videos_outp = "";
$delete_video_function = "";
$add_video_from_other_page_function = "";
$tell_to_bros_function = "";

$ahuenno_video_function = "";

$outp_src = "";
$video_src_arr = "";
$video_name = "";

    for($i = 0; $i < count($videos); $i++){
    
                    if($_SESSION['user'] === 'Adminto'){
                        $delete_video_function = "<a onclick = delete_video(this," . $videos[$i]['this_id'] . ")>Удалить</a>";
                    }
                    
                    if(!empty($_SESSION['user'])){
                        $add_video_from_other_page_function = " | <a onclick = add_video_from_common_page(this," . $videos[$i]['this_id'] . ")>Добавить к себе</a>";
                        $tell_to_bros_function =  " | <a onclick = tell_to_bros(this," . $videos[$i]['this_id'] . ")>на малафильню</a>";
                        
                    }
    
                    if(!empty($_SESSION['user'])){

                    $ahuenno_video_function = " onclick = set_ahuenno_under_video(". $videos[$i]['this_id'] . ") ";

                    }
    
        // Видео с ютуба
         if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)([a-zA-Z0-9\-_]{1,256})/is',$videos[$i]['link']) === 1){ 
    
            preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)([a-zA-Z0-9\-_]{1,256})/is',$videos[$i]['link'], $video_src_arr);  // Возвращает совпадение
    
            $hash = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)/is',"",$video_src_arr[0]);
            
            $outp_src = "https://www.youtube.com/embed/" . $hash;
            
            $video_name = youtube_name($hash);
    
         } 
         
         // Видео с порнхаба
     if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(rt\.)?(www.)?(pornhub\.com\/view_video\.php\?viewkey=)([a-zA-Z0-9\-_]{1,256})/is',$videos[$i]['link']) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(rt\.)?(www.)?(pornhub\.com\/view_video\.php\?viewkey=)([a-zA-Z0-9\-_]{1,256})/is',$videos[$i]['link'], $video_src_arr);  // Возвращает совпадение 
        
        $outp_src = "";
      
        $hash = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(rt\.)?(www.)?(pornhub\.com\/view_video\.php\?viewkey=)/is',"",$video_src_arr[0]);
        
        $outp_src = "https://www.pornhub.com/embed/" . $hash; 
        
     } 
         
    
    /**********************************************************************************************************************************************************************************/
    // Видео с вк
    if(preg_match('/(^|[\n ])([\w]*?)(\/\/)?(vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=])+/is',$videos[$i]['link']) === 1){ 
    
            preg_match('/(^|[\n ])([\w]*?)(\/\/)?(vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=])+/is',$videos[$i]['link'],$video_src_arr);  // Возвращает совпадение
            
            $outp_src = $video_src_arr[0];
            $video_name = "";
    
    } 
   
   $current_time = time();
   
       // ЛАЙКИ
     $sql = "SELECT COUNT(*) AS `ahuenno_count` FROM `common_videos_likes` WHERE `video_id`={$videos[$i]['this_id']}";	
     $query = $connection_handler->prepare($sql);
     $query->execute();
     $ahuenno_count = $query->fetchAll(PDO::FETCH_ASSOC);
     $ahuenno_count = $ahuenno_count[0]['ahuenno_count'];

    $send_comment_form = "";
                    
                    if(!empty($_SESSION['user'])){
                        $send_comment_form = "<div class = send_comment_form>
                                            <textarea style = 'width:100%' rows=1 id = 'comment_textarea_" . $videos[$i]['this_id'] . "' onkeypress = send_comment_enter(event," . $videos[$i]['this_id'] . ") oninput = this.rows=3;this.placeholder='' maxlength = '1000' placeholder = 'malafeel'></textarea><br />
                                            <button type = 'button' class='btn btn-success btn-md' onclick = send_comment(". $videos[$i]['this_id'] . ")>Малафить</button>
                                        </div>" ;
            }

    // КОММЕНТЫ
    $sql = "SELECT *  FROM `common_videos_comments` WHERE `video_id`={$videos[$i]['this_id']} ORDER BY `this_id` ASC";	
    $query = $connection_handler->prepare($sql);
    $query->execute();
    $comments = $query->fetchAll(PDO::FETCH_ASSOC);
    
    $comments_outp = "";
    $video_date = $videos[$i]['date'];
    
                    for($j = 0; $j < count($comments); $j++){ // Собираем комменты
                    
                        $comment_id = $comments[$j]['this_id'];
                        $comment_author = $comments[$j]['user'];
                        $comment_text = $comments[$j]['comment_text'];
                        $comment_date = $comments[$j]['date'];
                    
                        $multimedia = href2obj($comment_text);
                    
                         $sql = "SELECT *  FROM `additional_info` WHERE `nickname`='{$comment_author}'";	
                         $query = $connection_handler->prepare($sql);
                         $query->execute();
                         $avatar_src = $query->fetchAll(PDO::FETCH_ASSOC);
                         $avatar_src = $avatar_src[0]['avatar'];
                    
                        $delete_comment_function = "";
                        
                            $sql = "SELECT last_action_time FROM main_info WHERE nickname='{$comment_author}'"; // Выбираем время последней активности пользователя	
                            $query = $connection_handler->prepare($sql); //Подготавливаем запрос
                            $query->execute();
                            $result = $query->fetchAll(PDO::FETCH_ASSOC);
                            $last_action_time = $result[0]['last_action_time'];
                    
                            $online = ""; /* Текст, который будет отображаться в месте онлайн */
                            
                            if(($current_time - $last_action_time) <= 180){ // Разница <= 180 секунд
                                
                                    /* ПРОВЕРЯЕМ С КАКОГО УСТРОЙСТВА ЗАЩЕЛ ПОЛЬЗОВАТЕЛЬ */
                                    $sql = "SELECT * FROM `main_info` WHERE `nickname`='{$comment_author}'"; 	
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
                        
                        
                        if($comment_author === $_SESSION['user']){ // Функция удаления коммента
                            $delete_comment_function = "<a onclick = delete_comment(this," . $comment_id . ")>Чисти</a>";    
                        }
              
                         $comments_outp .= "<section id = 'comment_container_" . $comment_id . "' class = 'comment_container'>
                                                <div class = 'avatar_nick_date_container'>
                                                <a href = 'user.php?zs=" . $comment_author . "' target = _blank'><img src='users/" . $avatar_src . "' class = 'avatar' /><h1 class = 'nickname'>" . $online . $comment_author . "</h1></a><br />
                                                <span class = 'comment_date'>" . $comment_date . "</span>
                                                </div>
                                                    <div class = comment_text>"
                                                    . tolink($comment_text) .
                                                    "</div>
                                                    <div class = comment_bottom>" .
                                                     "<div class = multimedia_container>" . $multimedia . "</div>" .
                                                     $delete_comment_function .  
                                                    "</div>
                                            </section>";
        }
                  
            $videos_outp .= "<section class = 'common_video_container row' style = 'border:1px solid black' id = 'user_video_container_" . $videos[$i]['this_id'] . "'>
                        <div class = 'video_info_container col-md-2'><a href = " . $videos[$i]['link']  . " target = '_blank'>" . $video_name . "</a>
                                    <div class = 'video_date'>" . $video_date . "</div>" .
                           '<div class = "functions_under_video_container">' .  $delete_video_function . $add_video_from_other_page_function . " | <a href = ". $videos[$i]['link']  . " target = _blank>Ссылка</a></div>
                             <div class = ahuenno_gavno_under_video_container>" .
                            $tell_to_bros_function . "<span class = ahuenno_video_span " . $ahuenno_video_function . "><img src = imgs/like.png class = img_ahuenno />Ахуенно | <span class = ahuenno_count_span id = ahuenno_count_span_" . $videos[$i]['this_id']  . " >" . $ahuenno_count . "</span></span> 
                            </div> 
                             
                        </div>
                                   <div class = 'video_container col-md-7'>
                                        <iframe style = 'display:inline-block' class = 'user_video' src = '" . $outp_src . "' frameborder = '0' allowfullscreen></iframe>" .
                                    "</div>
                                    
                                    <div class = 'comments_container col-md-3'>"
                                            .
                                    $send_comment_form    .
                                           "<div class = comments>"
                                           . $comments_outp .
                                    "</div>
                                    </div> 
                             </section>";
    
    
    }

echo $videos_outp;

?>

</div>       


<script>

function send_comment(video_id){
    var comment_textarea = document.getElementById("comment_textarea_" + video_id);
    
    if(comment_textarea.value == ""  || comment_textarea.value.match(/^\s+$/ig)){
        return;
    }

    var xmlhttp = new XMLHttpRequest();
    
    xmlhttp.onreadystatechange = function() {

if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        window.location.reload();
    } 
}

var formData = new FormData();
formData.append('comment', comment_textarea.value.trim());
formData.append('video_id', video_id);

xmlhttp.open('POST', 'scripts/common_videos_comments.php', true);
xmlhttp.send(formData);
    
}

function send_comment_enter(event,video_id){
    var char = event.which || event.keyCode;  
if(char == 13){
send_comment(video_id);   
}
}

function delete_comment(a,comment_id){

    var xmlhttp = new XMLHttpRequest();
    
    xmlhttp.onreadystatechange = function() {

if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        a.innerHTML = "Почищено";
        a.onclick = null;
    } 
}

var formData = new FormData();
formData.append('comment_id', comment_id);

xmlhttp.open('POST', 'scripts/delete_comment_under_common_video.php', true);
xmlhttp.send(formData);
    
}

function set_ahuenno_under_video(video_id){
    
    var ahuenno_count_span = document.getElementById("ahuenno_count_span_" + video_id);
    
    var xmlhttp = new XMLHttpRequest();
    
    xmlhttp.onreadystatechange = function() {

if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        ahuenno_count_span.innerHTML = xmlhttp.response;
    } 
}

var formData = new FormData();
formData.append('video_id', video_id);

xmlhttp.open('POST', 'scripts/set_like_common_video.php', true);
xmlhttp.send(formData);
    
}

</script>

</main>    

</body>    

</html>    

<?php ob_end_flush(); ?>