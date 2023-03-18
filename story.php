<?php ob_start(); ?>

<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

$id = htmlspecialchars($_GET['id']);

 if(empty($id)){
    
    header('Location: index.php');
    exit();
    
} 

if(!empty($_SESSION['user'])){
$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();
}

function tolink($text) { // Превращение в ссылку
 
  $text = preg_replace("/(^|[\n ])([\w]*?)(https?:\/\/)(www\.)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;#:%=+,])*)*)/is", "$1$2<a href='$3$4$5' target = _blank>$3$4$5</a>", $text); // http(s)://www.frendors.com
 $text = preg_replace("/(^|[\n ])([\w]*?)(https?:\/\/)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;#:%=+,])*)*)/is", "$1$2<a href='$3$4' target = _blank>$3$4</a>", $text); // http(s)://frendors.com
 $text = preg_replace("/(^|[\n ])([\w]*?)(www\.)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;#:%=+,])*)*)/is", "$1$2<a href='//$4' target = _blank>$3$4</a>", $text); // www.frendors.com
 $text = preg_replace("/(^|[\n ])([\w]*?)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;#:%=+,])*)*)/is", "$1$2<a href='//$3' target = _blank>$3</a>", $text); //frendors.com    
  $text = preg_replace("/(^|[\n ])([\w]*?)(https:\/\/yandex.ru\/search\/\?text=[&;=a-zA-Z0-9%+,йцукенгшщзхфывапролджэячсмитьбюЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮ!?@.\s\n]{1,256})/is","$1$2<a href='$3' target = _blank>$3</a>",$text); //yandex
 
 $text = preg_replace("/(^|[\n ])([\w]*?)(\/\/vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=]{1,256})/","$1$2<a href='//$3$4' target = _blank>$3$4$5</a>", $text);
 $text = preg_replace("/(^|[\n ])([\w]*?)(\[url href=\"?)(https?:\/\/)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;#:%=+,])*)*)(\])([a-zA-Z0-9йцукенгшщзхфывапролджэячсмитьбюЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮ!?@.\s\n]{2,80})+(\"?\[\/url\])/", "$1$2<a href='$4$5' target = _blank>$11</a>" ,$text); 
 $text = preg_replace("/(^|[\n ])([\w]*?)(\[url href=\"?)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;#:%=+,])*)*)(\])([a-zA-Z0-9йцукенгшщзхфывапролджэячсмитьбюЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮ!?@.\s\n]{2,80})+(\"?\[\/url\])/", "$1$2<a href='http://$4' target = _blank>$10</a>" ,$text); 

 $text = preg_replace("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1<a href='mailto:$2@$3' target = _blank>$2@$3</a>", $text);

 return $text;

}

function parseDate($date){
  
  $result = "";
  
    
   if(preg_match('/(\d{4})-(\d{2})-(\d{2})\s(\d{2}):(\d{2}):(\d{2})/is',$date,$matches) === 1){
      $year = $matches[1];
       $day = $matches[3];
       $hour = $matches[4];
       $min = $matches[5];
       
       $month = $matches[2];
       
       switch($month){
           case '01': $month = 'янв';  break;
           case '02': $month = 'фев';  break;
           case '03': $month = 'мар';  break;
           case '04': $month = 'апр';  break;
           case '05': $month = 'мая';  break;
           case '06': $month = 'июн';  break;
           case '07': $month = 'июн';  break;
           case '08': $month = 'июл';  break;
           case '09': $month = 'авг';  break;
           case '10': $month = 'сен';  break;
           case '11': $month = 'ноя';  break;
           case '12': $month = 'дек';  break;
           
       }
       
       if($day[0] == '0'){
           
           $day =  substr($day, 1);
           
       }
       
        if($hour[0] == '0'){
           
           $hour =  substr($hour, 1);
           
       }
       
       $result = $day . ' ' . $month . ' ' . $year . ' ' . $hour . ':' . $min;
       
   }
   
   return $result;
    
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

$name = $discussion[0]['name'];
$story = tolink(nl2br($discussion[0]['text']));
$author = $discussion[0]['author'];
$date = $discussion[0]['date'];

$sql = "SELECT `avatar` FROM `additional_info` WHERE `nickname`='{$author}'";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$avatar = $query->fetchAll(PDO::FETCH_ASSOC);
$avatar = $avatar[0]['avatar'];


$sql = "SELECT COUNT(*) AS `likes_count` FROM `common_discussions_likes` WHERE `story_id`={$id}";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$likes_count = $query->fetchAll(PDO::FETCH_ASSOC);
$likes_count = $likes_count[0]['likes_count']; 

$sql = "SELECT COUNT(*) AS `dislikes_count` FROM `common_discussions_dislikes` WHERE `story_id`={$id}";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$dislikes_count = $query->fetchAll(PDO::FETCH_ASSOC);
$dislikes_count = $dislikes_count[0]['dislikes_count']; 

if($likes_count == 0){
    $likes_count = "";
}

if($dislikes_count == 0){
    $dislikes_count = "";
}

$setLikeFun = "";
$setDislikeFun = "";

$sql = "SELECT * FROM `common_discussions_likes` WHERE `story_id`={$id} AND `liker`='{$_SESSION['user']}'";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$likes = $query->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM `common_discussions_dislikes` WHERE `story_id`={$id} AND `disliker`='{$_SESSION['user']}'";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$dislikes = $query->fetchAll(PDO::FETCH_ASSOC);


if(!empty($_SESSION['user'])){
   
   if(empty($likes) && empty($dislikes)){
       
           $setLikeFun = 'onclick = setLike(' . $id . ',this)';
            $setDislikeFun = 'onclick = setDislike(' . $id .  ',this)';
    }

}

$post_textarea = "";

if(!empty($_SESSION['user'])){
   
  $post_textarea = '<div class="w3-card w3-white w3-round w3-margin" id = "post_input_block"><br>
                   
                    <div class="w3-row w3-padding">
                      <textarea id = "post_input" placeholder = "пиши" class="w3-border w3-padding" 
                            onkeypress = "send_post_enter_key(event)" maxlength = "1000" 
                            oninput = "this.style.height=\'70px\'">
                        </textarea>
                 <button type="button" class="w3-button w3-block w3-blue-grey" onclick = sendPost()>
                     <i class="fa fa-pencil"></i>Ахуенно</button> 
                </div>
             
            </div>';

}

$sql = "SELECT * FROM `common_discussions_posts` INNER JOIN `additional_info` 
ON common_discussions_posts.author=additional_info.nickname WHERE `story_id`={$id} 
ORDER BY common_discussions_posts.this_id DESC";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$posts = $query->fetchAll(PDO::FETCH_ASSOC);

$posts_container = "";

for($i = 0; $i < count($posts); $i++){
   
   $post_author = $posts[$i]['author'];
   $post_date = $posts[$i]['date'];
   $post_text = $posts[$i]['text'];
   $post_author_avatar = $posts[$i]['avatar'];
   
   $posts_container .= '<div class="w3-display-container w3-margin">   
          
            <div class="w3-card w3-white w3-round w3-margin w3-padding"><br>
             <a href=user.php?zs=' . $post_author . ' target=_blank>
                <img src="users/' . $post_author_avatar  . '" alt="' . $post_author . '" class="w3-left w3-circle w3-margin-right" style="width:60px;height:60px;">
                </a>
                <span class="w3-right w3-opacity">' . parseDate($post_date) . '</span>
                <h4><a href=user.php?zs=' . $post_author . ' target=_blank>' . $post_author . '</a></h4><br>
                <hr class="w3-clear" style = "margin-top:-5px;">
               
               <div class="post_text_container" style = "margin-top:-10px;"> <p>' . tolink($post_text) . '</p></div>
        
             </div> 
       
        </div>  ';
    
}


?>

<!DOCTYPE html>
<html>
<title><?php echo $name; ?></title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name = "description" content = "<?php echo $name;  ?>" />
<meta name="keywords" content = "<?php echo $author; ?>, outmind, crazy, outstanding" / >
<meta name = "author" content = "<?php echo $author; ?>">

<meta property="og:title" content="<?php echo $name; ?>"/>
<meta property="og:description" content="<?php echo $story;  ?>"/>
<meta property="og:image" content="https://frendors.com/users/<?php echo $avatar; ?>">
<meta property="og:type" content="article"/>
<meta property="og:url" content= "https://frendors.com/story.php?id=<?php echo $id; ?>" />
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inconsolata">

<script type="text/javascript" src="https://vk.com/js/api/openapi.js?159"></script>
<script type="text/javascript" src="//vk.com/js/api/openapi.js?136"></script>
<script type="text/javascript" src="//vk.com/js/api/openapi.js?137"></script>

<script type='text/javascript'>
  VK.init({apiId: 5757931});
</script>

<script type='text/javascript'>
        
        VK.Widgets.Auth('vk_auth', {
            width: '200px', 
            onAuth: function(data) {
         var user_id = data['uid'];
         var first_name =  data['first_name'];
         var last_name = data['last_name'];
         var hash = data['hash'];
        
         var first_last_name = first_name + '_' + last_name;
         
         window.location.replace('vk_registration.php?vk_name=' + first_last_name + '&user_id=' + user_id + '&a_cho_tam=' + hash);
                
        } 
        
        });
        
        </script>

 <script type="application/ld+json">
{
  "@context" : "https://schema.org",
  "@type" : "Organization",
  "name" : "frendors",
  "url" : "https://frendors.com",
 "sameAs" : [
    "https://vk.com/frendors",
    "https://www.facebook.com/groups/196393694136228/",
    "https://twitter.com/chosty_frosty",
    "https://plus.google.com/b/109772920171943742867/109772920171943742867"
  ]
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

<!-- Google counter -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-85516784-1', 'auto');
  ga('send', 'pageview');

</script>

<style>
body, html {
  height: 100%;
  font-family: "Inconsolata", sans-serif;
}

.bgimg {
  background-position: center;
  background-size: cover;
  background-image: url("/w3images/coffeehouse.jpg");
  min-height: 75%;
}

.menu {
  display: none;
}
</style>

<?php 

$vk = "";

if(empty($_SESSION['user'])){
    $vk = '<div id="vk_auth" style = "position:relative;bottom:10px;"></div>';
    
}

?>
<script>

function setLike(story_id,button){
   var likes_counter_span =  document.getElementById("likes_counter_span_" + story_id);
   var xmlhttp = new XMLHttpRequest();

xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
   likes_counter_span.innerHTML = xmlhttp.response;
   button.onclick = null;
} 
}

var formData = new FormData();
formData.append('story_id', story_id);

xmlhttp.open("POST", "scripts/common_discussion_set_like.php", true);
xmlhttp.send(formData);

}

function setDislike(story_id,button){
   var dislikes_counter_span =  document.getElementById("dislikes_counter_span_" + story_id);
    var xmlhttp = new XMLHttpRequest();

xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
   dislikes_counter_span.innerHTML = xmlhttp.response;
   button.onclick = null;
} 
}

var formData = new FormData();
formData.append('story_id', story_id);

xmlhttp.open("POST", "scripts/common_discussion_set_dislike.php", true);
xmlhttp.send(formData);

} 

function sendPost(){
var xmlhttp = new XMLHttpRequest();
var post_textarea = document.getElementById("post_input"); // Сообщение

if(post_textarea.value === "" || post_textarea.value.match(/^\s+$/g)){return;}

xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
window.location.reload();
} 
}

var formData = new FormData();
formData.append('story_id', <?php echo $id; ?>);
formData.append('text', post_textarea.value.trim());

xmlhttp.open("POST", "scripts/common_discussions_posts.php", true);
xmlhttp.send(formData);    

post_textarea.value = "";  
post_textarea.rows = 1;

}

function send_post_enter_key(event){
var char = event.which || event.keyCode;    
if(char == 13) {
sendPost();    
}   
}

</script>

<style>

#post_input{

    width:100%;
    resize:none;
    height:35px;
    overflow:hidden;
    margin-bottom:10px;
    

}  
    
</style>

<body style = "background-color:#cefdce;">

<!-- Add a background color and large text to the whole page -->
<div class="w3-container">
<h6 class = "w3-left"><a href="malafil.php">Истории</a></h6>
<?php echo $vk; ?>
<h1 class = "w3-center" style = "position:relative;top:15px;word-wrap:break-word;"><?php echo $name; ?></h1>
  
<main class="w3-content" style="max-width:700px" >

            <div class="w3-card w3-white w3-round w3-margin" id = "story_block"><br>
                   
                    <div class="w3-row w3-padding">
                      
                        <a href= "user.php?zs=<?php echo $author; ?>" target=_blank>
                            <img src = "users/<?php echo $avatar; ?>" alt="Avatar" class="w3-left w3-circle w3-margin-right" style="width:60px;height:60px;position:relative;bottom:20px"></a>
                
                            <span class="w3-right w3-opacity"><?php echo parseDate($date); ?></span>
                             <h4><a href= user.php?zs=<?php echo $author; ?>  target=_blank><?php echo $author; ?></a></h4><br>
                           
                           <hr class="w3-clear" style = "margin-top:-10px;">
                          <div class = "story_container" style = "margin-top:-10px;"><p><?php echo tolink($story); ?></p></div>
                     <hr class="w3-clear" style = "margin-top:-10px;">
                                   <div class = "post_buttons_container">
                          <button type="button" class="w3-button w3-theme-d1 w3-margin-bottom w3-blue-grey" <?php echo $setLikeFun; ?>>
                          <i class="fa fa-thumbs-up"></i>Ахуенно <i class = "likers_count" id = "likes_counter_span_<?php echo $id; ?>"><?php echo $likes_count; ?></i>
                              </button> 
                         <button type="button" class="w3-button w3-theme-d2 w3-margin-bottom w3-blue-grey"  <?php echo $setDislikeFun; ?> >
                         <i class="fa fa-thumbs-down"></i>Гавно! <i class = "dislikers_count" id = "dislikes_counter_span_<?php echo $id; ?>"><?php echo $dislikes_count; ?></i></button>
                        </div>
                    </div>
             
            </div>
            
            <?php echo $post_textarea; ?>
         
         <div class="w3-display-container w3-margin">   
          
       <?php echo $posts_container; ?>
       
        </div>     

  </main> <!-- End Main -->

</div>

</body>
</html>

<?php ob_end_flush(); ?>
