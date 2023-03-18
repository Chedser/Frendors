<?php
ob_start();

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//ini_set('display_errors', 'On');

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
<title>Хочешь в шашки?</title>
<meta charset = "utf-8" />
<script src="bootstrap/js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<link rel = "stylesheet" href = "css/normalize.css"  type = "text/css" />
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
    background-color:#cefdce;
    margin:0 auto;
    height:100%;
    font-size:20px;
 }

main {
    padding: 10px;
    width:99%;
    }

img {
border-radius:10px;	
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
word-wrap:break-word;

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

<main class = "container-fluid">
    
    <div class = "row">
    
    <style>
        
        /* TopNav  */

.topnav {
  overflow: hidden;
  background-color: #4D636F;
  position:fixed;
  width:100%;
  z-index:10;
  top:0;
}

.topnav a {
  display: inline-block;
  color: #f2f2f2;
  padding: 14px 2.5%;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:not(:first-child):hover {
  background-color: #ddd;
  color: black;
}

.topnav a.active {
  background-color: #4CAF50; /* Зеленый */
  color: white;
}

 .topnav a.icon {
    float: right;
    display: block;
  }
  
  .topnav_img{
      width:25px;
      height:25px;
  }
  
  .topnav_img:hover{
       background-color: #ddd;
       cursor:pointer;
       }
       
    .shift-bage{
        position:relative;
        right:15px;
        margin-right:-15px;
    }  
 
/*** DropDown ***/ 
    
#drp_dn{
display:none;
text-align:justify;
}

#drp_dn a{
    display:inline-block;
}

.green-spot {
  display: none;
  position: relative;
  right: 5px;
  top: 3px;
  width: 10px;
  height: 10px;
  border-radius: 50%;

}

    </style>
    
<?php 

$topnav_content = "";


if(!empty($_SESSION['user'])){
    
    echo '<script>
function dropDown() {
  var x = document.getElementById("drp_dn");
  var y = document.getElementsByClassName("shift-bage");
  
  if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
        
        for (var i = 0; i < y.length; i++) {
          y[i].className += " w3-hide";
}

  } else { 
    x.className = x.className.replace(" w3-show", "");
    
        for (var i = 0; i < y.length; i++) {
             y[i].className = y[i].className.replace(" w3-hide", "");
        }
  }
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches(".dropbtn")) {
    var dropdowns = document.getElementById("drp_dn");
  dropdowns.className = dropdowns.className.replace(" w3-show", "");
  }

}
</script>';

/* ИЩЕМ КОЛИЧЕСТВО ЗАПРОСОВ В ДРУЗЬЯ */

$sql = "SELECT COUNT(*) AS 'requests_count' FROM `friend_requests` WHERE `requester2`=:requester2";	
$query = $connection_handler->prepare($sql);
$query->bindParam(':requester2', $login_session, PDO::PARAM_STR); // Пользователь к к которому зашли. Принимают заявку
$query->execute();
$requests_count = $query->fetchAll(PDO::FETCH_ASSOC);
$requests_count = $requests_count[0]['requests_count'];  
   
$total_count_notices = 0;   
   
$new_friend = "";
    if($requests_count != 0){ // Eсли есть запросы в друзья
    $new_friend = $requests_count;  
    $total_count_notices += $requests_count;
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
    $new_dialogs =   $new_dialogs_count;  
    $total_count_notices += $new_dialogs_count;
    } 

   // Выбираем все оповещения из базы 
$sql = "SELECT COUNT(*) AS `notice_count` FROM `notice` WHERE `noticed`='{$_SESSION['user']}' AND `is_readen`=0";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$notice_count = $query->fetchAll(PDO::FETCH_ASSOC);      
$notice_count = $notice_count[0]['notice_count']; 
 
$notice_count_badge = ""; 
 
if($notice_count > 0){
    
    $notice_count_badge = $notice_count;
    $total_count_notices += $notice_count;

} 

$green_spot = "";

if($total_count_notices > 0){
    $green_spot = "<span class = 'green-spot w3-teal'></span>";
}

    $topnav_content =  '<div class="topnav" id="topnav" >
    <a href = user.php?zs=' . $_SESSION['user'] . ' ><img class = "topnav_img" src = "imgs/header/bumazhka.png" title = "Бумажка"></a>
  <a href = "dialogs.php" class = "w3-hide-small"><img class="topnav_img" src="imgs/header/vdvoem_tuta.png" title="Личка">
      <span class="w3-badge w3-right  w3-small shift-bage w3-teal">' . $new_dialogs . '</span>
  </a>
  <a href="bros.php?zs=' . $_SESSION['user'] . '" class = "w3-hide-small"><img class="topnav_img" src="imgs/header/bratki.png" title="Долбоебы">
      <span class="w3-badge w3-right w3-small shift-bage w3-teal " >' . $new_friend . '</span>
  </a>
  <a href="notices.php" class = "w3-hide-small"><img class="topnav_img" src="imgs/header/opoves.png" title="Диндон">
      <span class="w3-badge w3-right w3-small shift-bage w3-teal">' . $notice_count_badge . '</span>
  </a>
  <a href="groups.php?zs=' . $_SESSION['user'] . '"><img class="topnav_img" src="imgs/header/handcuffs.png" title="Группы"></a>

  <a href="javascript:void(0);" class="icon dropbtn" onclick="dropDown()">
    <i class="fa fa-bars dropbtn"></i>' . $green_spot .
  '</a>
  
  <div id="drp_dn" class = "drp_dn" class="w3-card">
        <a href="user.php?zs=' . $_SESSION['user'] . '" class="w3-bar-item w3-button">Бумажка</a>
        <a href="dialogs.php" class="w3-bar-item w3-button">Личка 
        <span class="w3-badge w3-right  w3-small w3-teal">' . $new_dialogs . '</span>
        </a>
        <a href="bros.php?zs=' . $_SESSION['user'] . '" class="w3-bar-item w3-button">Долбоебы   
        <span class="w3-badge w3-right w3-small w3-teal " >' . $new_friend .  '</span>
        </a>
        <a href="notices.php" class="w3-bar-item w3-button">Диндон  
            <span class="w3-badge w3-right w3-small w3-teal">' . $notice_count_badge . '</span>
        </a>
        <a href = "chat.php" class="w3-bar-item w3-button">Чатбот</a>
        <a href="fun_select.php" class="w3-bar-item w3-button">Развлечься</a>
        <a href="radio.php" target = _blank class="w3-bar-item w3-button">Песни</a>
        <a href="malafil.php" class="w3-bar-item w3-button">Малафил</a>
        <a href="common_images.php" class="w3-bar-item w3-button">Картинки</a>
    </div>
    </div>';
    
}

?>

 <?php echo $topnav_content; ?>

<h1 style = "color:blue;text-align:center;font-family:Georgia;margin-top:50px">Шашки</h1>

<div id = "funs" style = "margin-top:20px;">

    <section onclick = "window.location.assign('lva.php')" class = "fun_section">
<div>
<img class = "fun_img" src = "/games/yopuman/logo.png" />
<span class = "fun_name">Link VK Adapter</span>
</div>
<span class = "fun_description">Преобразуем вк ссылку в нормальную, чтобы повыебываться</span>
</section>

<section onclick = "window.location.assign('games/yopuman/')" class = "fun_section">
<div>
<img class = "fun_img" src = "/games/yopuman/logo.png" />
<span class = "fun_name">Yopuman</span>
</div>
<span class = "fun_description">Приложение с ахуительными стихами и чатботом</span>
</section>

<section onclick = "window.location.assign('games/berdyansk_ultimate2/')" class = "fun_section">
<div>
<img class = "fun_img" src = "games/berdyansk_ultimate2/pahom_circle.png" />
<span class = "fun_name">Berdyansk Ultimate 2: El Goo</span>
</div>
<span class = "fun_description">Пахом на яхте стреляет в Епифанов на катерах и водяных танках в Азовском море, а Товарищ Капитан на Тополь М  пытается помешать ему</span>
</section>

    <section onclick = "window.location.assign('games/berdyansk_ultimate/')" class = "fun_section">
<div>
<img class = "fun_img" src = "games/berdyansk_ultimate/pahom_btr.png" />
<span class = "fun_name">Berdyansk Ultimate: New War</span>
</div>
<span class = "fun_description">Товарищ Капитан десантирует танки с Епифаном на Бердянский полуостров близ острова Оаху Гавайских островов, а Пахом на БТР самоотверженно отражает атаку</span>
</section>

<section onclick = "window.location.assign('games/cat_epifan2/')" class = "fun_section">
<div>
<img class = "fun_img" src = "games/cat_epifan2/head.png" />
<span class = "fun_name">Кот Епифан и Космический Пахом 2: Атака Головы</span>
</div>
<span class = "fun_description">Кот Епифан и Космический Пахом отражают нашествие Головы</span>
</section>    

<section onclick = "window.location.assign('games/cat_epifan.php')" class = "fun_section">
<div>
<img class = "fun_img" src = "games/logo.png" />
<span class = "fun_name">Кот Епифан и Космический Пахом</span>
</div>
<span class = "fun_description">Кот Епифан стреляет трахеями по Космическому Пахому</span>
</section>

<section onclick = "window.location.assign('games/kavo/')" class = "fun_section">
<div>
<img class = "fun_img" src = "games/kavo/kavo.png" />
<span class = "fun_name">KAVO</span>
</div>
<span class = "fun_description">Головы Пахома летят к погоне</span>
</section>

<section onclick = "window.location.assign('games/flying_plate/flying_plate.php')" class = "fun_section">
<div>
<img class = "fun_img" src = "imgs/games/flying_plate/flying_plate.jpg" />
<span class = "fun_name">Летающая тарелка</span>
</div>
<span class = "fun_description">Даже хуй знат какое описание написать</span>
</section>

<section onclick = "window.location.assign('games/5bv/5bv.php')" class = "fun_section">
<div>
<img class = "fun_img" src = "imgs/games/5bv/veselyi_sanich.png" />
<span class = "fun_name">Спиздили суки</span>
</div>
<span class = "fun_description">Пахом и Мычалкин спиздили у Саныча 5 бутылок. Помогите Санычу найти их</span>
</section>

<section onclick = "window.location.assign('games/head_answers.php')" class = "fun_section">
<div>
<img class = "fun_img" src = "head.jpg" />
<span class = "fun_name">Голова знает</span>
</div>
<span class = "fun_description">Голова отвечает на вопросы.</span>
</section>

<section onclick = "window.location.assign('games/knb/')" class = "fun_section">
<div>
<img class = "fun_img" src = "games/knb/imgs/rock.png" />
<span class = "fun_name">Камень, ножницы, бумажка</span>
</div>
<span class = "fun_description">Ну и будете на интерес играть какой-нибудь.</span>
</section>

<section onclick = "window.location.assign('games/find_stone/')" class = "fun_section">
<div>
<img class = "fun_img" src = "games/find_stone/kamushek.png" />
<span class = "fun_name">Камушек</span>
</div>
<span class = "fun_description">Пахом спрятал камушек в одной из точек мира и забыл это место. Помогите Пахому найти его</span>
</section>

<section onclick = "window.location.assign('games/shitting_pahom/')" class = "fun_section">
<div>
<img class = "fun_img" src = "games/shitting_pahom/shitting_pahom.png" />
<span class = "fun_name">Где насрал Пахом</span>
</div>
<span class = "fun_description">Пахом срет в одном из населенных пунктов мира. Найдите его<br />
Угадав координаты Пахома, он отобразится на карте</span>
</section>

<section onclick = "window.location.assign('games/karty_sdelali/')" class = "fun_section">
<div>
<img class = "fun_img" src = "games/karty_sdelali/imgs/rubashka.png" />
<span class = "fun_name">Карты сделали</span>
</div>
<span class = "fun_description">Может карты сделаем? Нарисуем щас</span>
</section>

</div>

</div><!-- class=row -->

</main>    

</body>



</html>    


<?php ob_end_flush(); ?>

