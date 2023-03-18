<!DOCTYPE html>

<?php
ob_start();
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

error_reporting(0);

function session_isset(){ // Пользователь вошел
if(!empty($_SESSION['user'])){ // Пользователь вошел через логин-пароль
return true;
} else {
return false;
}
}

if(empty($_SESSION['user'])){
header('Location: index.php'); // Редиректим на index.php
exit();   
}

$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute(); 



?>

<html>
<head>
<title>Сидим тута</title>
<meta charset = "utf-8"/>
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
    width: 100%;
    background-color:#cefdce;
    margin:0 auto;
    height:100%;
    font-size:20px;
 }

main {
    padding: 10px;
    border-left: 2px double blue;
    border-right: 2px double blue;
    padding-bottom: 90px;
}

td {
border-bottom: 1px solid black;    
}

a {
color:blue;    
}

.dialog {
border-top:1px dashed black;    
border-bottom:1px dashed black;    
padding-top:5px;    
padding-bottom:5px;
width:100%;
height:200px;
cursor:pointer;
}

.dialog:hover {
background-color:white;
opacity:0.7;
}
.initiator, joined {
 height:90px;
}

.joined {
margin-top:10px;    
}

.initiator {
border-bottom:1px solid green;    
}

.initiator_img_container{
border-radius:5px;  
margin-right:5px;
float:left;

}

.initiator_img,.joined_img {
 width:50px;
 height:50px;
 border-radius:10px;
}

.initiator_nick_container {
float:left;
width:200px;
}

.initiator_dialog_begin{
    display:block;
    color:gray;
    font-size:10px;
    font-weight:bold;
    margin-top:5px;
}

.initiator_nick {
 display:block;
 margin-bottom:-10px;
 color:#3399cc;
 font-family:Tahoma;
 font-size:15px;
}

.initiator_online{
 color:gray;
 display:block;
 margin-left:6px;
}

.new_message_img {
width:40px;
height:40px;
}

.initiator_last_message_container {
margin-left:10px;
width:200px;
float:left; 
border-left:1px solid black;
padding-left:10px;
}

.initiator_last_message {
 word-wrap: break-word;
width:325px;
height:60px;
overflow-y:hidden;
}

.initiator_last_message_date,.joined_last_message_date{
color:gray;    
}

.joined_nick {
 color:#3399cc;
 position:relative;
 top:15px;
 font-family:Tahoma;
 font-size:15px;
}

.joined_last_message_container {
    border-left:1px solid black;
    display:inline-block;
    margin-left:30px;
width:200px;
padding-left:10px;
}

.joined_nick_and_img_container{
display:inline-block;
position:relative;
top:-30px;
width:250px;
margin-right:-20px;
}

.joined_last_message_content {
 word-wrap: break-word;
width:325px;
height:60px;
overflow-y:hidden;
}

.joined_nick_and_img_container_first{
    display:inline-block;
position:relative;
    position:relative;
    top:-5px;
    width:250px;
margin-right:-20px;
}

.joined_user_online_first_section{
color:gray;
position:relative;
left:5px;
}

.joined_nick_first_section{
position:relative;
top:10px;
}

header { /* Шапка */
position:relative;
left: 150px;
top:50px;
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
/* ИЗВЛЕКАЕМ ВСЕ ДИАЛОГИ В КОТОРЫХ СЕССИОННЫЙ ЯВЛЯЕТСЯ ПРОСОЕДИНЕННЫМ */
$sql = "SELECT COUNT(*) AS `sessioner_joined_count` FROM `dialogs` WHERE `joined`='{$_SESSION['user']}'";
$query = $connection_handler->prepare($sql);
$query->execute();
$sessioner_joined_count = $query->fetchAll(PDO::FETCH_ASSOC);  
$sessioner_joined_count = $sessioner_joined_count[0]['sessioner_joined_count'];

/* ИЗВЛЕКАЕМ ВСЕ ДИАЛОГИ В КОТОРЫХ СЕССИОННЫЙ ЯВЛЯЕТСЯ ПРОСОЕДИНЕННЫМ */
$sql = "SELECT COUNT(*) AS `sessioner_initiator_count` FROM `dialogs` WHERE `initiator`='{$_SESSION['user']}'";
$query = $connection_handler->prepare($sql); 
$query->execute();
$sessioner_initiator_count = $query->fetchAll(PDO::FETCH_ASSOC);  
$sessioner_initiator_count = $sessioner_initiator_count[0]['sessioner_initiator_count'];

$all_dialogs_count = $sessioner_joined_count + $sessioner_initiator_count;

?>

<?php 
/* ИЗВЛЕКАЕМ АКТИВНЫЕ ДИАЛОГИ В КОТОРЫХ СЕССИОННЫЙ ЯВЛЯЕТСЯ ПРОСОЕДИНЕННЫМ */
$sql = "SELECT COUNT(*) AS `sessioner_joined_count` FROM `dialogs` WHERE `joined`='{$_SESSION['user']}' AND `is_finished`=0";
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$sessioner_joined_count = $query->fetchAll(PDO::FETCH_ASSOC);  
$sessioner_joined_count = $sessioner_joined_count[0]['sessioner_joined_count'];

$sessioner_joined_count_span = "";

if($sessioner_joined_count > 0){
$sessioner_joined_count_span =  '<span class = badje style=color:yellow;background-color:#1E06F7; border:0px solid black; border-radius:100%; padding:3px;>' . $sessioner_joined_count . '</span>';    
}

$sql = "SELECT COUNT(*) AS `sessioner_initiator_count` FROM `dialogs` WHERE `initiator`='{$_SESSION['user']}' AND `is_finished_for_initiator`=0";
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$sessioner_initiator_count = $query->fetchAll(PDO::FETCH_ASSOC);  
$sessioner_initiator_count = $sessioner_initiator_count[0]['sessioner_initiator_count'];

$sessioner_initiator_count_span = "";

if($sessioner_initiator_count > 0){
$sessioner_initiator_count_span =  '<span class = badje style=color:yellow;background-color:#1E06F7; border:0px solid black; border-radius:100%; padding:3px;>' . $sessioner_initiator_count . '</span>';
}


/* ИЗВЛЕКАЕМ КОЛИЧЕСТВО ЗАВЕРШЕННЫХ ДИАЛОГОВ В КОТОРЫХ СЕССИОННЫЙ ЯВЛЯЕТСЯ ПРИСОЕДИНЕННЫМ*/
$sql = "SELECT COUNT(*) AS `sessioner_joined_finished_dialogs_count` FROM `dialogers` WHERE `dialoger`='{$_SESSION['user']}' AND `is_finished` = 1";
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$sessioner_joined_finished_dialogs = $query->fetchAll(PDO::FETCH_ASSOC);  
$sessioner_joined_finished_dialogs = $sessioner_joined_finished_dialogs[0]['sessioner_joined_finished_dialogs_count'];

/* ИЗВЛЕКАЕМ ВСЕ ДИАЛОГИ В КОТОРЫХ СЕССИОННЫЙ ЯВЛЯЕТСЯ ПРОСОЕДИНЕННЫМ */
$sql = "SELECT COUNT(*) AS `sessioner_joined_count_all` FROM `dialogs` WHERE `joined`='{$_SESSION['user']}'";
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$sessioner_joined_count_all = $query->fetchAll(PDO::FETCH_ASSOC);  
$sessioner_joined_count_all = $sessioner_joined_count_all[0]['sessioner_joined_count_all'];


?>

<?php
    if(session_isset()){

echo '<a href = user.php?zs=' . $_SESSION['user'] . '>' . $_SESSION['user'] . '</a>';

}
?>

<main class = "container-fluid">
  <div class = "row">
    <?php echo "<h5>Всего диалогов | " . $all_dialogs_count . "</h5>" ?>
<div class="container">
 <ul class="nav nav-tabs" style = "margin-bottom:10px; width:515px">
    <li class="active"><a data-toggle="tab" href="#second" title = "Второе сообщение в диалоге ваше">Второй <?php echo $sessioner_joined_count_span; ?></a></li>
    <li><a data-toggle="tab" href="#first" title = "Вы создали диалог">Первый <?php echo $sessioner_initiator_count_span; ?></span></a></li>
</ul> 

 <div class="tab-content">

<!-- ВТОРОЙ  -->
<div id="second" class="tab-pane fade in active">
Активные <?php echo "<span style = 'text-decoration:underline;'>" . $sessioner_joined_count . '</span>';  ?> | Завершенные <?php echo "<span style = 'text-decoration:underline;'>" .  $sessioner_joined_finished_dialogs . '</span><br />'; ?>
Всего <?php echo "<span style = 'text-decoration:underline;'>" . $sessioner_joined_count_all . "</span>"; ?>
<?php 

/*/////////////////////////////////////////////////СЕССИОННЫЙ ПРИСОЕДИНЕННЫЙ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/

/* ИЗВЛЕКАЕМ ДИАЛОГИ В КОТОРЫХ СЕССИОННЫЙ ЯВЛЯЕТСЯ ПРОСОЕДИНЕННЫМ */
$sql = "SELECT * FROM `dialogs` WHERE `joined`='{$_SESSION['user']}'  ORDER BY `date` DESC";
$query = $connection_handler->prepare($sql); 
$query->execute();
$sessioner_joined = $query->fetchAll(PDO::FETCH_ASSOC);    

if(!empty($sessioner_joined)){ // ЕСЛИ ДИАЛОГИ В КОТОРЫХ СЕССИОННЫЙ ЯВЛЯЕТСЯ ПРОСОЕДИНЕННЫМ СУЩЕСТВУЮТ

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++АКТИВНЫЕ ДИАЛОГИ СЕССИОННОГО ПРИСОЕДИНЕННОГО++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/* ИЗВЛЕКАЕМ АКТИВНЫЕ ДИАЛОГИ В КОТОРЫХ СЕССИОННЫЙ ЯВЛЯЕТСЯ ПРИСОЕДИНЕННЫМ */
$sql = "SELECT * FROM `dialogers` WHERE `dialoger`='{$_SESSION['user']}' AND `is_finished`=0  ORDER BY `date` DESC";
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$sessioner_joined_active_dialogs = $query->fetchAll(PDO::FETCH_ASSOC);    

if(!empty($sessioner_joined_active_dialogs)){ // ЕСЛИ АКТИВНЫЕ ДИАЛОГИ В КОТОРЫХ СЕССИОННЫЙ ЯВЛЯЕТСЯ ПРИСОЕДИНЕННЫМ СУЩЕСТВУЮТ

/* ИЗВЛЕКАЕМ КОЛИЧЕСТВО АКТИВНЫХ ДИАЛОГОВ В КОТОРЫХ СЕССИОННЫЙ ЯВЛЯЕТСЯ ПРИСОЕДИНЕННЫМ*/
$sql = "SELECT COUNT(*) AS `sessioner_joined_active_dialogs_count` FROM `dialogers` WHERE `dialoger`='{$_SESSION['user']}' AND `is_finished`=0";
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$sessioner_joined_active_dialogs_count = $query->fetchAll(PDO::FETCH_ASSOC);  
$sessioner_joined_active_dialogs_count = $sessioner_joined_active_dialogs_count[0]['sessioner_joined_active_dialogs_count'];

$sessioner_joined_active_dialogs_output = ""; // ПЕРЕМЕННАЯ ДЛЯ ВЫВОДА АКТИВНЫХ ДИАЛОГОВ

/* ОТОБРАЖАЕМ АКТИВНЫЕ ДИАЛОГИ В КОТОРЫХ СЕССИОННЫЙ ЯВЛЯЕТСЯ ПРИСОЕДИНЕННЫМ */
for($i = 0; $i < $sessioner_joined_active_dialogs_count; $i++){

            /* ----------------------------------ИНИЦИАТОР СВЕРХУ--------------------------------------------------------------------------------------- */
            
            /* ИЗВЛЕКАЕМ ИМЯ ИНИЦИАТОРА ДИАЛОГА */
            $sql = "SELECT `initiator` AS `sessioner_joined_active_dialogs_initiator` FROM `dialogs` WHERE `this_id`={$sessioner_joined_active_dialogs[$i]['dialog']}";
            $query = $connection_handler->prepare($sql); //Подготавливаем запрос
            $query->execute();
            $sessioner_joined_active_dialogs_initiator = $query->fetchAll(PDO::FETCH_ASSOC);    
            $sessioner_joined_active_dialogs_initiator = $sessioner_joined_active_dialogs_initiator[0]['sessioner_joined_active_dialogs_initiator'];
            
            /* ИЗВЛЕКАЕМ ДАТУ НАЧАЛА ДИАЛОГА */
            $sql = "SELECT `date` AS `sessioner_joined_active_dialogs_initiator_date_of_new_dialog` FROM `date_of_new_dialog` WHERE `dialog`={$sessioner_joined_active_dialogs[$i]['dialog']}";
            $query = $connection_handler->prepare($sql); //Подготавливаем запрос
            $query->execute();
            $sessioner_joined_active_dialogs_initiator_date_of_new_dialog = $query->fetchAll(PDO::FETCH_ASSOC);    
            $sessioner_joined_active_dialogs_initiator_date_of_new_dialog = $sessioner_joined_active_dialogs_initiator_date_of_new_dialog[0]['sessioner_joined_active_dialogs_initiator_date_of_new_dialog'];
            
            /* ИЗВЛЕКАЕМ АВАТАР ИНИЦИАТОРА ДИАЛОГА */
            $sql = "SELECT `avatar` AS `sessioner_joined_active_dialogs_initiator_avatar` FROM `additional_info` WHERE `nickname`='{$sessioner_joined_active_dialogs_initiator}'";
            $query = $connection_handler->prepare($sql); //Подготавливаем запрос
            $query->execute();
            $sessioner_joined_active_dialogs_initiator_avatar = $query->fetchAll(PDO::FETCH_ASSOC);  
            $sessioner_joined_active_dialogs_initiator_avatar = $sessioner_joined_active_dialogs_initiator_avatar[0]['sessioner_joined_active_dialogs_initiator_avatar'];    
            
            /* ИЗВЛЕКАЕМ ПОСЛЕДНЕЕ СООБЩЕНИЕ ОТ ИНИЦИАТОРА ДИАЛОГА */
            $sql = "SELECT `message` AS `sessioner_joined_active_dialogs_initiator_last_message` FROM `dialog_messages` WHERE `sender`='{$sessioner_joined_active_dialogs_initiator}' AND `dialog`={$sessioner_joined_active_dialogs[$i]['dialog']} ORDER BY `this_id` DESC";
            $query = $connection_handler->prepare($sql); //Подготавливаем запрос
            $query->execute();
            $sessioner_joined_active_dialogs_initiator_last_message = $query->fetchAll(PDO::FETCH_ASSOC);    
            $sessioner_joined_active_dialogs_initiator_last_message =$sessioner_joined_active_dialogs_initiator_last_message[0]['sessioner_joined_active_dialogs_initiator_last_message'];
             
            /* ИЗВЛЕКАЕМ ДАТУ ПОСЛЕДНЕГО СООБЩЕНИЯ ОТ ИНИЦИАТОРА ДИАЛОГА */
            $sql = "SELECT `date` AS `sessioner_joined_active_dialogs_initiator_last_message_date` FROM `dialog_messages` WHERE `sender`='{$sessioner_joined_active_dialogs_initiator}' AND `dialog`={$sessioner_joined_active_dialogs[$i]['dialog']} ORDER BY `this_id` DESC";
            $query = $connection_handler->prepare($sql); //Подготавливаем запрос
            $query->execute();
            $sessioner_joined_active_dialogs_initiator_last_message_date = $query->fetchAll(PDO::FETCH_ASSOC);    
            $sessioner_joined_active_dialogs_initiator_last_message_date =$sessioner_joined_active_dialogs_initiator_last_message_date[0]['sessioner_joined_active_dialogs_initiator_last_message_date']; 
             
            /*-------------------------------------------ПРИСОЕДИНЕННЫЙ (СЕССИОННЫЙ) СНИЗУ-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/  
            
            /* ИЗВЛЕКАЕМ АВАТАР ПОЛЬЗОВАТЕЛЯ */
            $sql = "SELECT `avatar` AS 'sessioner_joined_active_dialogs_sessioner_avatar' FROM `additional_info` WHERE `nickname`='{$_SESSION['user']}'";
            $query = $connection_handler->prepare($sql); //Подготавливаем запрос
            $query->execute();
            $sessioner_joined_active_dialogs_sessioner_avatar = $query->fetchAll(PDO::FETCH_ASSOC);    
            $sessioner_joined_active_dialogs_sessioner_avatar = $sessioner_joined_active_dialogs_sessioner_avatar[0]['sessioner_joined_active_dialogs_sessioner_avatar']; 
            
            /* ИЗВЛЕКАЕМ ПОСЛЕДНЕЕ СООБЩЕНИЕ ОТ ПРИСОЕДИНЕННОГО СЕССИОННОГО */
            $sql = "SELECT `message` AS `sessioner_joined_active_dialogs_sessioner_last_message` FROM `dialog_messages` WHERE `sender`='{$_SESSION['user']}' AND `dialog`={$sessioner_joined_active_dialogs[$i]['dialog']} ORDER BY `this_id` DESC";
            $query = $connection_handler->prepare($sql); //Подготавливаем запрос
            $query->execute();
            $sessioner_joined_active_dialogs_sessioner_last_message = $query->fetchAll(PDO::FETCH_ASSOC);    
            $sessioner_joined_active_dialogs_sessioner_last_message = $sessioner_joined_active_dialogs_sessioner_last_message[0]['sessioner_joined_active_dialogs_sessioner_last_message'];
            
            /* ИЗВЛЕКАЕМ ДАТУ ПОСЛЕДНЕГО СООБЩЕНИЯ ОТ ПРИСОЕДИНЕННОГО (СЕССИОННОГО) */
            $sql = "SELECT `date` AS `sessioner_joined_active_dialogs_sessioner_last_message_date` FROM `dialog_messages` WHERE `sender`='{$_SESSION['user']}' AND `dialog`='{$sessioner_joined_active_dialogs[$i]['dialog']}' ORDER BY `this_id` DESC";
            $query = $connection_handler->prepare($sql); //Подготавливаем запрос
            $query->execute();
            $sessioner_joined_active_dialogs_sessioner_last_message_date = $query->fetchAll(PDO::FETCH_ASSOC);    
            $sessioner_joined_active_dialogs_sessioner_last_message_date =$sessioner_joined_active_dialogs_sessioner_last_message_date[0]['sessioner_joined_active_dialogs_sessioner_last_message_date']; 
            
            $sessioner_joined_active_dialogs_output .= '<section class = dialog id=' . $sessioner_joined_active_dialogs[$i]['dialog'] . '  onclick = window.location.replace("dialog.php?id=' . $sessioner_joined_active_dialogs[$i]['dialog'] . '") >
            
            <div class = initiator>
            <div class =  initiator_img_container>    
            <img class = initiator_img  src = users/' . $sessioner_joined_active_dialogs_initiator_avatar . ' /><br />
            <span class = initiator_online>' . $sessioner_joined_active_dialogs_initiator_online . '</span>
            </div>
            <div class = "initiator_nick_container">
            <span class = initiator_nick><a href = user.php?zs=' . $sessioner_joined_active_dialogs_initiator . '>' .  $sessioner_joined_active_dialogs_initiator . '</a></span>
            <span class = initiator_dialog_begin>' .  $sessioner_joined_active_dialogs_initiator_date_of_new_dialog . '</span>
            <img class = new_message_img src = imgs/closed_box.png>
            </div>
            <div class = initiator_last_message_container>
            <div class = initiator_last_message>' .
            $sessioner_joined_active_dialogs_initiator_last_message .
            '</div>
            <span class = initiator_last_message_date>' . $sessioner_joined_active_dialogs_initiator_last_message_date . '</span>
            </div>    
            </div>
            <div class = joined>
            <div class = joined_nick_and_img_container> 
            <img class = joined_img  src = users/' . $sessioner_joined_active_dialogs_sessioner_avatar  . ' />
            <span class = joined_nick><a href = user.php?zs=' . $_SESSION['user'] . '>' . $_SESSION['user'] . '</a></span>
            </div>
            
            <div class = joined_last_message_container>
            <div class = joined_last_message_content>' .
             $sessioner_joined_active_dialogs_sessioner_last_message .
            '</div>
            <span class = joined_last_message_date>' . $sessioner_joined_active_dialogs_sessioner_last_message_date . '</span>
            </div>
            </div>
            
            </section>';    
        } // for($i = 0; $i < $sessioner_joined_active_dialogs_count; $i++)

echo $sessioner_joined_active_dialogs_output; // ВЫВОДИМ АКТИВНЫЕ ДИАЛОГИ В КОТОРЫХ СЕССИОННЫЙ ЯВЛЯЕТСЯ ПРИСОЕДИНЕННЫМ

    } //if(!empty($sessioner_joined_active_dialogs)) 

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++НЕАКТИВНЫЕ ДИАЛОГИ СЕССИОННОГО ПРИСОЕДИНЕННОГО++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/* ИЗВЛЕКАЕМ ЗАВЕРШЕННЫЕ ДИАЛОГИ В КОТОРЫХ СЕССИОННЫЙ ЯВЛЯЕТСЯ ПРИСОЕДИНЕННЫМ */
$sql = "SELECT * FROM `dialogers` WHERE `dialoger`='{$_SESSION['user']}' AND `is_finished` = 1  ORDER BY `date` DESC";
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$sessioner_joined_finished_dialogs = $query->fetchAll(PDO::FETCH_ASSOC);        

if(!empty($sessioner_joined_finished_dialogs)){ // ЕСЛИ ИЗВЛЕКАЕМ ЗАВЕРШЕННЫЕ ДИАЛОГИ В КОТОРЫХ СЕССИОННЫЙ ЯВЛЯЕТСЯ ПРИСОЕДИНЕННЫМ СУЩЕСТВУЮТ

/* ИЗВЛЕКАЕМ КОЛИЧЕСТВО ЗАВЕРШЕННЫХ ДИАЛОГОВ В КОТОРЫХ СЕССИОННЫЙ ЯВЛЯЕТСЯ ПРИСОЕДИНЕННЫМ*/
$sql = "SELECT COUNT(*) AS `sessioner_joined_finished_dialogs_count` FROM `dialogers` WHERE `dialoger`='{$_SESSION['user']}' AND `is_finished` = 1";
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$sessioner_joined_finished_dialogs_count = $query->fetchAll(PDO::FETCH_ASSOC);  
$sessioner_joined_finished_dialogs_count = $sessioner_joined_finished_dialogs_count[0]['sessioner_joined_finished_dialogs_count'];

$sessioner_joined_finished_dialogs_output = ""; // ВЫВОД ЗАВЕРШЕННЫХ ДИАЛОГОВ

/* ОТОБРАЖАЕМ ЗАВЕРШЕННЫЕ ДИАЛОГИ В КОТОРЫХ СЕССИОННЫЙ ЯВЛЯЕТСЯ ПРИСОЕДИНЕННЫМ */
for($i = 0; $i < $sessioner_joined_finished_dialogs_count; $i++){

            /* ----------------------------------ИНИЦИАТОР СВЕРХУ--------------------------------------------------------------------------------------- */
             
            /* ИЗВЛЕКАЕМ ИМЯ ИНИЦИАТОРА ДИАЛОГА */
            $sql = "SELECT `initiator` AS `sessioner_joined_finished_dialogs_initiator` FROM `dialogs` WHERE `this_id`={$sessioner_joined_finished_dialogs[$i]['dialog']}";
            $query = $connection_handler->prepare($sql); //Подготавливаем запрос
            $query->execute();
            $sessioner_joined_finished_dialogs_initiator = $query->fetchAll(PDO::FETCH_ASSOC);    
            $sessioner_joined_finished_dialogs_initiator = $sessioner_joined_finished_dialogs_initiator[0]['sessioner_joined_finished_dialogs_initiator']; 
            
            /* ИЗВЛЕКАЕМ АВАТАР ИНИЦИАТОРА ДИАЛОГА */
            $sql = "SELECT `avatar` AS `sessioner_joined_finished_dialogs_initiator_avatar` FROM `additional_info` WHERE `nickname`='{$sessioner_joined_finished_dialogs_initiator}'";
            $query = $connection_handler->prepare($sql); //Подготавливаем запрос
            $query->execute();
            $sessioner_joined_finished_dialogs_initiator_avatar = $query->fetchAll(PDO::FETCH_ASSOC);  
            $sessioner_joined_finished_dialogs_initiator_avatar = $sessioner_joined_finished_dialogs_initiator_avatar[0]['sessioner_joined_finished_dialogs_initiator_avatar'];    
            
            /* ИЗВЛЕКАЕМ ДАТУ НАЧАЛА ДИАЛОГА */
            $sql = "SELECT `date` AS `sessioner_joined_finished_dialogs_initiator_date_of_new_dialog` FROM `date_of_new_dialog` WHERE `dialog`={$sessioner_joined_finished_dialogs[$i]['dialog']}";
            $query = $connection_handler->prepare($sql); //Подготавливаем запрос
            $query->execute();
            $sessioner_joined_finished_dialogs_initiator_date_of_new_dialog = $query->fetchAll(PDO::FETCH_ASSOC);    
            $sessioner_joined_finished_dialogs_initiator_date_of_new_dialog = $sessioner_joined_finished_dialogs_initiator_date_of_new_dialog[0]['sessioner_joined_finished_dialogs_initiator_date_of_new_dialog'];
            
            /* ИЗВЛЕКАЕМ ПОСЛЕДНЕЕ СООБЩЕНИЕ ОТ ИНИЦИАТОРА ДИАЛОГА */
            $sql = "SELECT `message` AS `sessioner_joined_finished_dialogs_initiator_last_message` FROM `dialog_messages` WHERE `sender`='{$sessioner_joined_finished_dialogs_initiator}' AND `dialog`={$sessioner_joined_finished_dialogs[$i]['dialog']} ORDER BY `this_id` DESC";
            $query = $connection_handler->prepare($sql); //Подготавливаем запрос
            $query->execute();
            $sessioner_joined_finished_dialogs_initiator_last_message = $query->fetchAll(PDO::FETCH_ASSOC);    
            $sessioner_joined_finished_dialogs_initiator_last_message =$sessioner_joined_finished_dialogs_initiator_last_message[0]['sessioner_joined_finished_dialogs_initiator_last_message'];
              
            /* ИЗВЛЕКАЕМ ДАТУ ПОСЛЕДНЕГО СООБЩЕНИЯ ОТ ИНИЦИАТОРА ДИАЛОГА */
            $sql = "SELECT `date` AS `sessioner_joined_finished_dialogs_initiator_last_message_date` FROM `dialog_messages` WHERE `sender`='{$sessioner_joined_finished_dialogs_initiator}' AND `dialog`={$sessioner_joined_finished_dialogs[$i]['dialog']} ORDER BY `this_id` DESC";
            $query = $connection_handler->prepare($sql); //Подготавливаем запрос
            $query->execute();
            $sessioner_joined_finished_dialogs_initiator_last_message_date = $query->fetchAll(PDO::FETCH_ASSOC);    
            $sessioner_joined_finished_dialogs_initiator_last_message_date =$sessioner_joined_finished_dialogs_initiator_last_message_date[0]['sessioner_joined_finished_dialogs_initiator_last_message_date'];    
             
             /*-------------------------------------------ПРИСОЕДИНЕННЫЙ (СЕССИОННЫЙ) СНИЗУ-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/  
             /* ИЗВЛЕКАЕМ АВАТАР ПОЛЬЗОВАТЕЛЯ */
            $sql = "SELECT `avatar` AS 'sessioner_joined_finished_dialogs_sessioner_avatar' FROM `additional_info` WHERE `nickname`='{$_SESSION['user']}'";
            $query = $connection_handler->prepare($sql); //Подготавливаем запрос
            $query->execute();
            $sessioner_joined_finished_dialogs_sessioner_avatar = $query->fetchAll(PDO::FETCH_ASSOC);    
            $sessioner_joined_finished_dialogs_sessioner_avatar = $sessioner_joined_finished_dialogs_sessioner_avatar[0]['sessioner_joined_finished_dialogs_sessioner_avatar']; 
            
            /* ИЗВЛЕКАЕМ ПОСЛЕДНЕЕ СООБЩЕНИЕ ОТ ПРИСОЕДИНЕННОГО СЕССИОННОГО */
            $sql = "SELECT `message` AS `sessioner_joined_finished_dialogs_sessioner_last_message` FROM `dialog_messages` WHERE `sender`='{$_SESSION['user']}' AND `dialog`={$sessioner_joined_finished_dialogs[$i]['dialog']} ORDER BY `this_id` DESC";
            $query = $connection_handler->prepare($sql); //Подготавливаем запрос
            $query->execute();
            $sessioner_joined_finished_dialogs_sessioner_last_message = $query->fetchAll(PDO::FETCH_ASSOC);    
            $sessioner_joined_finished_dialogs_sessioner_last_message = $sessioner_joined_finished_dialogs_sessioner_last_message[0]['sessioner_joined_finished_dialogs_sessioner_last_message'];
            
            /* ИЗВЛЕКАЕМ ДАТУ ПОСЛЕДНЕГО СООБЩЕНИЯ ОТ ПРИСОЕДИНЕННОГО (СЕССИОННОГО) */
            $sql = "SELECT `date` AS `sessioner_joined_finished_dialogs_sessioner_last_message_date` FROM `dialog_messages` WHERE `sender`='{$_SESSION['user']}' AND `dialog`={$sessioner_joined_finished_dialogs[$i]['dialog']} ORDER BY `this_id` DESC";
            $query = $connection_handler->prepare($sql); //Подготавливаем запрос
            $query->execute();
            $sessioner_joined_finished_dialogs_sessioner_last_message_date = $query->fetchAll(PDO::FETCH_ASSOC);    
            $sessioner_joined_finished_dialogs_sessioner_last_message_date =$sessioner_joined_finished_dialogs_sessioner_last_message_date[0]['sessioner_joined_finished_dialogs_sessioner_last_message_date']; 
            
            $sessioner_joined_finished_dialogs_output .= '<section class = dialog id=' . $sessioner_joined_finished_dialogs[$i]['dialog'] . '  onclick = window.location.replace("dialog.php?id=' . $sessioner_joined_finished_dialogs[$i]['dialog'] . '") >
            
            <div class = initiator>
            <div class =  initiator_img_container>    
            <img class = initiator_img  src = users/' . $sessioner_joined_finished_dialogs_initiator_avatar . ' /><br />
            <span class = initiator_online>' . $initiator_online . '</span>
            </div>
            <div class = "initiator_nick_container">
            <span class = initiator_nick><a href = user.php?zs=' . $sessioner_joined_finished_dialogs_initiator . '>' . $sessioner_joined_finished_dialogs_initiator . '</a></span>
            <span class = initiator_dialog_begin>' .  $sessioner_joined_finished_dialogs_initiator_date_of_new_dialog . '</span>
            </div>
            <div class = initiator_last_message_container>
            <div class = initiator_last_message>' .
            $sessioner_joined_finished_dialogs_initiator_last_message .
            '</div>
            <span class = initiator_last_message_date>' . $sessioner_joined_finished_dialogs_initiator_last_message_date . '</span>
            </div>    
            </div>
            <div class = joined>
            <div class = joined_nick_and_img_container> 
            <img class = joined_img  src = users/' . $sessioner_joined_finished_dialogs_sessioner_avatar  . ' />
            <span class = joined_nick><a href = user.php?zs=' . $_SESSION['user'] . '>' . $_SESSION['user'] . '</a></span>
            </div>
            
            <div class = joined_last_message_container>
            <div class = joined_last_message_content>' .
            $sessioner_joined_finished_dialogs_sessioner_last_message .
            '</div>
            <span class = joined_last_message_date>' . $sessioner_joined_finished_dialogs_sessioner_last_message_date . '</span>
            </div>
            </div>
            
            </section>';
                
    
        } //for($i = 0; $i < $sessioner_joined_finished_dialogs_count; $i++)
    
    } //if(!empty($sessioner_joined_finished_dialogs))

echo $sessioner_joined_finished_dialogs_output;

} //if(!empty($sessioner_joined))



/*********************************************************************************************************************************************************************************************************************/
?>
            </div><!-- <div id="second" class="tab-pane fade in active">  -->


<!--  ПЕРВЫЙ  -->
   
   <?php 

/* ИЗВЛЕКАЕМ КОЛИЧЕСТВО АКТИВНЫХ ДИАЛОГОВ В КОТОРЫХ СЕССИОННЫЙ ЯВЛЯЕТСЯ ИНИЦИАТОРОМ */
$sql = "SELECT COUNT(*) AS `sessioner_initiator_count` FROM `dialogs` WHERE `initiator`='{$_SESSION['user']}' AND `is_finished_for_initiator`=0";
$query = $connection_handler->prepare($sql); 
$query->execute();
$sessioner_initiator_active_dialogs_count = $query->fetchAll(PDO::FETCH_ASSOC);  
$sessioner_initiator_active_dialogs_count = $sessioner_initiator_active_dialogs_count[0]['sessioner_initiator_count'];   

/* ИЗВЛЕКАЕМ КОЛИЧЕСТВО ЗАВЕРШЕННЫХ ДИАЛОГОВ В КОТОРЫХ СЕССИОННЫЙ ЯВЛЯЕТСЯ ИНИЦИАТОРОМ */
$sql = "SELECT COUNT(*) AS `sessioner_initiator_finished_dialogs_count` FROM `dialogs` WHERE `initiator`='{$_SESSION['user']}' AND `is_finished_for_initiator`=1";
$query = $connection_handler->prepare($sql); 
$query->execute();
$sessioner_initiator_finished_dialogs_count = $query->fetchAll(PDO::FETCH_ASSOC);  
$sessioner_initiator_finished_dialogs_count = $sessioner_initiator_finished_dialogs_count[0]['sessioner_initiator_finished_dialogs_count'];   

/* ИЗВЛЕКАЕМ ВСЕ ДИАЛОГИ В КОТОРЫХ СЕССИОННЫЙ ЯВЛЯЕТСЯ ИНИЦИАТОРОМ */
$sql = "SELECT COUNT(*) AS `sessioner_initiator_count_all` FROM `dialogs` WHERE `initiator`='{$_SESSION['user']}'";
$query = $connection_handler->prepare($sql); 
$query->execute();
$sessioner_initiator_count_all = $query->fetchAll(PDO::FETCH_ASSOC);  
$sessioner_initiator_count_all = $sessioner_initiator_count_all[0]['sessioner_initiator_count_all'];   

   ?>
   
<div id="first" class="tab-pane fade">
Активные  <?php echo "<span style = 'text-decoration:underline;'>" . $sessioner_initiator_active_dialogs_count . "</span>"; ?> | Завершенные <?php echo "<span style = 'text-decoration:underline;'>" . $sessioner_initiator_finished_dialogs_count . "</span><br />" ?>
Всего <?php echo  "<span style = 'text-decoration:underline;'>" . $sessioner_initiator_count_all . '</span>';?>
<?php
/*/////////////////////////////////////////////////СЕССИОННЫЙ ИНИЦИАТОР////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/

/* ИЗВЛЕКАЕМ ДИАЛОГИ В КОТОРЫХ СЕССИОННЫЙ ЯВЛЯЕТСЯ ИНИЦИАТОРОМ */
$sql = "SELECT * FROM `dialogs` WHERE `initiator`='{$_SESSION['user']}' ORDER BY `date` DESC";
$query = $connection_handler->prepare($sql); 
$query->execute();
$sessioner_initiator = $query->fetchAll(PDO::FETCH_ASSOC);  

if(!empty($sessioner_initiator)){ // ЕСЛИ ДИАЛОГИ В КОТОРЫХ СЕССИОННЫЙ ЯВЛЯЕТСЯ ИНИЦИАТОРОМ

/*+++++++++++++++++++++++++++++++++АКТИВНЫЕ ДИАЛОГИ СЕССИОННОГО ИНИЦИАТОРА++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/* ИЗВЛЕКАЕМ КОЛИЧЕСТВО ДИАЛОГОВ В КОТОРЫХ СЕССИОННЫЙ ЯВЛЯЕТСЯ ИНИЦИАТОРОМ */
$sql = "SELECT COUNT(*) AS `sessioner_initiator_count` FROM `dialogs` WHERE `initiator`='{$_SESSION['user']}' AND `is_finished_for_initiator`=0";
$query = $connection_handler->prepare($sql); 
$query->execute();
$sessioner_initiator_active_dialogs_count = $query->fetchAll(PDO::FETCH_ASSOC);  
$sessioner_initiator_active_dialogs_count = $sessioner_initiator_active_dialogs_count[0]['sessioner_initiator_count'];

if($sessioner_initiator_active_dialogs_count > 0){
    
/* ИЗВЛЕКАЕМ АКТИВНЫЕ ДИАЛОГИ В КОТОРЫХ СЕССИОННЫЙ ЯВЛЯЕТСЯ ИНИЦИАТОРОМ */
$sql = "SELECT *  FROM `dialogs` WHERE `initiator`='{$_SESSION['user']}' AND `is_finished_for_initiator`=0  ORDER BY `date` DESC";
$query = $connection_handler->prepare($sql); 
$query->execute();
$sessioner_initiator_active_dialogs = $query->fetchAll(PDO::FETCH_ASSOC);  

$sessioner_initiator_active_dialogs_output = "";

for($i = 0; $i < $sessioner_initiator_active_dialogs_count; $i++){

            /* ----------------------------------ИНИЦИАТОР (СЕССИОННЫЙ) СВЕРХУ--------------------------------------------------------------------------------------- */
            
             /* ИЗВЛЕКАЕМ АВАТАР ИНИЦИАТОРА ДИАЛОГА */
            $sql = "SELECT `avatar` AS `sessioner_initiator_active_dialogs_initiator_avatar` FROM `additional_info` WHERE `nickname`='{$_SESSION['user']}'";
            $query = $connection_handler->prepare($sql);
            $query->execute();
            $sessioner_initiator_active_dialogs_initiator_avatar = $query->fetchAll(PDO::FETCH_ASSOC);  
            $sessioner_initiator_active_dialogs_initiator_avatar = $sessioner_initiator_active_dialogs_initiator_avatar[0]['sessioner_initiator_active_dialogs_initiator_avatar'];       
            
            /* ИЗВЛЕКАЕМ ДАТУ НАЧАЛА ДИАЛОГА */
            $sql = "SELECT `date` AS `sessioner_initiator_active_dialogs_dialog_begin` FROM `date_of_new_dialog` WHERE `dialog` = {$sessioner_initiator_active_dialogs[$i]['this_id']}";
            $query = $connection_handler->prepare($sql);
            $query->execute();
            $sessioner_initiator_active_dialogs_dialog_begin = $query->fetchAll(PDO::FETCH_ASSOC);  
            $sessioner_initiator_active_dialogs_dialog_begin = $sessioner_initiator_active_dialogs_dialog_begin[0]['sessioner_initiator_active_dialogs_dialog_begin'];
            
            /* ИЗВЛЕКАЕМ ПОСЛЕДНЕЕ СООБЩЕНИЕ ДИАЛОГА */
            $sql = "SELECT `message` AS `sessioner_initiator_active_dialogs_last_message` FROM `dialog_messages` WHERE `dialog` = {$sessioner_initiator_active_dialogs[$i]['this_id']} AND `sender`='{$_SESSION['user']}' ORDER BY `this_id` DESC";
            $query = $connection_handler->prepare($sql);
            $query->execute();
            $sessioner_initiator_active_dialogs_last_message = $query->fetchAll(PDO::FETCH_ASSOC);  
            $sessioner_initiator_active_dialogs_last_message = $sessioner_initiator_active_dialogs_last_message[0]['sessioner_initiator_active_dialogs_last_message'];  
            
            /* ИЗВЛЕКАЕМ ДАТУ ПОСЛЕДНЕГО СООБЩЕНИЯ ДИАЛОГА */
            $sql = "SELECT `date` AS `sessioner_initiator_active_dialogs_date_of_last_message` FROM `dialog_messages` WHERE `sender` = '{$_SESSION['user']}' AND `dialog`={$sessioner_initiator_active_dialogs[$i]['this_id']} ORDER BY `this_id` DESC";
            $query = $connection_handler->prepare($sql);
            $query->execute();
            $sessioner_initiator_active_dialogs_date_of_last_message = $query->fetchAll(PDO::FETCH_ASSOC);  
            $sessioner_initiator_active_dialogs_date_of_last_message = $sessioner_initiator_active_dialogs_date_of_last_message[0]['sessioner_initiator_active_dialogs_date_of_last_message'];  
            
            /* ----------------------------------ПРИСОЕДИНЕННЫЙ СНИЗУ--------------------------------------------------------------------------------------- */
            
            /* ИЗВЛЕКАЕМ ИМЯ ПРИСОЕДИНЕННОГО */
            $sql = "SELECT `joined` AS `sessioner_initiator_active_dialogs_joined` FROM `dialogs` WHERE `this_id`={$sessioner_initiator_active_dialogs[$i]['this_id']}";
            $query = $connection_handler->prepare($sql);
            $query->execute();
            $sessioner_initiator_active_dialogs_joined = $query->fetchAll(PDO::FETCH_ASSOC);  
            $sessioner_initiator_active_dialogs_joined = $sessioner_initiator_active_dialogs_joined[0]['sessioner_initiator_active_dialogs_joined'];
            
            /* ИЗВЛЕКАЕМ АВАТАР ПРИСОЕДИНЕННОГО */
            $sql = "SELECT `avatar` AS `sessioner_initiator_active_dialogs_joined_avatar` FROM `additional_info` WHERE `nickname`='{$sessioner_initiator_active_dialogs_joined}'";
            $query = $connection_handler->prepare($sql);
            $query->execute();
            $sessioner_initiator_active_dialogs_joined_avatar = $query->fetchAll(PDO::FETCH_ASSOC);  
            $sessioner_initiator_active_dialogs_joined_avatar = $sessioner_initiator_active_dialogs_joined_avatar[0]['sessioner_initiator_active_dialogs_joined_avatar']; 
            
            /* ИЗВЛЕКАЕМ ПОСЛЕДНЕЕ СООБЩЕНИЕ ПРИСОЕДИНЕННОГО */
            $sql = "SELECT `message` AS `sessioner_initiator_active_dialogs_joined_last_message` FROM `dialog_messages` WHERE `sender`='{$sessioner_initiator_active_dialogs_joined}' ORDER BY `this_id` DESC";
            $query = $connection_handler->prepare($sql);
            $query->execute();
            $sessioner_initiator_active_dialogs_joined_last_message = $query->fetchAll(PDO::FETCH_ASSOC);  
            $sessioner_initiator_active_dialogs_joined_last_message = $sessioner_initiator_active_dialogs_joined_last_message[0]['sessioner_initiator_active_dialogs_joined_last_message'];  
            
            /* ИЗВЛЕКАЕМ ДАТУ ПОСЛЕДНЕГО СООБЩЕНИЯ ПРИСОЕДИНЕННОГО */
            $sql = "SELECT `date` AS `sessioner_initiator_active_dialogs_joined_last_message_date` FROM `dialog_messages` WHERE `sender`='{$sessioner_initiator_active_dialogs_joined}' ORDER BY `this_id` DESC";
            $query = $connection_handler->prepare($sql);
            $query->execute();
            $sessioner_initiator_active_dialogs_joined_last_message_date = $query->fetchAll(PDO::FETCH_ASSOC);  
            $sessioner_initiator_active_dialogs_joined_last_message_date = $sessioner_initiator_active_dialogs_joined_last_message_date[0]['sessioner_initiator_active_dialogs_joined_last_message_date'];  
            
                $sessioner_initiator_active_dialogs_output .= '<section class = dialog id=' . $sessioner_initiator_active_dialogs[$i]['this_id'] . '  onclick = window.location.replace("dialog.php?id=' . $sessioner_initiator_active_dialogs[$i]['this_id'] . '") >
            <div class = initiator>
            <div class =  initiator_img_container>    
            <img class = initiator_img  src = users/' . $sessioner_initiator_active_dialogs_initiator_avatar . ' /><br />
            </div>
            <div class = "initiator_nick_container">
            <span class = initiator_nick><a href = user.php?zs=' . $_SESSION['user'] . '>' .  $_SESSION['user'] . '</a></span>
            <span class = initiator_dialog_begin>' .  $sessioner_initiator_active_dialogs_dialog_begin . '</span>
            
            </div>
            <div class = initiator_last_message_container>
            <div class = initiator_last_message>' .
            $sessioner_initiator_active_dialogs_last_message .
            '</div>
            <span class = initiator_last_message_date>' . $sessioner_initiator_active_dialogs_date_of_last_message . '</span>
            </div>    
            </div>
            <div class = joined>
            <div class = joined_nick_and_img_container_first> 
            <img class = joined_img  src = users/' . $sessioner_initiator_active_dialogs_joined_avatar  . ' />
            <img class = new_message_img src = imgs/closed_box.png>
            <span class = joined_nick_first_section><a href = user.php?zs=' . $sessioner_initiator_active_dialogs_joined  . '>' . $sessioner_initiator_active_dialogs_joined . '</a></span><br />
            <span class =  joined_user_online_first_section>'. $joined_user_online .'</span>
            </div>
            
            <div class = joined_last_message_container>
            <div class = joined_last_message_content>' .
                $sessioner_initiator_active_dialogs_joined_last_message .
            '</div>
            <span class = joined_last_message_date>' . $sessioner_initiator_active_dialogs_joined_last_message_date . '</span>
            </div>
            </div>
            
            </section>';   

        }//for($i = 0; $i < $sessioner_initiator_count; $i)
echo $sessioner_initiator_active_dialogs_output;     
}//if($sessioner_initiator_count > 0)   

/*+++++++++++++++++++++++++++++++++ЗАВЕРШЕННЫЕ ДИАЛОГИ СЕССИОННОГО ИНИЦИАТОРА++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/* ИЗВЛЕКАЕМ  ЗАВЕРШЕННЫЕ ДИАЛОГИ В КОТОРЫХ СЕССИОННЫЙ ЯВЛЯЕТСЯ ИНИЦИАТОРОМ */ 
$sql = "SELECT *  FROM `dialogs` WHERE `initiator`='{$_SESSION['user']}' AND `is_finished_for_initiator` = 1  ORDER BY `date` DESC";
$query = $connection_handler->prepare($sql); 
$query->execute();
$sessioner_initiator_finished_dialogs = $query->fetchAll(PDO::FETCH_ASSOC);  

if(!empty($sessioner_initiator_finished_dialogs)){

/* ИЗВЛЕКАЕМ КОЛИЧЕСТВО ЗАВЕРШЕННЫХ ДИАЛОГОВ В КОТОРЫХ СЕССИОННЫЙ ЯВЛЯЕТСЯ ИНИЦИАТОРОМ */
$sql = "SELECT COUNT(*) AS `sessioner_initiator_finished_dialogs_count` FROM `dialogs` WHERE `initiator`='{$_SESSION['user']}' AND `is_finished_for_initiator`=1";
$query = $connection_handler->prepare($sql); 
$query->execute();
$sessioner_initiator_finished_dialogs_count = $query->fetchAll(PDO::FETCH_ASSOC);  
$sessioner_initiator_finished_dialogs_count = $sessioner_initiator_finished_dialogs_count[0]['sessioner_initiator_finished_dialogs_count'];   

if($sessioner_initiator_finished_dialogs_count > 0){ // ЗАВЕРШЕННЫЕ ДИАЛОГИ ЕСТЬ

$sessioner_initiator_finished_dialogs_output = "";    

for($i = 0; $i < $sessioner_initiator_finished_dialogs_count; $i++){

            /* ----------------------------------ИНИЦИАТОР (СЕССИОННЫЙ) СВЕРХУ--------------------------------------------------------------------------------------- */
            
             /* ИЗВЛЕКАЕМ АВАТАР ИНИЦИАТОРА ДИАЛОГА */
            $sql = "SELECT `avatar` AS `sessioner_initiator_finished_dialogs_initiator_avatar` FROM `additional_info` WHERE `nickname`='{$_SESSION['user']}'";
            $query = $connection_handler->prepare($sql);
            $query->execute();
            $sessioner_initiator_finished_dialogs_initiator_avatar = $query->fetchAll(PDO::FETCH_ASSOC);  
            $sessioner_initiator_finished_dialogs_initiator_avatar = $sessioner_initiator_finished_dialogs_initiator_avatar[0]['sessioner_initiator_finished_dialogs_initiator_avatar'];       
            
            /* ИЗВЛЕКАЕМ ДАТУ НАЧАЛА ДИАЛОГА */
            $sql = "SELECT `date` AS `sessioner_initiator_finished_dialogs_dialog_begin` FROM `date_of_new_dialog` WHERE `dialog` = {$sessioner_initiator_finished_dialogs[$i]['this_id']}";
            $query = $connection_handler->prepare($sql);
            $query->execute();
            $sessioner_initiator_finished_dialogs_dialog_begin = $query->fetchAll(PDO::FETCH_ASSOC);  
            $sessioner_initiator_finished_dialogs_dialog_begin = $sessioner_initiator_finished_dialogs_dialog_begin[0]['sessioner_initiator_finished_dialogs_dialog_begin'];
            
            /* ИЗВЛЕКАЕМ ПОСЛЕДНЕЕ СООБЩЕНИЕ ДИАЛОГА */
            $sql = "SELECT `message` AS `sessioner_initiator_finished_dialogs_last_message` FROM `dialog_messages` WHERE `dialog` = {$sessioner_initiator_finished_dialogs[$i]['this_id']} AND `sender`='{$_SESSION['user']}' ORDER BY `this_id` DESC";
            $query = $connection_handler->prepare($sql);
            $query->execute();
            $sessioner_initiator_finished_dialogs_last_message = $query->fetchAll(PDO::FETCH_ASSOC);  
            $sessioner_initiator_finished_dialogs_last_message = $sessioner_initiator_finished_dialogs_last_message[0]['sessioner_initiator_finished_dialogs_last_message'];  
            
            /* ИЗВЛЕКАЕМ ДАТУ ПОСЛЕДНЕГО СООБЩЕНИЯ ДИАЛОГА */
            $sql = "SELECT `date` AS `sessioner_initiator_finished_dialogs_date_of_last_message` FROM `dialog_messages` WHERE `sender` = '{$_SESSION['user']}' AND `dialog`={$sessioner_initiator_finished_dialogs[$i]['this_id']} ORDER BY `this_id` DESC";
            $query = $connection_handler->prepare($sql);
            $query->execute();
            $sessioner_initiator_finished_dialogs_date_of_last_message = $query->fetchAll(PDO::FETCH_ASSOC);  
            $sessioner_initiator_finished_dialogs_date_of_last_message = $sessioner_initiator_finished_dialogs_date_of_last_message[0]['sessioner_initiator_finished_dialogs_date_of_last_message'];  
            
            /* ----------------------------------ПРИСОЕДИНЕННЫЙ СНИЗУ--------------------------------------------------------------------------------------- */
            /* ИЗВЛЕКАЕМ ИМЯ ПРИСОЕДИНЕННОГО */
            $sql = "SELECT `joined` AS `sessioner_initiator_finished_dialogs_joined` FROM `dialogs` WHERE `this_id`={$sessioner_initiator_finished_dialogs[$i]['this_id']}";
            $query = $connection_handler->prepare($sql);
            $query->execute();
            $sessioner_initiator_finished_dialogs_joined = $query->fetchAll(PDO::FETCH_ASSOC);  
            $sessioner_initiator_finished_dialogs_joined = $sessioner_initiator_finished_dialogs_joined[0]['sessioner_initiator_finished_dialogs_joined'];
            
            /* ИЗВЛЕКАЕМ АВАТАР ПРИСОЕДИНЕННОГО */
            $sql = "SELECT `avatar` AS `sessioner_initiator_finished_dialogs_joined_avatar` FROM `additional_info` WHERE `nickname`='{$sessioner_initiator_finished_dialogs_joined}'";
            $query = $connection_handler->prepare($sql);
            $query->execute();
            $sessioner_initiator_finished_dialogs_joined_avatar = $query->fetchAll(PDO::FETCH_ASSOC);  
            $sessioner_initiator_finished_dialogs_joined_avatar = $sessioner_initiator_finished_dialogs_joined_avatar[0]['sessioner_initiator_finished_dialogs_joined_avatar']; 
            
            /* ИЗВЛЕКАЕМ ПОСЛЕДНЕЕ СООБЩЕНИЕ ПРИСОЕДИНЕННОГО */
            $sql = "SELECT `message` AS `sessioner_initiator_finished_dialogs_joined_last_message` FROM `dialog_messages` WHERE `sender`='{$sessioner_initiator_finished_dialogs_joined}' ORDER BY `this_id` DESC";
            $query = $connection_handler->prepare($sql);
            $query->execute();
            $sessioner_initiator_finished_dialogs_joined_last_message = $query->fetchAll(PDO::FETCH_ASSOC);  
            $sessioner_initiator_finished_dialogs_joined_last_message = $sessioner_initiator_finished_dialogs_joined_last_message[0]['sessioner_initiator_finished_dialogs_joined_last_message'];  
            
            /* ИЗВЛЕКАЕМ ДАТУ ПОСЛЕДНЕГО СООБЩЕНИЯ ПРИСОЕДИНЕННОГО */
            $sql = "SELECT `date` AS `sessioner_initiator_finished_dialogs_joined_last_message_date` FROM `dialog_messages` WHERE `sender`='{$sessioner_initiator_finished_dialogs_joined}' ORDER BY `this_id` DESC";
            $query = $connection_handler->prepare($sql);
            $query->execute();
            $sessioner_initiator_finished_dialogs_joined_last_message_date = $query->fetchAll(PDO::FETCH_ASSOC);  
            $sessioner_initiator_finished_dialogs_joined_last_message_date = $sessioner_initiator_finished_dialogs_joined_last_message_date[0]['sessioner_initiator_finished_dialogs_joined_last_message_date'];  
            
            $sessioner_initiator_finished_dialogs_output .=  '<section class = dialog id=' . $sessioner_initiator_finished_dialogs[$i]['this_id'] . '  onclick = window.location.replace("dialog.php?id=' . $sessioner_initiator_finished_dialogs[$i]['this_id'] . '") >
            
            <div class = initiator>
            <div class =  initiator_img_container>    
            <img class = initiator_img  src = users/' .$sessioner_initiator_finished_dialogs_initiator_avatar . ' /><br />
            </div>
            <div class = "initiator_nick_container">
            <span class = initiator_nick><a href = users.php?zs=' . $_SESSION['user'] . '>' .  $_SESSION['user'] . '</a></span>
            <span class = initiator_dialog_begin>' .  $sessioner_initiator_finished_dialogs_dialog_begin. '</span>
            </div>
            <div class = initiator_last_message_container>
            <div class = initiator_last_message>' .
            $sessioner_initiator_finished_dialogs_last_message .
            '</div>
            <span class = initiator_last_message_date>' . $sessioner_initiator_finished_dialogs_date_of_last_message . '</span>
            </div>    
            </div>
            <div class = joined>
            <div class = joined_nick_and_img_container_first> 
            <img class = joined_img  src = users/' . $sessioner_initiator_finished_dialogs_joined_avatar . ' />
            <span class = joined_nick_first_section><a href = user.php?zs=' . $sessioner_initiator_finished_dialogs_joined . '>' .$sessioner_initiator_finished_dialogs_joined . '</a></span><br />
            <span class =  joined_user_online_first_section>'. $joined_user_online .'</span>
            </div>
            
            <div class = joined_last_message_container>
            <div class = joined_last_message_content>' .
              $sessioner_initiator_finished_dialogs_joined_last_message .
            '</div>
            <span class = joined_last_message_date>' . $sessioner_initiator_finished_dialogs_joined_last_message_date . '</span>
            </div>
            </div>
            
            </section>';   
           
}//for($i = 0; $i < $sessioner_initiator_finished_dialogs_count; $i++)


echo $sessioner_initiator_finished_dialogs_output;    
        } //if($sessioner_initiator_finished_dialogs_count > 0)   
} // if(empty($sessioner_initiator_finished_dialogs))
 
/*************************************************************************************************************************************************************************************************/   
    
} //if(!empty($sessioner_initiator))

?>

</div>            
      
        </div> <!-- <div class="tab-content"> -->
    </div><!--  div class = container -->
</div> <!-- class=row -->
</main>   

<script async>
(function find_link(){
var main = document.getElementsByTagName("main");
var user_chat = document.getElementById("user_chat_messages");
main[0].innerHTML = main[0].innerHTML.replace(/((http:|https:)\/\/\S+)/g, '<a href="$1" target="_blank">$1</a>');
user_chat.innerHTML = user_chat.innerHTML.replace(/((http:|https:)\/\/\S+)/g, '<a href="$1" target="_blank">$1</a>');
})();
</script>


</body>    

</html>    

<?php ob_end_flush(); ?>
