<?php ob_start(); ?>

<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

$id = (int) htmlspecialchars($_GET['id']);

function tolink($text) { // Превращение в ссылку
 
 $text = preg_replace("/(^|[\n ])([\w]*?)((ht|f)tp(s)?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", "$1$2<a href='$3' target = _blank>$3</a>", $text);
 $text = preg_replace("/(^|[\n ])([\w]*?)((www|ftp)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a href='http://$3' target = _blank>$3</a>", $text); 
 $text = preg_replace("/(^|[\n ])([\w]*?)(\.[^ \,\"\t\n\r<]*)/is", "<a href='http://$0' target = _blank>$0</a>", $text); 
 $text= preg_replace("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1<a href='mailto:$2@$3' target = _blank>$2@$3</a>", $text);
 
 return $text;
}

?>

<?php

$sql = "SELECT * FROM `common_discussions` WHERE `this_id`={$id}";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$discussion = $query->fetchAll(PDO::FETCH_ASSOC);

if(empty($discussion) && !empty($_SESSION['user'])){ // Обсуждения нет, но авторизовались
    header('Location: user.php?zs=' . $_SESSION['user']);
    exit();
}

if(empty($discussion) && empty($_SESSION['user'])){ // Обсуждения нет, и не авторизовались
    header('Location: index.php');
    exit();
}

$name = $discussion[0]['name'];
$story = tolink(nl2br($discussion[0]['text']));
$author = $discussion[0]['author'];
$date = $discussion[0]['date'];

$sql = "SELECT `avatar` FROM `additional_info` WHERE `nickname`='{$author}'";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$avatar = $query->fetchAll(PDO::FETCH_ASSOC);
$avatar = $avatar[0]['avatar'];

?>

<!DOCTYPE html>

<html>

<head>    
<title>История</title>
<meta charset = "utf-8" />
<meta name = "description" content = "<?php echo 'frendors.com | ' . $name; ?>" />
<meta name="keywords" content = "frendors.com,социальная сеть для поехавших,зеленый слоник,бердянск,больничка,сергей пахомов,владимир епифанцев,александр маслаев,александр осмоловский,сладкий хлеб,азов,украина,пахом,голова,трэш фильмы,артхаус,человеческая многоножка" / >
<meta name = "author" content = "<?php echo $author; ?>">

<meta property="og:title" content="<?php echo 'frendors.com | ' . $name; ?>"/>
<meta property="og:description" content="<?php echo $story; ?>"/>
<meta property="og:image" content="//frendors.com/users/<?php echo $avatar; ?>">
<meta property="og:type" content="website"/>
<meta property="og:url" content= "//frendors.com/" />


<link rel = "stylesheet" href = "css/normalize.css"  type = "text/css" />
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel = "stylesheet" src = "css/roboto/roboto.css">
<script src="bootstrap/js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

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
    font-size:20px;
    width: 100%;
    background-color:#cefdce;
    margin:0 auto;
    height:100%;
}

main {
    padding: 10px;
    border-left:1px solid blue;
    border-right:1px solid blue;
    width:100%;
    padding-bottom: 90px;

    }

a {
    color:blue;
}  

  input[type=text],input[type=password],input[type=email],textarea{
          padding:5px;
          border-radius:5px;
 }
 
  input[type=text]:focus,input[type=password]:focus,input[type=email]:focus,input[type=checkbox]:focus,textarea:focus{
     background-color: #98DDDE;
     box-shadow: 0px 0px 1px #7FFFD4;
}
    
#disc_title{
    color:blue;
    font-size:25px;
    text-decoration:underline;
    max-width:1050px;
    word-wrap:break-word;
}
   
#author_date_div{
    margin-top:-5px;
    margin-bottom:10px;
}   

#avatar{
    width:30px;
    height:30px;
}

#story_div{
    width:100%;
    word-wrap:break-word;
    padding:10px;
}

.post_container {
    max-width:520px;
    margin-bottom:5px;
    border-bottom:1px solid white;
}

.post_container:hover {
    background-color:white;
    opacity:0.7;
    cursor:pointer;
}

.post_avatar{
    width:40px;
    height:40px;
    border-radius:5px;
    display:block;
    float:left;
    margin-right:5px;
}
   
.user_page_link{
    font-size:18px;
}

.post_date {
    color:gray;
    font-size:12px;
    
}

.post_link_date_container {
    border-bottom:1px solid gray;
}

.post_text {
    word-wrap:break-word;
    border-bottom:1px solid gray;
}

.doebat {
    font-size:15px;
    color:green;
}

.likes_dislikes_container {
color:blue; 
margin-bottom:10px;
}

.dislikes_container {
    position:relative;
    left:115px;
    margin-bottom:-45px;
    top:-43px;
}

.likes_container:hover {
   background-color:green; 
}

.dislikes_container:hover {
    background-color:gray;
}

.like_img, .dislike_img {
    width:30px;
    height:30px;
}

.likes_dislikes_story_container{
color:blue;
margin-bottom:10px;
}

.likes_story_container{
  float:left;
  display:inline-block;
  border-radius:5px;
  margin-right:10px;
  padding:5px;
cursor:pointer;
}

.likes_story_container:hover, .likes_container:hover {
background: #9dd53a; /* Old browsers */
background: -moz-linear-gradient(top,  #9dd53a 0%, #a1d54f 50%, #80c217 51%, #7cbc0a 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top,  #9dd53a 0%,#a1d54f 50%,#80c217 51%,#7cbc0a 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom,  #9dd53a 0%,#a1d54f 50%,#80c217 51%,#7cbc0a 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#9dd53a', endColorstr='#7cbc0a',GradientType=0 ); /* IE6-9 */    
}

.likes_story_container:active, .likes_container:active {
background: #7cbc0a; /* Old browsers */
background: -moz-linear-gradient(top, #7cbc0a 0%, #80c217 49%, #a1d54f 50%, #9dd53a 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top, #7cbc0a 0%,#80c217 49%,#a1d54f 50%,#9dd53a 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom, #7cbc0a 0%,#80c217 49%,#a1d54f 50%,#9dd53a 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#7cbc0a', endColorstr='#9dd53a',GradientType=0 ); /* IE6-9 */
}

.dislikes_story_container{
  display:inline-block;
  border-radius:5px;
  margin-right:10px;
  padding:5px;
  cursor:pointer;
}

.dislikes_story_container:hover, .dislikes_container:hover {
background: #f3e2c7; /* Old browsers */
background: -moz-linear-gradient(top, #f3e2c7 0%, #c19e67 50%, #b68d4c 51%, #e9d4b3 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top, #f3e2c7 0%,#c19e67 50%,#b68d4c 51%,#e9d4b3 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom, #f3e2c7 0%,#c19e67 50%,#b68d4c 51%,#e9d4b3 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f3e2c7', endColorstr='#e9d4b3',GradientType=0 ); /* IE6-9 */  
}

.dislikes_story_container:active, .dislikes_container:active {
background: #e9d4b3; /* Old browsers */
background: -moz-linear-gradient(top, #e9d4b3 0%, #b68d4c 49%, #c19e67 50%, #f3e2c7 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top, #e9d4b3 0%,#b68d4c 49%,#c19e67 50%,#f3e2c7 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom, #e9d4b3 0%,#b68d4c 49%,#c19e67 50%,#f3e2c7 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e9d4b3', endColorstr='#f3e2c7',GradientType=0 ); /* IE6-9 */
}


.online {
    color:gray;
    display:block;
    position:relative;
    margin-top:-8px;
    right:0px;
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

<main style = "container-fluid">

<div class = "row">

<div id="vk_like"></div>
<script type="text/javascript">
    VK.Widgets.Like("vk_like", {type: "button"});
</script>

<h4 id = "disc_title"><?php echo $name; ?></h4>
<div id = "author_date_div"><a href = "user.php?zs=<?php echo $author; ?>"><img id = "avatar" src = "users/<?php echo $avatar; ?>" /></a>  <a style = "color:black;text-decoration:underline;" href = "user.php?zs=<?php echo $author; ?>"><?php echo $author; ?></a> | <span><?php echo $date;?></span></div>
<a href = "malafil.php"><< К историям </a>
<div id = "story_div"> 
<?php 

$set_like_story_function = "";
$set_dislike_story_function = "";

if(!empty($_SESSION['user'])){
$set_like_story_function = " onclick = set_like_story(" . $id . ")";
$set_dislike_story_function = " onclick = set_dislike_story(" . $id . ")";
    
}

$sql = "SELECT COUNT(*) AS `likes_count` FROM `common_discussions_likes_under_story` WHERE `story_id`={$id}";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$likes_count_story = $query->fetchAll(PDO::FETCH_ASSOC);
$likes_count_story = $likes_count_story[0]['likes_count']; 

$sql = "SELECT COUNT(*) AS `dislikes_count` FROM `common_discussions_dislikes_under_story` WHERE `story_id`={$id}";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$dislikes_count_story = $query->fetchAll(PDO::FETCH_ASSOC);
$dislikes_count_story = $dislikes_count_story[0]['dislikes_count']; 

echo '<section id = "story_container"><div id = "story_content">' . 
$story . 
'</div>' .
'<div class = "likes_dislikes_story_container">
    <div class = "likes_story_container"' . $set_like_story_function . ' ><img class = "like_img" src = "imgs/like.png" /> Ахуенно | <span id = "likes_story_counter_span_' . $id . '">'  . $likes_count_story   . '</span></div>
    <div class = "dislikes_story_container"' .  $set_dislike_story_function . ' ><img class = "dislike_img" src = "imgs/dislike.png" /> Гавно! | <span id = "dislikes_story_counter_span_' . $id . '">' . $dislikes_count_story . '</span></div>
    </div>
    </div>' .
'</section>'; 

?>

<script>

function set_like_story(story_id){

   var likes_story_counter_span =  document.getElementById("likes_story_counter_span_" + story_id);
   var xmlhttp = new XMLHttpRequest();

xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
   likes_story_counter_span.innerHTML = xmlhttp.response;

} 
}

xmlhttp.open("GET", "scripts/common_discussion_set_like_story.php?story_id=" + story_id, true);  
xmlhttp.send();  

}  

function set_dislike_story(story_id){

   var dislikes_story_counter_span =  document.getElementById("dislikes_story_counter_span_" + story_id);
   var xmlhttp = new XMLHttpRequest();

xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
   dislikes_story_counter_span.innerHTML = xmlhttp.response;

} 
}

xmlhttp.open("GET", "scripts/common_discussion_set_dislike_story.php?story_id=" + story_id, true);  
xmlhttp.send();  

}   


</script>

</div>

<?php 

$story_input = '';

if(!empty($_SESSION['user'])){
$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();

$story_input = '<div>
<textarea placeholder = "Малафить" id = "comment_textarea" style = "resize:none;width:100%;" autofocus = "autofocus" rows = "1" maxlength = "3000" oninput = "show_send_comment_button()" required = "required"></textarea><br />
<button id = "send_comment_button" type = "button"  style = "display:none" class="btn btn-primary" onclick = "send_post()">Ахуенно</button>
</div>';
echo $story_input;
}

?>

<hr />

<?php 

/* Выводим комменты */
$sql = "SELECT * FROM `common_discussions_posts` WHERE `story_id`={$id} ORDER BY `this_id` DESC";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$posts = $query->fetchAll(PDO::FETCH_ASSOC);
$posts_container = "";

if(!empty($posts)){
    
    for($i = 0; $i < count($posts); $i++){
        $author = $posts[$i]['author'];
        $text = $posts[$i]['text'];
        $date = $posts[$i]['date'];
        $post_id = $posts[$i]['this_id'];
$sql = "SELECT `avatar` FROM `additional_info` WHERE `nickname`='{$author}'";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$avatar = $query->fetchAll(PDO::FETCH_ASSOC);
$avatar = $avatar[0]['avatar'];
 
$sql = "SELECT COUNT(*) AS `likes_count` FROM `common_discussions_likes` WHERE `story_id`={$id} AND `post_id`={$post_id}";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$likes_count = $query->fetchAll(PDO::FETCH_ASSOC);
$likes_count = $likes_count[0]['likes_count']; 

$sql = "SELECT COUNT(*) AS `dislikes_count` FROM `common_discussions_dislikes` WHERE `story_id`={$id} AND `post_id`={$post_id}";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$dislikes_count = $query->fetchAll(PDO::FETCH_ASSOC);
$dislikes_count = $dislikes_count[0]['dislikes_count']; 

$doebat_button = "";
$set_like_function = "";
$set_dislike_function = "";
$online = ""; /* Текст, который будет отображаться в месте онлайн */

$sql = "SELECT last_action_time FROM main_info WHERE nickname=:nickname"; // Выбираем время последней активности пользователя	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $author, PDO::PARAM_STR);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);
$last_action_time = $result[0]['last_action_time'];

        if(($current_time - $last_action_time) <= 180){ // Разница <= 180 секунд
            $online = "<span class = 'online'>здеся<span>";
                } 


if(!empty($_SESSION['user'])){
    $set_like_function = 'onclick = set_like(' . $id . ',' . $post_id . ')';
    $set_dislike_function = 'onclick = set_dislike(' . $id . ',' . $post_id . ')';
    
}

if(!empty($_SESSION['user'])){
if($author != $_SESSION['user']){
    $doebat_button = '</div>
    <div>
    <a class = "doebat" href = "#" onclick = doebat("' . $author . '")>Доебать</a>
    </div>';    
}
}    
    $posts_container .= '<section class = "post_container" id = "post_' . $post_id . '">
    <div><a href = "user.php?zs=' . $author . '"><img class = "post_avatar" src = "users/' . $avatar . '"></a>
    <div class = "post_link_date_container"><a class = "user_page_link" href = "user.php?zs=' . $author . '">' . $author . '</a><br />
    <span class = "post_date">' .$date . '</span><br />' .
    $online .
    '</div>
    <div class = "post_text">' .
    tolink($text) .
    $doebat_button .
    '<div class = "likes_dislikes_container">
    <div class = "likes_story_container"' . $set_like_function . ' ><img class = "like_img" src = "imgs/like.png" /> Ахуенно | <span id = "likes_counter_span_' . $post_id . '">' . $likes_count . '</span></div>
    <div class = "dislikes_story_container"' .  $set_dislike_function . ' ><img class = "dislike_img" src = "imgs/dislike.png" /> Гавно! | <span id = "dislikes_counter_span_' . $post_id . '">' . $dislikes_count . '</span></div>
    </div>
    </div>' .
    '</section>';
    
    }
   echo $posts_container;  
    
}


?>

</div><!-- class row -->

</main>    

<script>

function show_send_comment_button(){
    var comment_textarea = document.getElementById('comment_textarea');
    var send_comment_button = document.getElementById('send_comment_button');
    comment_textarea.rows=4;
    send_comment_button.style.display = 'block';
}

function send_post(){
    var comment_textarea = document.getElementById('comment_textarea');
    var story_id = <?php echo $id;?>;

    if(comment_textarea.value == "" || comment_textarea.value.match(/^\s+$/g)){
       return;
    }
   
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
window.location.reload();
} 
}

var formData = new FormData();
formData.append('story_id', story_id);
formData.append('text', comment_textarea.value.trim());

xmlhttp.open("POST", "scripts/common_discussions_posts.php", true);
xmlhttp.send(formData);

}

function moveCaretToPos(inputObject,pos)
{
if (inputObject.selectionStart)
{
 inputObject.setSelectionRange(0,pos);
}
}

function doebat(username){
  var comment_textarea = document.getElementById('comment_textarea');

comment_textarea.innerHTML = username + ", "; 
moveCaretToPos(comment_textarea,comment_textarea.innerHTML.length);

} 

/* Лайки дизлайки */

function set_like(story_id, post_id){
   var likes_counter_span =  document.getElementById("likes_counter_span_" + post_id);
   var xmlhttp = new XMLHttpRequest();

xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
   likes_counter_span.innerHTML = xmlhttp.response;
} 
}

xmlhttp.open("GET", "scripts/common_discussion_set_like.php?story_id=" + story_id + "&post_id=" + post_id, true);  
xmlhttp.send();  
}

function set_dislike(story_id, post_id){
   var dislikes_counter_span =  document.getElementById("dislikes_counter_span_" + post_id);
    var xmlhttp = new XMLHttpRequest();

xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
   dislikes_counter_span.innerHTML = xmlhttp.response;
} 
}

xmlhttp.open("GET", "scripts/common_discussion_set_dislike.php?story_id=" + story_id + "&post_id=" + post_id, true);  
xmlhttp.send();  
} 


</script>
</body>    


</html>    

<?php ob_end_flush(); ?>