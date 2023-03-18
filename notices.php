<?php
ob_start();

session_start();

//ini_set('display_errors', 'On');

require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if(empty($_SESSION['user'])){
header('Location: ../index.php');
exit();
}

function session_isset(){ // Пользователь вошел
if(!empty($_SESSION['user'])){ // Пользователь вошел через логин-пароль
return true;
} else {
return false;
}
}

if(!session_isset()){
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Что случилося то?</title>
<meta charset = "utf-8" />
<script src="bootstrap/js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<link rel = "stylesheet" href = "css/normalize.css"  type = "text/css" />

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
    width: 99%;
    background-color:#cefdce;
    margin:0 auto;
    height:100%;
    font-size:20px;
    word-wrap:break-word;
 }

main {
    padding: 10px;
    border-left: 2px double blue;
    border-right: 2px double blue;
    padding-bottom: 90px;
    }

img {
border-radius:10px;	
}

.avatar{
    width:80px;
    height:80px;
}

header { /* Шапка */
position:relative;
top:60px;
right:60px;
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

.fun_section {
margin:10px;    
}

.fun_img {
width:50px;
height:50px;
}

.fun_img:hover {
transform:scale(1.05); 
cursor:pointer;
}

.fun_description {
display:block;
position:relative;
left:60px;
top:-30px;
margin-top:-20px;
margin-bottom:-10px;
color:white;
}

.fun_name {
display:block;
position:relative;
left:60px;
top:-50px;
font-family:Tahoma;    
font-weight:bold;
color:blue;    
}

a {
    color:blue;
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

<main>
<?php if(session_isset()){ // авторизовались
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

echo '<a href=user.php?zs=' . $_SESSION['user'] . '> <<< Ваша бумажка</a>';
}

?>


<?php 

/* Обнуляем оповещения */
$sql = "UPDATE `notice` SET `is_readen`=1 WHERE `noticed`='{$_SESSION['user']}'";	
$query = $connection_handler->prepare($sql); 
$query->execute();

?>

<section id = "notices_section" class = "container-fluid">

<h1 style = "color:blue;text-align:center;position:relative;top:20px;">Что случилося то?</h1>

<div class = "raw">

<style>

.avatar_container {
    float:left;
    margin-right:10px;
  }

.delete_friend_notice_description {
  
}

.delete_friend_notice_date, .comment_post_notice_date, .confirm_friend_request_notice_date, .deny_friend_request_notice_date, 
.reply_to_notice_date, .user_wall_post_notice_date, .like_user_wall_post_notice, .like_user_wall_post_notice_date, .dislike_user_wall_post_notice_date, 
.tell_ahuenno_user_wall_post_notice_date, .tell_gavno_user_wall_post_notice_date, .new_user_notice_date {
    color:gray;
    word-wrap:break-word;
    clear:both;
 }
 
 .delete_friend_notice,.comment_post_notice, .confirm_friend_request_notice, .deny_friend_request_notice, .reply_to_notice,
 .user_wall_post_notice, .like_user_wall_post_notice, .dislike_user_wall_post_notice, .tell_ahuenno_user_wall_post_notice, .tell_gavno_user_wall_post_notice, .new_user_notice {
 border-bottom:1px solid black;
 width:100%; 
 cursor:pointer;
 margin-bottom:10px;
     word-wrap:break-word;
 }
 
 .delete_friend_notice:hover, .comment_post_notice:hover, .deny_friend_request_notice:hover, .reply_to_notice:hover, 
 .user_wall_post_notice:hover, .tell_ahuenno_user_wall_post_notice:hover, .dislike_user_wall_post_notice:hover, .like_user_wall_post_notice:hover {
 color:white;
 opacity:0.9;
}
 
 
 .like_user_wall_post_notice_description, .dislike_user_wall_post_notice_description{
     color:black;
}
 
.video_under_post, .frendors_page_iframe_under_post{
     width:310px;
    height:260px;
}

.img_under_post, .commented_img_under_notice{
    display:block;
   max-width:310px;
   max-height:260px;
} 
 
</style>

<?php 

/* Извлекаем сообщения */
$sql = "SELECT * FROM `notice` WHERE `noticed`='{$_SESSION['user']}' ORDER BY `date` DESC LIMIT 30";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$notices = $query->fetchAll(PDO::FETCH_ASSOC);

function tolink($text) { // Превращение в ссылку
 
 $text = preg_replace("/(^|[\n ])([\w]*?)(https?:\/\/)(www\.)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;%=+])*)*)/is", "$1$2<a href='//$4$5' target = _blank>$3$4$5</a>", $text); // http(s)://www.frendors.com
 $text = preg_replace("/(^|[\n ])([\w]*?)(https?:\/\/)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;%=+])*)*)/is", "$1$2<a href='//$4' target = _blank>$3$4</a>", $text); // http(s)://frendors.com
 $text = preg_replace("/(^|[\n ])([\w]*?)(www\.)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;%=+])*)*)/is", "$1$2<a href='//$4' target = _blank>$3$4</a>", $text); // www.frendors.com
 $text = preg_replace("/(^|[\n ])([\w]*?)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;%=+])*)*)/is", "$1$2<a href='//$3' target = _blank>$3</a>", $text); //frendors.com    
 $text = preg_replace("/(^|[\n ])([\w]*?)(\/\/vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=]{1,256})/","$1$2<a href='//$3$4' target = _blank>$3$4$5</a>", $text);
 $text = preg_replace("/(^|[\n ])([\w]*?)(\[url href=)(https:\/\/)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;%=+])*)*)(\])([a-zA-Z0-9йцукенгшщзхфывапролджэячсмитьбюЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮ!?@.\s\n]{2,80})+(\[\/url\])/", "$1$2<a href='//$5' target = _blank>$11</a>" ,$text); 

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
     

/* // FD страница   
     if(preg_match('/(^|[\n ])([w]*?)(https?:\/\/)?(www\.)?(frendors\.com[\/]?)+(([a-zA-Z0-9\.=_\-\?&]{8,256}))?/is',$text) === 1){ 

        preg_match('/(^|[\n ])([w]*?)(https?:\/\/)?(www\.)?(frendors\.com[\/]?)+(([a-zA-Z0-9\.=_\-\?&]{8,256}))?/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $outp_src = "";
        $multimedia_under_post_for_arr = "";
        
        $outp_src = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?/is',"https://",$multimedia_src_arr[0]);

        $multimedia_under_post_for_arr = "<iframe class = 'frendors_page_iframe_under_post' src = '" . $outp_src . "'></iframe>";
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

     }  */    


$multimedia_relult = "";

for($i = 0; $i < count($multimedia_under_post_arr); $i++){
    
    $multimedia_result .= $multimedia_under_post_arr[$i];
    
}

 return $multimedia_result;

} 

if(!empty($notices)){
    
    for($i = 0; $i < count($notices); $i++){

$sql = "SELECT `avatar` FROM `additional_info` WHERE `nickname`='{$notices[$i]['noticer']}'";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$noticer_avatar = $query->fetchAll(PDO::FETCH_ASSOC);
$noticer_avatar = $noticer_avatar[0]['avatar'];

        /* Определяем тип оповещения */
    switch($notices[$i]['type']){

        case 'delete_friend': /* УДАЛЯЕМ ИЗ ДРУЗЕЙ */ 

            echo "<section class = delete_friend_notice id = delete_friend_notice_{$notices[$i]['this_id']} onclick = window.location.replace('user.php?zs={$notices[$i]['noticer']}')>
            <div class = avatar_container><a href = user.php?zs={$notices[$i]['noticer']} title = {$notices[$i]['noticer']}><img class = 'avatar' src = 'users/{$noticer_avatar}' /></a></div> 
            <div class = delete_friend_notice_description>{$notices[$i]['description']}</div>
            <div class = delete_friend_notice_date>{$notices[$i]['date']}</div>
            </section>";
            
            break;
            
        case 'confirm_friend_request': /* ПОДТВЕРЖДАЕМ ДРУГА*/ 

            echo "<section class = confirm_friend_request_notice id = confirm_friend_request_notice_{$notices[$i]['this_id']} onclick = window.location.replace('user.php?zs={$notices[$i]['noticer']}')>
            <div class = avatar_container><a href = user.php?zs={$notices[$i]['noticer']} title = {$notices[$i]['noticer']}><img class = 'avatar' src = 'users/{$noticer_avatar}' /></a></div> 
            <div class = confirm_friend_request_notice_description>{$notices[$i]['description']}</div>
            <div class = confirm_friend_request_notice_date>{$notices[$i]['date']}</div>
            </section>";
            
            break;
        
        case 'deny_friend_request': /* ОТКЛОНЯЕМ ДРУГА */ 

            echo "<section class = deny_friend_request_notice id = deny_friend_request_notice_{$notices[$i]['this_id']} onclick = window.location.replace('user.php?zs={$notices[$i]['noticer']}')>
            <div class = avatar_container><a href = user.php?zs={$notices[$i]['noticer']} title = {$notices[$i]['noticer']}><img class = 'avatar' src = 'users/{$noticer_avatar}' /></a></div> 
            <div class = deny_friend_request_notice_description>{$notices[$i]['description']}</div>
            <div class = deny_friend_request_notice_date>{$notices[$i]['date']}</div>
            </section>";
            
            break;        
      
       case 'comment_post': /* Комментируем пост */   

        $post_page = $notices[$i]['page'];
        $comment = $notices[$i]['post_text'];
        $post_sender = $notices[$i]['noticer'];
        $post_id = $notices[$i]['post_id'];
        $whose_page = $notices[$i]['description'];
        
        $sql = "SELECT * FROM `wall_user_posts` WHERE `this_id`={$post_id}";
        $query = $connection_handler->prepare($sql);
        $query->execute();
        $post_text = $query->fetchAll(PDO::FETCH_ASSOC); 
        $post_text = $post_text[0]['message'];
        
        $trunced_text = $post_text;
        $multimedia_comment = href2obj($comment);
        $multimedia_post_text = href2obj($post_text);

if(strlen($post_text) > 80){
    $trunced_text =  mb_substr($post_text,0,80) . "...";
} 
            
             echo "<section class = comment_post_notice id = comment_post_notice_{$notices[$i]['this_id']}>
            <div class = avatar_container><a href = user.php?zs=" . str_replace(" ","%20",$notices[$i]['noticer']) . " title = " . str_replace(" ", "_",$notices[$i]['noticer']) . "><img class = 'avatar' src = 'users/{$noticer_avatar}' /></a></div> 
            <div class = comment_post_notice_description><a href = user.php?zs=" . str_replace(" ", "%20",$post_sender) . ">{$post_sender}</a> прокомментил ваш пост <a data-toggle = collapse data-target = '#full_text_post_{$notices[$i]['this_id']}'>" . $trunced_text . "</a> на  {$whose_page}</div>
            <div  id = full_text_post_{$notices[$i]['this_id']} class = 'panel-collapse collapse'>
            
            <div class='well well-sm' style = 'color:black;word-wrap:break-word;'>" .
            tolink($post_text) .
            "<div class = 'multimedia_under_notice_container'>" . $multimedia_post_text  . "</div>
            </div>
            </div>
            
            </div>
            <div class = comment_post_notice_date>{$notices[$i]['date']}</div>
            
            <div style = 'heighth:1px; border:1px dashed white'></div>
            
            <div style = 'color:blue;word-wrap:break-word'>" .
            tolink($comment) .
            "<div class = 'multimedia_under_notice_container'>" . $multimedia_comment  . "</div>
            <a href = user.php?zs=" . str_replace(" ", "%20",$post_page) . "#user_wall_post_{$post_id}>Перейти к посту >>></a>
            </div>
            
            </section>";
            break;
/**********************************************************************************************************************************************/ 
    
         case 'reply_to': /* Отвечаем на коммент */   

$comment_page = $notices[$i]['page'];
$reply_to_comment_text = tolink($notices[$i]['reply_to_comment_text']); // Коммент, отвечают которым
$comment_text = $notices[$i]['comment_text'];
$comment_id = $notices[$i]['reply_to_comment_id'];
$post_id = $notices[$i]['post_id'];
$whose_page = $notices[$i]['description'];

$multimedia_reply_to_comment_text = href2obj($reply_to_comment_text);
$multimedia_comment_text = href2obj($comment_text);

$trunced_text = $comment_text;

if(strlen($comment_text) > 80){
    $trunced_text =  mb_substr($comment_text,0,80) . "...";
} 
            
             echo "<section class = reply_to_notice id = comment_post_notice_{$notices[$i]['this_id']}>
            <div class = avatar_container><a href = user.php?zs=" . str_replace(" ", "%20",$notices[$i]['noticer']) . " title = {$notices[$i]['noticer']}><img class = 'avatar' src = 'users/{$noticer_avatar}' /></a></div> 
            <div class = reply_to_notice_description><a href = user.php?zs=" . str_replace(" ", "%20",$notices[$i]['noticer']) . ">{$notices[$i]['noticer']}</a>  ответил на ваш коммент  <a data-toggle = collapse data-target = #full_text_comment_{$notices[$i]['this_id']}>{$trunced_text}</a> на  {$whose_page}</div>
            <div id = 'full_text_comment_{$notices[$i]['this_id']}' class = 'panel-collapse collapse'>
            
            <div class='well well-sm' style = 'color:black;word-wrap:break-word;' >" .
            tolink($comment_text) .
            "<div class = 'multimedia_under_notice_container'>" . $multimedia_comment_text  . "</div>
            </div>
            
            </div>
            <div class = reply_to_notice_date>{$notices[$i]['date']}</div>
            
            <div style = 'heighth:1px; border:1px dashed white'></div>
            
            <div style = 'color:blue;word-wrap:break-word'>" .
             tolink($reply_to_comment_text) .
            "<div class = 'multimedia_under_notice_container'>" . $multimedia_reply_to_comment_text  . "</div>
            <a href = user.php?zs=" . str_replace(" ", "%20", $comment_page) . "#user_wall_comment_{$post_id}_{$comment_id}>Перейти к комменту >>></a>
            </div>
            
            </section>";  
            break;
/*******************************************************************************************************************************************/    
       case 'user_wall_post': /* Пост */
                            $post_id = $notices[$i]['post_id'];                            
                            $description = $notices[$i]['description']; 
                            $post_text = $notices[$i]['post_text'];
                            $post_id = $notices[$i]['post_id'];
                            $page = $notices[$i]['page'];
                              
                            $multimedia_post_text = href2obj($post_text);
  
                              echo "<section class = user_wall_post_notice id = user_wall_post_post_notice_{$notices[$i]['this_id']}>
                                    <div class = avatar_container><a href = user.php?zs={$notices[$i]['noticer']} title = {$notices[$i]['noticer']}><img class = 'avatar' src = 'users/{$noticer_avatar}' /></a></div> 
                                    <div class = user_wall_post_notice_description>{$description}</div>
                                    
                                    <div class = user_wall_post_notice_date>{$notices[$i]['date']}</div>
                                    
                                    <div style = 'heighth:1px; border:1px dashed white'></div>
                                    
                                    <div style = 'color:blue;word-wrap:break-word'>" .
                                     tolink($post_text) .
                                    "<div class = 'multimedia_under_notice_container'>" . $multimedia_post_text  . "</div>
                                    <a href = user.php?zs={$page}#user_wall_post_{$post_id}>Перейти к посту >>></a>
                                    </div>
                                    
                                    </section>";  
                             
                            break;
   
/****************************************************************************************************************************************************/

    case 'like_post': /* Лайк поста */
                            $post_id = $notices[$i]['post_id'];                            
                            $description = $notices[$i]['description']; 
                            $post_text = $notices[$i]['post_text'];
                            $post_id = $notices[$i]['post_id'];
                            $page = $notices[$i]['page'];
                              
                            $multimedia_post_text = href2obj($post_text); 
                              
                              echo "<section class = like_user_wall_post_notice id = like_user_wall_post_post_notice_{$notices[$i]['this_id']}>
                                    <div class = avatar_container><a href = user.php?zs={$notices[$i]['noticer']} title = {$notices[$i]['noticer']}><img class = 'avatar' src = 'users/{$noticer_avatar}' /></a></div> 
                                    <div class = like_user_wall_post_notice_description><a href = user.php?zs={$notices[$i]['noticer']}>{$notices[$i]['noticer']}</a> пролайкал ваш пост на   {$description}</div>
                                    
                                    <div class = like_user_wall_post_notice_date>{$notices[$i]['date']}</div>
                                    
                                    <div style = 'heighth:1px; border:1px dashed white'></div>
                                    
                                    <div style = 'color:blue;word-wrap:break-word'>" .
                                    tolink($post_text) . 
                                    "<div class = 'multimedia_under_notice_container'>" . $multimedia_post_text  . "</div>
                                    <a href = user.php?zs={$page}#user_wall_post_{$post_id}>Перейти к посту >>></a>
                                    </div>
                                    
                                    </section>";  
                             
                            break;

/****************************************************************************************************************************************************/

    case 'dislike_post': /* Дизлайк поста */
                            $post_id = $notices[$i]['post_id'];                            
                            $description = $notices[$i]['description']; 
                            $post_text = $notices[$i]['post_text'];
                            $post_id = $notices[$i]['post_id'];
                            $page = $notices[$i]['page'];
                            
                            $multimedia_post_text = href2obj($post_text); 
                              
                              echo "<section class = dislike_user_wall_post_notice id = dislike_user_wall_post_post_notice_{$notices[$i]['this_id']}>
                                    <div class = avatar_container><a href = user.php?zs={$notices[$i]['noticer']} title = {$notices[$i]['noticer']}><img class = 'avatar' src = 'users/{$noticer_avatar}' /></a></div> 
                                    <div class = dislike_user_wall_post_notice_description><a href = user.php?zs={$notices[$i]['noticer']}>{$notices[$i]['noticer']}</a> прогавнил ваш пост на   {$description}</div>
                                    
                                    <div class = like_user_wall_post_notice_date>{$notices[$i]['date']}</div>
                                    
                                    <div style = 'heighth:1px; border:1px dashed white'></div>
                                    
                                    <div style = 'color:blue;word-wrap:break-word'>" .
                                    tolink($post_text) . 
                                    "<div class = 'multimedia_under_notice_container'>" . $multimedia_post_text  . "</div>
                                    <a href = user.php?zs={$page}#user_wall_post_{$post_id}>Перейти к посту >>></a>
                                    </div>
                                    
                                    </section>";  
                             
                            break;

 case 'tell_ahuenno_post': /* Лайк поста */
                            $post_id = $notices[$i]['post_id'];                            
                            $description = $notices[$i]['description']; 
                            $post_text = $notices[$i]['post_text'];
                            $post_id = $notices[$i]['post_id'];
                            $page = $notices[$i]['page'];
                              
                            $multimedia_post_text = href2obj($post_text); 
                               
                              echo "<section class = tell_ahuenno_user_wall_post_notice id = tell_ahuenno_user_wall_post_post_notice_{$notices[$i]['this_id']}>
                                    <div class = avatar_container><a href = user.php?zs={$notices[$i]['noticer']} title = {$notices[$i]['noticer']}><img class = 'avatar' src = 'users/{$noticer_avatar}' /></a></div> 
                                    <div class = tell_ahuenno_user_wall_post_notice_description><a href = user.php?zs={$notices[$i]['noticer']}>{$notices[$i]['noticer']}</a> сделал репост вашего поста</div>
                                    
                                    <div class = tell_ahuenno_user_wall_post_notice_date>{$notices[$i]['date']}</div>
                                    
                                    <div style = 'heighth:1px; border:1px dashed white'></div>
                                    
                                    <div style = 'color:blue;word-wrap:break-word'>" .
                                    tolink($post_text) . 
                                    "<div class = 'multimedia_under_notice_container'>" . $multimedia_post_text  . "</div>
                                    <a href = user.php?zs={$page}#user_wall_post_{$post_id}>Перейти к посту >>></a>
                                    </div>
                                    
                                    </section>";  
                             
                            break;

case 'tell_gavno_post': /* Дизлайк поста */
                            $post_id = $notices[$i]['post_id'];                            
                            $description = $notices[$i]['description']; 
                            $post_text = $notices[$i]['post_text'];
                            $post_id = $notices[$i]['post_id'];
                            $page = $notices[$i]['page'];
                             
                            $multimedia_post_text = href2obj($post_text);  
                              
                              echo "<section class = tell_gavno_user_wall_post_notice id = tell_gavno_user_wall_post_post_notice_{$notices[$i]['this_id']}>
                                    <div class = avatar_container><a href = user.php?zs={$notices[$i]['noticer']} title = {$notices[$i]['noticer']}><img class = 'avatar' src = 'users/{$noticer_avatar}' /></a></div> 
                                    <div class = tell_gavno_user_wall_post_notice_description><a href = user.php?zs={$notices[$i]['noticer']}>{$notices[$i]['noticer']}</a> сделал дизрепост вашего поста</div>
                                    
                                    <div class = tell_gavno_user_wall_post_notice_date>{$notices[$i]['date']}</div>
                                    
                                    <div style = 'heigth:1px; border:1px dashed white'></div>
                                    
                                    <div style = 'color:blue;word-wrap:break-word'>" .
                                    tolink($post_text) . 
                                    "<div class = 'multimedia_under_notice_container'>" . $multimedia_post_text  . "</div>
                                    <a href = user.php?zs={$page}#user_wall_post_{$post_id}>Перейти к посту >>></a>
                                    </div>
                                    
                                    </section>";  
                             
                            break;

            case 'primary_image_comment': 
                                    $image_commenter = $notices[$i]['noticer'];
                                    $link = $notices[$i]['link'];
                                    $image_id = $notices[$i]['multimedia_id'];
                                    $comment_text = $notices[$i]['comment_text'];
                                    $comment_id = $notices[$i]['comment_id'];
                                    
                                    $multimedia = href2obj($comment_text);

             echo "<section class = user_wall_post_notice_container id = comment_post_notice_{$notices[$i]['this_id']}>
            <div class = avatar_container><a href = user.php?zs=" . str_replace(" ","%20",$image_commenter) . " title = " . str_replace(" ", "_",$image_commenter) . ">
            <img class = 'avatar' src = 'users/{$noticer_avatar}' />" . $online . "</a></div> 
            <div class = user_wall_post_notice_description><a href = user.php?zs=" . str_replace(" ", "%20",$image_commenter) . ">{$image_commenter}</a> прокомментил вашу картинку</div>
            <div><a href = primary_album.php?zs=" . $_SESSION['user'] . "&image_id={$image_id} target = _blank><img class = 'commented_img_under_notice' src = {$link} /></a><div> 
             
             <div><a href=primary_album.php?zs=" . $_SESSION['user'] . "&image_id={$image_id} target = _blank>Ссылка</a> | <a href = {$link} target = _blank>Оригинал</a> </div>
             
             <div style = 'color:blue;word-wrap:break-word'>" .
            tolink($comment_text) .
            "</div>
            
            <div class = 'multimedia_under_notice_container'>" . $multimedia  . "</div>
            
            <div class = comment_post_notice_date>{$common_notice[$i]['date']}</div>
            <div><a href=primary_album.php?zs=" . $_SESSION['user'] . "&image_id={$image_id}#comment_container_{$image_id} target = _blank>Перейти к комменту >>></a></div>
            </section>"; 
           
           break; 
           
           
            case 'common_image_comment': 
                                    $image_commenter = $notices[$i]['noticer'];
                                    $link = $notices[$i]['link'];
                                    $image_id = $notices[$i]['multimedia_id'];
                                    $comment_text = $notices[$i]['comment_text'];
                                    $comment_id = $notices[$i]['comment_id'];
                                    
                                    $multimedia = href2obj($comment_text);

             echo "<section class = user_wall_post_notice_container id = comment_post_notice_{$notices[$i]['this_id']}>
            <div class = avatar_container><a href = user.php?zs=" . str_replace(" ","%20",$image_commenter) . " title = " . str_replace(" ", "_",$image_commenter) . ">
            <img class = 'avatar' src = 'users/{$noticer_avatar}' />" . $online . "</a></div> 
            <div class = user_wall_post_notice_description><a href = user.php?zs=" . str_replace(" ", "%20",$image_commenter) . ">{$image_commenter}</a> прокомментил вашу общую картинку</div>
            <div><a href = common_images.php?image_id={$image_id} target = _blank><img class = 'commented_img_under_notice' src = {$link} /></a><div> 
             
             <div><a href=common_images.php?image_id={$image_id} target = _blank>Ссылка</a> | <a href = {$link} target = _blank>Оригинал</a> </div>
             
             <div style = 'color:blue;word-wrap:break-word'>" .
            tolink($comment_text) .
            "</div>
            
            <div class = 'multimedia_under_notice_container'>" . $multimedia  . "</div>
            
            <div class = comment_post_notice_date>{$common_notice[$i]['date']}</div>
            <div><a href=common_images.php?image_id={$image_id}#comment_container_{$image_id} target = _blank>Перейти к комменту >>></a></div>
            </section>"; 
           
           break; 

            case 'user_video_comment': 
                                    $video_commenter = $notices[$i]['noticer'];
                                    $link = $notices[$i]['link'];
                                    $video_id = $notices[$i]['multimedia_id'];
                                    $comment_text = $notices[$i]['comment_text'];
                                    $comment_id = $notices[$i]['comment_id'];
                                    
                                    $multimedia = href2obj($comment_text);

            $iframe_src_uvc = $link;

            if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)([a-zA-Z0-9\-_]{1,256})/is',$link) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)([a-zA-Z0-9\-_]{1,256})/is',$link, $multimedia_src_arr);  // Возвращает совпадение

        $hash = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)/is',"",$multimedia_src_arr[0]);
        
        $iframe_src_uvc = "https://www.youtube.com/embed/" . $hash;
}

             echo "<section class = user_wall_post_notice_container id = comment_post_notice_{$notices[$i]['this_id']}>
            <div class = avatar_container><a href = user.php?zs=" . str_replace(" ","%20",$video_commenter) . " title = " . str_replace(" ", "_",$video_commenter) . ">
            <img class = 'avatar' src = 'users/{$noticer_avatar}' />" . $online . "</a></div> 
            <div class = user_wall_post_notice_description><a href = user.php?zs=" . str_replace(" ", "%20",$video_commenter) . ">{$video_commenter}</a> прокомментил ваше видио</div>
            <iframe src={$iframe_src_uvc} class = 'video_under_post' frameborder = 0 allowfullscreen></iframe> 
             
             <div><a href=user_videos.php?zs={$_SESSION['user']}#user_video_container_{$video_id} target = _blank>Ссылка</a> | <a href = {$link} target = _blank>Оригинал</a> </div>
             
             <div style = 'color:blue;word-wrap:break-word'>" .
            tolink($comment_text) .
            "</div>
            
            <div class = 'multimedia_under_common_notice_container'>" . $multimedia  . "</div>
            
            <div class = comment_post_notice_date>{$common_notice[$i]['date']}</div>
            <div><a href=user_videos.php?zs={$_SESSION['user']}#user_video_container_{$video_id} target = _blank>Перейти к комменту >>></a></div>
            </section>"; 
           
           break; 
           
            case 'common_video_comment': 
                                    $video_commenter = $notices[$i]['noticer'];
                                    $link = $notices[$i]['link'];
                                    $video_id = $notices[$i]['multimedia_id'];
                                    $comment_text = $notices[$i]['comment_text'];
                                    $comment_id = $notices[$i]['comment_id'];
                                    
                                    $multimedia = href2obj($comment_text);
            $iframe_src_cvc = $link;

    if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)([a-zA-Z0-9\-_]{1,256})/is',$link) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)([a-zA-Z0-9\-_]{1,256})/is',$link, $multimedia_src_arr);  // Возвращает совпадение

        $hash = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)/is',"",$multimedia_src_arr[0]);
        
        $iframe_src_cvc = "https://www.youtube.com/embed/" . $hash;
}

             echo "<section class = user_wall_post_notice_container id = comment_post_notice_{$notices[$i]['this_id']}>
            <div class = avatar_container><a href = user.php?zs=" . str_replace(" ","%20",$video_commenter) . " title = " . str_replace(" ", "_",$video_commenter) . ">
            <img class = 'avatar' src = 'users/{$noticer_avatar}' />" . $online . "</a></div> 
            <div class = user_wall_post_notice_description><a href = user.php?zs=" . str_replace(" ", "%20",$video_commenter) . ">{$video_commenter}</a> прокомментил ваше общее видио видио</div>
            <iframe src={$iframe_src_cvc} class = 'video_under_post' frameborder = 0 allowfullscreen></iframe> 
             
             <div><a href=common_videos.php#common_video_container_{$video_id} target = _blank>Ссылка</a> | <a href = {$link} target = _blank>Оригинал</a> </div>
             
             <div style = 'color:blue;word-wrap:break-word'>" .
            tolink($comment_text) .
            "</div>
            
            <div class = 'multimedia_under_common_notice_container'>" . $multimedia  . "</div>
            
            <div class = comment_post_notice_date>{$common_notice[$i]['date']}</div>
            <div><a href=common_videos.php#user_video_container_{$video_id} target = _blank>Перейти к комменту >>></a></div>
            </section>"; 
           
           break;


case 'new_user': /* Новый пользователь */
                            
                              echo "<section class = new_user_notice id = new_user_notice_{$notices[$i]['this_id']}>
                                    <div class = avatar_container><a href = user.php?zs={$notices[$i]['noticer']} title = {$notices[$i]['noticer']}><img class = 'avatar' src = 'users/{$noticer_avatar}' /></a></div> 
                                    <div class = new_user_notice_description> <a href = user.php?zs=green_bot>green_bot</a><br /> Поздравляем с регистрацией в социальной сети для поехавших БЕЗ цензуры и прочей хуйни. Наша команда искренне надеется, что вы стену ебать начнете от нашего проекта.
                                    Ну а пока чтоб вам уж совсем грустно не было поиграйте в <a href = fun_select.php>шашки</a></div>
                                    
                                    <div class = new_user_notice_date>{$notices[$i]['date']}</div>
                                    
                                    </section>";  
                             
                            break;

case 'add_supporter': /* Новый пользователь */
                            
                              echo "<section class = new_user_notice id = new_user_notice_{$notices[$i]['this_id']}>
                                    <div class = avatar_container><a href = user.php?zs={$notices[$i]['noticer']} title = {$notices[$i]['noticer']}><img class = 'avatar' src = 'users/{$noticer_avatar}' /></a></div> 
                                    <div class = new_user_notice_description> <a href = user.php?zs=green_bot>green_bot</a><br /><span>Поздравляем нахуй! Вы выбраны в качестве черпака</span></div>
                                    
                                    <div class = new_user_notice_date>{$notices[$i]['date']}</div>
                                    
                                    </section>";  
                             
                            break;                            
           
             // Пользователь рассказал ахуенно об общей картинке
         case 'telled_ahuenno_common_image': 
                                     
                                            $image_id = $notices[$i]['multimedia_id'];
                                            $link = $notices[$i]['link'];

           echo "<section class = user_wall_post_notice_container id = user_wall_post_post_notice_{$notices[$i]['this_id']}>
                                    <div class = avatar_container><a href = user.php?zs=" . str_replace(" ", "%20",$notices[$i]['noticer']) . " title = " . str_replace(" ", "_",$notices[$i]['noticer']) . ">
                                    <img class = avatar src = 'users/{$noticer_avatar}' />" . $online . str_replace(" ","_",$notices[$i]['noticer']) . "</a> сделал репост вашей картинки в общем альбоме </div> 
                                
              <div class = user_wall_post_notice_description>
            <a href = common_images.php?image_id={$image_id} target=_blank>
            <img src={$link} class = 'img_under_post' onerror = this.src='imgs/file_not_found.png' /></a> 
             
             <div><a href=common_images.php?image_id={$image_id} target = _blank>Ссылка</a> | <a href = {$link} target = _blank>Оригинал</a> </div>
                                    
            <div class = user_wall_post_notice_date>{$notices[$i]['date']}</div>
             </div>
             <a href = common_images.php?image_id={$image_id} target = _blank>Перейти к картинке >>></a>
                </section>"; 
           
            break; 

  // Пользователь рассказал ахуенно об общей картинке
         case 'telled_ahuenno_primary_image': 
                                     
                                            $image_id = $notices[$i]['multimedia_id'];
                                            $link = $notices[$i]['link'];

           echo "<section class = user_wall_post_notice_container id = user_wall_post_post_notice_{$notices[$i]['this_id']}>
                                    <div class = avatar_container><a href = user.php?zs=" . str_replace(" ", "%20",$notices[$i]['noticer']) . " title = " . str_replace(" ", "_",$notices[$i]['noticer']) . ">
                                    <img class = avatar src = 'users/{$noticer_avatar}' />" . $online . str_replace(" ","_",$notices[$i]['noticer']) . "</a> сделал репост вашей картинки </div> 
                                
              <div class = user_wall_post_notice_description>
            <a href = primary_album.php?zs=" . str_replace(" ","_",$notices[$i]['noticed']) . "&image_id={$image_id} target=_blank>
            <img src={$link} class = 'img_under_post' onerror = this.src='imgs/file_not_found.png' /></a> 
             
             <div><a href=primary_album.php?zs=" . str_replace(" ","_",$notices[$i]['noticed']) . "&image_id={$image_id} target = _blank>Ссылка</a> | <a href = {$link} target = _blank>Оригинал</a> </div>
                                    
            <div class = user_wall_post_notice_date>{$notices[$i]['date']}</div>
             </div>
             <a href = primary_album.php?zs=" . str_replace(" ","_",$notices[$i]['noticed']) . "&image_id={$image_id} target = _blank>Перейти к картинке >>></a>
                </section>"; 
           
            break; 

        // Пользователь рассказал ахуенно об общей картинке
         case 'telled_gavno_primary_image': 
                                     
                                            $image_id = $notices[$i]['multimedia_id'];
                                            $link = $notices[$i]['link'];

           echo "<section class = user_wall_post_notice_container id = user_wall_post_post_notice_{$notices[$i]['this_id']}>
                                    <div class = avatar_container><a href = user.php?zs=" . str_replace(" ", "%20",$notices[$i]['noticer']) . " title = " . str_replace(" ", "_",$notices[$i]['noticer']) . ">
                                    <img class = avatar src = 'users/{$noticer_avatar}' />" . $online . str_replace(" ","_",$notices[$i]['noticer']) . "</a> сделал дизрепост вашей картинки </div> 
                                
              <div class = user_wall_post_notice_description>
            <a href = primary_album.php?zs=" . str_replace(" ","_",$notices[$i]['noticed']) . "&image_id={$image_id} target=_blank>
            <img src={$link} class = 'img_under_post' onerror = this.src='imgs/file_not_found.png' /></a> 
             
             <div><a href=primary_album.php?zs=" . str_replace(" ","_",$notices[$i]['noticed']) . "&image_id={$image_id} target = _blank>Ссылка</a> | <a href = {$link} target = _blank>Оригинал</a> </div>
                                    
            <div class = user_wall_post_notice_date>{$notices[$i]['date']}</div>
             </div>
             <a href = primary_album.php?zs=" . str_replace(" ","_",$notices[$i]['noticed']) . "&image_id={$image_id} target = _blank>Перейти к картинке >>></a>
                </section>"; 
           
            break; 

            // Пользователь рассказал ахуенно об общем видео
         case 'telled_ahuenno_common_video': 
                                     
                                            $video_id = $notices[$i]['multimedia_id'];
                                            $link = $notices[$i]['link'];
                                     
           $iframe_src_acv = $link;

if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)([a-zA-Z0-9\-_]{1,256})/is',$link) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)([a-zA-Z0-9\-_]{1,256})/is',$link, $multimedia_src_arr);  // Возвращает совпадение

        $hash = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)/is',"",$multimedia_src_arr[0]);
        
        $iframe_src_acv = "https://www.youtube.com/embed/" . $hash;
}
           
           echo "<section class = user_wall_post_notice_container id = user_wall_post_post_notice_{$notices[$i]['this_id']}>
                                    <div class = avatar_container><a href = user.php?zs=" . str_replace(" ", "%20",$notices[$i]['noticer']) . " title = " . str_replace(" ", "_",$notices[$i]['noticer']) . ">
                                    <img class = avatar src = 'users/{$noticer_avatar}' />" . $online . $notices[$i]['noticer'] . "</a> сделал репост вашего видио</div><br /> 
                                    <div class = user_wall_post_notice_description>
     
            <iframe src={$iframe_src_acv} class = 'video_under_common_notice' frameborder = 0 allowfullscreen></iframe> 
             
             <div><a href=common_videos.php#user_video_container_{$video_id} target = _blank>Ссылка</a> | <a href = {$link} target = _blank>Оригинал</a> </div>
             
            <div><a href=common_videos.php#user_video_container_{$video_id} target = _blank>Перейти к видио >>></a></div>
            </a>
            </section>"; 
             
            break; 

// Пользователь рассказал ахуенно об общем видео
         case 'telled_ahuenno_user_video': 
                                     
                                            $video_id = $notices[$i]['multimedia_id'];
                                            $link = $notices[$i]['link'];
                                            $whose_multimedia = $notices[$i]['whose_multimedia'];
           
           $iframe_src_acv = $link;

if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)([a-zA-Z0-9\-_]{1,256})/is',$link) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)([a-zA-Z0-9\-_]{1,256})/is',$link, $multimedia_src_arr);  // Возвращает совпадение

        $hash = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)/is',"",$multimedia_src_arr[0]);
        
        $iframe_src_acv = "https://www.youtube.com/embed/" . $hash;
}
           
           echo "<section class = user_wall_post_notice_container id = user_wall_post_post_notice_{$notices[$i]['this_id']}>
                                    <div class = avatar_container><a href = user.php?zs=" . str_replace(" ", "%20",$notices[$i]['noticer']) . " title = " . str_replace(" ", "_",$notices[$i]['noticer']) . ">
                                    <img class = avatar src = 'users/{$noticer_avatar}' />" . $online . $notices[$i]['noticer'] . "</a> сделал репост вашего видио</div><br /> 
                                    <div class = user_wall_post_notice_description>
                                    
            <iframe src={$iframe_src_acv} class = 'video_under_common_notice' frameborder = 0 allowfullscreen></iframe> 
             
             <div><a href=user_videos.php?zs=" . str_replace(" ", "%20",$notices[$i]['noticed']) . "#user_video_container_{$video_id} target = _blank>Ссылка</a> | <a href = {$link} target = _blank>Оригинал</a> </div>
             
            <div><a href=user_videos.php?zs=" . str_replace(" ", "%20",$notices[$i]['noticed']) . "#user_video_container_{$video_id} target = _blank>Перейти к видио >>></a></div>
            </section>"; 
             
            break; 

// Пользователь рассказал ахуенно об общем видео
         case 'telled_gavno_user_video': 
                                     
                                            $video_id = $notices[$i]['multimedia_id'];
                                            $link = $notices[$i]['link'];
                                            $whose_multimedia = $notices[$i]['whose_multimedia'];
           
           $iframe_src_acv = $link;

if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)([a-zA-Z0-9\-_]{1,256})/is',$link) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)([a-zA-Z0-9\-_]{1,256})/is',$link, $multimedia_src_arr);  // Возвращает совпадение

        $hash = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)/is',"",$multimedia_src_arr[0]);
        
        $iframe_src_acv = "https://www.youtube.com/embed/" . $hash;
}
           
           echo "<section class = user_wall_post_notice_container id = user_wall_post_post_notice_{$notices[$i]['this_id']}>
                                    <div class = avatar_container><a href = user.php?zs=" . str_replace(" ", "%20",$notices[$i]['noticer']) . " title = " . str_replace(" ", "_",$notices[$i]['noticer']) . ">
                                    <img class = avatar src = 'users/{$noticer_avatar}' />" . $online . $notices[$i]['noticer'] . "</a> сделал дизрепост вашего видио</div><br /> 
                                    <div class = user_wall_post_notice_description>
                                    
            <iframe src={$iframe_src_acv} class = 'video_under_common_notice' frameborder = 0 allowfullscreen></iframe> 
             
             <div><a href=user_videos.php?zs=" . str_replace(" ", "%20",$notices[$i]['noticed']) . "#user_video_container_{$video_id} target = _blank>Ссылка</a> | <a href = {$link} target = _blank>Оригинал</a> </div>
             
            <div><a href=user_videos.php?zs=" . str_replace(" ", "%20",$notices[$i]['noticed']) . "#user_video_container_{$video_id} target = _blank>Перейти к видио >>></a></div>
            </section>"; 
             
            break; 

            case 'marked_as_pidor': /* ПОСЧИТАТЬ ПИДОРОМ */ 

            echo "<section class = deny_friend_request_notice id = deny_friend_request_notice_{$notices[$i]['this_id']} onclick = window.location.replace('user.php?zs={$notices[$i]['noticer']}')>
            <div class = avatar_container><a href = user.php?zs={$notices[$i]['noticer']} title = {$notices[$i]['noticer']}><img class = 'avatar' src = 'users/{$noticer_avatar}' /></a></div> 
            <div class = deny_friend_request_notice_description><a href = user.php?zs={$notices[$i]['noticer']} title = {$notices[$i]['noticer']}>{$notices[$i]['noticer']}</a> считатет вас пидором</div>
            <div class = deny_friend_request_notice_date>{$notices[$i]['date']}</div>
            </section>";
            
            break;     
        } //  switch($notices[$i]['type'])
    
    } //   for($i = 0; $i < count($notices); $i++)
    
} // if(!empty($notices))

?>

</div><!-- class row -->

</section>    

</main>    

</body>

</html>    


<?php ob_end_flush(); ?>

