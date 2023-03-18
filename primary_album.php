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

    $login = $_GET['zs'];

    $sql = "SELECT * FROM `user_images_primary_album` WHERE `user`='{$login}' ORDER BY `this_id` DESC";
        $query = $connection_handler->prepare($sql);
        $query->execute();
        $images = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $images_count = count($images);
        
        $cover_img = "";

$image_id_for_facebook = "";

$image_id = $_GET['image_id'];
$next_image;
$prev_image;

if(!empty($image_id)){
    $image_id_for_facebook = "&image_id=" . $image_id;
    
    
    // Айди следующего изображения
    $sql = "SELECT * FROM `user_images_primary_album` WHERE `user`='{$login}' AND `this_id`<{$image_id} ORDER BY `this_id` DESC";	
    $query = $connection_handler->prepare($sql);
    $query->execute();
    $next_image = $query->fetchAll(PDO::FETCH_ASSOC);
    $next_image = $next_image[0]['this_id'];
      
      if(empty($next_image)){ // Следующее изображение есть
        $next_image = $image_id;
        
    }
 
     // Айди предыдущего изображения
    $sql = "SELECT * FROM `user_images_primary_album` WHERE `user`='{$login}' AND `this_id`>{$image_id}";	
    $query = $connection_handler->prepare($sql);
    $query->execute();
    $prev_image = $query->fetchAll(PDO::FETCH_ASSOC);
    $prev_image = $prev_image[0]['this_id'];
    
      if(empty($prev_image)){ // Следующее изображение есть
        $prev_image = $image_id;
    }
}

        if(empty($images)){
            $cover_img = "imgs/empty_album.png";    
        }else{
            $cover_img = $images[0]['link'];   
       
                    if(!empty($image_id)){
        
                        $sql = "SELECT * FROM `user_images_primary_album` WHERE `this_id`=" . $image_id;
                $query = $connection_handler->prepare($sql);
                $query->execute();
                $image_for_facebook = $query->fetchAll(PDO::FETCH_ASSOC);
        
                $cover_img = $image_for_facebook[0]['link'];
            
    }           
       
}

        if(empty($login)){
        header('Location:index.php');
        exit();
    }
    
    $sql = "SELECT *  FROM `main_info` WHERE `nickname`='{$login}'";	
    $query = $connection_handler->prepare($sql);
    $query->execute();
    $user_info = $query->fetchAll(PDO::FETCH_ASSOC);
    
    if(empty($user_info)){
        header('Location:index.php');
        exit();
    }
    
    $add_image_a = "";
    
    if(!empty($_SESSION['user']) && $_SESSION['user'] === $login){
        $add_image_a = ' | <a role="button" data-toggle="modal" data-target="#add_image_modal">Добавить картинку</a>';
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


?>

<html>

<head>
<title>Primary album | <?php echo $login; ?></title>
<meta charset = "utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name = "description" content = "Primary album |  <?php echo $login;  ?>" />
    <meta name="keywords" content = "<?php echo $login; ?>,primary album, photos, images, pics, pictures" / >
    <meta name = "author" content = "<?php echo $login; ?>">

<meta property="og:title" content="Primary album | <?php echo $login;  ?>"/>
<meta property="og:description" content="Outmind pics"/>
<meta property="og:image" content="<?php echo $cover_img; ?>">
<meta property="og:type" content="article"/>
<meta property="og:url" content= "//frendors.com/primary_album.php?zs=<?php echo $login . $image_id_for_facebook ?>" />

<link rel = "stylesheet" href = "css/normalize.css"  type = "text/css" />
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel = "stylesheet" src = "css/roboto/roboto.css">
<script src="bootstrap/js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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

<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.8&appId=105917036567372";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

<style>

body {
    font-family:'Roboto';
    margin:0 auto;
    height:100%;
}

main {
    padding: 10px;
    border-left:1px solid blue;
    border-right:1px solid blue;
    margin:0 auto;
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
    cursor:pointer;
}

#add_image_modal{
 margin-top:200px;
}

input[type=text]{
          padding:5px;
          border-radius:5px;
}

input[type=text]:focus{
     background-color: #98DDDE;
     box-shadow: 0px 0px 1px #7FFFD4;
} 

#vk_like_top{
  position:relative;
  top:1px;
  right:0px;
}

#fb_like_top{
    position:relative;
    top:10px;
}

#vk_auth{
        margin-top:20px;
}

#facebook_login_button{
    
    margin-top:10px;
    
}

</style>

</head>    

<body class="" style = "max-width:1400px;background-color:#cefdce;">

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

if(empty($_SESSION['user'])){
    echo "<a href = index.php target = _blank>frendors.com</a>";
}else{

echo '<a href = user_albums.php?zs=' . $login . '> <<< Альбомы</a>' . $add_image_a;
    
}
?>

<div id="vk_like_top"></div>
<script type="text/javascript">
    VK.Widgets.Like("vk_like_top", {type: "button"});
</script>
<div class="fb-like" id = "fb_like_top" data-href="https://frendors.com/primary_album.php?zs=<?php echo $login; ?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>

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


<h1 style = "color:blue;text-align:center;margin-bottom:5px;">Primary</h1>

<!-- Modal -->
<div id="add_image_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Добавляем картинку</h4>
      </div>
      <div class="modal-body">
        Ссылка <input type = "text" maxlength = "300" style = "width:100%" id = "img_link_input" required = "required" /><br />
        <span id = "errors" style = "color:red;display:none">Данный тип ссылок не поддерживается</span><br />
     <button type="button" class="btn btn-success" style = "position:relative;top:10px;" onclick = "add_image()" >Добавить</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Нахуй</button>
      </div>
    </div>

  </div>
</div>  
 
<style> 
 
/**********************************************/

/* Next & previous buttons */
.prev,
.next {
  cursor: pointer;
  width: auto;
  color: black;
  font-weight: bold;
  font-size: 20px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
  user-select: none;
  -webkit-user-select: none;
  display:block;
}

.prev{
    float:left;
}

.next{
    float:right;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover,
.next:hover {
  background-color: rgba(0, 0, 0, 0.8);
}

/**********************************************************************************/

.ahuenno_image_span{
    display:block;
    color: blue;
    padding:3px;
    border-radius:3px;
    cursor:pointer;
    float:left;
}

.ahuenno_image_span:hover{
   background: #9dd53a; /* Old browsers */
   background: -moz-linear-gradient(top,  #9dd53a 0%, #a1d54f 50%, #80c217 51%, #7cbc0a 100%); /* FF3.6-15 */
   background: -webkit-linear-gradient(top,  #9dd53a 0%,#a1d54f 50%,#80c217 51%,#7cbc0a 100%); /* Chrome10-25,Safari5.1-6 */
   background: linear-gradient(to bottom,  #9dd53a 0%,#a1d54f 50%,#80c217 51%,#7cbc0a 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
   filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#9dd53a', endColorstr='#7cbc0a',GradientType=0 ); /* IE6-9 */
}


.ahuenno_image_span:active{
    background: #7cbc0a; /* Old browsers */
    background: -moz-linear-gradient(top, #7cbc0a 0%, #80c217 49%, #a1d54f 50%, #9dd53a 100%); /* FF3.6-15 */
    background: -webkit-linear-gradient(top, #7cbc0a 0%,#80c217 49%,#a1d54f 50%,#9dd53a 100%); /* Chrome10-25,Safari5.1-6 */
    background: linear-gradient(to bottom, #7cbc0a 0%,#80c217 49%,#a1d54f 50%,#9dd53a 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#7cbc0a', endColorstr='#9dd53a',GradientType=0 ); /* IE6-9 */
}

.img_ahuenno, .img_gavno{
    width:20px;
    height:20px;
}

.gavno_image_span{
    display:block;
    color: blue;
    padding:3px;
    border-radius:3px;
    cursor:pointer;
    float:right;
}

.gavno_image_span:hover{
    background: #f3e2c7; /* Old browsers */
    background: -moz-linear-gradient(top, #f3e2c7 0%, #c19e67 50%, #b68d4c 51%, #e9d4b3 100%); /* FF3.6-15 */
    background: -webkit-linear-gradient(top, #f3e2c7 0%,#c19e67 50%,#b68d4c 51%,#e9d4b3 100%); /* Chrome10-25,Safari5.1-6 */
    background: linear-gradient(to bottom, #f3e2c7 0%,#c19e67 50%,#b68d4c 51%,#e9d4b3 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f3e2c7', endColorstr='#e9d4b3',GradientType=0 ); /* IE6-9 */
}

.gavno_image_span:active{
    background: #e9d4b3; /* Old browsers */
    background: -moz-linear-gradient(top, #e9d4b3 0%, #b68d4c 49%, #c19e67 50%, #f3e2c7 100%); /* FF3.6-15 */
    background: -webkit-linear-gradient(top, #e9d4b3 0%,#b68d4c 49%,#c19e67 50%,#f3e2c7 100%); /* Chrome10-25,Safari5.1-6 */
    background: linear-gradient(to bottom, #e9d4b3 0%,#b68d4c 49%,#c19e67 50%,#f3e2c7 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e9d4b3', endColorstr='#f3e2c7',GradientType=0 ); /* IE6-9 */
}

.ahuenno_gavno_under_image_container{
  
}

#fb-like{
  margin:2px;
float:left;
}

#vk_like{
 margin:2px;
float:left;
}

#fb_vk_like_container{
 float:left;
}

#ahuenno_gavno_container{
float:right;
}

#comments_textarea_container{
    display:inline-block;
    width:100%;
}

#comments_container{
    word-wrap:break-word;
    padding:0 20px;
}

#textarea_container{
border-bottom:1px solid black;
margin-bottom:5px;
padding:5px;
}


textarea{
          width:100%;
          resize: none;
}

#send_comment_form{
 
}

input[type=text]:focus,textarea:focus{
     background-color: #98DDDE;
     box-shadow: 0px 0px 1px #7FFFD4;
} 

#send_comment_button{
   
}

/******************************************************/

.comment_date{
    color:gray;
    font-size:12px;
    display:block;
    margin:0px;
    border-bottom:1px dashed black;

}

.comment_text{
    color:black;

}

.comment_container{
    margin-bottom:5px;
    border-bottom:1px solid grey;
    padding:5px;
}

.avatar{
    width:50px;
    height:50px;
    border-radius:5px;
   
}

.nickname{
    font-weight:bold;
    color:blue;
    font-size:20px;
    display:block;
    margin-top:0px;
    margin:0px;

}

.nickname:hover{
    text-decoration:underline;
}

.avatar_nick_date_container{

}

.zdesya_img{
    width:15px;
    height:15px;
   
}

.delete_comment_a{
   
}

.video_under_comment,
.img_under_comment, 
.frendors_page_iframe_under_comment{
    width:380px;
    height:300px;
    margin-right:300px;
}

</style> 
  
  <style>
      
      /* The Modal (background) */
#modal_img {
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    padding-top:2px;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
#modal_img_header_body_footer { /* Заголовок, контэйнер для картинки, футер */
    position: relative;
    background-color: #fefefe;
    margin: auto;
    padding: 0;
    border: 1px solid #888;
    width: 80%;
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
    -webkit-animation-name: animatetop;
    -webkit-animation-duration: 0.4s;
    animation-name: animatetop;
    animation-duration: 0.4s
}

/* Add Animation */
@-webkit-keyframes animatetop {
    from {top:-300px; opacity:0} 
    to {top:0; opacity:1}
}

@keyframes animatetop {
    from {top:-300px; opacity:0}
    to {top:0; opacity:1}
}

/* The Close Button */
.close {
    color: white;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

#modal_img_header {
    padding: 2px 16px;
    background-color: #5cb85c;
    color: white;
}

#modal_img_body { /* Контэнер для картинки */

    display:inline-block;
    text-align:center;
     padding:3px;
     padding-bottom:0;
    
}

@media screen and (min-width:426px){
   #modal_img_body{
       height:300px;
} 

}

@media screen and (min-width:769px){
   #modal_img_body{
       height:370px;
} 

}

@media screen and (min-width:1025px){
   #modal_img_body{
       height:350px;
} 

}

#modal_img_footer {
    padding: 2px 16px;
   border-top:1px solid black;
}
 
 .to_malafilnya_gavno_span{
     
 }
 
 #img_in_modal{
     cursor:pointer;
 }
 
 #galery_wrapper{
  text-align:center;   
 }
 
 #galery_container{
  display:inline-block;
 }
 
 .image_container{
     padding:5px;
     display:inline-block;

 }
 
 .image_container img{
     cursor:pointer;
     width:400px;
     height:400px;
 }
 
 
 @media only screen and (max-width: 601px) {
 
  .image_container img{
   width:100%;
     height:100%;
 }
}
      
  </style>
 
 <div id = "galery_wrapper">
 <div id = "gallery_container" >
 
<?php 

for($i = 0; $i < count($images); $i++){

 echo '<div class="image_container">
                
            <img src="' . $images[$i]['link'] . '" 
            onclick = window.location.replace("primary_album.php?zs=' .$login . '&image_id=' . $images[$i]['this_id'] . '")  />
            
        </div>';
} 

    if(!empty($image_id)){
        
        $sql = "SELECT *  FROM `user_images_primary_album` WHERE `this_id`={$image_id}";	
        $query = $connection_handler->prepare($sql);
        $query->execute();
        $image = $query->fetchAll(PDO::FETCH_ASSOC);
        
        if(!empty($image)){ // Такое изображение есть
        
        $delete_image_function = ""; // Функция удаления
          
            if($_SESSION['user'] === $login){
               $delete_image_function = "<a onclick = 'delete_image(this);return false;'>delete</a> |"; 
            }
       
       $add_image_to_primary_album_in_modal_function = ""; // Функция добавления изображения в первичный альбом
        
        if(!empty($_SESSION['user'])){
            
            if($_SESSION['user'] !== $login){
                
                $add_image_to_primary_album_in_modal_function = " | <a onclick = add_image_to_primary_album_in_modal(this," . $image_id . ")>в первичный</a>";
                
            }
            
        }
           
           $ahuenno_image_function = "";
           $gavno_image_function = "";
           $tell_to_bros_ahuenno_function = "";
           $tell_to_bros_gavno_function = "";
            
             if(!empty($_SESSION['user'])){

                $ahuenno_image_function = " onclick = tell_to_bros_ahuenno(this," . $image_id . ") ";
                $gavno_image_function = " onclick = tell_to_bros_gavno(this," . $image_id . ")";
                
            }
        
     $send_comment_form = "";
     
     if(!empty($_SESSION['user'])){
         
         $send_comment_form = "<div id = send_comment_form>
                                            <textarea rows=1 class = 'w3-input w3-border' onkeypress = send_comment_enter(event) 
                                            id = 'comment_textarea' style = 'width:100%;margin-bottom:5px' maxlength = '1000' oninput = 'this.rows = 3'></textarea>
                                            <button type = 'button' class='w3-button w3-block w3-theme' id = 'send_comment_button' onclick = send_comment()>Ahuenno</button>
                                </div>";
         
     }
            
     // ЛАЙКИ
     $sql = "SELECT COUNT(*) AS `ahuenno_count` FROM `primary_album_likes` WHERE `image_id`={$image_id}";	
     $query = $connection_handler->prepare($sql);
     $query->execute();
     $ahuenno_count = $query->fetchAll(PDO::FETCH_ASSOC);
     $ahuenno_count = $ahuenno_count[0]['ahuenno_count'];
    
    // ДИЗЛАЙКИ
     $sql = "SELECT COUNT(*) AS `gavno_count` FROM `primary_album_dislikes` WHERE `image_id`={$image_id}";	
     $query = $connection_handler->prepare($sql);
     $query->execute();
     $gavno_count = $query->fetchAll(PDO::FETCH_ASSOC);
     $gavno_count = $gavno_count[0]['gavno_count'];
    
    // КОММЕНТЫ
    $sql = "SELECT *  FROM `comments_primary_album` WHERE `image_id`={$image_id} ORDER BY `this_id` DESC";	
    $query = $connection_handler->prepare($sql);
    $query->execute();
    $comments = $query->fetchAll(PDO::FETCH_ASSOC);
    
    $comments_outp = "";
    $current_time = time();
    
                    for($j = 0; $j < count($comments); $j++){ // Собираем комменты
                    
                        $comment_id = $comments[$j]['this_id'];
                        $comment_author = $comments[$j]['user'];
                        $comment_text = $comments[$j]['text'];
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
                    
                            $online = "<img src = imgs/zdesya.png class = zdesya_img style = 'visibility:hidden' />"; /* Текст, который будет отображаться в месте онлайн */
                            
                            if(($current_time - $last_action_time) <= 180){ // Разница <= 180 секунд
                                
                                    /* ПРОВЕРЯЕМ С КАКОГО УСТРОЙСТВА ЗАЩЕЛ ПОЛЬЗОВАТЕЛЬ */
                                    $sql = "SELECT * FROM `main_info` WHERE `nickname`='{$comment_author}'"; 	
                                    $query = $connection_handler->prepare($sql); //Подготавливаем запрос
                                    $query->execute();
                                    $user_os = $query->fetchAll(PDO::FETCH_ASSOC);
                                    $user_os = $user_os[0]['os'];
                                
                                if($user_os === 'mobile'){
                                        $online = '<img src = imgs/phone.png class = zdesya_img style = "visibility:visible" />';
                                    }else{
                                        $online = '<img src = imgs/zdesya.png class = zdesya_img style = "visibility:visible" />';
                                    }
                                } 
                        
                        if($comment_author === $_SESSION['user'] || $image[0]['user'] === $_SESSION['user']){ // Функция удаления коммента
                            $delete_comment_function = "<a onclick = delete_comment(this," . $comment_id . ") class = 'delete_comment_a'>Чисти</a>";    
                        }
              
                        $comments_outp .= "<section id = 'comment_container_" . $comment_id . "' class = 'comment_container'>
                                                <div class = 'avatar_nick_date_container'>
                                                <a href = 'user.php?zs=" . $comment_author . "' target = _blank'><img src='users/" . $avatar_src . "' class = 'avatar' /><h1 class = 'nickname'>" . $online . $comment_author . "</h1></a>
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
    
    $redirect = $_GET['redirect'];
    $redirect_page = 'primary_album.php?zs=' . $login;
    
      if($redirect === "user"){
        $redirect_page = 'user.php?zs=' . $login; 
      }

     echo '<div class="w3-row w3-border" id = "modal_img">

<div class="w3-twothird w3-container w3-white" style = "border-right:1px solid black">
 
  <img class="w3-image" id = "img_in_modal" style = "height:640px;width:840px;" src = "' . $image[0]['link'] . '" onclick = "next_image()" />

</div>

<div class="w3-third w3-container w3-white">
        <span class="close" style = "color:black;position:relative;left:10px;" onclick = window.location.replace("' . $redirect_page . '")>&times;</span>
        <div class = "ahuenno_gavno_under_image_container" style = "margin-top:20px;margin-bottom:5px">
    <div id = "links_container" style = "margin-bottom:5px;">'. $delete_image_function .  
    '<a href="' . $image[0]['link'] . '" target = _blank>original</a>' .  $add_image_to_primary_album_in_modal_function . $tell_to_bros_ahuenno_function  .
        '<span class = to_malafilnya_gavno_span>' . $tell_to_bros_gavno_function . '</span>
  </div>
        <button class="w3-button w3-block w3-theme" style = "margin-bottom:5px" ' . $ahuenno_image_function . '>
                        <i class = "fa fa-thumbs-up"></i>Ahuenno | <span class = ahuenno_count_span id = ahuenno_count_span_' . $image_id  . ' >' . $ahuenno_count . 
                        '</span>
        </button> 
        
                <button class="w3-button w3-block w3-theme" style = "margin-bottom:10px" ' . $gavno_image_function . '>
                    <i class="fa fa-thumbs-down" /></i>Gavno! | <span class = gavno_count_span id = gavno_count_span_' . $image_id  . ' >' . $gavno_count . '</span>
        </button>
  
  </div>
   
       <div id = "textarea_container">' .
            $send_comment_form    .
              '</div>
              
                 <div id = "comments_container">' .
              $comments_outp .
              '</div>
</div>


</div>';
        
        }else{
            header('Location: user.php?zs=' . $login);
            exit();
            
        }

/*****************************************************************************************/

 
 
  /*****************************************************************************************/
        
}

?>
</div>
</div>


<script>

function tell_to_bros_ahuenno(ahuenno_span,id){
  var ahuenno_count_span = document.getElementById("ahuenno_count_span_" + id);  

if(id == null || id == ""){
   return; 
}

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {

if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
       
        var response = JSON.parse(xmlhttp.response);
          ahuenno_span.onclick = null;
        
        if(response.likes_count !== "null"){
            ahuenno_count_span.innerHTML = response.likes_count;
          
        }
      
    } 
}

var formData = new FormData();
formData.append('image_id', id);

xmlhttp.open('POST', 'scripts/tell_to_bros_ahuenno_primary_image.php', true);
xmlhttp.send(formData);

}

function tell_to_bros_gavno(gavno_span,id){
  var gavno_count_span = document.getElementById("gavno_count_span_" + id);  

if(id == null || id == ""){
   return; 
}

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {

if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      
        var response = JSON.parse(xmlhttp.response);
         gavno_span.onclick = null;
        if(response.dislikes_count !== "null"){
            gavno_count_span.innerHTML = response.dislikes_count;
           
        }
      
    } 
}

var formData = new FormData();
formData.append('image_id', id);

xmlhttp.open('POST', 'scripts/tell_to_bros_gavno_primary_image.php', true);
xmlhttp.send(formData);

}


</script>

<script>

function add_image(){
    
    var img_link_input = document.getElementById("img_link_input");
    var errors = document.getElementById("errors");

    if(img_link_input.value == ""){
        return;
    }
    
    if(!img_link_input.value.match(/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([a-zA-Z0-9_\-.]{2,256})\.([a-zA-Z]{2,6})[\/]([a-zA-Z0-9_\/\-.?&;%=+])+(png|jpg|jpeg|gif)/ig)){
       errors.style.display = "block"; 
    }else{
        
       var xmlhttp = new XMLHttpRequest();
       
       xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            img_link_input.value = "";
          errors.style.display = "block";
           errors.innerHTML = xmlhttp.response;
        
            } 
        }
        
  var formData = new FormData();
  formData.append('link', img_link_input.value.trim());

   xmlhttp.open('POST', 'scripts/add_image_in_primary_album.php', true);
   xmlhttp.send(formData);
   
    }
    
}


function next_image() {
 
    window.location.replace("primary_album.php?zs=<?php echo $login; ?>&image_id=<?php echo $next_image; ?>"); 

} 

function prev_image(){
    
        window.location.replace("primary_album.php?zs=<?php echo $login; ?>&image_id=<?php echo $prev_image; ?>");

}


function delete_image(obj){

var xmlhttp = new XMLHttpRequest();
       
       xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {

            obj.innerHTML = xmlhttp.response;
            next_image();
            } 
        }
        
  var formData = new FormData();
  formData.append('image_id', <?php  echo $image_id; ?>);
  
   xmlhttp.open('POST', 'scripts/delete_image_in_primary_album.php', true);
   xmlhttp.send(formData);

}

function add_image_to_primary_album_in_modal(obj,image_id){
   
       var xmlhttp = new XMLHttpRequest();
       
       xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {

            obj.innerHTML = xmlhttp.response;
            obj.onclick = null;
            
            } 
        }
        
  var formData = new FormData();
  formData.append('image_id', image_id);

   xmlhttp.open('POST', 'scripts/add_image_in_primary_album_in_modal.php', true);
   xmlhttp.send(formData);

}

/*********************************************************************************************************/

function set_ahuenno_under_image(image_id){
    
    var ahuenno_count_span = document.getElementById("ahuenno_count_span_" + image_id);
    
    var xmlhttp = new XMLHttpRequest();
    
    xmlhttp.onreadystatechange = function() {

if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        ahuenno_count_span.innerHTML = xmlhttp.response;
    } 
}

var formData = new FormData();
formData.append('image_id', image_id);

xmlhttp.open('POST', 'scripts/set_like_primary_image.php', true);
xmlhttp.send(formData);
    
}

function set_gavno_under_image(image_id){
    
    var gavno_count_span = document.getElementById("gavno_count_span_" + image_id);
    
    var xmlhttp = new XMLHttpRequest();
    
    xmlhttp.onreadystatechange = function() {

if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        gavno_count_span.innerHTML = xmlhttp.response;
    } 
}

var formData = new FormData();
formData.append('image_id', image_id);

xmlhttp.open('POST', 'scripts/set_dislike_primary_image.php', true);
xmlhttp.send(formData);
    
}


/****************************************************************************************/

function send_comment(){
    var comment_textarea = document.getElementById("comment_textarea");
    
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
formData.append('image_id', <?php echo $image_id; ?>);

xmlhttp.open('POST', 'scripts/primary_album_comments.php', true);
xmlhttp.send(formData);
    
}

function send_comment_enter(event){
    var char = event.which || event.keyCode;  
if(char == 13){
send_comment();   
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

xmlhttp.open('POST', 'scripts/delete_comment_primary_album.php', true);
xmlhttp.send(formData);
    
}

</script>
   
    </main>    

</body>    

</html>    

<?php ob_end_flush(); ?>