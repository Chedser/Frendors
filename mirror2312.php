<?php ob_start(); ?>

<?php

ini_set('display_errors', 'Off');
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection_bot.php';

function href2obj_post($text) { // Превращение из ссылки в объект под постом

$multimedia_under_post_arr = array();

// Видео с ютуба
     if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([m\.]*)?(youtube\.com\/watch\?v=)([a-zA-Z0-9\-_]{1,256})/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([m\.]*)?(youtube\.com\/watch\?v=)([a-zA-Z0-9\-_]{1,256})/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $outp_src = "";
        $multimedia_under_post_for_arr = "";
        
        $hash = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([m\.]*)?(youtube\.com\/watch\?v=)/is',"",$multimedia_src_arr[0]);
        
        $outp_src = "https://www.youtube.com/embed/" . $hash;
        $multimedia_under_post_for_arr = "<div class = 'container-iframe'>
                                                <iframe class = 'responsive-iframe' src = '" . $outp_src . "' height = '200' frameborder = '0' allowfullscreen></iframe>
                                        </div>";
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

     } 
     
     // Видео с ютуба
     if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([m\.]*)?(youtu\.be\/)([a-zA-Z0-9\-_]{1,256})/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([m\.]*)?(youtu\.be\/)([a-zA-Z0-9\-_]{1,256})/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $outp_src = "";
        $multimedia_under_post_for_arr = "";
        
        $hash = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([m\.]*)?(youtu\.be\/)/is',"",$multimedia_src_arr[0]);
        
        $outp_src = "https://www.youtube.com/embed/" . $hash;
        $multimedia_under_post_for_arr = "<div class = 'container-iframe'>
                                                <iframe class = 'responsive-iframe' src = '" . $outp_src . "' height = '200' frameborder = '0' allowfullscreen></iframe>
                                        </div>";
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

     }
        // Видео с ютуба
     if(preg_match('/(^|[\n ])([\w]*?)(https:\/\/)([a-z0-9\.\/]{1,256})(\/audiomsg\/)([a-z0-9\.\/]{1,256})/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https:\/\/)([a-z0-9\.\/]{1,256})(\/audiomsg\/)([a-z0-9\.\/]{1,256})/is',$text, $multimedia_src_arr);  // Возвращает совпадение

        $multimedia_under_post_for_arr = "<audio src = " .  $multimedia_src_arr[0]  . " class = 'container-iframe' controls>
                                               
                                        </audio>";
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

     }
     
// Видео с xvideo
     if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([m\.]*)?(xvideos\.com\/video)([0-9]{1,8})([\/])([a-zA-Z0-9\-_]{1,256})/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([m\.]*)?(xvideos\.com\/video)([0-9]{1,8})([\/])([a-zA-Z0-9\-_]{1,256})/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $outp_src = "";
        $multimedia_under_post_for_arr = "";
        
        $hash = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([m\.]*)?(xvideos\.com\/video)/is',"",$multimedia_src_arr[0]);
        
        $outp_src = "https://www.xvideos.com/embedframe/" . $hash; 
        $multimedia_under_post_for_arr = "<div class = 'container-iframe'>
                                                <iframe class = 'responsive-iframe' src = '" . $outp_src . "' height = '200' frameborder = '0' allowfullscreen></iframe>
                                        </div>";
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);
        
     } 
    
     // Видео с редтуба
     if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(ru.)?(redtube\.com\/)([0-9]{1,256})/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(ru.)?(redtube\.com\/)([0-9]{1,256})/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $outp_src = "";
        $multimedia_under_post_for_arr = "";
        
        $hash = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(ru.)?(redtube\.com\/?)/is',"",$multimedia_src_arr[0]);
        
        $outp_src = "https://embed.redtube.com/?id=" . $hash;
        $multimedia_under_post_for_arr = "<div class = 'container-iframe'>
                                                <iframe class = 'responsive-iframe' src = '" . $outp_src . "' height = '200' frameborder = '0' allowfullscreen></iframe>
                                        </div>";
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

     } 

/**********************************************************************************************************************************************************************************/
// Видео с вк
if(preg_match('/(^|[\n ])([\w]*?)(\/\/)?(https:\/\/vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=])+/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(\/\/)?(https:\/\/vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=])+/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $multimedia_under_post_for_arr = "<div class = 'container-iframe'>
                                                <iframe class = 'responsive-iframe' src = '" . $multimedia_src_arr[0] . "' height = '200' frameborder = '0' allowfullscreen></iframe>
                                        </div>";
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

} 

// Видео с порнхаба
     if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(rt\.)?(pornhub\.com\/view_video\.php\?viewkey=)([a-zA-Z0-9\-_]{1,256})/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(rt\.)?(pornhub\.com\/view_video\.php\?viewkey=)([a-zA-Z0-9\-_]{1,256})/is',$text, $multimedia_src_arr);  // Возвращает совпадение 
     
         $outp_src = "";
        $multimedia_under_post_for_arr = "";
     
        $hash = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(rt\.)?(www.)?(pornhub\.com\/view_video\.php\?viewkey=)/is',"",$multimedia_src_arr[0]);
        
        $outp_src = "https://www.pornhub.com/embed/" . $hash; 
        $multimedia_under_post_for_arr = "<div class = 'container-iframe'>
                                                <iframe class = 'responsive-iframe' src = '" . $outp_src . "' height = '200' frameborder = '0' allowfullscreen></iframe>
                                        </div>";
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);
     } 

/**********************************************************************************************************************************************************************************/
     
// Картинка1   
     if(preg_match('/(^|[\n ])([\w]*?)(https:\/\/pp.userapi.com\/)([a-zA-Z0-9_\-\/\-.?&;%=+]{1,256})$/is',$text, $multimedia_src_arr) === 1){ 

        $multimedia_under_post_for_arr = "<img class = 'w3-threequarter multimedia_under_post' src = '" . $multimedia_src_arr[0] . "' onerror = this.src='imgs/file_not_found.png' />";  
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

     }      
     
     // Картинка2   
     if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/sun[0-9]{1,100}-[0-9]{1,100}\.userapi\.com\/)([a-zA-Z0-9_\-\/\-.?&;%=+\,!]{1,256})$/is',$text,$multimedia_src_arr) === 1){ 

        $multimedia_under_post_for_arr = "<img class = 'w3-threequarter multimedia_under_post' src = '" . $multimedia_src_arr[0] . "' onerror = this.src='imgs/file_not_found.png' />";  
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

     } 
     
        // Картинка3   
     if(preg_match('/(https:\/\/pp.vk.me\/)([a-zA-Z0-9_\-\/\-.?&;%=+]{1,256})$/is',$text,$multimedia_src_arr) === 1){ 

        $multimedia_under_post_for_arr = "<img class = 'w3-threequarter multimedia_under_post' src = '" . $multimedia_src_arr[0] . "' onerror = this.src='imgs/file_not_found.png' />";  
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

     } 
 
$multimedia_relult = "";


for($i = 0; $i < count($multimedia_under_post_arr); $i++){
    
    $multimedia_result .= $multimedia_under_post_arr[$i];
    
}

 return $multimedia_result;

}

/*************************************************************************************************************************************************************************/

function href2obj_comment_post($text) { // Превращение из ссылки в объект под комментом к посту

$multimedia_under_post_arr = array();

// Видео с ютуба
     if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)([a-zA-Z0-9\-_]{1,256})/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)([a-zA-Z0-9\-_]{1,256})/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $outp_src = "";
        $multimedia_under_post_for_arr = "";
        
        $hash = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)/is',"",$multimedia_src_arr[0]);
        
        $outp_src = "https://www.youtube.com/embed/" . $hash;
        $multimedia_under_post_for_arr = "<iframe class = 'video_under_comment_post' src = '" . $outp_src . "' frameborder = '0' allowfullscreen></iframe>";
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

     } 
     
     // Видео с xvideo
     if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([m\.]*)?(xvideos\.com\/video)([0-9]{1,8})([\/])([a-zA-Z0-9\-_]{1,256})/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([m\.]*)?(xvideos\.com\/video)([0-9]{1,8})([\/])([a-zA-Z0-9\-_]{1,256})/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $outp_src = "";
        $multimedia_under_post_for_arr = "";
        
        $hash = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([m\.]*)?(xvideos\.com\/video)/is',"",$multimedia_src_arr[0]);
        
        $outp_src = "https://www.xvideos.com/embedframe/" . $hash; 
        $multimedia_under_post_for_arr = '<iframe class = "video_under_comment_post" src=' . $outp_src . ' frameborder=0 height=200 allowfullscreen=allowfullscreen></iframe>';
         array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);
        
     } 

/**********************************************************************************************************************************************************************************/
// Видео с вк
if(preg_match('/(^|[\n ])([\w]*?)(\/\/)?(vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=])+/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(\/\/)?(vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=])+/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $multimedia_under_post_for_arr = "<iframe class = 'video_under_comment_post' src = '" . $multimedia_src_arr[0] . "' frameborder = '0' allowfullscreen></iframe>";
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

} 

 // Видео с редтуба
     if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(ru.)?(redtube\.com\/)([0-9]{1,256})/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(ru.)?(redtube\.com\/)([0-9]{1,256})/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $outp_src = "";
        $multimedia_under_post_for_arr = "";
        
        $hash = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(ru.)?(redtube\.com\/?)/is',"",$multimedia_src_arr[0]);
        
        $outp_src = "https://embed.redtube.com/?id=" . $hash;
        $multimedia_under_post_for_arr = "<iframe class = 'video_under_comment_post' src = '" . $outp_src . "' frameborder = '0' allowfullscreen></iframe>";
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

     } 

/**********************************************************************************************************************************************************************************/
     
// Картинка   
     if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([a-zA-Z0-9_\-.]{2,256})\.([a-zA-Z]{2,6})[\/]([a-zA-Z0-9_\/\-.?&;%=+])+(png|jpg|jpeg|gif)(\?extra=[a-zA-Z0-9_\-\/\-.?&;%=+]{1,256})?/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([a-zA-Z0-9_\-.]{2,256})\.([a-zA-Z]{2,6})[\/]([a-zA-Z0-9_\/\-.?&;%=+])+(png|jpg|jpeg|gif)(\?extra=[a-zA-Z0-9_\-\/\-.?&;%=+]{1,256})?/is',$text, $multimedia_src_arr);  // Возвращает совпадение
  
       $multimedia_under_post_for_arr = "<img class = 'img_under_comment_post' src = '" . $multimedia_src_arr[0] . "' onerror = this.src='imgs/file_not_found.png' />";  

        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

     }  

$multimedia_relult = "";

for($i = 0; $i < count($multimedia_under_post_arr); $i++){
    
    $multimedia_result .= $multimedia_under_post_arr[$i];
    
}

 return $multimedia_result;

}

/***********************************************************************************************************************************************************************/

function href2obj_common_notice($text) { // Превращение из ссылки в объект под постом

$multimedia_under_post_arr = array();

// Видео с ютуба
     if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)([a-zA-Z0-9\-_]{1,256})/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)([a-zA-Z0-9\-_]{1,256})/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $outp_src = "";
        $multimedia_under_post_for_arr = "";
        
        $hash = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)/is',"",$multimedia_src_arr[0]);
        
        $outp_src = "https://www.youtube.com/embed/" . $hash;
        $multimedia_under_post_for_arr = "<iframe class = 'video_under_common_notice' src = '" . $outp_src . "' frameborder = '0' allowfullscreen></iframe>";
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

     } 

/**********************************************************************************************************************************************************************************/
// Видео с вк
if(preg_match('/(^|[\n ])([\w]*?)(\/\/)?(vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=])+/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(\/\/)?(vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=])+/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $multimedia_under_post_for_arr = "<iframe class = 'video_under_common_notice' src = '" . $multimedia_src_arr[0] . "' frameborder = '0' allowfullscreen></iframe>";
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

} 

/**********************************************************************************************************************************************************************************/
    
// Картинка   
     if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([a-zA-Z0-9_\-.]{2,256})\.([a-zA-Z]{2,6})[\/]([a-zA-Z0-9_\/\-.?&;%=+])+(png|jpg|jpeg|gif)(\?extra=[a-zA-Z0-9_\-\/\-.?&;%=+]{1,256})?/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([a-zA-Z0-9_\-.]{2,256})\.([a-zA-Z]{2,6})[\/]([a-zA-Z0-9_\/\-.?&;%=+])+(png|jpg|jpeg|gif)(\?extra=[a-zA-Z0-9_\-\/\-.?&;%=+]{1,256})?/is',$text, $multimedia_src_arr);  // Возвращает совпадение
 
        $multimedia_under_post_for_arr = "<img class = 'img_under_common_notice' src = '" . $multimedia_src_arr[0] . "' onerror = this.src='imgs/file_not_found.png' />";  
 
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

     } 

$multimedia_relult = "";

for($i = 0; $i < count($multimedia_under_post_arr); $i++){
    
    $multimedia_result .= $multimedia_under_post_arr[$i];
    
}

 return $multimedia_result;

}

/***********************************************************************************************************************************************************************/

function tolink($text) { // Превращение в ссылку
 
 $text = preg_replace("/(^|[\n ])([\w]*?)(https?:\/\/)(www\.)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;#:%=+,])*)*)/is", "$1$2<a href='$3$4$5' target = _blank>$3$4$5</a>", $text); // http(s)://www.frendors.com
 $text = preg_replace("/(^|[\n ])([\w]*?)(https?:\/\/)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;#:%=+,])*)*)/is", "$1$2<a href='$3$4' target = _blank>$3$4</a>", $text); // http(s)://frendors.com
 $text = preg_replace("/(^|[\n ])([\w]*?)(www\.)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;#:%=+,])*)*)/is", "$1$2<a href='//$4' target = _blank>$3$4</a>", $text); // www.frendors.com
 $text = preg_replace("/(^|[\n ])([\w]*?)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;#:%=+,])*)*)/is", "$1$2<a href='//$3' target = _blank>$3</a>", $text); //frendors.com    
 $text = preg_replace("/(^|[\n ])([\w]*?)(https:\/\/yandex.ru\/search\/\?text=[&;=a-zA-Z0-9%+,йцукенгшщзхфывапролджэячсмитьбюЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮ!?@.\s\n]{1,256})/is","$1$2<a href='$3' target = _blank>$3</a>",$text); //yandex
 $text = preg_replace("/(^|[\n ])([\w]*?)(https:\/\/yandex.ru\/video\/search\?text=)([&;=a-zA-Z0-9%+,йцукенгшщзхфывапролджэячсмитьбюЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮ!?@.\s\n]{1,256})/is","$1$2<a href='$3$4' target = _blank>$3$4</a>",$text); //yandex
 $text = preg_replace("/(^|[\n ])([\w]*?)(\/\/vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=]{1,256})/","$1$2<a href='//$3$4' target = _blank>$3$4$5</a>", $text);
 $text = preg_replace("/(^|[\n ])([\w]*?)(\[url href=\"?)(https?:\/\/)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;#:%=+,])*)*)(\])([a-zA-Z0-9йцукенгшщзхфывапролджэячсмитьбюЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮ!?@.\s\n]{2,80})+(\"?\[\/url\])/", "$1$2<a href='$4$5' target = _blank>$11</a>" ,$text); 
 $text = preg_replace("/(^|[\n ])([\w]*?)(\[url href=\"?)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;#:%=+,])*)*)(\])([a-zA-Z0-9йцукенгшщзхфывапролджэячсмитьбюЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮ!?@.\s\n]{2,80})+(\"?\[\/url\])/", "$1$2<a href='http://$4' target = _blank>$10</a>" ,$text); 

 $text = preg_replace("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1<a href='mailto:$2@$3' target = _blank>$2@$3</a>", $text);

 return $text;

}

?>

<!DOCTYPE html>
<html>
<title>Зеркало</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karma">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Karma", sans-serif}
.w3-bar-block .w3-bar-item {padding:20px}
</style>
<body>

<?php 

$peer_id = "";
$set = "";

if(strlen($_GET['i']) !=0 && is_numeric($_GET['i'])){
    
$peer_id = $_GET['i'];

$sql = "SELECT * FROM `bot_vk` WHERE `peer_id`=:peer_id  ORDER BY id DESC LIMIT 200";	
$query = $chb->prepare($sql);
$query->bindParam(':peer_id', $peer_id, PDO::PARAM_STR); 
$query->execute();
$set = $query->fetchAll(PDO::FETCH_ASSOC); 
    
}else{
    
$sql = "SELECT * FROM `bot_vk` ORDER BY id DESC LIMIT 200";	
$query = $chb->prepare($sql);
//$query->bindParam(':peer_id', $peer_id, PDO::PARAM_STR); 
$query->execute();
$set = $query->fetchAll(PDO::FETCH_ASSOC); 
    
}


$sql = "SELECT DISTINCT `peer_id` FROM `bot_vk` ORDER BY id";	
$query = $chb->prepare($sql);
//$query->bindParam(':peer_id', $peer_id, PDO::PARAM_STR); 
$query->execute();
$peers_rt = $query->fetchAll(PDO::FETCH_ASSOC); 

$peers = "";

for($i = 0; $i < count($peers_rt); $i++){
  
  $tmp =   $peers_rt[$i]['peer_id'];
  
  if($tmp === '2000000012'){
      $tmp = 'Чат Евы и Шиша';
    }else if($tmp === '2000000002'){
         $tmp = 'Тестовый';
    }
  
    $peers .= "<a href=" . $_SERVER['SELF'] . "?i=" . $peers_rt[$i]['peer_id'] . " class=w3-bar-item w3-button>" . $tmp . "</a>";
    
}

$peers .= "<a href='/mirror.php' class=w3-bar-item w3-button>Весь</a>";

?>


<?php 

$msgs = "";

for($i = 0; $i < count($set); $i++){
  
  $id = $set[$i]['id'];
  
  $avatar = $set[$i]['avatar'];
  $vk_id = $set[$i]['vk_id'];
  $user_name = $set[$i]['user_name'];
  $user_last_name = $set[$i]['user_last_name'];
  $nickname = $set[$i]['nickname'];
  $msg = $set[$i]['msg'];
  $mm = href2obj_post($msg);
  $response = "";
  
  if(!empty($set[$i]['response'])){
       $response = "<hr class=w3-clear />" . tolink($set[$i]['response']);
      
  }
 
  $date = $set[$i]['date'];
    
    $msgs .= '<div class="w3-container w3-card w3-white w3-round w3-margin" id=' . $id . '><br>
       
        <div class="w3-row">
          
            <a href=https://vk.com/id' . $vk_id . ' target=_blank><img src="' . $avatar . ' alt="Avatar" class="w3-left w3-circle w3-margin-right" style="width:60px"></a>
            
                <span class="w3-right w3-opacity">' . $date . '</span>
            
                <h4><a href=https://vk.com/id' . $vk_id . ' target=_blank>' . $user_name . " " . $nickname . " " . $user_last_name . '</a></h4><br>
         
            <hr class="w3-clear">
           
            <p style=word-wrap:break-word>' . tolink($msg) . '</p>
       
        </div>'
 
    .   $mm     .
      '
     <div><p>' . tolink($response) . '</p></div>
      </div>';
    
}

?>

<!-- !PAGE CONTENT! -->
<div class="w3-main w3-content" style="max-width:600px;margin-top:20px">
<h1 style = "text-align:center;"><?php echo $peer_id; ?></h1>
<div class="w3-display-container">
<div class="w3-dropdown-click w3-display-middle">

  <button onclick="dropDown()" class="w3-button w3-black">peers</button>
 
  <div id="Demo" class="w3-dropdown-content w3-bar-block w3-border">
                    <?php echo $peers; ?>
   </div>
</div>
</div>



<script>
function dropDown() {
  var x = document.getElementById("Demo");
  if (x.className.indexOf("w3-show") == -1) { 
    x.className += " w3-show";
  } else {
    x.className = x.className.replace(" w3-show", "");
  }
}
</script>

<?php 

echo $msgs;

?>


<!-- End page content -->
</div>


</body>
</html>


<?php ob_end_flush(); ?>
