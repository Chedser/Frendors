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
    
    $album_id = (int) $_GET['album_id'];
    $login = $_GET['zs'];

    if(empty($album_id)){
        header('Location:index.php');
        exit();
    }
    
    $sql = "SELECT *  FROM `user_albums` WHERE `this_id`={$album_id}";	
    $query = $connection_handler->prepare($sql);
    $query->execute();
    $album_info = $query->fetchAll(PDO::FETCH_ASSOC);
    
    if(empty($album_info)){
        header('Location:index.php');
        exit();
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
    
    if($_SESSION['user'] === $login){
        $add_image_a = ' | <a role="button" data-toggle="modal" data-target="#add_image_modal">Добавить картинку</a>';
    }

    $delete_album_a = "";
    
    if(!empty($_SESSION['user']) && $login === $_SESSION['user']){
        
        $delete_album_a = ' | <a onclick = "delete_album();return false;" style = "cursor:pointer;">Удалить альбом</a>';    
        
    }
   
$sql = "SELECT *  FROM `images_in_user_album` WHERE `album_id`={$album_id}";	
$query = $connection_handler->prepare($sql);
$query->execute();
$images = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<html>

<head>
<title><?php echo $album_info[0]['name']; ?></title>
<meta charset = "utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name = "description" content = "<?php echo $login . "|" . $album_info[0]['name'];  ?>" />
    <meta name="keywords" content = "<?php echo $login; ?>,зеленый слоник, бердянск,больничка, сергей пахомов, владимир епифанцев,александр маслаев,александр осмоловский,сладкий хлеб,азов,украина,альбом" / >
    <meta name = "author" content = "<?php echo $login; ?>">

<meta property="og:title" content="<?php echo $album_info[0]['name']; ?> | <?php echo $login;  ?>"/>
<meta property="og:description" content="Хорошие картинки просто"/>
<meta property="og:image" content="<?php echo $images[0]['link']; ?>">
<meta property="og:type" content="article"/>
<meta property="og:url" content= "//frendors.com/user_album.php?id=<?php echo $album_id; ?>&zs=<?php echo $login; ?>" />

<link rel = "stylesheet" href = "css/normalize.css"  type = "text/css" />
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel = "stylesheet" src = "css/roboto/roboto.css">
<script src="bootstrap/js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

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
    width: 1100px;
    background-color:#79C753;
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
        '<header style = "color:white;height:60px;">
<nav style = "margin-top:-5px;"> 
    <img src = "user_page_logo.png" height = "40" style = "position:relative;top:-10px;"/>
    <ul style = "display:inline-block; list-style:none; position:relative;top:10px; color:white; width:600px;margin-right:40px;">
        <li  data-placement="bottom" data-toggle="tooltip" title = "Ваша страница" role = "button"><a href = "user.php?zs=' . $_SESSION['user'] . '"><img class = "header_items_img" src = "imgs/header/bumazhka.png"><br /><span>Бумажка</span></a></li>
        <li  data-placement="bottom" data-toggle="tooltip" title = "Ваши друзья" role = "button"><a href = "bros.php?zs=' .$_SESSION['user'] . '"><img class = "header_items_img" src = "imgs/header/bratki.png"><br /><span>Братки ' . $new_friend . '</span></a></li>
        <li  data-placement="bottom" data-toggle="tooltip" title = "Сообщения" role = "button"><a href = "dialogs.php"><img class = "header_items_img" src = "imgs/header/vdvoem_tuta.png"><br /><span>Вдвоем тута ' . $new_dialogs . '</span></a></li>
        <li  data-placement="bottom" data-toggle="tooltip" title = "Чат" role = "button"><a href = "chat.php"><img class = "header_items_img" style = "width:45px;" src = "imgs/header/mnogo_tuta.png"><br /><span>Много тута </span></a></li>
        <li  data-placement="bottom" data-toggle="tooltip" title = "Решил немножко поравзвлечь" role = "button"><a href = "fun_select.php"><img class = "header_items_img" src = "imgs/header/igry.png"><br /><span>Шашки</span></a></li>
        <li  data-placement="bottom" data-toggle="tooltip" title = "Все ж мы люди" role = "button"><a href = "malafil.php"><img class = "header_items_img" src = "imgs/header/malafit.png"><br /><span>Малафить</span></a></li>
      </ul>    
<section style = "display:inline-block; position:relative;top:10px; left:290px; text-align:center;" data-placement="right" data-placement="bottom" data-toggle="tooltip" title = "Да ладно, ну чо ты как этот прям" role = "button">
     <a href = "exit.php"><img class = "header_items_img" src = "imgs/header/po_trube.png"><br /><span>По трубе</span></a>
</section>
</nav>    

</header>';

}

?>

    <main>

<a href = "user_albums.php?zs=<?php echo $login; ?>"> <<< Альбомы</a> <?php echo $add_image_a . $delete_album_a; ?>

<h1 style = "color:aqua;text-align:center;position:relative;top:20px;"><?php echo $album_info[0]['name']; ?></h1>
<p style = "color:green"><?php echo $album_info[0]['description']; ?></p>

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
        Ссылка <input type = "text" maxlength = "300" size = "65" id = "img_link_input" required = "required" /><br />
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
 
 .album_img,#img_in_modal{
   margin:5px;
   cursor:pointer;
   transition: 0.3s
     
}

 .album_img:hover{
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)
 }
 
 #modal_for_image{
     
    position:fixed;
    z-index:2;
    top:100px;

 }
 
 #img_in_modal{
    
     margin:0 auto;
     display:block;
     cursor:pointer;

 }

#img_in_modal_container{

    width:550px;
    height:520px;
    padding:10px;
    border-bottom:1px solid black;    
    
}

/**********************************************/

/* Next & previous buttons */
.prev,
.next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  padding: 16px;
  margin-top: -50px;
  color: green;
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

</style> 
  
<div id = "images_container">

<?php 

for($i = 0; $i < count($images); $i++){

  echo  '<img src=' . $images[$i]['link'] . ' onclick = window.location.replace("user_album.php?album_id=' .$album_id . '&image_id=' . $images[$i]['this_id'] . '&zs=' . $login . '") class="album_img">';

} 

    $image_id = (int) $_GET['image_id'];
    
    if(!empty($image_id)){
        
        $sql = "SELECT *  FROM `images_in_user_album` WHERE `this_id`={$image_id}";	
        $query = $connection_handler->prepare($sql);
        $query->execute();
        $image = $query->fetchAll(PDO::FETCH_ASSOC);
        
        if(!empty($image)){ // Такое изображение есть
        
        $delete_image_function = "";
          
            if($_SESSION['user'] === $login){
               $delete_image_function = "<a onclick = 'delete_image(this," . $image_id . ");return false;'>Удалить</a> | "; 
            }
       
           $add_image_to_primary_album_in_modal_function = ""; // Функция добавления изображения в первичный альбом
        
        if(!empty($_SESSION['user'])){
            
            if($_SESSION['user'] !== $login){
                
                $add_image_to_primary_album_in_modal_function = " | <a onclick = add_image_to_primary_album_in_modal(this," . $image_id . ",true)>Добавить в первичный</a>";
                
            }
            
        }
        
        $redirect = $_GET['redirect'];
        $redirect_page = 'user_album.php?album_id=' . $album_id . '&zs=' . $login;
        if(!empty($redirect)){
            $redirect_page = 'user.php?zs=' . $login;
        }
        
        echo '<div style = "position:fixed; top:-100px; left: 0px;z-index:1; background-color:red;opacity:0.5; width:100%;height:125%"></div>';
            
            echo '<div id="modal_for_image">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick = window.location.replace("' . $redirect_page . '")>&times;</button>
            </div>
      <div class="modal-body">
          <section id = "img_in_modal_container">
          <img src= ' . $image[0]['link'] . ' id = "img_in_modal" onclick = "next_image(false)" /><a class="next" onclick="next_image(false)">&#10095;</a>  
          </section>' . 
       $delete_image_function . " <a href=" . $image[0]['link'] . " target = _blank>Оригинал</a>" . $add_image_to_primary_album_in_modal_function .
       '</div>
      <div class="modal-footer">

      </div>
    </div>

  </div>
</div>';
            
        }else{
            header('Location: user.php?zs=' . $login);
            exit();
            
        }

    // Айди следующего изображения
    $sql = "SELECT * FROM `user_images_primary_album` WHERE `user`='{$login}' AND `this_id`>{$image_id}";	
    $query = $connection_handler->prepare($sql);
    $query->execute();
    $next_image = $query->fetchAll(PDO::FETCH_ASSOC);
    
      if(!empty($next_image)){ // Следующее изображение есть
        
        $next_image = $next_image[0]['this_id'];
        
    }else{
        
        $next_image = $image_id;
        
    }
        
    }

?>

</div>       

<script>

function next_image(after_deleting) {
    
    function parse_response(response){
    var json_obj = JSON.parse(response);

if(json_obj.image_id === "empty"){
    window.location.replace("user_album.php?album_id=<?php echo $album_id; ?>&zs=<?php echo $login; ?>");
}else {
window.location.replace("user_album.php?album_id=<?php echo $album_id; ?>&image_id=" + json_obj.image_id + '&zs=<?php echo $login; ?>');
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
  formData.append('login', "<?php echo $login; ?>");
  formData.append('after_deleting', after_deleting);


   xmlhttp.open('POST', 'scripts/change_image_in_modal_in_user_album.php', true);
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

            alert(xmlhttp.response);
            window.location.reload();
            
            } 
        }
        
  var formData = new FormData();
  formData.append('link', img_link_input.value.trim());
  formData.append('album_id', <?php echo $album_id; ?>);
   
   xmlhttp.open('POST', 'scripts/add_image_in_user_album.php', true);
   xmlhttp.send(formData);
   
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
  formData.append('album_id', <?php echo $album_id; ?>);
  formData.append('image_id', <?php echo $image_id; ?>);
  
   xmlhttp.open('POST', 'scripts/delete_image_in_user_album.php', true);
   xmlhttp.send(formData);

}

function delete_album(){
   
       var xmlhttp = new XMLHttpRequest();
       
       xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {

            alert("Альбом удален");
            window.location.replace("user_albums.php?zs=<?php echo $login; ?>");
            
            } 
        }
        
  var formData = new FormData();
  formData.append('album_id', <?php echo $album_id; ?>);
   
   xmlhttp.open('POST', 'scripts/delete_user_album.php', true);
   xmlhttp.send(formData);
   
}

function add_image_to_primary_album_in_modal(obj,image_id,image_of_user_album){
   
       var xmlhttp = new XMLHttpRequest();
       
       xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {

            obj.innerHTML = xmlhttp.response;
            obj.onclick = null;
            
            } 
        }
        
  var formData = new FormData();
  formData.append('image_id', image_id);
  formData.append('image_of_user_album', image_of_user_album);

   xmlhttp.open('POST', 'scripts/add_image_in_primary_album_in_modal.php', true);
   xmlhttp.send(formData);

}

</script>
   
    </main>    

</body>    

</html>    

<?php ob_end_flush(); ?>