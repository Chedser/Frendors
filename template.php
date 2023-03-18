<?php ob_start(); ?>

<!DOCTYPE html>

<?php

session_start();
ini_set('display_errors', 'Off');

require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/user_info.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

function session_isset(){ 
if(!empty($_SESSION['user'])){ 
return true;
} else {
return false;
}
}

/* ОС пользователя */
if(session_isset()){ 
 $user_os = strtolower($_SERVER['HTTP_USER_AGENT']);
 $user_os_in_bd = "";
if(stripos($user_os,'android') !== false || stripos($user_os,'mobile') !== false || stripos($user_os,'iphone') !== false || stripos($user_os,'ipod') !== false || stripos($user_os,'ipad') !== false )  {
     $user_os_in_bd = "mobile";
  }else {
    $user_os_in_bd = "not_mobile";
} 

 // ВСТАВЛЯЕМ ОС В ТАБЛИЦУ 
        $sql = "UPDATE `main_info` SET `os`='$user_os_in_bd' WHERE `nickname`='{$_SESSION['user']}'";
        $query = $connection_handler->prepare($sql);
        $query->execute();  
}

$login_session = $_SESSION['user'];

function href2obj_post($text) { // Превращение из ссылки в объект под постом

$multimedia_under_post_arr = array();

// Видео с ютуба
     if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([m\.]*)?(youtube\.com\/watch\?v=)([a-zA-Z0-9\-_]{1,256})/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([m\.]*)?(youtube\.com\/watch\?v=)([a-zA-Z0-9\-_]{1,256})/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $outp_src = "";
        $multimedia_under_post_for_arr = "";
        
        $hash = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([m\.]*)?(youtube\.com\/watch\?v=)/is',"",$multimedia_src_arr[0]);
        
        $outp_src = "https://www.youtube.com/embed/" . $hash;
        $multimedia_under_post_for_arr = "<iframe class = 'video_under_post' src = '" . $outp_src . "' height = '200' frameborder = '0' allowfullscreen></iframe>";
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

     } 
     
// Видео с xvideo
     if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([m\.]*)?(xvideos\.com\/video)([0-9]{1,8})([\/])([a-zA-Z0-9\-_]{1,256})/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([m\.]*)?(xvideos\.com\/video)([0-9]{1,8})([\/])([a-zA-Z0-9\-_]{1,256})/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $outp_src = "";
        $multimedia_under_post_for_arr = "";
        
        $hash = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([m\.]*)?(xvideos\.com\/video)/is',"",$multimedia_src_arr[0]);
        
        $outp_src = "https://www.xvideos.com/embedframe/" . $hash; 
        $multimedia_under_post_for_arr = '<iframe class = "video_under_post" src=' . $outp_src . ' frameborder=0 height=200 allowfullscreen=allowfullscreen></iframe>';
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);
        
     } 
    
     // Видео с редтуба
     if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(ru.)?(redtube\.com\/)([0-9]{1,256})/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(ru.)?(redtube\.com\/)([0-9]{1,256})/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $outp_src = "";
        $multimedia_under_post_for_arr = "";
        
        $hash = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(ru.)?(redtube\.com\/?)/is',"",$multimedia_src_arr[0]);
        
        $outp_src = "https://embed.redtube.com/?id=" . $hash;
        $multimedia_under_post_for_arr = "<iframe class = 'video_under_post' src = '" . $outp_src . "' height = '200' frameborder = '0' allowfullscreen></iframe>";
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

     } 

/**********************************************************************************************************************************************************************************/
// Видео с вк
if(preg_match('/(^|[\n ])([\w]*?)(\/\/)?(vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=])+/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(\/\/)?(vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=])+/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $multimedia_under_post_for_arr = "<iframe class = 'video_under_post' src = '" . $multimedia_src_arr[0] . "' height = '200' frameborder = '0' allowfullscreen></iframe>";
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

} 

// Видео с порнхаба
     if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(rt\.)?(www.)?(pornhub\.com\/view_video\.php\?viewkey=)([a-zA-Z0-9\-_]{1,256})/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(rt\.)?(www.)?(pornhub\.com\/view_video\.php\?viewkey=)([a-zA-Z0-9\-_]{1,256})/is',$text, $multimedia_src_arr);  // Возвращает совпадение 
     
         $outp_src = "";
        $multimedia_under_post_for_arr = "";
     
        $hash = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(rt\.)?(www.)?(pornhub\.com\/view_video\.php\?viewkey=)/is',"",$multimedia_src_arr[0]);
        
        $outp_src = "https://www.pornhub.com/embed/" . $hash; 
        $multimedia_under_post_for_arr = "<iframe class = 'video_under_post' src = '" . $outp_src . "' height = '200' frameborder = '0' allowfullscreen></iframe>";
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
 $text = preg_replace("/(^|[\n ])([\w]*?)(\/\/vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=]{1,256})/","$1$2<a href='//$3$4' target = _blank>$3$4$5</a>", $text);
 $text = preg_replace("/(^|[\n ])([\w]*?)(\[url href=\"?)(https?:\/\/)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;#:%=+,])*)*)(\])([a-zA-Z0-9йцукенгшщзхфывапролджэячсмитьбюЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮ!?@.\s\n]{2,80})+(\"?\[\/url\])/", "$1$2<a href='$4$5' target = _blank>$11</a>" ,$text); 
 $text = preg_replace("/(^|[\n ])([\w]*?)(\[url href=\"?)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;#:%=+,])*)*)(\])([a-zA-Z0-9йцукенгшщзхфывапролджэячсмитьбюЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮ!?@.\s\n]{2,80})+(\"?\[\/url\])/", "$1$2<a href='http://$4' target = _blank>$10</a>" ,$text); 

 $text = preg_replace("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1<a href='mailto:$2@$3' target = _blank>$2@$3</a>", $text);

 return $text;

}

/* УЗНАЕМ ЯВЛЯЕТСЯ ЛИ ПОЛЬЗОВАТЕЛЬ НОВЫМ */
$sql = "SELECT *  FROM `main_info` WHERE `nickname`='{$_SESSION['user']}'";	
$query = $connection_handler->prepare($sql);
$query->execute();
$is_new_user = $query->fetchAll(PDO::FETCH_ASSOC);
$is_new_user = $is_new_user[0]['is_new_user'];  

if($is_new_user == 1){ // Является новым пользователем
           
           // ВСТАВЛЯЕМ ОПОВЕЩЕНИЕ В ТАБЛИЦУ ЛИЧНЫХ ОПОВЕЩЕНИЙ 
            $sql = "INSERT INTO `notice`(`noticer`,`noticed`,`description`,`type`) VALUE ('green_bot','{$_SESSION['user']}','empty','new_user')";
            $query = $connection_handler->prepare($sql);
            $query->execute();  
            
            // ВСТАВЛЯЕМ ОПОВЕЩЕНИЕ В ТАБЛИЦУ ОБЩИХ ОПОВЕЩЕНИЙ 
            $sql = "INSERT INTO `common_notice`(`noticer`,`description`,`type`) VALUE ('{$_SESSION['user']}','empty','new_user')";
            $query = $connection_handler->prepare($sql);
            $query->execute(); 
    
            /* УЖЕ НЕ НОВЫЙ */
            $sql = "UPDATE `main_info` SET `is_new_user`=0";	
            $query = $connection_handler->prepare($sql);
            $query->execute();
            
}

?>

<?php 

/* Ава для ВК */

$sql = "SELECT * FROM `additional_info` WHERE `nickname` = '{$login}'"; 	
$query = $connection_handler->prepare($sql); 
$query->execute();
$avatar_for_vk = $query->fetchAll(PDO::FETCH_ASSOC);
$avatar_for_vk = $avatar_for_vk[0]['avatar'];

/* ОПИСАНИЕ СТРАНИЦЫ ДЛЯ ВК */
$sql = "SELECT * FROM `user_status` WHERE `page`='{$login}' ORDER BY this_id DESC";
$query = $connection_handler->prepare($sql);
$query->execute();
$last_user_status_for_vk = $query->fetchAll(PDO::FETCH_ASSOC);
$last_user_status_for_vk = $last_user_status_for_vk[0]['status'];

?>

<html>
<head>
    <title><?php echo str_replace(" ","_",$login); ?></title>
    <meta charset = "utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name = "description" content = "<?php echo $last_user_status_for_vk;  ?>" />
    <meta name="keywords" content = "<?php echo $login; ?>,зеленый слоник, бердянск,больничка, сергей пахомов, владимир епифанцев,александр маслаев,александр осмоловский,сладкий хлеб,азов,украина,путин,политика" / >
    <meta name = "author" content = "<?php echo $login; ?>">

<meta property="og:title" content="<?php echo $login; ?>"/>
<meta property="og:description" content="<?php echo $last_user_status_for_vk;  ?>"/>
<meta property="og:image" content="users/<?php echo $avatar_for_vk; ?>">
<meta property="og:type" content="article"/>
<meta property="og:url" content= "//frendors.com/user.php?zs=<?php echo $login; ?>" />

<script src="bootstrap/js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

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
<!-- /Google counter -->
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});

function moveCaretToStart(inputObject)
{
if (inputObject.selectionStart)
{
 inputObject.setSelectionRange(0,0);
 inputObject.focus();
}
}
</script>
<script>

function play_audio(audio_arg){
    var audio = new Audio(audio_arg);
    audio.load();
    audio.play();
}

function setSelectionRange(input, selectionStart, selectionEnd) {
  if (input.setSelectionRange) {
    input.focus();
    input.setSelectionRange(selectionStart, selectionEnd);
  }
  else if (input.createTextRange) {
    var range = input.createTextRange();
    range.collapse(true);
    range.moveEnd('character', selectionEnd);
    range.moveStart('character', selectionStart);
    range.select();
  }
}
 
function setCaretToPos (input, pos) {
  setSelectionRange(input, pos, pos);
}

function tolink(message){
    return message.replace(/^(https?:\/\/)?(www\.)?(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;#%=+,])*)*)/ig, "<a href=//$3 target = _blank>$3</a>").
    replace(/^(ftps?:\/\/)?(www\.)?(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;#%=+,])*)*)/ig, "<a href=//$3 target = _blank>$3</a>").
    replace(/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/ig, "$1<a href=mailto:$2@$3 target = _blank>$2@$3</a>").
    replace(/(^|[\n ])([\w]*?)(\[url href=)(https?:\/\/)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;#%=+,])*)*)(\])([a-zA-Z0-9йцукенгшщзхфывапролджэячсмитьбюЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮ!?@.\s\n]{2,80})+(\[\/url\])/, "$1$2<a href='$4$5' target = _blank>$11</a>").
    replace(/(^|[\n ])([\w]*?)(\[url href=)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;#%=+,])*)*)(\])([a-zA-Z0-9йцукенгшщзхфывапролджэячсмитьбюЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮ!?@.\s\n]{2,80})+(\[\/url\])/, "$1$2<a href='http://$4' target = _blank>$10</a>");

}

</script>

<link rel = "stylesheet" href = "css/normalize.css"  type = "text/css" />
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<style>

/* Общее */
*{
    box-sizing: border-box;
    font-size:18px;
}

body, html {
    font-family:'Roboto'; 
    margin:0 auto;
    padding:5px;
    width:100%;
}

a{
    cursor:pointer;
     color:#2398D6;
}

/* Верхние элементы*/
#upper_elements{
    border-bottom:1px dashed black;
}

#more_bros_container{
display:inline-block;
}

#user_page_logo{
    height:20px;
    width:20px;
    display:inline-block;
     margin-top:0px;
}

#exit_button{
    display:inline-block;
    float:right;
 }

#exit_button_img, #more_bros_img{
    height:20px;
}

#logo_translate_exit_container{
    text-align:center;
   margin-bottom:-30px;
}

</style>    

<style>

.telled_ahuenno_span, 
.telled_gavno_span{
    color:#2398D6;
}

.telled_ahuenno_span:hover, 
.telled_gavno_span:hover{
    text-decoration:underline;
}

/*************************************/

#preview_div_post_img, 
#preview_div_post_video, 
#preview_frendors_page_iframe{
    margin-bottom:10px;
    display:none;
}

#preview_div_post_img{
    width:100%;
    max-height:650px;
}

.img_under_post{
    display:block;
    width:100%;
    max-height:300px;
}

    #user_wall_post_textarea_container{
        
    }

/**********************************************************/

.preview_div_comment_post_img, 
.preview_div_comment_post_video, 
.preview_frendors_page_comment_post_iframe{
    margin-bottom:10px;
    width:100%;
    display:none;
}

#preview_div_comment_post_img{
    height:500px;
}

.img_under_comment_post{
    display:block;
   width:100%;
    max-height:500px;
}

/*********************************************************/

.preview_div_reply_to_comment_img, 
.preview_div_reply_to_comment_video, 
.preview_frendors_page_reply_to_comment_iframe{
    margin-bottom:10px;
    display:none;
}

.preview_div_reply_to_comment_img{
    max-width:650px;
    max-height:650px;
}

.preview_div_reply_to_comment_video, 
.preview_frendors_page_reply_to_comment_iframe{
width:580px;
height:500px;
}

/***********************************************************/

.img_under_common_notice, .commented_img_under_common_notice{
    display:block;
    width:100%;
    max-height:190px;
    
}

.user_online{
    width:30px;
    height:30px;
    margin:5px;
   border-radius:100%; 
   display:inline-block;
}

#footer_links_container{
    display:none;
}

/* Отображение верхних ссылок и нижних невидимых в зависимости от ширины экрана */

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
    #footer_links_container {
        display:block;
    }
    
    #header{
        display:none;
    }
}

</style>

</head>    

<body onload = "scrollBottom();">

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

<style>
 
.dislike,
.indifferent {
display:inline-block;
color: blue;
padding:3px;
border-radius:3px;
cursor:pointer;
}

.dislike:hover,
.comments_dislikes_container:hover{
background:gray; /* Old browsers */
}

.indifferent:hover{
background: yellow; /* Old browsers */
}

</style>

<?php 

if(session_isset()){ // авторизовались

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

   // Выбираем все оповещения из базы 
$sql = "SELECT COUNT(*) AS `notice_count` FROM `notice` WHERE `noticed`='{$_SESSION['user']}' AND `is_readen`=0";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$notice_count = $query->fetchAll(PDO::FETCH_ASSOC);      
$notice_count = $notice_count[0]['notice_count']; 
 
$notice_count_badje = ""; 
 
if($notice_count > 0){
    
    $notice_count_badje = "<span class = 'badge badge-info'>{$notice_count}</span>";    

} 

}
?>

</div>

<style>

textarea{
    resize:none;
  }

#change_ava_img{
    float:left;
}

#notice_img{
    float:right;
}

/* Модальное окно смены авы */
.modal-main-avatar {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 2; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (Image) */
.modal-content-main-avatar {
    margin: auto;
    display: block;
    max-height:500px;
    max-width: 500px;
}

/* Caption of Modal Image (Image Text) - Same Width as the Image */
#caption_main_avatar_modal {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
}

/* Add Animation - Zoom in the Modal */
.modal-content-main-avatar, 
#caption_main_avatar_modal { 
    -webkit-animation-name: zoom;
    -webkit-animation-duration: 0.6s;
    animation-name: zoom;
    animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
    from {-webkit-transform:scale(0)} 
    to {-webkit-transform:scale(1)}
}

@keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
}

/* The Close Button */
.close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
}

.close:hover,
.close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
    .modal-content-main-avatar {
        width: 100%;
    }
}



/* Кнопки под авой */
#delete_friend_vbratki_doebat_bros_buttons_container{
    font-weight:normal;
}

#delete_friend_vbratki_doebat_buttons_container{
    margin-bottom:5px;
}

#wait_for_reply_cancel_friend_request_buttons_container{
 font-weight:normal;
}

#delete_friend_button,
#vbratki_button,
#doebat_button,
#bros_button{
    word-wrap:break-word;
    width:100%;
    display:block;
    margin:3px;
    background-color:#f5f5f5;
    color:black;
}

#delete_friend_button{

}

#delete_friend_button{
    
}

#vbratki_button{
   font-size:15px; 
}

#wait_for_reply2_button{
    
}

#doebat_button{

}

#bros_button_container{
   
}

#bros_button{
    word-wrap:break-word;
    display:block;
    color:black;
}

#wait_for_reply2{
    border:1px solid yellow;
    text-align:center;
    padding:5px; 
    margin-top:5px; 
    border-radius:3px;
    color:green;
    background-color:yellow;
    width:100%;
    word-wrap:break-word;
}


#wait_for_reply{
    display:none;
    border:1px solid yellow;
    text-align:center;
    padding:5px; 
    margin-top:5px; 
    border-radius:3px;
    color:green;
    background-color:yellow;
    width:100%;
    word-wrap:break-word;
}

#cancel_friend_request_button{
   display:none; 
   cursor:pointer; 
   padding:5px;
   margin-top:5px; 
   width:100%;
   text-align:center;
    word-wrap:break-word;
    margin-bottom:5px;
}

#cancel_friend_request_field{
    display:none; 
    border:1px solid yellow;
    padding:5px; 
    margin-top:5px; 
    border-radius:3px;
    color:green;
    background-color:yellow;
    text-align:center;
    width:100%;
     word-wrap:break-word;
}

#deleted_friend_message{
    display:none; 
    border:1px solid yellow;
    text-align: center;
    padding:5px; 
    margin:5px; 
    border-radius:3px;
    color:green;
    background-color:yellow;
    width:100%;
     word-wrap:break-word;
}

#friend_request_button{
    display:none;
    background-color:blue; 
    margin:5px;
    padding:5px; 
    cursor:pointer;
    color:white; 
    border-radius:5px; 
    width:100%;
     word-wrap:break-word;
}

#give_strap_button{
    width:100%;
    background-color:#ccc;
    color:black;
}

#give_strap_button_wrapper{
   word-wrap:break-word;
}

/* Модальное окно личного сообщения */
 #private_message_box {
   margin-top:50px;
} 

.delete_friend_reason_radios_label{
    font-size:18px;
}


 @-webkit-keyframes zoom {
    from {-webkit-transform: scale(0)}
    to {-webkit-transform: scale(1)}
}

@keyframes zoom {
    from {transform: scale(0.1)}
    to {transform: scale(1)}
} 

/* The Close Button */
.close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
}

.close:hover,
.close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
    .modal-content {
        width: 100%;
    }
}

/* Главный контэйнер */
#main_container{
    margin-top:5px;
}


#left_side_main_menu_wrapper{ /* Выравниватель левой стороны и меню */
   border:1px solid black;
}

#right_side_center_wrapper{ /* Выравниватель центра и правой стороны */
   
}

@media screen and (max-width: 768px) { /* Максимум планшет. Убираем RSS ленту, топ10 братков, контэйнер общих оповещений */
    #rss_container, #top15_good_users, #random_site_container{
        display:none; 
    }

}

/******** Меню слева *********************/
#main_menu_container{

}

#main_menu{
    
}

/******* Левая сторона. Ава *******/
#left_side_container{

}

/******* Середина. Стена *******/
#center_container{

}

.like,
.dislike, 
.indifferent{
    cursor:pointer;
    color:blue;
    border-radius:5px;
    font-size:15px;
}

.dislike{
    margin-left:10px;
}

</style>

<?php 

if(!empty($_SESSION['user'])){ // Авторизовались
    /* ОНЛАЙН | ОФФЛАЙН  */
$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $login_session, PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();

$sql = "SELECT last_action_time FROM main_info WHERE nickname=:nickname"; // Выбираем время последней активности пользователя	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $login, PDO::PARAM_STR);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);
$last_action_time = $result[0]['last_action_time'];

}

$online = ""; /* Текст, который будет отображаться в месте онлайн */

        if(($current_time - $last_action_time) <= 180){ // Разница <= 180 секунд
            
                /* ПРОВЕРЯЕМ С КАКОГО УСТРОЙСТВА ЗАЩЕЛ ПОЛЬЗОВАТЕЛЬ */
                $sql = "SELECT * FROM `main_info` WHERE `nickname`='{$login}'"; 	
                $query = $connection_handler->prepare($sql); //Подготавливаем запрос
                $query->execute();
                $user_os = $query->fetchAll(PDO::FETCH_ASSOC);
                $user_os = $user_os[0]['os'];

            if($user_os === 'mobile'){
                    $online = '<img src = imgs/phone.png id = zdesya_img_under_main_avatar />';
                }else {
                     $online = '<img src = imgs/zdesya.png id = zdesya_img_under_main_avatar />';
                }
           
            } 

?>

<style>

 #header { /* Шапка */
margin-bottom: 5px;
}

#header ul{
  padding:0;
}

#header a:active, 
#header a:visited, 
#header a:hover, 
#header span{
color:#2398D6;    
cursor:pointer;
}

#header li { /* Элементы шапки */
display:inline-block;
}

.header_items_img {
height:15px;
width:15px;
}

</style>

<div id = "main_container" class = "container-fluid">

<div class = "raw">

<div id = "main_menu_container"  class = "col-md-2">

<aside id = "main_menu">

<?php 

   $unanswered_questions_badje = ""; // Вопросы если черпак
   $answered_questions_badje = ""; // ОТВЕТЫ НА ВОПРОСЫ

if(!empty($_SESSION['user'])){

    // ПРОВЕРЯЕМ СУЩЕСТВУЕТ ЛИ ПОМОЩНИК В БАЗЕ ПОМОЩНИКОВ
    $sql = "SELECT * FROM `supporters` WHERE `user`='{$_SESSION['user']}'";	
    $query = $connection_handler->prepare($sql); 
    $query->execute();
    $supporter = $query->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($supporter)){
            
            // ПРОВЕРЯЕМ ЕСТЬ ЛИ ВОПРОСЫ В БАЗЕ
            $sql = "SELECT * FROM `support_questions` WHERE `supporter`='{$_SESSION['user']}' AND `is_answered`=0";	
            $query = $connection_handler->prepare($sql); 
            $query->execute();
            $unanswered_questions = $query->fetchAll(PDO::FETCH_ASSOC);
        
                if(count($unanswered_questions) > 0){ // Вопросы в базе есть
                     $unanswered_questions_badje = "<span class = 'badge' style='background-color:blue;color:black'>" . count($unanswered_questions) . "</span>";
                } 
             
        }

 // ПРОВЕРЯЕМ ЕСТЬ ЛИ ОТВЕТЫ В БАЗЕ
            $sql = "SELECT * FROM `support_questions` WHERE `user`='{$_SESSION['user']}' AND `is_viewed`=0 AND `is_answered`=1";	
            $query = $connection_handler->prepare($sql); 
            $query->execute();
            $answered_questions = $query->fetchAll(PDO::FETCH_ASSOC);
        
                if(count($answered_questions) > 0){ // Вопросы в базе есть
                     $answered_questions_badje = "<span class = 'badge' style='background-color:green;color:black'>" . count($answered_questions) . "</span>";
        } 

/************************************************************************************************************************************************************************/

$unanswered_question_badje_to_user = "";
$answered_question_badje_to_user = "";


if($_SESSION['user'] === $login){ // СИДИМ НА СВОЕЙ СТРАНИЦЕ
            
            // ПРОВЕРЯЕМ ЕСТЬ ЛИ НЕОТВЕЧЕННЫЕ ВОПРОСЫ В БАЗЕ К СЕССИОННОМУ
            $sql = "SELECT * FROM `user_questions` WHERE `user`='{$_SESSION['user']}' AND `is_answered`=0";	
            $query = $connection_handler->prepare($sql); 
            $query->execute();
            $unanswered_questions_to_user = $query->fetchAll(PDO::FETCH_ASSOC);
            
            if(count($unanswered_questions_to_user) > 0){
                $unanswered_questions_badje_to_user = "<span class = 'badge' style='background-color:blue;color:black'>" . count($unanswered_questions_to_user) . "</span>";
            }

            // ПРОВЕРЯЕМ ЕСТЬ ЛИ ОТВЕЧЕННЫЕ ВОПРОСЫ В БАЗЕ ОТ ДРУГОГО ПОЛЬЗОВАТЕЛЯ
            $sql = "SELECT * FROM `user_questions` WHERE `asker`='{$_SESSION['user']}' AND `is_answered`=1 AND `is_viewed`=0";	
            $query = $connection_handler->prepare($sql); 
            $query->execute();
            $answered_questions_to_user = $query->fetchAll(PDO::FETCH_ASSOC);
            
            if(count($answered_questions_to_user) > 0){
                $answered_questions_badje_to_user = "<span class = 'badge' style='background-color:green;color:black'>" . count($answered_questions_to_user) . "</span>";
            }

}

/********************************ОПОВЕЩЕНИЯ**************************************************************************************************************************************/

   // Выбираем все оповещения из базы 
 $sql = "SELECT COUNT(*) AS `notice_count` FROM `notice` WHERE `noticed`='{$_SESSION['user']}' AND `is_readen`=0";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$notice_count = $query->fetchAll(PDO::FETCH_ASSOC);      
$notice_count = $notice_count[0]['notice_count']; 

if($notice_count > 0){
    
    $notice_count_badje = "<span class = 'badge badge-info'>{$notice_count}</span>";    

}

/****************************************** Редактор **************************************************************************/
 
if(!empty($_SESSION['user'])){
    
    $vip_li = "";
    $vip_img = "";
    
            $sql = "SELECT * FROM `vips` WHERE `user`='{$login}'";	
            $query = $connection_handler->prepare($sql); 
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
    if(!empty($result)){
    
        $vip_img = "<img src = imgs/vip.png / style = 'width:15px;height:15px;display:block'>";
        
    }
 
            $sql = "SELECT * FROM `vips` WHERE `user`='{$_SESSION['user']}'";	
            $query = $connection_handler->prepare($sql); 
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
       
    if(!empty($result)){
       $vip_li =   "<li role = button><a href = editor.php>Редактор</a></li>";
       }

}
 
 
$app_id_vk = "5757931";
$secret_key_vk = "DMTvuElXhDwuUsBuAzhZ"; 
$code = $_GET['code'];
 
$oauth = file_get_contents('https://oauth.vk.com/access_token?client_id=' . $app_id_vk . '&client_secret=' . $secret_key_vk . '&redirect_uri=https://frendors.com/user.php?zs=' . $_GET['zs'] . '&code=' . $code);

$time = time();

/* ВСЕ ПОЛЬЗОВАТЕЛИ ЗДЕСЯ */
$sql = "SELECT * FROM `main_info`"; 
    $query = $connection_handler->prepare($sql);
    $query->execute();
$all_users_last_action_time = $query->fetchAll(PDO::FETCH_ASSOC); 
$counter10 = 0;

$all_user_separator = "";

echo "<section id = 'all_users_online'>";

for($i = 0; $i < count($all_users_last_action_time); $i++){
    if(($time - $all_users_last_action_time[$i]['last_action_time']) < 180 && $counter10 != 10 && $all_users_last_action_time[$i]['nickname'] !== $_SESSION['user']){
        ++$counter10;
        
        $sql = "SELECT `avatar` FROM `additional_info` WHERE `nickname`='" . $all_users_last_action_time[$i]['nickname'] . "'"; 
    $query = $connection_handler->prepare($sql);
    $query->execute();
$all_user_avatar = $query->fetchAll(PDO::FETCH_ASSOC);
$all_user_avatar = $all_user_avatar[0]['avatar'];
        echo "<section style = 'display:inline-block;'>" .
        
            "<a href = 'user.php?zs=" . $all_users_last_action_time[$i]['nickname'] . "' title = '" . $all_users_last_action_time[$i]['nickname'] . "'><img src = 'users/" . $all_user_avatar . "' class = 'user_online' title = '" . $all_users_last_action_time[$i]['nickname'] . "'/></a>" .
        
        "</section>";
    }
    
    if($counter10 > 0){
        $all_user_separator = "<div style = 'border:1px dashed black'></div></section>";
    }
}

echo $all_user_separator;
    
    echo 
    '<header id = "header">
            <ul style = "list-style:none; position:relative;top:0px; color:white;margin-right:0px;">
            <li role = "button" onmouseover = play_audio("sounds/hover.mp3")><a href = "user.php?zs=' . $_SESSION['user'] . '">Бумажка</a> | </li>
            <li role = "button" onmouseover = play_audio("sounds/hover.mp3")><a href = "dialogs.php">Вдвоем тута ' . $new_dialogs . '</a> | </li>
            <li role = "button" onmouseover = play_audio("sounds/hover.mp3")><a href = "bros.php?zs=' .$_SESSION['user'] . '">Братки ' . $new_friend . '</a> | </li>
            <li role = "button" onmouseover = play_audio("sounds/hover.mp3")><a href = "chat.php">Чатбот</a> | </li>
            <li role = "button" onmouseover = play_audio("sounds/hover.mp3")><a href = "fun_select.php">Шашки</a> | </li>
            <li role = "button" onmouseover = play_audio("sounds/hover.mp3")><a href = "radio.php" target = "_blank">Радио</a> | </li>
            <li role = "button" onmouseover = play_audio("sounds/hover.mp3")><a href = "malafil.php">Малафить</a> | </li>
            <li role = "button" onmouseover = play_audio("sounds/hover.mp3")><a href = "common_images.php">Картинки</a> | </li>
            <li role = "button" onmouseover = play_audio("sounds/hover.mp3")><a href = "common_videos.php">Видио</a> | </li>
            <li role = "button" onmouseover = play_audio("sounds/hover.mp3")><a href = "notices.php">Оповещения' . $notice_count_badje . '</a> | </li>
            <li role = "button" onmouseover = play_audio("sounds/hover.mp3")><a href = "streamer.php">Стример</a> | </li>
            <li role = button onmouseover = play_audio("sounds/hover.mp3")><a href = "support.php">Черпаки ' .  $unanswered_questions_badje . $answered_questions_badje . '</a> | </li>' .
            $vip_li .
            '</ul>    
    </header>';

}

?>

<style>

#footer{
   position:fixed;
   bottom:0;
   right:0px;
   width:100%;
   padding:5px;
   background-color:#f5f5f5;
   border:1px solid gray;
   z-index:1;
}

.footer_img{
    width:30px;
    height:30px;
    display:inline-block;
    margin-right:20px;
}

.footer_img:hover{
    border:1px solid black;
}

#footer_content #left_side_links{
      display:inline-block;
}

/* Три полоски */
.bars_container {
    display:inline-block;
    float:right;
    position:relative;
    top:2px;
    cursor: pointer;
    margin-right:3px;
}

.bar1, .bar2, .bar3 {
    width: 20px;
    height: 4px;
    background-color: #333;
    margin: 3px 0;
    transition: 0.4s;
}

.change .bar1 {
    -webkit-transform: rotate(-45deg) translate(-9px, 6px);
    transform: rotate(-45deg) translate(-9px, 6px);
}

.change .bar2 {opacity: 0;}

.change .bar3 {
    -webkit-transform: rotate(45deg) translate(-8px, -8px);
    transform: rotate(45deg) translate(-8px, -8px);
}

/* Контэйнер скрытых ссылок*/

#hidden_links_container{
    border:1px solid black;
    display:inline-block;
    position:fixed;
    bottom:35px;
    right:0px;
    width:150px;
    max-height:375px;
    background-color:#f5f5f5;
    z-index:1;
    
}

#hidden_links_container ul{
    margin-left:-35px;
    list-style:none; 
}

</style>

<script>
function showHiddenLinks(x) {
    x.classList.toggle("change");
     $("#hidden_links_container").toggle();
}

</script>

<?php 

if(session_isset()) {
echo "<div id = footer_links_container>
<div id = hidden_links_container style = display:none;>
             
             <ul>
            <li role = button><a href = user.php?zs=" . $_SESSION['user'] . ">Бумажка</a></li>
            <li role = button><a href = dialogs.php>Вдвоем тута" . $new_dialogs . "</a></li>
            <li role = button><a href = bros.php?zs=" . $_SESSION['user'] . ">Братки " . $new_friend . "</a></li>
            <li role = button><a href = chat.php>Чатбот</a></li>
            <li role = button><a href = fun_select.php>Шашки</a></li>
            <li role = button><a href = radio.php target = _blank>Радио</a></li>
            <li role = button><a href = malafil.php>Малафить</a></li>
            <li role = button><a href = common_images.php>Картинки</a></li>
            <li role = button><a href = common_videos.php>Видио</a></li>
            <li role = button><a href = notices.php>Оповещения " .  $notice_count_badje . "</a></li>
            <li role = button><a href = streamer.php>Стример</a></li>
            <li role = button><a href = support.php>Черпаки " .  $unanswered_questions_badje . $answered_questions_badje . "</a></li>" .
             $vip_li .
            "</ul>    
          </div>

<footer id = footer>
    <div id = footer_content>
    <div id = left_side_links>
        <a href = user.php?zs=" . $_SESSION['user'] . "><img class = footer_img  src = imgs/header/bumazhka.png title = Бумажка /></a>
        <a href = dialogs.php><img class = footer_img src = imgs/header/vdvoem_tuta.png title = Вдвоем тута />" . $new_dialogs . "</a>
        <a href = bros.php><img class = footer_img src = imgs/header/bratki.png title = Братки />" . $new_friend . "</a>
        <a href = notices.php><img class = footer_img src = imgs/header/opoves.png title = Оповещения />" . $notice_count_baje . "</a>
        <a href = streamer.php><img class = footer_img src = imgs/header/lenta.png title = Стример /></a>
    </div>    
         
        <div class=bars_container onclick=showHiddenLinks(this)>
         
          <div class=bar1></div>
          <div class=bar2></div>
          <div class=bar3></div>
        </div>
    </div>
</footer>
</div>";
}
?>

<div id="vk_subscribe">
    <a href = "//vk.com/green_elephante" target = "_blank" style = "color:black;font-size:15px;" title = "в группу не вступаешь -- по ебалу по ебалу получаешь нахуй"><img src = "zs_group.jpg"  height = "20" width = "20" style = "border-radius:100%;border:1px solid black"/>ГЛАВНАЯ группа  фильма</a>  
</div>

<style>

#random_site_container{
    margin-top:10px;
}

#mark_as_pidor_button{
    width:100%;
    margin-bottom:-3px;
    background-color:#ccc;
    color:black;
    }

</style>

</aside>

</div>    


<div id = "center_container" class = "col-md-10">

<main id = "center">

</main>    

</div><!-- Центр -->

</div> <!-- Главный контэйнер -->

</div><!-- Raw -->

</body>    
</html>

<?php ob_end_flush(); ?>
