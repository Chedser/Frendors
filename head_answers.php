<?php 
ob_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

error_reporting(0);

/* ПОЛУЧАЕМ ВОПРОС И ОТВЕТ ИЗ БАЗЫ */    
$sql = "SELECT question, answer, date from head_answers ORDER BY this_id DESC"; 
    $query = $connection_handler->prepare($sql);
    $query->execute(); 
$result = $query->fetchAll(PDO::FETCH_ASSOC); // Получаем строки

/* КОЛИЧЕСТВО ВОПРОСОВ В БАЗЕ */    
$sql = "SELECT COUNT(*) AS num_rows from head_answers"; // Извлекаем все сообщения на стену из базы 
    $query = $connection_handler->prepare($sql);
    $query->execute();
$num_rows = $query->fetchAll(PDO::FETCH_ASSOC); // Получаем двумерный массив строк
 
$question_count  = $num_rows[0]['num_rows']; // Количество комментариев        

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
    <title>Голова знает</title>    
<meta charset = "utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name = "description" content = "Голова знает" />
<meta name="keywords" content = "голова" / >
<script src="../bootstrap/js/jquery.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
<link rel = "stylesheet" href = "../css/normalize.css"  type = "text/css" />

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
    width: 1000px;
   background-color:#79C753; 
    margin:0 auto;
    height:100%;
 }

main {
    padding: 10px;
    border-left: 2px double blue;
    border-right: 2px double blue;
    width:80%;
    float:right;
    margin-left:-15px;
    padding-bottom: 90px;
    min-height:820px;
    }

header { /* Шапка */
position:relative;
right: 55px;
top:40px;
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
$active_button = "";

if($login == $login_session){
$active_button = "active";    
}

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
echo 
'<header style = "color:white;height:60px;">
<nav> 
    <img src = "../../user_page_logo.png" height = "40" style = "position:relative;top:-45px;left:50px;"/>
    <ul style = "display:inline-block; list-style:none; position:relative;top:-30px; left:130px; color:white; width:600px;margin-right:40px;">
        <li  data-placement="bottom" data-toggle="tooltip" title = "Ваша страница" role = "button"><a href = "../../user.php?zs=' . $_SESSION['user'] . '"><img class = "header_items_img" src = "../../imgs/header/bumazhka.png"><br /><span>Бумажка</span></a></li>
        <li  data-placement="bottom" data-toggle="tooltip" title = "Друзья" role = "button"><a href = "../../bros.php?zs=' .$_SESSION['user'] . '"><img class = "header_items_img" src = "../../imgs/header/bratki.png"><br /><span>Братки ' . $new_friend . '</span></a></li>
        <li  data-placement="bottom" data-toggle="tooltip" title = "Сообщения" role = "button"><a href = "../../dialogs.php"><img class = "header_items_img" src = "../../imgs/header/vdvoem_tuta.png"><br /><span>Вдвоем тута ' . $new_message . '</span></a></li>
        <li  data-placement="bottom" data-toggle="tooltip" title = "Чат" role = "button"><a href = "../../chat.php"><img class = "header_items_img" style = "width:45px;" src = "../../imgs/header/mnogo_tuta.png"><br /><span>Много тута </span></a></li>
        <li  data-placement="bottom" data-toggle="tooltip" title = "Решил немножко поравзвлечь" role = "button"><a href = "../../fun_select.php"><img class = "header_items_img" src = "../../imgs/header/igry.png"><br /><span>Шашки</span></a></li>
        <li  data-placement="bottom" data-toggle="tooltip" title = "Все ж мы люди" role = "button"><a href = "malafil.php"><img class = "header_items_img" src = "../../imgs/header/malafit.png"><br /><span>Малафить</span></a></li>
      </ul>    
<section style = "display:inline-block; position:relative;top:-30px; left:70px; text-align:center;" data-placement="right" data-placement="bottom" data-toggle="tooltip" title = "Да ладно, ну чо ты как этот прям" role = "button">
     <a href = "../../exit.php"><img class = "header_items_img" src = "../../imgs/header/po_trube.png"><br /><span>По трубе</span></a>
</section>
</nav>    

</header>';

}
?>

<table style = "color:white; border-collapse:separate; border-spacing:5px 0px">
<tr>
    <td style = "font-size: 20px; text-decoration:underline">Задайте вопрос Голове</td>
    <td><img src = "head.jpg" width = "30" height = "30"/></td>
</tr>
<tr>
    <td style = "color:">Джин ты ебаный</td>
    <td></td>
</tr>    
<tr>
    <td><p style = "color:gray; font-size:10px;">Максимум 1000 символов</p></td>     
    <td></td>    
</tr>
</table>
    

<textarea id = "head_answer_textarea" placeholder = "Голова знает" style = "resize:none" cols = "70" rows = "10" oninput = "leaved_symbols()" onfocus = "this.placeholder = ''" onblur = "this.placeholder = 'Голова знает'" maxlength = "1000"></textarea><br />
    <button type = "submit" class = "btn btn-primary btn-sm" style = "display:block; float:left; margin-right: 375px;" onclick = "question_head()">Спросить</button>
    <p style = "color: white; display: block;position:relative; right:30px;color:gray; font-size:12px">Осталось: 
    <span id = "leaved_symbols">1000</span></p>
<p id = "empty_input_field" style = "color:yellow"></p>

 
<hr />
<div id = "answers">
    <span style = "color: white" >Ответы: </span><span style = "color: blue"> <?php echo $question_count ?></span>

<?php

$answers = "";

if($question_count > 0){ /* ВЫВОДИМ ОТВЕТЫ */

for($i = 0; $i < $question_count; $i++ ){
$answer = $result[$i]['answer'];
switch($answer){
    case 'yes': $answer = "Даааа";
                break;
    case 'no': $answer = "НЕТ!";
               break;
     case 'hui': $answer = "Хуй блять";
               break;
    default: $answer = "Тебе позвонят";    

            }    
 $answers .=   '<table style = "width:70%; border-bottom:1px solid white;">
<tr><td>Вопрос&emsp;&gt;&gt;&gt;</td></tr>    
<tr style = "color: blue; word-break: break-all;"><td>' .$result[$i]['question'] . '</td></tr>
<tr ><td>Ответ&emsp;&gt;&gt;&gt;&emsp;<span style = "color:blue">' . $answer . '</span></td></tr>
<tr style = "color: gray; font-size: 12px;"><td>' . $result[$i]['date'] . '</td></tr>
    </table>';       
        }
 }
 
echo $answers;
?>
</div>
    
</main>   
<script>

function leaved_symbols(){
var show_leaved_symbols = document.getElementById("leaved_symbols"); // Показываем количество оставшихся символов
var head_answer_textarea = document.getElementById("head_answer_textarea"); // Текстовое поле
var sym_counter = 1000; // Количество оставшихся символов
var input_length = head_answer_textarea.value.length; // Количество введеных символов
var leaved_sym = sym_counter - input_length; // Количество введеных символов     
show_leaved_symbols.innerHTML = leaved_sym;    
}

function question_head(){
var head_answer_textarea = document.getElementById("head_answer_textarea");
var empty_input_field = document.getElementById("empty_input_field"); 
var answers = document.getElementById("answers"); 
var xmlhttp = new XMLHttpRequest();

if(head_answer_textarea.value === "" || head_answer_textarea.value === null || head_answer_textarea.value.match(/^\s+$/g)){
empty_input_field.innerHTML = "Вы не задали вопрос Голове";
return;    
}

xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                window.location.reload();
            }
        };
xmlhttp.open("GET", "../handlers/head_answers_handler.php?head_answer=" + head_answer_textarea.value.trim(), true);
xmlhttp.send();
head_answer_textarea.value = "";
}
    
    
</script>    
    
</body>    

</html>    
<?php ob_end_flush();  ?>