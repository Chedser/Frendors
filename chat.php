<?php ob_start();
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);        

$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();


function session_isset(){ // Пользователь вошел
if(!empty($_SESSION['user'])){ // Пользователь вошел через логин-пароль
return true;
} else {
return false;
}
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Чат</title>
    <meta charset = 'utf-8' />
    <link rel = "stylesheet" href = "css/normalize.css"  type = "text/css" />
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name = "description" content = "Социальная сеть для поехавших и поклонников Светланы Басковой. У нас есть чат, малафильня, братки... Да всё что хочешь" />
<meta name="keywords" content = "зеленый слоник, бердянск,больничка, сергей пахомов, владимир епифанцев,александр маслаев,александр осмоловский,сладкий хлеб,азов,украина,путин,политика" / >
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
    font-size:20px;
 }

main {
    padding: 10px;
    border-left: 2px double blue;
    border-right: 2px double blue;
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

#wrapper{
border: 1px solid #a4aa8f;    
margin-left:15px;
margin-top: 10px;
}

#messages {
overflow-y:auto; 
height:665px; 
border:1px solid white;
margin:8px;
margin-bottom:12px;
word-break:break-all;
padding:10px    
}    
  
a {
color:blue;    
} 
 
header { /* Шапка */
margin-bottom: 5px;
height:80px;
margin-top:50px;
margin-right:10px;
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

<body onload = "resize_none(); scrollBottom();">

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

<main class = "container-fluid">
<?php if(session_isset()){ // авторизовались

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
echo '<a href = user.php?zs=' . $_SESSION['user'] . '>' . $_SESSION['user'] . '</a>';
}
?>

<div id = "wrapper" class = "row">
<table style = "color:white; border-collapse:separate;">
<tr style = "height:700px;">
    <td>
    <div id = "messages"> <!-- Здесь отображаются сообщения -->
<?php 

$sql = "SELECT nickname, message FROM chat  ORDER BY time ASC"; 
    $query = $connection_handler->prepare($sql);
    $query->execute();
$data = $query->fetchAll(PDO::FETCH_ASSOC); // Все сообщения

$sql = "SELECT COUNT(id) AS num_rows from chat"; // Извлекаем все сообщения на стену из базы 
    $query = $connection_handler->prepare($sql);
    $query->execute();
$num_rows = $query->fetchAll(PDO::FETCH_ASSOC); // Получаем двумерный массив строк
 
$messages_count  = $num_rows[0]['num_rows']; // Количество сообщений    

$messages = "";
$doebat_function = "";

if(!empty($_SESSION['user'])){
    $doebat_function = "<span style = 'color:gray; font-size:10px;cursor:pointer;'" . 
    " onclick = " . "doebat('" . str_replace(" ", "_", $data[$i]['nickname']) . "')" . ">доебать</span>";
}

if($messages_count > 0) { // Сообщения есть в базе

    for($i = 0; $i < $messages_count; $i++){ // Выводим сообщения
     
    if(empty($data[$i])){ // Пользователь не отправлял этих сообщений. Отправлял другой
    $data[$i] = null;    
    }
   
    $messages .= "<section><span style = 'color:green'><a href = '../user.php?zs=" . $data[$i]['nickname'] . 
    "' style = 'display:inline-block;color:blue;' title = 'Браток' >{$data[$i]['nickname']}</a></span>" . $doebat_function  .  "&ensp;<span style = 'color:black'>{$data[$i]['message']}</span></section>";
   
    }
}

echo $messages;

$connection_handler = null;        
        
?>
  
    </div>
    </td>

</tr>

<?php

if(!empty($_SESSION['user'])) {
echo  '<tr style = "height:60px;">
    <td colspan = "2">
        <textarea style = "color:black;width:90%;resize:none;" autofocus = "autofocus" maxlength = "300" id = "message" rows = "3" onkeypress = "send_message_enter(event);"></textarea>
     </td>
    <td style = "border-bottom:none"></td>
</tr>
    <tr>
        <td rowspan = "2"><button type = "button" сlass = "btn btn-success btn-md" style = "color:blue; margin:5px; margin-left:28%;" onclick = "sendMessage()">Ахуенно</button></td>
        <td colspan = "2"></td>
    </tr>'; 
    
}else{
    echo "<tr>
                <td colspan = 2><a href = index.php>Авторизуйтесь чтобы отправить сообщение</a></td>
                  <td style = border-bottom:none></td>
            </tr>";
}
    ?>  
    
    </table>    
</div>
</main>    
<script>

function moveCaretToStart(inputObject)
{
if (inputObject.selectionStart)
{
 inputObject.setSelectionRange(0,0);
 inputObject.focus();
}
}

function scrollBottom(){
var messages_field = document.getElementById("messages"); 
messages_field.scrollTop = messages_field.scrollHeight;
}        
    
function resize_none(){
var textarea = document.getElementById("message");
textarea.style.resize = "none";  
textarea.style.margin = "10px";     
textarea.style.marginLeft = "17px";
textarea.style.overflowY = "hidden";      
}
    
function sendMessage(){
var nickname = "<?php echo $_SESSION['user']; ?>"; 
var message = document.getElementById("message");
var messages_field = document.getElementById("messages");    
var response = "";

if(message.value.trim() === "" || message.value.match(/^\s+$/g)){return;}  
    
var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function(){
if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
window.location.reload();
    }
}

xmlhttp.open("GET", "handlers/chat_handler.php?message=" + message.value.trim(), true);
xmlhttp.send();
moveCaretToStart(message);
message.value = "";
}
  
function doebat(username){
var textarea = document.getElementById("message");  
textarea.innerHTML = username + ", "; 
} 

function send_message_enter(event){
     var char = event.which || event.keyCode;
if(char == 13){
sendMessage();
      }
}
     
</script>    
    
<script async>
(function find_link(){
var chat = document.getElementById("messages");
chat.innerHTML = chat.innerHTML.replace(/((http:|https:)\/\/\S+)/g, '<a href="$1" target="_blank">$1</a>');
})();
</script>
    
</body>    
</html>
<?php ob_end_flush(); ?>