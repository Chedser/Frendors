<?php ob_start(); ?>

<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

$q = urlencode($_GET['q']);

$q_og = "";

if(!empty($q)){
    
    $q_og = '?q=' . $q;
    
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

 $url = "http://searx.roughs.ru/search?q={$q}&categories=general&format=json";
  $content = json_decode(file_get_contents($url));

$res_container = "";

foreach($content->results as $content){
    
    $link = $content->url;
    $title = $content->title;
    $description = $content->content;
    
       $res_container .= '<div class="w3-display-container w3-margin">   
          
            <div class="w3-card w3-white w3-round w3-margin w3-padding"><br>
             <a href=' . $link . ' target=_blank>'
         . $title . '</a><br />
                <hr class="w3-clear" style = "margin-top:-5px;">
               
               <div class="post_text_container" style = "margin-top:-10px;"> <p>' . tolink($description) . '</p></div>

             </div> 
       
        </div>';
    
}

?>

<!DOCTYPE html>
<html>
<title>Поиск долбоеба</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name = "description" content = "Долбоеба поиск" />
<meta name="keywords" content = "outmind, crazy, outstanding" / >
<meta name = "author" content = "Vectorlfex">

<meta property="og:title" content="Поиск долбоеба"/>
<meta property="og:description" content="Долбоеба поиск"/>
<meta property="og:image" content="https://frendors.com/users/user_page_logo.png">
<meta property="og:type" content="article"/>
<meta property="og:url" content= "https://frendors.com/search.php"<?php echo $q_og; ?> />
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inconsolata">

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

<script>

function search(){
var xmlhttp = new XMLHttpRequest();
var post_textarea = document.getElementById("post_input");

if(post_textarea.value === "" || post_textarea.value.match(/^\s+$/g)){return;}


window.location.assign('search.php?q=' + post_textarea.value.replace(' ', '+'));


}

function send_post_enter_key(event){
var char = event.which || event.keyCode;    
if(char == 13) {
search();    
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

<main class="w3-content" style="max-width:700px" >

            <div class="w3-card w3-white w3-round w3-margin" id = "post_input_block"><br>
                   
                    <div class="w3-row w3-padding">
                        <h1 style = "text-align:center">Поиск долбоеба</h1>
                      <input id = "post_input" placeholder = "пиши" class="w3-border w3-padding" 
                            onkeypress = "send_post_enter_key(event)" maxlength = "100" />
                 <button type="button" class="w3-button w3-block w3-blue-grey" onclick = search()>
                     <i class="fa fa-pencil"></i>Найти</button> 
                </div>
             
            </div>
         
         <div class="w3-display-container w3-margin">   
          
       <?php 
       
       if(empty($q)){
           
           echo "<h2 style='text-align:center'>Здеся будя результат</h2>";
           
           
       } else if(!empty($res_container)){
           
           echo $res_container;
           
       }
        ?>
       
        </div>     

  </main> <!-- End Main -->

</div>

</body>
</html>

<?php ob_end_flush(); ?>
