<?php ob_start(); ?>

<?php

if(empty($_GET['zs'])){
    header('Location: index.php');
    exit();
    
}

session_start();

$user = $_GET['zs'];

$whose_stories = "Твои истории";

if((!empty($_SESSION['user']) && strcmp($user,$_SESSION['user']) != 0) || 
(empty($_SESSION['user'])) ){
    
    $whose_stories = "Истории | " . $user;
    
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

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

$sql = "SELECT * FROM `user_stories` WHERE `author`='{$user}' ORDER BY this_id DESC";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$discussions = $query->fetchAll(PDO::FETCH_ASSOC);


$sql = "SELECT * FROM `additional_info` WHERE `nickname`='{$user}'";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$avatar = $query->fetchAll(PDO::FETCH_ASSOC);
$avatar = $avatar[0]['avatar'];

$new = "";

if(!empty($discussions)){
for($i = 0; $i < count($discussions);$i++){

$name = $discussions[$i]['name'];
$text = $discussions[$i]['text'];
$id = $discussions[$i]['this_id'];
$date = $discussions[$i]['date'];


if(strlen($name) > 80){
     $name = mb_substr($name,0,80);
    $name .= "...";
}

if(strlen($text) > 200){
    $text = mb_substr($text,0,200);
    $text .= "...";
}


$discussions_container .= '<div class="w3-display-container w3-margin w3-hover-sand" style="cursor:pointer;" onclick = window.location.replace(\'user_story.php?id=' . $id . '\')>   
          
            <div class="w3-card w3-white w3-round w3-margin w3-padding"><br>
             
                <img src="users/' . $avatar  . '" alt="' . $user . '" class="w3-left w3-circle w3-margin-right" style="width:60px;height:60px;">
                
                <span class="w3-right w3-opacity">' . parseDate($date) . '</span>
                <h4>' . $user . '</a></h4><br />
                <hr class="w3-clear" style = "margin-top:-10px;">
              
               <div class="story_txt_container">
               <h5 class ="w3-center">' . $name . '</h5>
                    <div class="post_text_container" style = "margin-top:-10px;"> <p>' . tolink($text) . '</p></div>
                </div>
             </div> 
       
        </div>';

}
    
}

/*************************************************************************************/

$story_input_block = "";

if(!empty($_SESSION['user']) && $_SESSION['user'] === $user){
   
  $story_input_block = '<div class="w3-card w3-white w3-round w3-margin" id = "story_input_block" style="display:none;"><br>
                   
                    <div class="w3-row w3-padding" style = "margin-top:-35px;">
                      <h3 class="w3-center">Заголовок</h3>
                       <input id = "story_header_input" placeholder = "пиши" class="w3-input w3-border" maxlength = "80">
                     <div id = "story_text_input_container" style = "margin-top:-10px;">
                          <h3 class="w3-center">Содержание</h3> 
                     <textarea id = "story_text_input" class="w3-border w3-padding" style = "margin-top:-10px;"  maxlength = "1000" 
                            oninput = "this.style.height=\'150px\'">
                    </textarea>
               <button type="button" class="w3-button w3-block w3-blue-grey" onclick = sendStory()>
                     <i class="fa fa-pencil"></i>Ахуенно</button> 
                   <span id="errors_span"></span>
                 
                    </div> 
                </div>
             
            </div>';

}

$backward = "";

if(!empty($_SESSION['user'])){
    
    
    $backward =  '<h6 class = "w3-left"><a href="user.php?zs=' . $user . '">Нахуй</a></h6>';
    
}

$new = "";

if(!empty($_SESSION['user']) && $user === $_SESSION['user']){
    
  $new = '<div class = "w3-center" id="new_story_link"><span class = "w3-text-teal" style="font-size:15px;" onclick = showBlock(document.getElementById(\'story_input_block\'))>новая</span></div>';
}

$whose_stories = "";

    
    if(empty($discussions) && !empty($_SESSION['user']) && strcmp($user,$_SESSION['user']) == 0 ){
        
        $whose_stories = "Историй пока что нет";
        
    }else if(empty($_SESSION['user']) || (!empty($_SESSION['user']) && strcmp($user,$_SESSION['user']) != 0)){
        
            $whose_stories = "Истории | " . $user;
        
    }else if(!empty($_SESSION['user']) && strcmp($user,$_SESSION['user']) == 0){
        
        $whose_stories = "Твои истории";
        
    }

?>

<!DOCTYPE html>
<html>
<title><?php echo "Истории | " . $user; ?></title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name = "description" content = "Потом будем тут блять малафить всё" />
<meta name="keywords" content = "малафить, outmind, crazy, outstanding" / >
<meta name = "author" content = "<?php echo $author; ?>">

<meta property="og:title" content="<?php echo "Истории | " . $user; ?>"/>
<meta property="og:description" content="Хорошие истории просто"/>
<meta property="og:image" content="https://frendors.com/users/<?php echo $avatar; ?>">
<meta property="og:type" content="article"/>
<meta property="og:url" content= "https://frendors.com/user.php?zs=<?php echo $user; ?>" />
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

function sendStory(){
  var disc_topic = document.getElementById("story_header_input");
  var disc_textarea = document.getElementById("story_text_input");
  var errors_span = document.getElementById("errors_span");
  var errors_txt = "";
  var send_story_flag = true;

   if(disc_topic.value === ""){
    errors_txt += "Где название нахуй!?<br />";
    send_story_flag = false;
    }
    
    if(disc_topic.value.match(/^\s+$/g)){
    errors_txt += "Одни пробелы в названии  нахуй!?<br />";
send_story_flag = false;
    }
    
    if(disc_textarea.value.match(/^\s+$/g)){
     errors_txt += "Одни пробелы в истории  нахуй!?<br />";
   send_story_flag = false;
}

if(disc_textarea.value === ""){
     errors_txt +="Где история нахуй!?<br />";
    send_story_flag = false;
    } 

if(send_story_flag == false){
    errors_span.innerHTML = errors_txt;
    return;
}


var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
    disc_topic.value = "";
    disc_textarea.value = "";
    window.location.reload();

} 
}

var formData = new FormData();
formData.append('name', disc_topic.value.trim());
formData.append('text', disc_textarea.value.trim());

xmlhttp.open("POST", "scripts/write_user_story.php", true);
xmlhttp.send(formData);

}

function showBlock(block){
    
    if(block.style.display === "none"){
        
        block.style.display = "block";
        
    }else{
         block.style.display = "none";
    }
    
}

</script>

<style>

#story_text_input{

    width:100%;
    resize:none;
    height:35px;
    overflow:hidden;
    margin-bottom:10px;
    margin-top:15px;

}  

.story_txt_container{
    margin-top:-15px;
    word-wrap:break-word;
    
}

#new_story_link{
    margin-top:-5px;
    margin-bottom:-10px;
    cursor:pointer;
    text-decoration:underline;
}

#new_story_link:hover{
     text-decoration:none;
}
    
</style>

<body style = "background-color:#cefdce;">

<!-- Add a background color and large text to the whole page -->
<div class="w3-container">
 <?php echo $backward;?> 
<?php echo $vk; ?>
<h1 class = "w3-center" style = "position:relative;top:15px;word-wrap:break-word;"><?php echo $whose_stories;?></h1>
 <?php echo $new; ?>
<main class="w3-content" style="max-width:700px;" >
    <?php echo $story_input_block; ?>
     <?php echo $discussions_container; ?>
 
  </main> <!-- End Main -->

</div>

</body>
</html>

<?php ob_end_flush(); ?>
