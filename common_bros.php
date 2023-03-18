<?php ob_start();  ?>

<!DOCTYPE html>

<?php
session_start();
error_reporting(0);
header("Content-type: text/html; charset=utf-8");

require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

$login_session = $_SESSION['user'];
$login = $_GET['zs'];

function session_isset(){ // Пользователь вошел
if(!empty($_SESSION['user'])){ // Пользователь вошел через логин-пароль
return true;
} else {
return false;
}
}

 if(empty($login_session)){
header('Location: index.php'); 
exit();   
} 

$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();    

/* Запросы в друзья может видеть только сессионный пользователь и на своей странице. */
if(session_isset() && $login == $login_session){ // авторизовались и сидим на своей странице

/* ИЩЕМ ЗАПРОСЫ В ДРУЗЬЯ */
$sql = "SELECT * FROM `friend_requests` WHERE `requester2`=:requester2";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':requester2', $login_session, PDO::PARAM_STR); // Пользователь к к которому зашли. Принимают заявку
$query->execute();
$requests = $query->fetchAll(PDO::FETCH_ASSOC);

/* ИЩЕМ КОЛИЧЕСТВО ЗАПРОСОВ В ДРУЗЬЯ */
$sql = "SELECT COUNT(*) AS 'requests_count' FROM `friend_requests` WHERE `requester2`=:requester2";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':requester2', $login, PDO::PARAM_STR); // Пользователь к к которому зашли. Принимают заявку
$query->execute();
$requests_count = $query->fetchAll(PDO::FETCH_ASSOC);
$requests_count = $requests_count[0]['requests_count'];
}

/**************************************************************************************************************************************/


?>

<?php 
 if(session_isset()){ 
  /* ИЩЕМ КОЛИЧЕСТВО ЗАПРОСОВ В ДРУЗЬЯ */
$sql = "SELECT COUNT(*) AS 'requests_count' FROM `friend_requests` WHERE `requester2`=:requester2";	
$query = $connection_handler->prepare($sql);
$query->bindParam(':requester2', $login_session, PDO::PARAM_STR); // Пользователь к к которому зашли. Принимают заявку
$query->execute();
$requests_count = $query->fetchAll(PDO::FETCH_ASSOC);
$requests_count = $requests_count[0]['requests_count'];  
   
$new_friend = "";
    if($requests_count != 0){ // Eсли есть запросы в друзья
    $new_friend =  "<span class = 'badge' style='color:blue;'>" . $requests_count . "</span>";  
    }
    
/* ИЩЕМ АЙДИ ПОЛЬЗОВАТЕЛЯ */
$sql = "SELECT user_id from main_info WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $login_session, PDO::PARAM_STR);
$query->execute();
$user_id = $query->fetchAll(PDO::FETCH_ASSOC);
$user_id = $user_id[0]['user_id'];    
       
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

<html>
<head>
<title>Общие братки</title>
<meta charset = "utf-8"/>

    <meta name = "description" content = "Братки" />
    <meta name="keywords" content = "<?php echo $login; ?>,зеленый слоник, бердянск,больничка, сергей пахомов, владимир епифанцев,александр маслаев,александр осмоловский,сладкий хлеб,азов,украина,альбом" / >
    <meta name = "author" content = "<?php echo $login; ?>">

<script src="bootstrap/js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<link rel = "stylesheet" href = "css/normalize.css"  type = "text/css" />

<script async>

function show_private_message_box(user_id){ // Открываем окно для ввода сообщения
var receiver_hidden_field = document.getElementById("receiver_hidden_field");
receiver_hidden_field.value = user_id;

}

function send_private_message(){// Отправляем сообщение пользователю
var private_message_box = document.getElementById("private_message_box");
var private_message_textarea = document.getElementById("private_message_textarea");
var private_message_box_errors = document.getElementById("private_message_box_errors");;
var receiver_hidden_field = document.getElementById("receiver_hidden_field");

if(private_message_textarea.value.length == 0 || receiver_hidden_field.value == "" || receiver_hidden_field.value == null){
return;   
}

var xmlhttp = new XMLHttpRequest();
var formData = new FormData();
formData.append('user_id', receiver_hidden_field.value);
formData.append('message', private_message_textarea.value);

xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
private_message_textarea.value = "";
private_message_box_errors.innerHTML = xmlhttp.response;
setTimeout(window.location.reload(),3000);
} 
}

xmlhttp.open("POST", "scripts/send_private_message.php", true);
xmlhttp.send(formData);

receiver_hidden_field.value = ""; 
}

function  close_private_message_box(){ // Закрываем окно отправки сообщения
var private_message_box = document.getElementById("private_message_box");	
private_message_box.style.display = "none";
transparent_field.style.display = "none";
return false;	
}

</script>

<script async>

function confirm_friend_request(button, user_id, id){ // 
var xmlhttp = new XMLHttpRequest();
var response_result_tr = document.getElementById("response_result_tr_" + id);
var response_buttons_tr = document.getElementById("response_buttons_tr_" + id);
var gavno_button = document.getElementById("gavno_button_" + id);

gavno_button.onclick = null;
gavno_button.style.display = "none";

button.style.display = "none";

xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {

var parsed = JSON.parse(xmlhttp.response);

        if(parsed.status === "true"){
        
        response_result_tr.style.display = "table-row";
        response_result_tr.style.backgroundColor = "yellow";
        response_result_tr.style.textAlign = "center";
        response_buttons_tr.style.display = "none";
        response_result_tr.innerHTML = "Вы братки";
        }else{
           response_result_tr.style.backgroundColor = "yellow";
        response_result_tr.style.textAlign = "center";
           response_result_tr.innerHTML = "Ошибка нахуй!"; 
        }

} 

    
}

var formData = new FormData();
formData.append('user_id', user_id);

xmlhttp.open("POST", "scripts/confirm_friend_request.php", true);
xmlhttp.send(formData);
}

function deny_friend_request(button, user_id,id){ // 
var xmlhttp = new XMLHttpRequest();

var response_result_tr = document.getElementById("response_result_tr_" + id);
var response_buttons_tr = document.getElementById("response_buttons_tr_" + id);
var vbratki_button = document.getElementById("vbratki_button_" + id);
vbratki_button.style.display = "none";
response_buttons_tr.style.display = "none";

xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {

response_result_tr.style.display = "table-row";
response_result_tr.style.backgroundColor = "yellow";
response_result_tr.style.textAlign = "center";
response_result_tr.innerHTML = "Фуфел";

    } 
}

var formData = new FormData();
formData.append('user_id', user_id);

xmlhttp.open("POST", "scripts/deny_friend_request.php", true);
xmlhttp.send(formData);

}

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
    width: 99%;
    background-color:#cefdce;
    margin:0 auto;
    height:100%;
    font-size:20px;
 }

main {
        border-left: 2px double blue;
    border-right: 2px double blue;
    padding-bottom: 90px;
  
}

a {
color:blue;    
}

button {
cursor: pointer;    
}

#response_result_td, #delete_friend_td{
padding:3px;    
}

section {
margin-bottom: 3px;    
}

header { /* Шапка */
margin-bottom: 5px;
height:80px;
margin-top:-10px;
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

img {
border-radius:5px;    
}

#private_message_box {
margin-top:50px;    
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

<!-- Отправка личного сообщения -->
<div class="modal fade" id="private_message_box" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Отправка личного сообщения</h4>
        </div>

<div class="modal-body">
<section id = "private_message_box_wrapper">
    <input type = "hidden" id = "receiver_hidden_field" value = "">
<span>Да всё что хошь</span>
<textarea class="form-control" id = "private_message_textarea" style = " resize:none;" 
placeholder = "Да всякое вобщем" cols = "50" rows = "10"   maxlength = "3000" oninput = "this.placeholder = '';" onblur = "this.placeholder='Да всякое вобщем'" autofocus = "autofocus" ></textarea><br />
<span id = "private_message_box_errors"></span>
<button type = "button" onclick = send_private_message() class="btn btn-primary">Ахуенно</button>
<span style = "position:relative;left:200px;">Максимум 3000 символов</span>
</section>
</div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Нахуй</button>
        </div>
      </div>
      
    </div>
  </div>

<main  class = "container-fluid">

<div class = "row">

<?php 

echo "<a href=user.php?zs=" . $login . ">" . $login . "</a>";

?>

<?php 
$whose_bros = "";
if(session_isset() && $login != $_SESSION['user']) {
    $whose_bros = "Братки ваши и пользователя " . $login;
}else{
    header('Location:index.php');
    exit();
}
?>

<?php 

if($login !== $_SESSION['user']){
 
 // ИЩЕМ ДРУЗЕЙ, КОТОРЫЕ ОТПРАВЛЯЛИ ЗАЯВКУ СЕССИОННОМУ И ПОЛЬЗОВАТЕЛЮ 
$common_friends_from = array(); // ОБЩИЕ ДРУЗЬЯ, КОТОРЫЕ ОТПРАВЛЯЛИ ЗАЯВКУ СЕССИОННОМУ И К КОТОРОМУ ЗАШЛИ
  
  // ИЩЕМ  ТЕХ ДРУЗЕЙ КОТОРЫЕ ОТПРАВЛЯЛИ ЗАЯВКУ СЕССИОННОМУ 
$sql = "SELECT friend1,friend2, additional_info.avatar AS avatar FROM `friends`" . 
" INNER JOIN additional_info ON additional_info.nickname=friends.friend1 WHERE `friend2`='{$_SESSION['user']}'"; 	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$friends_from_of_sessioner = $query->fetchAll(PDO::FETCH_ASSOC);
$friends_from_of_sessioner_count = count($friends_from_of_sessioner);

// ИЩЕМ  ТЕХ ДРУЗЕЙ КОТОРЫЕ ОТПРАВЛЯЛИ ЗАЯВКУ ПОЛЬЗОВАТЕЛЮ, К КОТОРОМУ ЗАШЛИ 
$sql = "SELECT friend1,friend2, additional_info.avatar AS avatar FROM `friends`" . 
" INNER JOIN additional_info ON additional_info.nickname=friends.friend1 WHERE `friend2`='{$login}'"; 	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$friends_from_of_login = $query->fetchAll(PDO::FETCH_ASSOC);
$friends_from_of_login_count = count($friends_from_of_login);
    
$common_friends_from = array();

for($i = 0; $i < $friends_from_of_sessioner_count; $i++){
         for($j = 0; $j < $friends_from_of_login_count; $j++){
                if($friends_from_of_sessioner[$i]['friend1'] === $friends_from_of_login[$j]['friend1'] ){
                    array_push($common_friends_from, $friends_from_of_login[$j]['friend1']); 
                }
            
         }   
}    

/****************************************************************************************************************************************/

// ИЩЕМ ДРУЗЕЙ, КОТОРЫМ ОТПРАВЛЯЛ ЗАЯВКУ СЕССИОННЫЙ И ПОЛЬЗОВАТЕЛ 
$common_friends_to = array(); // ОБЩИЕ ДРУЗЬЯ, КОТОРЫМ ОТПРАВЛЯЛ ЗАЯВКУ СЕССИОННЫЙ И К КОТОРОМУ ЗАШЛИ

// ИЩЕМ  ТЕХ ДРУЗЕЙ КОТОРЫМ ОТПРАВЛЯЛ ЗАЯВКУ СЕССИОННЫЙ 
$sql = "SELECT friend1,friend2, additional_info.avatar AS avatar FROM `friends`" . 
" INNER JOIN additional_info ON additional_info.nickname=friends.friend1 WHERE `friend1`='{$_SESSION['user']}'"; 	
$query = $connection_handler->prepare($sql);
$query->execute();
$friends_to_of_sessioner = $query->fetchAll(PDO::FETCH_ASSOC);
$friends_to_of_sessioner_count = count($friends_to_of_sessioner);

// ИЩЕМ  ТЕХ ДРУЗЕЙ КОТОРЫМ ОТПРАВЛЯЛ ЗАЯВКУ ПОЛЬЗОВАТЕЛЬ, К КОТОРОМУ ЗАШЛИ 
$sql = "SELECT friend1,friend2, additional_info.avatar AS avatar FROM `friends`" . 
" INNER JOIN additional_info ON additional_info.nickname=friends.friend1 WHERE `friend1`='{$login}'"; 	
$query = $connection_handler->prepare($sql); 
$query->execute();
$friends_to_of_login = $query->fetchAll(PDO::FETCH_ASSOC);
$friends_to_of_login_count = count($friends_to_of_login);

$common_friends_to = array();

for($i = 0; $i < $friends_to_of_sessioner_count; $i++){
         for($j = 0; $j < $friends_to_of_login_count; $j++){
                if($friends_to_of_sessioner[$i]['friend2'] === $friends_to_of_login[$j]['friend2'] ){
                   array_push($common_friends_to, $friends_to_of_login[$j]['friend2']); 
                }
            
         }   
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////// 
 
$common_friends_total = array();

if(!empty($common_friends_to)){ // ДОБАВЛЯЕМ В ОБЩИЙ МАССИВ
    for($i = 0;$i < count($common_friends_to); $i++){
    array_push($common_friends_total, $common_friends_to[$i]);
        }
}

if(!empty($common_friends_from)){
    
    for($i = 0;$i < count($common_friends_from); $i++){
    array_push($common_friends_total, $common_friends_from[$i]);
        }
}

$common_friends_total_outp .= $common_friends_from_outp . $common_friends_to_outp; // ВСЕ ОБЩИЕ ДРУЗЬЯ

$friends_total = count($common_friends_total);

}

?>

<h1 style = "color:blue;text-align:center;font-family:Tahoma;"><?php echo $whose_bros; ?></h1>

<div> <!-- Контэйнер -->
<div>
<a href = "find_bros.php"><img class = "header_items_img" style = "position:relative;left:40px;" src = "imgs/header/find_new_bro.png"><br /><span>Больше братков</span></a><br />
</div>    
<div style = "display:inline-block;width:300px;"><!-- Мои братки  -->
<h4 style = "text-align:center;">Братки <?php echo "<span style = 'color:green'>" . $friends_total . "</span>"; ?></h4>
<hr />

<!-- Удаление пользователя -->
  <div class="modal fade" id="delete_friend_modal" role="dialog" style = "margin-top:15%">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Убрать из братков</h4>
        </div>
        <div class="modal-body">
        <section id = "delete_friend_reason_radios_section">
                <h3>Причина удаления из братков</h3> 
        <input type = "hidden" id = "hidden_for_delete_friend" value = "doebal">
        <input type = "hidden" id = "hidden_for_delete_friend_under_ava" value = "">
        <input type = "hidden" id = "hidden_for_delete_message_under_ava" value = "">
        <input type = "radio" class = "delete_friend_reason_radios" name = "delete_friend_reason_radio" value = "doebal" onclick = "set_delete_reason(this)" checked = "checked"/> <span class = "delete_friend_reason_radios_label">Доебал</span><br />    
        <input type = "radio" class = "delete_friend_reason_radios" name = "delete_friend_reason_radio" value = "fufel" onclick = "set_delete_reason(this)" /> <span class = "delete_friend_reason_radios_label">Фуфел</span><br />     
        <input type = "radio" class = "delete_friend_reason_radios" name = "delete_friend_reason_radio" value = "pidr" onclick = "set_delete_reason(this)" /> <span class = "delete_friend_reason_radios_label">Пидр</span><br />      
        
       <button type="button" class="btn btn-primary" id = "delete_friend_close_button" onclick = delete_friend(this) >Уничтожить</button>
        
        </section>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Нахуй</button>
        </div>
      </div>
</div>
</div>

<script>

function set_delete_friend_under_ava(user_id,id){
    var hidden_for_delete_friend_under_ava = document.getElementById("hidden_for_delete_friend_under_ava");
    var hidden_for_delete_message_under_ava = document.getElementById("hidden_for_delete_message_under_ava");
    hidden_for_delete_message_under_ava.value = id;
    hidden_for_delete_friend_under_ava.value = user_id;
}

function set_delete_reason(radio_button){
    var hidden_for_delete_friend = document.getElementById("hidden_for_delete_friend");
hidden_for_delete_friend.value = radio_button.value;
}

function delete_friend(button){ // УДАЛЯЕМ  ПОЛЬЗОВАТЕЛЯ

var xmlhttp = new XMLHttpRequest();

   var hidden_for_delete_message_under_ava = document.getElementById("hidden_for_delete_message_under_ava"); // Айди

var delete_friend_modal = document.getElementById("delete_friend_modal"); // Модальное окно

var delete_friend_tr = document.getElementById("delete_friend_tr_" + hidden_for_delete_message_under_ava.value); // Сообщение об удалении из друзей

var delete_friend_reason_radios = document.getElementsByClassName("delete_friend_reason_radios"); // Радиокнопки
var delete_friend_button_under_ava = document.getElementById("delete_friend_button_under_ava"); // Модальное окно
var delete_friend_reason_radios_section = document.getElementById("delete_friend_reason_radios_section");
var delete_friend_close_button = document.getElementById("delete_friend_close_button");
var delete_friend_button_under_ava = document.getElementById("delete_friend_button_under_ava_"+ hidden_for_delete_message_under_ava.value);
var hidden_for_delete_friend_under_ava = document.getElementById("hidden_for_delete_friend_under_ava"); // Для кнопки под авой
var hidden_for_delete_friend = document.getElementById("hidden_for_delete_friend"); // Для кнопки под авой

reason = hidden_for_delete_friend.value;

 xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
delete_friend_tr.style.display = "block"; // Показываем сообщение 
 button.style.display = "none"; // Удаляем кнопку на модальном окне
delete_friend_button_under_ava.style.display = "none"; // Удаляем кнопку под авой
delete_friend_reason_radios_section.innerHTML = "<span style = font-size:18px>" + xmlhttp.response + "</span>"; 
    } 
}

var formData = new FormData();
formData.append('user_id', hidden_for_delete_friend_under_ava.value);
formData.append('reason',  reason);

xmlhttp.open("POST", "scripts/delete_friend.php", true);
xmlhttp.send(formData);

}

</script>


<?php

/* ИЩЕМ ДРУЗЕЙ ДРУГОГО ПОЛЬЗОВАТЕЛЯ */
if(session_isset() && $login !== $_SESSION['user']){ // авторизовались и сидим на ЧУЖОЙ странице
 
$friends_total = count($common_friends_total);
$all_friends = "";

    for($i = 0; $i < $friends_total; $i++){
      
      $doebat_button = "";
       $online =   "";
      
     $sql = "SELECT * FROM `main_info` WHERE `nickname`='{$common_friends_total[$i]}'";
        $query = $connection_handler->prepare($sql); //Подготавливаем запрос
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $last_action_time = $result[0]['last_action_time'];
        $user_id = $result[0]['user_id'];  
      
       /* ИЩЕМ АВУ ПОЛЬЗОВАТЕЛЯ */
        $sql = "SELECT * FROM `additional_info` WHERE `nickname`='{$common_friends_total[$i]}'"; 	
        $query = $connection_handler->prepare($sql); //Подготавливаем запрос
        $query->execute();
        $avatar = $query->fetchAll(PDO::FETCH_ASSOC);
        $avatar = $avatar[0]['avatar'];
    
         if(($current_time - $last_action_time) <= 180){
        $online = "<span style = 'color:gray;'>Здеся</span>";     
        }
    
    $doebat_button = "<tr>
            <td></td>
            <td><button type = 'button' class= 'btn btn-success btn-sm' data-toggle='modal' data-target='#private_message_box' style = 'margin-left:5px;margin-top:5px;' onclick = show_private_message_box('" . $user_id . "') >Доебать</button></td>
            </tr>";
    
    $all_friends .= "<section >
            <table>
            <tr>
            <td colspan = '2'><img src = 'users/{$avatar}' width = '50' height = '50'>
            <a href = 'user.php?zs=" . str_replace(" ","%20",$common_friends_total[$i]) . "' style = 'position:relative; top: -18px;'>" . str_replace(" ","_",$common_friends_total[$i]) . "</a><br/>" .
                $online .
            "</td>
            </tr>
            <tr style = 'display:none' id = delete_friend_tr_" . $i .">
            <td colspan = '2'  style = 'background-color: yellow;text-align:center'>Гавно!</td>
            </tr>" .
            $doebat_button .
            "</table>                
            </section>";
    
    }


////////////////////////////////////////////////////////////////////////////////////////////////////////////////

echo $all_friends;    
}    

?>
</div><!--  Мои братки -->

<?php 

$online_friends_count = 0;
$online_friends = array();

if(session_isset() && $login !== $_SESSION['user']){

$current_time = time();

    for($i = 0; $i < $friends_total; $i++){

    $sql = "SELECT * FROM `main_info` WHERE `nickname`='{$common_friends_total[$i]}'";
    $query = $connection_handler->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    $last_action_time = $result[0]['last_action_time'];
    $user_id_online = $result[0]['user_id'];

    if(($current_time - $last_action_time) <= 180){
  ++$online_friends_count;
    array_push($online_friends,$common_friends_total[$i]);        
               }
        } 

}
?>


<div style = "display:inline-block; width:300px;"><!-- БРАТКИ ОНЛАЙН  -->

<?php 

$online_bros_header = "";

if($online_bros_count > 0){
 $online_bros_header = "<h4 style = text-align:center;>Братки здеся: <span style = 'color:green'>" . $online_friends_count . "</span></h4>
<hr />";   
    
}

echo $online_bros_header;

?>

<?php 

if(session_isset() && $login !== $_SESSION['user']){ // авторизовались и сидим на ЧУЖОЙ странице

$all_friends = "";

    for($i = 0; $i < $online_friends_count; $i++){
      
      $doebat_button = "";

     $sql = "SELECT * FROM `main_info` WHERE `nickname`='{$online_friends[$i]}'";
        $query = $connection_handler->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $last_action_time = $result[0]['last_action_time'];
        $user_id = $result[0]['user_id'];  
      
       /* ИЩЕМ АВУ ПОЛЬЗОВАТЕЛЯ */
        $sql = "SELECT * FROM `additional_info` WHERE `nickname`='{$online_friends[$i]}'"; 	
        $query = $connection_handler->prepare($sql); //Подготавливаем запрос
        $query->execute();
        $avatar = $query->fetchAll(PDO::FETCH_ASSOC);
        $avatar = $avatar[0]['avatar'];

    $doebat_button = "<tr>
            <td></td>
            <td><button type = 'button' class= 'btn btn-success btn-sm' data-toggle='modal' data-target='#private_message_box' style = 'margin-left:5px;margin-top:5px;' onclick = show_private_message_box('" . $user_id . "') >Доебать</button></td>
            </tr>";
    
    $all_friends .= "<section >
            <table>
            <tr>
            <td colspan = '2'><img src = 'users/{$avatar}' width = '50' height = '50'>
            <a href = 'user.php?zs=" . str_replace(" ","%20",$online_friends[$i]) . "' style = 'position:relative; top: -18px;'>" . str_replace(" ","_",$common_friends_total[$i]) . "</a><br/>
            </td>
            </tr>
            <tr style = 'display:none' id = delete_friend_tr_" . $i .">
            <td colspan = '2'  style = 'background-color: yellow;text-align:center'>Гавно!</td>
            </tr>" .
            $doebat_button .
            "</table>                
            </section>";
    
    }
    
echo $all_friends;    
}  
?>    
</div> <!-- Братки онлайн -->

</div> <!--  Контэйнер -->

</div><!-- class = row -->

</main>    

</body>    

</html>    

<?php ob_end_flush(); ?>
