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

?>

<html>

<head>
<title>Новость дня | Архив</title>
<meta charset = "utf-8" />
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
    width: 100%;
    background-color:#cefdce;
    margin:0 auto;
    height:100%;
    font-size:20px;
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

.like {
display:inline-block;
color: blue;
padding:3px;
border-radius:3px;
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

.daily_news_likes_img, .daily_news_dislikes_img, .daily_news_indifferent_img {
    width:20px;
    height:20px;
    margin-top:-10px;
}

.dislike,.indifferent {
display:inline-block;
color: blue;
padding:3px;
border-radius:3px;
}

.daily_news_date {
    color:gray;
    font-size:15px;
}

.daily_news_separator{
     margin-top:-5px;
     margin-bottom:5px;
     border:1px dashed white;
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

echo '<a href=user.php?zs=' . $_SESSION['user'] . '>' . $_SESSION['user'] . '</a>';

}

?>

    <main class = "container-fluid">
     
    <div class = "row">
    
    <h1 style = "color:blue;text-align:center;"> А чо там? </h1>
    <span style = "color:green">Новость дня | Архив</span>
    <hr />
    <div id = "daily_news_container" style = "padding:5px;">
        
        <?php 
        
        /* ИЩЕМ ЕЖЕДНЕВНЫЕ НОВОСТИ */
        $sql = "SELECT * FROM `daily_news` ORDER BY `this_id` DESC";	
        $query = $connection_handler->prepare($sql);
        $query->execute();
        $daily_news = $query->fetchAll(PDO::FETCH_ASSOC);
         
        $outp = "";
         
        for($i = 0; $i < count($daily_news); $i++){
                 
            // ЛАЙКИ 
            $sql = "SELECT COUNT(*) AS `daily_news_likes` FROM `daily_news_likes` WHERE `news_id`={$daily_news[$i]['this_id']}";	
            $query = $connection_handler->prepare($sql);
            $query->execute();
            $daily_news_likes = $query->fetchAll(PDO::FETCH_ASSOC);
            $daily_news_likes = $daily_news_likes[0]['daily_news_likes'];
            
            // ДИЗЛАЙКИ 
            $sql = "SELECT COUNT(*) AS `daily_news_dislikes` FROM `daily_news_dislikes` WHERE `news_id`={$daily_news[$i]['this_id']}";	
            $query = $connection_handler->prepare($sql);
            $query->execute();
            $daily_news_dislikes = $query->fetchAll(PDO::FETCH_ASSOC);
            $daily_news_dislikes = $daily_news_dislikes[0]['daily_news_dislikes'];
            
            // БЕЗРАЗЛИЧИЕ 
            $sql = "SELECT COUNT(*) AS `daily_news_indifferent` FROM `daily_news_indifferent` WHERE `news_id`={$daily_news[$i]['this_id']}";	
            $query = $connection_handler->prepare($sql);
            $query->execute();
            $daily_news_indifferent = $query->fetchAll(PDO::FETCH_ASSOC);
            $daily_news_indifferent = $daily_news_indifferent[0]['daily_news_indifferent'];
            
            $outp .= "<section class = daily_news_section>
                    <div class = daily_news_text>" . $daily_news[$i]['text'] . "</div>  
                    <div class = daily_news_rating>
                            <section class = like><img class = daily_news_likes_img src = imgs/like.png /> Ахуенно | <span>" . $daily_news_likes . "</span></section>
                            <section class = dislike><img class = daily_news_dislikes_img src = imgs/dislike.png /> Гавно! | <span>" . $daily_news_dislikes . "</span></section>
                            <section class = indifferent ><img class = daily_news_indifferent_img src = imgs/indifferent.png /> Да похуй вообще бля | <span>" . $daily_news_indifferent . "</span></section>
                    <span class = daily_news_date>" . $daily_news[$i]['date'] . "</span>
                    </div>
                    </section><hr class = daily_news_separator />";     
                }
         
        echo $outp; 
         
        ?>
        
    </div>
    </div><!-- class row -->
    </main>    

</body>    

</html>    

<?php ob_end_flush(); ?>