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
        $user_images_in_primary_album = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $cover_img = "";
        
        if(empty($user_images_in_primary_album)){
            $cover_img = "imgs/empty_album.png";    
        }else{
            $cover_img = $user_images_in_primary_album[0]['link'];   
        }
        
?>  

<html>

<head>
<title>Альбомы пользователя</title>
<meta charset = "utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name = "description" content = "Альбомы | <?php echo $login;  ?>" />
    <meta name="keywords" content = "<?php echo $login; ?>,зеленый слоник, бердянск,больничка, сергей пахомов, владимир епифанцев,александр маслаев,александр осмоловский,сладкий хлеб,азов,украина,альбом" / >
    <meta name = "author" content = "<?php echo $login; ?>">

<meta property="og:title" content="Альбомы | <?php echo $login;  ?>"/>
<meta property="og:description" content="Хорошие альбомы просто"/>
<meta property="og:image" content="<?php echo $cover_img; ?>">
<meta property="og:type" content="article"/>
<meta property="og:url" content= "//frendors.com/user_albums.php?zs=<?php echo $login; ?>" />

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
    margin:0 auto;
    max-width:1400px;
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

</style>

</head>    

<body style = "background-color:#cefdce;">

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

<style>

.ava_in_user_ava_container{
  
}

#avatars_container{
  
}

#avatars_wrapper{
  text-align:center;
}

.ava_in_user_ava_container{
 width:200px;
 height:200px;  
 cursor:pointer;
 margin:5px;
}

.ava_in_user_ava_container.hover-shadow {
  transition: 0.3s
}

.hover-shadow:hover {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)
}

#avatars_modal{

  display: none;
  position: fixed;
  z-index: 2;
  padding-top: 100px;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: black;
}

/* Add Animation - Zoom in the Modal */
#avatars_modal { 
    -webkit-animation-name: zoom;
    -webkit-animation-duration: 0.6s;
    animation-name: zoom;
    animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
    from {-webkit-transform:scale(0)} 
    to {-webkit-transform:scale(1)}
}

@keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
}

/* The Close Button */
.close {
  color: white;
  position: absolute;
  top: 10px;
  right: 25px;
  font-size: 35px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #999;
  text-decoration: none;
  cursor: pointer;
}

/* Modal Content */
#avatars_modal_content {
  position: relative;
  background-color: black;
  margin: auto;
  padding: 0;
  width: 90%;
  max-width: 1200px;
}

.avatar_demo_container{
display:inline-block; 
margin:5px;
cursor:pointer;
}

.avatar_demo{
        width:200px;
        height:200px;
        opacity:0.6;
}

.active,
.avatar_demo:hover {
  opacity: 1;
}

/* Next & previous buttons */
.prev,
.next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  padding: 16px;
  margin-top: -50px;
  color: white;
  font-weight: bold;
  font-size: 20px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
  user-select: none;
  -webkit-user-select: none;
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

.avatar_slides {
  background-color:black;
  display: none;
  margin-bottom:10px;
  cursor:pointer;
}

.big_avatar_in_avatars_modal{
    width:100px;
    height:100px;
    margin:0 auto;
}

#fb_like_top{
 margin-top:5px;   
}

</style>

    <main>
<?php 

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

?>

<a href = "user.php?zs=<?php echo $login; ?>" style = "color:blue;"><<< <?php echo $login; ?></a>
<div id="vk_like"></div>
<script type="text/javascript">
    VK.Widgets.Like("vk_like", {type: "button"});
</script>
<div class=fb-like id = fb_like_top data-href=https://frendors.com/user_albums.php?zs=<?php echo $login; ?> data-layout=button_count data-action=like data-size=small data-show-faces=true data-share=true></div>
<header style = "height:20px;color:blue;">Авы</header>
 
<div id = "avatars_wrapper">

<?php 

    /* УЗНАЕМ АЙДИ ПОЛЬЗОВАТЕЛЯ*/
        $sql = "SELECT * FROM `additional_info` WHERE `nickname`='{$login}'";
        $query = $connection_handler->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $user_id = $result[0]['user_id'];
  
      $user_dir = "users/zs" . $user_id . "/"; // Папка пользователя
      $files_array = scandir($user_dir); // Файлы в виде массива
      $files_count = count($files_array); // Количество файлов в папке   
       
      $avatars_output = ""; // Для вывода всех ав
      $i = 2; 
       
       if($files_count == 2){ // Файлов нет
            $avatars_output = '<img class = "ava_in_user_ava_container hover-shadow" onclick= "openModal(); currentSlide(1)" src = "users/default_ava.jpg" />';               
           $i = $files_count;
           
       }

     $current_slide = 1;

      for(;$i < $files_count; $i++){
          
          $avatars_output .= "<img class = 'ava_in_user_ava_container hover-shadow' onclick= 'openModal(); currentSlide({$current_slide})' src = " . $user_dir .  $files_array[$i] . " />";
          
         ++$current_slide;
         
      }
  
      echo $avatars_output;

    ?>

</div>      
  
<div id = "avatars_modal">
 <span class="close cursor" onclick="closeModal()">&times;</span>
    
    <div id = "avatars_modal_content">
        
        <?php 
        
        $avatars_output_above_demo_avatars_in_modal = "";
        $avatars_output_under_big_avatar_in_modal = "";
        $prev_next_rows = "<a class=prev onclick=plusSlides(-1)>&#10094;</a>
        <a class=next onclick=plusSlides(1)>&#10095;</a>";
        $i = 2; 
       
       if($files_count == 2){ // Файлов нет
           
           $prev_next_rows = "";
           
           $avatars_output_above_demo_avatars_in_modal = '<div class="avatar_slides">
                     <img сlass = big_avatar_in_avatars_modal src=users/default_ava.jpg style = "width:600px;height:600px;position:relative;left:300px;" />
                </div>';

           $i = $files_count;
           
       }

        $current_slide = 1;

      for(;$i < $files_count; $i++){ // Авы наверху и внизу
          
           $avatars_output_above_demo_avatars_in_modal .= '<div class="avatar_slides">
                     <img src=' . $user_dir .  $files_array[$i] . ' style = "width:600px;height:600px;position:relative;left:300px;" onclick = plusSlides(1) />
                </div>';
           
          $avatars_output_under_big_avatar_in_modal .= "<div class = 'avatar_demo_container'>
                                  <img class = 'avatar_demo' onclick= 'currentSlide({$current_slide})' src = " . $user_dir .  $files_array[$i] . " />
                            </div>";
          ++$current_slide;
          
      }
      
      if($files_count == 3){
          $avatars_output_under_big_avatar_in_modal = "";
           $prev_next_rows = "";
      }
      
      echo $prev_next_rows;
      echo $avatars_output_above_demo_avatars_in_modal;
      echo $avatars_output_under_big_avatar_in_modal;
        
    ?>
        
    </div>

</div>  
 
<div style = 'heighth:1px; border:1px dashed white'></div> 
 
<script>
function openModal() {
  document.getElementById('avatars_modal').style.display = "block";
}

function closeModal() {
  document.getElementById('avatars_modal').style.display = "none";
}

var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("avatar_slides");
  var dots = document.getElementsByClassName("avatar_demo");
  
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
}

</script> 
 
<style>
.album {
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    transition: 0.3s;
    width:210px;
    height:275px;
    margin-bottom:10px;
    border-radius: 5px;
    display:inline-block;
    cursor:pointer;
}

.album:hover {
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}

img {
    border-radius: 5px 5px 0 0;
}

.container {
    padding: 2px 16px;
}

.cover_img{
   width:210px;
   height:210px; 
}

a {
    color:blue;
}

#сreate_album_modal{
    position:relative;
    top:200px;
}

input[type=text],textarea{
          padding:5px;
          border-radius:5px;
}

input[type=text]:focus,textarea:focus{
     background-color: #98DDDE;
     box-shadow: 0px 0px 1px #7FFFD4;
} 

textarea{
    resize:none;
}
</style>
 
 <?php 
 
  $create_album_a = "";
    
    if($_SESSION['user'] === $login){
        $create_album_a = ' | <a role="button" data-toggle="modal" data-target="#create_album_modal">Создать новый</a>';
    }

 ?>
 
<header style = "height:20px;color:blue;">Альбомы <?php echo $create_album_a; ?></header> 

 <!-- Modal -->
<div id="create_album_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Создаем альбом</h4>
      </div>
      <div class="modal-body">
       
       Название <br /><input type = "text" maxlength = "80" size = "65" id = "album_name_input" required = "required" /><br /><br />
       Описание <br /><textarea maxlength = "200" rows = 5 cols = 67 id = "album_description_textarea" required = "required"></textarea>
        <button type="button" class="btn btn-success" style = "position:relative;top:10px;" onclick = "create_album()" >Создать</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Нахуй</button>
      </div>
    </div>

  </div>
</div>  
 
 <script>
 
 function create_album(){
     var album_name_input = document.getElementById('album_name_input');
     var album_description_textarea = document.getElementById('album_description_textarea');
     
     if(album_name_input.value == ""){
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
  formData.append('name', album_name_input.value.trim());
  
  if(album_description_textarea.value != ""){
      formData.append('description', album_description_textarea.value.trim());
  }
  
   xmlhttp.open('POST', 'scripts/create_user_album.php', true);
   xmlhttp.send(formData);

 }
 
 </script>
  
  <?php 
  
  $whose_album = "";
  
  if($login === $_SESSION['user']){
     $whose_album = 'Ваши альбомы'; 
  }else{
      $whose_album = "Альбомы пользователя " . $login;
  }
  
  ?>
  
  <h3 style="color:blue;text-decoration:underline;text-decoration:underline;text-align:center;"><?php echo $whose_album; ?></h3>
  
 <div id = "albums_container">
 
    <div class="album" id = "primary_album" style = "margin-bottom:10px;" onclick = "window.location.replace('primary_album.php?zs=<?php echo $login; ?>')">
      <div>
      <img src="<?php echo $cover_img; ?>" class = "cover_img" alt="первичный альбом">
      <div class="container">
        <h4><b>Первичный</b></h4>
        <p>Да всякое вобщем</p>
      </div>
    </div>

    </div>

        <div id = "created_albums">
        
        <?php 
        
            $sql = "SELECT * FROM `user_albums` WHERE `user`='{$login}'";
            $query = $connection_handler->prepare($sql);
            $query->execute();
            $user_albums = $query->fetchAll(PDO::FETCH_ASSOC);
     
         for($i = 0; $i < count($user_albums); $i++){
             
            $sql = "SELECT * FROM `images_in_user_album` WHERE `album_id`='{$user_albums[$i]['this_id']}'";
            $query = $connection_handler->prepare($sql);
            $query->execute();
            $images_in_user_album = $query->fetchAll(PDO::FETCH_ASSOC);
             
             $cover_img = "";
             
             if(empty($images_in_user_album)){
                $cover_img = "imgs/empty_album.png";  
             } else{
                $cover_img = $images_in_user_album[0]['link'];  
             }
             
            echo '<div class="album" id = "primary_album" style = "margin-bottom:10px;">
                      <div>
                      <img src=' . $cover_img . ' class = "cover_img" alt=' . $user_albums[$i]['name'] . ' onclick = window.location.replace("user_album.php?album_id=' . $user_albums[$i]['this_id'] . '&zs=' . $login . '")>
                      <div class="container" style = "word-wrap:break-word;">
                        <h4><b>' . $user_albums[$i]['name'] . '</b></h4>
                        <p>' . $user_albums[$i]['description'] . '</p>
                      </div>
                    </div>

                </div>';
        
         }
     
        ?>
        
        </div>    

</div>

    </main>    

</body>    

</html>    

<?php ob_end_flush(); ?>