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

if(session_isset()){

$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();  

}

   $sql = "SELECT *  FROM `common_images_likes`";	
   $query = $connection_handler->prepare($sql);
   $query->execute();
   $likes = $query->fetchAll(PDO::FETCH_ASSOC);

?>

 <?php 

    $add_image_a = "<a href = index.php target = _blank>Авторизуйтесь, чтобы добавить картинку</a>";
    
    if(session_isset()){
        $add_image_a = '<button type="button" class="btn btn-primary" role="button" data-toggle="modal" data-target="#add_image_modal">Добавить картинку</button>';
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


<?php 

$cover_img = "imgs/vesely_pahom.png";
$image_id_for_facebook = "";

$image_id = $_GET['image_id'];

if(!empty($image_id)){

$image_id_for_facebook = "?image_id=" . $image_id;

    $sql = "SELECT * FROM `common_images` WHERE `this_id`=" . $image_id;
    $query = $connection_handler->prepare($sql);
    $query->execute();
    $image_for_facebook = $query->fetchAll(PDO::FETCH_ASSOC);
    
    $cover_img = $image_for_facebook[0]['link'];
    
}

?>

<html>

<head>
<title>Общие картинки</title>
<meta charset = "utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name = "description" content = "Общий альбом" />
    <meta name="keywords" content = "картинки,зеленый слоник, бердянск,больничка, сергей пахомов, владимир епифанцев,александр маслаев,александр осмоловский,сладкий хлеб,азов,украина,альбом" / >
    <meta name = "author" content = "Frendors">

<meta property="og:title" content="Общие картинки"/>
<meta property="og:description" content="Хорошие картинки просто"/>
<meta property="og:image" content="<?php echo $cover_img; ?>">
<meta property="og:type" content="article"/>
<meta property="og:url" content= "//frendors.com/common_images.php<?php echo $image_id_for_facebook; ?>" />

<link rel = "stylesheet" href = "css/normalize.css"  type = "text/css" />
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel = "stylesheet" src = "css/roboto/roboto.css">
<script src="bootstrap/js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.8&appId=105917036567372";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

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
    float:right;
    margin-left:-15px;
    padding-bottom: 90px;
    min-height:900px;
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

.rating_img{
    
    width:100px;
    height:100px;
    border-radius:5px;
    
}

#rating_images_container{
    margin:10px 0;
}

.rating_image_container{
    display:inline-block;
    margin-left:7px;
}

.rating_image_container:hover{
    transform:scale(1.05);
}

.rating_image_container:active{
    transform:scale(1.0);
}

.likes_count_span{
    position:relative;
    display:block;
    margin-top:3px;
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

$sql = "SELECT *  FROM `common_images`";	
$query = $connection_handler->prepare($sql);
$query->execute();
$images_count = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<a href = "user.php?zs=<?php echo $_SESSION['user']; ?>"> << Назад</a>

<style>

#vk_auth{
    
    margin-top:5px;
    margin-bottom:5px;
    
}

#vk_like_top{
    
}

#fb_like_top{
    margin-top:5px;
}

</style>

<div id="vk_like_top"></div>
<script type="text/javascript">
    VK.Widgets.Like("vk_like_top", {type: "button"});
</script>
<div class=fb-like id = fb_like_top data-href=https://frendors.com/common_images.php data-layout=button_count data-action=like data-size=small data-show-faces=true data-share=true></div>

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

<h1 style = "color:blue;text-align:center;text-decoration:underline;position:relative;top:0px;">Общие картинки <?php echo count($images_count); ?></h1>
<p style = "color:green">Сюда можно картинки какие-нибудь выкладывать</p>
<?php echo $add_image_a; ?>
<div style = "border:1px dashed white;margin-top:10px;"></div>
<h3>TOP10 | Ахуенно блять ахуенно</h3>
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
          <p>ВНИМАНИЕ! Разрешается добавлять не более 3-х картинок<br />
          Удалить картинку может только <a href = "user.php?zs=Adminto" target = "_blank">Adminto</a><br />
          И нехуй по сто раз на кнопку нажимать: ждите пока окошко выскочит</p>
        Ссылка <input type = "text" maxlength = "300" style = "width:100%" id = "img_link_input" required = "required" onkeypress = "add_image_enter(event)" /><br />
        <span id = "errors" style = "color:red;display:none"></span><br />
     <button type="button" class="btn btn-success" style = "position:relative;top:10px;" onclick = "add_image()" >Добавить</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Нахуй</button>
      </div>
    </div>

  </div>
</div>  

<?php 

echo "<div id = rating_images_container>";

      $sql = "SELECT * FROM `common_images_likes`";	
      $query = $connection_handler->prepare($sql);
      $query->execute();
      $likes = $query->fetchAll(PDO::FETCH_ASSOC);

      $likes = array_values($likes);

if(count($likes) == 0){
    echo "<span style = 'color:blue;font-size:20px;'>Добавьте картинку и пролайкайте, чтобы.. блять я заебался этот код уже писать весь день! короче поняли нахуй</span>";
}

$rating = array();

for($i = 0; $i < count($likes); $i++){

    array_push($rating, $likes[$i]['image_id']);
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

/***************************************************************************/

$i = 0;

foreach($rating as $key => $value){

$i++;

if($i == 11){
    break;
}

$sql = "SELECT *  FROM `common_images` WHERE `this_id`={$key}";	
$query = $connection_handler->prepare($sql);
$query->execute();
$link = $query->fetchAll(PDO::FETCH_ASSOC);

echo '<section class = rating_image_container>
             <div><a href = common_images.php?image_id=' . $key . '><img src =' . $link[0]['link'] . ' class = rating_img /></a></div>
             <span class = "badge likes_count_span" >' . $value . '</span>
      </section>';    

} 

echo "</div>";
?>
 
<div style = "border:1px dashed white;margin-top:10px;"></div> 
 
<style> 
 
 #images_container{
     margin:0 auto;
     display:inline-block;
     text-align:center;
 }
 
 #images_wrapper{
     
 }
 
 .album_img{
   width:175px;
   height:175px;
   margin:5px;
   cursor:pointer;
   transition: 0.3s
     
}

 .album_img:hover{
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)
 }

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
    margin-left:10px;
}

.ahuenno_image_span:hover{
   background-color:#4CAF50;
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
          border-radius:5px;
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
    border:1px solid black;
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
    padding-top: 10px; /* Location of the box */
    left: 0;
    top: 0;
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

#img_in_modal{
    
    border:1px solid black;
    width:99%;
    
}


@media screen and (min-width:426px){
   #modal_img_body{
       height:300px;
} 

 #img_in_modal{
  height:270px;
}

}

@media screen and (min-width:769px){
   #modal_img_body{
       height:370px;
} 

     #img_in_modal{
  height:340px;
}
    
}

@media screen and (min-width:1025px){
   #modal_img_body{
       height:350px;
} 

     #img_in_modal{
  height:330px;
}
    
}

#modal_img_footer {
    padding: 2px 16px;
   border-top:1px solid black;
}
      
  </style>
   
  
<div id = "images_container">

<?php 

      $sql = "SELECT *  FROM `common_images` ORDER BY `this_id` DESC";	
        $query = $connection_handler->prepare($sql);
        $query->execute();
        $images = $query->fetchAll(PDO::FETCH_ASSOC);

for($i = 0; $i < count($images); $i++){

  echo  '<img src=' . $images[$i]['link'] . ' onclick = window.location.replace("common_images.php?image_id=' . $images[$i]['this_id'] . '") class="album_img">';

} 

    $image_id = (int) $_GET['image_id'];

    if(!empty($image_id)){
        
        $sql = "SELECT *  FROM `common_images` WHERE `this_id`={$image_id}";	
        $query = $connection_handler->prepare($sql);
        $query->execute();
        $image = $query->fetchAll(PDO::FETCH_ASSOC);
        
        if(!empty($image)){ // Такое изображение есть
        
        $delete_image_function = ""; // Функция удаления
          
            if($_SESSION['user'] === 'Adminto'){ // Картинку удалять может только админ
               $delete_image_function = "<a onclick = 'delete_image(this);return false;'>удалить</a> |"; 
            }
       
       $add_image_to_primary_album_in_modal_function = ""; // Функция добавления изображения в первичный альбом
       $ahuenno_image_function = "";
       $tell_to_bros_function = "";
        
        if(!empty($_SESSION['user'])){
        
            $add_image_to_primary_album_in_modal_function = " | <a onclick = add_image_to_primary_album_in_modal(this," . $image_id . ")>в первичный</a>";
            $ahuenno_image_function = " onclick = set_ahuenno_under_image(". $image_id . ") "; 
            $tell_to_bros_function =  " | <a onclick = tell_to_bros(this," . $image_id . ")>на малафильню</a>";
          
        }
          
     $send_comment_form = "";
     
     if(!empty($_SESSION['user'])){
         
         $send_comment_form = "<div id = send_comment_form>
                                            <textarea cols=42 rows=1 onkeypress = send_comment_enter(event) id = 'comment_textarea' maxlength = '1000' oninput = 'this.rows=3'></textarea>
                                            <button type = 'button' class='btn btn-success btn-md' id = 'send_comment_button' onclick = send_comment()>Малафить</button>
                                </div>";
         
     }
            
     // ЛАЙКИ
     $sql = "SELECT COUNT(*) AS `ahuenno_count` FROM `common_images_likes` WHERE `image_id`={$image_id}";	
     $query = $connection_handler->prepare($sql);
     $query->execute();
     $ahuenno_count = $query->fetchAll(PDO::FETCH_ASSOC);
     $ahuenno_count = $ahuenno_count[0]['ahuenno_count'];

    // КОММЕНТЫ
    $sql = "SELECT *  FROM `common_images_comments` WHERE `image_id`={$image_id} ORDER BY `this_id` DESC";	
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
    
    
         echo '<!-- Modal content -->
<div id = "modal_img" class = "container">
    <span class="close" style = "color:black;" onclick = window.location.replace("common_images.php")>&times;</span>
<div id="modal_img_header_body_footer">

 <div id="modal_img_body">
       
    <img class="img-responsive" id = "img_in_modal" src = "' . $image[0]['link'] . '" onclick = "next_image(false)" />
    
     <section id = "raws_container">
      <a class="prev" onclick="prev_image(false)">&#10094;</a>
      <a class="next" onclick="next_image(false)">&#10095;</a>
</section>
    
  </div>

  <div id="modal_img_footer">' . 
    '<div id = "user_functions_container" style = "float:left;">' . $delete_image_function . ' <a href="' . $image[0]['link'] . '" target = _blank>оригинал</a>' .  $add_image_to_primary_album_in_modal_function . $tell_to_bros_function . '</div>' .
     '<div class = "ahuenno_gavno_under_image_container container-fluid">
     <span class = ahuenno_image_span ' . $ahuenno_image_function . '><img src = imgs/like.png class = img_ahuenno />Ахуенно | <span class = ahuenno_count_span id = ahuenno_count_span_' . $image_id  . ' >' . $ahuenno_count . '</span></span> 
        </div> 

                <section id = "comments_textarea_container" class="container-fluid">
          <div class = "raw">
           
               <div id = "textarea_container" class = "col-md-3">' .
            $send_comment_form    .
              '</div>
              
                 <div id = "comments_container" class = "col-md-9">' .
              $comments_outp .
              '</div> 
              
          </div>
          </section>

  </div>

</div>
</div>';
        
            
        }else{
            header('Location: user.php?zs=' . $login);
            exit();
            
        }

    // Айди следующего изображения
    $sql = "SELECT * FROM `common_images` WHERE `this_id`<{$image_id} ORDER BY `this_id` DESC";	
    $query = $connection_handler->prepare($sql);
    $query->execute();
    $next_image = $query->fetchAll(PDO::FETCH_ASSOC);
    
      if(!empty($next_image)){ // Следующее изображение есть
        
        $next_image = $next_image[0]['this_id'];
        
    }else{
        
        $next_image = $image_id;
        
    }
  
      // Айди следующего изображения
    $sql = "SELECT * FROM `common_images` WHERE `this_id`>{$image_id} ORDER BY `this_id` DESC";	
    $query = $connection_handler->prepare($sql);
    $query->execute();
    $prev_image = $query->fetchAll(PDO::FETCH_ASSOC);
    
      if(!empty($prev_image)){ // Следующее изображение есть
        
        $prev_image = $prev_image[0]['this_id'];
        
    }else{
        
        $prev_image = $image_id;
        
    }
        
}

?>

</div>       

<script>

function next_image(after_deleting) {
    
    function parse_response(response){
    var json_obj = JSON.parse(response);

if(json_obj.image_id === "empty"){
    window.location.replace("common_images.php");
}else {
window.location.replace("common_images.php?image_id=" + json_obj.image_id);
}

}
 /*************************************************************************************************************/   
     var img_in_modal = document.getElementById('img_in_modal');

     var xmlhttp = new XMLHttpRequest();
       
       xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      
        parse_response(xmlhttp.response);    
            
            } 
        }
        
  var formData = new FormData();
  formData.append('image_id', <?php echo $image_id; ?>);
  formData.append('next_image_id', <?php echo $next_image; ?>);
  formData.append('after_deleting', after_deleting);

   xmlhttp.open('POST', 'scripts/change_image_in_modal_in_common_album.php', true);
   xmlhttp.send(formData);
 
} 

function prev_image(after_deleting) {
    
    function parse_response(response){
    var json_obj = JSON.parse(response);

if(json_obj.image_id === "empty"){
    window.location.replace("common_images.php");
}else {
window.location.replace("common_images.php?image_id=" + json_obj.image_id);
}

}
 /*************************************************************************************************************/   
     var img_in_modal = document.getElementById('img_in_modal');

     var xmlhttp = new XMLHttpRequest();
       
       xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      
        parse_response(xmlhttp.response);    
            
            } 
        }
        
  var formData = new FormData();
  formData.append('image_id', <?php echo $image_id; ?>);
  formData.append('prev_image_id', <?php echo $prev_image; ?>);
  formData.append('after_deleting', after_deleting);

   xmlhttp.open('POST', 'scripts/change_image_in_modal_in_common_album.php', true);
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
       errors.style.innerHTML = "Данный тип ссылок не поддерживается"; 
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

   xmlhttp.open('POST', 'scripts/add_image_in_common_album.php', true);
   xmlhttp.send(formData);
   
    }
    
}

function add_image_enter(event){
    var char = event.which || event.keyCode;  
if(char == 13){
add_image();   
}
}

function delete_image(obj){

var xmlhttp = new XMLHttpRequest();
       
       xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {

            obj.innerHTML = xmlhttp.response;
            next_image(true);
            } 
        }
        
  var formData = new FormData();
  formData.append('image_id', <?php echo $image_id; ?>);
  
   xmlhttp.open('POST', 'scripts/delete_image_in_common_album.php', true);
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

   xmlhttp.open('POST', 'scripts/add_common_image_in_primary_album_in_modal.php', true);
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

xmlhttp.open('POST', 'scripts/set_like_common_image.php', true);
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

xmlhttp.open('POST', 'scripts/common_album_comments.php', true);
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

xmlhttp.open('POST', 'scripts/delete_comment_common_album.php', true);
xmlhttp.send(formData);
    
}

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
formData.append('image_id', id);

xmlhttp.open('POST', 'scripts/tell_to_bros_common_image.php', true);
xmlhttp.send(formData);

}

</script>
   
    </main>    

</body>    

</html>    

<?php ob_end_flush(); ?>