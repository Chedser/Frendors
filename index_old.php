<?php ob_start(); ?>

<?php

session_start();
ini_set('display_errors', 'Off');

header ("Content-Type: text/html; charset=UTF-8");

if(!empty($_COOKIE['user'])){
    header ("Location: user.php?zs=" . $_COOKIE['user']);
    exit();
}

require_once $_SERVER['DOCUMENT_ROOT'] . "/scripts/connection_games.php";
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/user_info.php';

$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

$login_session = 'Frendors';
$login = 'Frendors';

$facebook_client_id = '105917036567372';
$facebook_client_secret = '9aabc3fc9c30da1a922f615a1dbf2687';

$hashed_string = $facebook_client_id . $facebook_client_secret;

$fb_hash = crypt($hashed_string,'babushka_Misha');

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
     
// Видео с xvideo
     if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([m\.]*)?(xvideos\.com\/video)([0-9]{1,8})([\/])([a-zA-Z0-9\-_]{1,256})/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([m\.]*)?(xvideos\.com\/video)([0-9]{1,8})([\/])([a-zA-Z0-9\-_]{1,256})/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $outp_src = "";
        $multimedia_under_post_for_arr = "";
        
        $hash = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([m\.]*)?(xvideos\.com\/video)/is',"",$multimedia_src_arr[0]);
        
        $outp_src = "https://www.xvideos.com/embedframe/" . $hash; 
        $multimedia_under_post_for_arr = '<iframe class = "w3-half multimedia_under_post" src=' . $outp_src . ' frameborder=0 height=200 allowfullscreen=allowfullscreen></iframe>';
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);
        
     } 
    
     // Видео с редтуба
     if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(ru.)?(redtube\.com\/)([0-9]{1,256})/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(ru.)?(redtube\.com\/)([0-9]{1,256})/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $outp_src = "";
        $multimedia_under_post_for_arr = "";
        
        $hash = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(ru.)?(redtube\.com\/?)/is',"",$multimedia_src_arr[0]);
        
        $outp_src = "https://embed.redtube.com/?id=" . $hash;
        $multimedia_under_post_for_arr = "<iframe class = 'w3-half multimedia_under_post' src = '" . $outp_src . "' height = '200' frameborder = '0' allowfullscreen></iframe>";
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

     } 

/**********************************************************************************************************************************************************************************/
// Видео с вк
if(preg_match('/(^|[\n ])([\w]*?)(\/\/)?(vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=])+/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(\/\/)?(vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=])+/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $multimedia_under_post_for_arr = "<iframe class = 'w3-half multimedia_under_post' src = '" . $multimedia_src_arr[0] . "' height = '200' frameborder = '0' allowfullscreen></iframe>";
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

} 

// Видео с порнхаба
     if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(rt\.)?(pornhub\.com\/view_video\.php\?viewkey=)([a-zA-Z0-9\-_]{1,256})/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(rt\.)?(pornhub\.com\/view_video\.php\?viewkey=)([a-zA-Z0-9\-_]{1,256})/is',$text, $multimedia_src_arr);  // Возвращает совпадение 
     
         $outp_src = "";
        $multimedia_under_post_for_arr = "";
     
        $hash = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(rt\.)?(www.)?(pornhub\.com\/view_video\.php\?viewkey=)/is',"",$multimedia_src_arr[0]);
        
        $outp_src = "https://www.pornhub.com/embed/" . $hash; 
        $multimedia_under_post_for_arr = "<iframe class = 'w3-half multimedia_under_post' src = '" . $outp_src . "' height = '200' frameborder = '0' allowfullscreen></iframe>";
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);
     } 

/**********************************************************************************************************************************************************************************/
     
// Картинка   
     if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([a-zA-Z0-9_\-.]{2,256})\.([a-zA-Z]{2,6})[\/]([a-zA-Z0-9_\/\-.?&;%=+])+(png|jpg|jpeg|gif)(\?extra=[a-zA-Z0-9_\-\/\-.?&;%=+]{1,256})?/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([a-zA-Z0-9_\-.]{2,256})\.([a-zA-Z]{2,6})[\/]([a-zA-Z0-9_\/\-.?&;%=+])+(png|jpg|jpeg|gif)(\?extra=[a-zA-Z0-9_\-\/\-.?&;%=+]{1,256})?/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $multimedia_under_post_for_arr = "<img class = 'w3-half multimedia_under_post' src = '" . $multimedia_src_arr[0] . "' onerror = this.src='imgs/file_not_found.png' />";  
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
   $text = preg_replace("/(^|[\n ])([\w]*?)(https:\/\/yandex.ru\/search\/\?text=[&;=a-zA-Z0-9%+,йцукенгшщзхфывапролджэячсмитьбюЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮ!?@.\s\n]{1,256})/is","$1$2<a href='$3' target = _blank>$3</a>",$text); //yandex
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

/* ИЩЕМ ПСЕВДОНИК ПОЛЬЗОВАТЕЛЯ */
$sql = "SELECT * FROM `main_info` WHERE `nickname`='{$login}'";
$query = $connection_handler->prepare($sql);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);
$pseudonick  = $result[0]['add_nickname'];
$is_vk_user = $result[0]['reg_type'];

$vk_img = "";

if($is_vk_user === 'vk'){
  $vk_img = "<img src = imgs/vk.png height = '20' width = '20' style = 'display:block' />";  
}

?>

<?php 
/* ИЗВЛЕКАЕМ ПОСЛЕДНИЙ СТАТУС ИЗ ТАБЛИЦЫ */
$sql = "SELECT * FROM `user_status` WHERE `page`='{$login}' ORDER BY this_id DESC";
$query = $connection_handler->prepare($sql);
$query->execute();
$last_user_status = $query->fetchAll(PDO::FETCH_ASSOC);

$show_status_saver_function = "";
$user_status_style = "";

if($login === $login_session){
            if(empty($last_user_status)){ // Статусы есть
            $show_status_saver_function = ' onclick = "show_status_saver();"';
            $last_user_status = 'Расскажите свою историю';    
            $user_status_style = ' style=color:gray;';
            } else {
           
                   if($login !== 'Adminto'){
                        $last_user_status =  tolink($last_user_status[0]['status']);
                        $show_status_saver_function = ' onclick = "show_status_saver();"';
                     
                   } else{
                       $show_status_saver_function = ' onclick = "show_status_saver();"';
                       $last_user_status = tolink($last_user_status[0]['status']);
                       
                   }
                
            }
    } else if($login !== $login_session){
                if(empty($last_user_status)){
            $last_user_status = 'У пользователя пока что нет историй';  
               $user_status_style = ' style=color:gray;';
            } else {
            
            if($login !== 'Adminto'){
                        $last_user_status = tolink($last_user_status[0]['status']);
                    } else{
                       $last_user_status = tolink($last_user_status[0]['status']);
                    }
        }

    }

?>

<!DOCTYPE html>
<html>
<head>

<title>Индексная | Социальная сеть для долбоебов | frendors.com</title>

<meta charset = "utf-8"/>    
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<meta name = "description" content = "frendors.com — социальная сеть для долбоебов. Здесь нет модерации, цензуры и прочей хуйни. Регистрируйся или иди нахуй" />
<meta name="keywords" content = "социальная сеть для долбоебов,долбоебы,чудики,придурки" / >
<meta name = "author" content = "<?php echo $login; ?>">

<meta property="og:title" content="frendors.com"/>
<meta property="og:description" content="frendors.com — социальная сеть для долбоебов. Здесь нет модерации, цензуры и прочей хуйни. Регистрируйся или иди нахуй"/>
<meta property="og:image" content="users/<?php echo $avatar_for_vk; ?>">
<meta property="og:type" content="article"/>
<meta property="og:url" content= "//frendors.com/user.php?zs=<?php echo $login; ?>" />

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel = "stylesheet" href = "css/normalize.css"  type = "text/css" />
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

 <!-- Put this script tag to the <head> of your page -->
<script type="text/javascript" src="https://vk.com/js/api/openapi.js?159"></script>
<script type="text/javascript" src="//vk.com/js/api/openapi.js?136"></script>
<script type="text/javascript" src="//vk.com/js/api/openapi.js?137"></script>
<script type=text/javascript>
  VK.init({apiId: 6686305, 
  onlyWidgets: true});
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

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
<!-- /Google counter -->
<script>
/* $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});

function moveCaretToStart(inputObject)
{
if (inputObject.selectionStart)
{
 inputObject.setSelectionRange(0,0);
 inputObject.focus();
}
} */
</script>

<script>
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
    
    FB.api('/me', function(response) {

window.location.replace("facebook_auth.php?name=" + response.name.replace(" ","_") + "&id=" + response.id + "&a_cho_tam=<?php echo $fb_hash; ?>");

    });


    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into Facebook.';
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
  FB.init({
    appId      : '105917036567372',
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v6.0' // use graph api version 2.8
  });

  // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

</script>

<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '105917036567372',
      xfbml      : true,
      version    : 'v6.0'
    });
  };

</script>

<style>
* {
  box-sizing: border-box;
}

.row::after {
  content: "";
  clear: both;
  display: table;
}

[class*="col-"] {
  float: left;
  padding: 15px;
}

html {
  font-family: "Lucida Sans", sans-serif;
}

.block{
    margin-bottom:10px;
}

.nick{
    color:#2398D6;
    text-decoration:none;
    margin-bottom:-10px;
}
.menu ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
}

.menu li {
  padding: 8px;
  margin-bottom: 7px;
  background-color: #33b5e5;
  color: #ffffff;
  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
}

.menu li:hover {
  background-color: #0099cc;
}

.aside {
  background-color: #33b5e5;
  padding: 15px;
  color: #ffffff;
  text-align: center;
  font-size: 14px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
}

.footer {
  background-color: #0099cc;
  color: #ffffff;
  text-align: center;
  font-size: 12px;
  padding: 15px;
}

/* For mobile phones: */
[class*="col-"] {
  width: 100%;
  
}

#right-side {
display:none;
margin-top:15px;
}

/* TopNav  */

.topnav {
  overflow: hidden;
  background-color: #4D636F;
  position:fixed;
  width:100%;
  z-index:10;
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

/*** BodyLifestyle ***/

   #body_lifestyle_container {
        margin-left:10px;
        margin-top:-5px;
        word-wrap:break-word;
    
         }
   
    #body_lifestyle_container h1{
        display:inline-block;
        font-size:15px;
        margin:0;
    }
    
    #body_lifestyle_wrapper{
         text-align:center;
    }
    
    /*** UserStatus ***/
     #user_status{
       margin-top:5px;
       margin-left:5px;
       word-wrap:break-word;
       cursor:pointer;
       margin-bottom:0px;
       font-weight:normal;
       font-size:15px;
       border-top:1px solid #F5F7F8;
       border-bottom:1px solid #F5F7F8;
       padding-top:5px;
       padding-bottom:5px;
    }
   
 #user_status:hover{
     text-decoration:underline;
 }
 
 #user_status_textarea{
     width:95%;
 }
 
 /*** MainInfo ***/
 
    #main_info_container{
        overflow-y:auto;
        display:none;
        font-weight:normal;
    }
    
    #main_info{
        padding:5px;
        word-wrap:break-word;
    }
    
    #main_info td{
            }
            
    #info_a{
        text-decoration:underline;
        display:block;
        margin-bottom:10px;
    }
            
    #info_a:hover{
        cursor:pointer;
        text-decoration:none;
    }        
  
@media only screen and (max-width: 600px) {
    .green-spot{
    display:inline-block;
}
}

@media only screen and (max-width: 767px) {
    .green-spot{
    display:inline-block;
}

#middle_side{
    width:100%;
}    
    
}

#main_avatar{
    cursor:pointer;
}

#zdesya_img_under_main_avatar{
    width:15px;
    height:15px;
}

.multimedia_under_post{
    margin-bottom:5px;
}

@media only screen and (min-width: 768px) {
  /* For desktop: */
  .col-1 {width: 8.33%;}
  .col-2 {width: 16.66%;}
  .col-3 {width: 25%;}
  .col-4 {width: 33.33%;}
  .col-5 {width: 41.66%;}
  .col-6 {width: 50%;}
  .col-7 {width: 58.33%;}
  .col-8 {width: 66.66%;}
  .col-9 {width: 75%;}
  .col-10 {width: 83.33%;}
  .col-11 {width: 91.66%;}
  .col-12 {width: 100%;}
  #right-side {
display:block;
}

.topnav .a{
     padding: 14px 0.1%;
}

}

.container-iframe {
  position: relative;
  width: 100%;
  overflow: hidden;
  padding-top: 62.5%; /* 8:5 Aspect Ratio */
}

.responsive-iframe {
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  width: 100%;
  height: 100%;
  border: none;
    
}

</style>

<style>

/* Bordered form */
form {
  border: 3px solid #f1f1f1;
}

/* Full-width inputs */
input[type=email], input[type=password], input[type=text] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

/* Set a style for all buttons */
button {
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

/* Add a hover effect for buttons */
button:hover {
  opacity: 0.8;
}

/* Extra style for the cancel button (red) */
.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #f44336;
}

/* Center the avatar image inside this container */
.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
}

/* Add padding to containers */
.container {
  padding: 16px;
}

/* The "Forgot password" text */
span.psw {
  float: right;
  padding-top: 16px;
}

hr {
  border: 1px solid #f1f1f1;
  margin-bottom: 25px;
}

/* Clear floats */
.clearfix::after {
  content: "";
  clear: both;
  display: table;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
    display: block;
    float: none;
  }
  .cancelbtn {
    width: 100%;
  }
}

/* Change styles for cancel button and signup button on extra small screens */
@media screen and (max-width: 300px) {
  .cancelbtn, .signupbtn {
    width: 100%;
  }
}

#enter_loader {
  display:none;
  margin-top:0px;
  margin-left:0px;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid blue;
  border-right: 16px solid green;
  border-bottom: 16px solid red;
  border-left: 16px solid pink;
  width: 30px;
  height: 30px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}
@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

</style>

<script>
function authorization(){
        var login = document.getElementById("login");
        var pass = document.getElementById("password");
        var send_form_flag = true;
        var server_response = document.getElementById("server_response");
        var second_click = document.getElementById("second_click");
        var enter_button_text = document.getElementById("enter_button_text");
        var enter_loader = document.getElementById("enter_loader");
         enter_button_text.style.visibility = "hidden";
        enter_loader.style.display = "inline-block"; 
        if(login.value == "" || pass.value == ""){ 
            send_form_flag = false;
            alert("Пустая пара логин-пароль");
        }
function resp_to_json(response){ 
var json_obj = JSON.parse(response); 
return json_obj.auth_error;
}        
var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
    if(resp_to_json(xmlhttp.response) === "Неверная пара логин-пароль"){
     pass.value = "";
    alert("Неверная пара логин-пароль");
        } else if(resp_to_json(xmlhttp.response) === "Верная пара логин-пароль") {
        second_click.style.display = "inline";
        server_response.value = "true";        
        }
   enter_loader.style.display = "none";
   enter_button_text.style.visibility = "visible";
    } 
}
var formData = new FormData();
formData.append('user_login', login.value);
formData.append('user_password', pass.value);
xmlhttp.open("POST", "authorization_ajax.php", true);
xmlhttp.send(formData);
if(server_response.value == "false"){
    send_form_flag = false;
}
return send_form_flag;
  }
</script>

</head>

<body class="w3-theme-l5;" style = "background-color:#cefdce;" onload = "init_game();">
    
    <div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v6.0&appId=105917036567372&autoLogAppEvents=1"></script>
    
   <!-- VK Widget -->
<div id="vk_community_messages"></div>
<script type="text/javascript">
VK.Widgets.CommunityMessages("vk_community_messages", 175954919, {disableButtonTooltip: "1"});
</script>
    
<div id="fb-root"></div>

<!-- Page Container -->
<div class="w3-container w3-content" style="max-width:1400px;"> 

<!-- The Grid -->
<div class="row">
    <!-- Left Column -->
  <div class="col-3 menu" id = "left_side">
     <!-- Profile -->
      <div class="w3-card w3-round w3-white block">
            <div class="w3-container">
                 
                 <div class="w3-center" id = "main_avatar_container">
                     <img id = "main_avatar" src="imgs/logo.png" style="height:106px;width:106px;border-radius:5px;display:inline-block"
                     alt="<?php echo "frendors | " . $avatar; ?>" onerror = this.src='users/default_ava.jpg'>    
                    
                     </div>
                 <div id = "body_lifestyle_container">
              
                    <div id = "auth_container">    
                     
                         <div id = "vk_auth_container">
                         <div id="vk_auth"></div>
                         
                            <div style = "margin-top:5px;"> 
                            
                            <div class="fb-login-button" data-size="medium"
                            data-button-type="continue_with" data-layout="default"  
                            data-auto-logout-link="false" data-use-continue-as="true" data-onlogin="checkLoginState()"></div>
                            
                            </div>
                        
                        </div>
                    </div>
                </div>
         
<script>

function openTab(evt,tabName) {
  var i, x, tablinks;
  x = document.getElementsByClassName("lsform");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < x.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" w3-border-blue-grey", "");
  }
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " w3-border-blue-grey";
  
}    
    
</script>         
                   
<style>
    
* {box-sizing: border-box}

/* Add padding to containers */

/* Full-width input fields */
input[type=text], input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
}

input[type=text]:focus, input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}

/* Overwrite default styles of hr */
hr {
  border: 1px solid #f1f1f1;
  margin-bottom: 25px;
}

/* Set a style for the submit/register button */
.registerbtn {
  background-color: #4CAF50;
  color: white;
  padding: 16px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
}

.registerbtn:hover {
  opacity:1;
}

/* Set a grey background color and center the text of the "sign in" section */
.signin {
  background-color: #f1f1f1;
  text-align: center;
}
    
</style>
 
<script>
function captcha(){    
var first_digit_tmp = document.getElementById("first_digit");
var second_digit_tmp = document.getElementById("second_digit");
var conv_op_tmp = document.getElementById("conv_op");
var user_answer = document.getElementsByName('user_answer');
var first_digit = parseInt(first_digit_tmp.src.slice(-5,-4)); 
var second_digit = parseInt(second_digit_tmp.src.slice(-5,-4));
var conv_op = conv_op_tmp.src.slice(-10,-9); 
var user_answer_value = "";  
var submit_form = true;     
for(var i = 0; i < user_answer.length; i++){ 
    if(user_answer[i].checked){
    user_answer_value = user_answer[i].value;    
        }
}
    if(conv_op === 'b'){ 
    if((first_digit > second_digit) && (user_answer_value === "true")){ 
    } else if((first_digit > second_digit) && (user_answer_value === "false")){ 
    submit_form = false; 
    } else if((first_digit < second_digit) && (user_answer_value === "true")){ 
      submit_form = false; 
    } else if((first_digit < second_digit) && (user_answer_value === "false")){ 
    } else if((first_digit == second_digit) && (user_answer_value === "false")){ 
    } else if((first_digit == second_digit) && (user_answer_value === "true")){ 
      submit_form = false; 
    }
    } 
     else if(conv_op === 'l'){ 
if((first_digit < second_digit) && (user_answer_value === "true")){
    } else if((first_digit < second_digit) && (user_answer_value === "false")){ 
    submit_form = false; 
    } else if((first_digit > second_digit) && (user_answer_value === "true")){ 
      submit_form = false; 
    } else if((first_digit > second_digit) && (user_answer_value === "false")){ 
        }else if((first_digit == second_digit) && (user_answer_value === "false")){ 
    } else if((first_digit == second_digit) && (user_answer_value === "true")){ 
      submit_form = false; 
    } 
    }
    else if(conv_op === 'e'){ 
if((first_digit == second_digit) && (user_answer_value === "true")){ 
}else if((first_digit == second_digit) && (user_answer_value === "false")){ 
submit_form = false; 
}
 else if((first_digit !== second_digit) && (user_answer_value === "false")){ 
}else if((first_digit !== second_digit) && (user_answer_value === "true")){ 
submit_form = false; 
}
} 
return submit_form;    
} 
 
function password_length(password_input){
var password_length_span = document.getElementById("password_length_span");
var password_length_img = document.getElementById("password_length_img");

password_length_span.style.color = "red";
password_length_img.src = "imgs/qwick_registration_not_free.png";
if(password_input.value !== ""){
    if(password_input.value.length < 6){
password_length_span.innerHTML = "<6";        
    } else  { 
    password_length_span.style.color = "green";
    password_length_img.src = "imgs/qwick_registration_free.png";
    }
}else {

  }
}    
var pass = document.getElementById("pass");
var pass_confirm = document.getElementById("pass_confirm");
function check_passes(){ 
if(pass.value !== "" && pass_confirm.value !== ""){
if(pass.value !== pass_confirm.value){
return false;    
}else {
    return true;    
    }
    } else {
    return false;    
    }
}
/*var ava_canvas = document.getElementById("ava_preview");
var ava_canvas_ctx = ava_canvas.getContext("2d");
function canvas_onload(){
        var image_obj = new Image(); 
        image_obj.src = "logo.png";    
        image_obj.weight = 200;
        image_obj.height = 200;

image_obj.onload = function(){
ava_canvas_ctx.drawImage(image_obj, 0, 0, 300, 150);
        }
}*/
 
var is_hidden = true;
function show_hide_pass(button){
var pass_confirm = document.getElementById("pass_confirm");
var pass = document.getElementById("pass");
if(pass_confirm.value === "" &&   pass.value === ""){
return;    
}
if(is_hidden){
    pass.type = "text";
    pass_confirm.type = "text";
    button.innerHTML = "Скрыть";
    is_hidden = false;
    } else {
    pass.type = "password";    
    pass_confirm.type = "password";
    button.innerHTML = "Показать";
    is_hidden = true;
}    
}
var file_errors_span = document.getElementById("file_errors_span");
var valid_file = true; 
var is_empty_canvas = document.getElementById("is_empty_canvas");
var is_empty_user_avatar = document.getElementById("is_empty_user_avatar");
function check_file(file){ 
    var avatar_file = file.files[0];    
    var avatar_info_span = document.getElementById("avatar_info_span"); 
    var accept = ["image/jpeg","image/png","image/gif"]; 
    var errors_txt = ""; 
    var file_info_txt = "";
    var accepted_format = true;
    if(accept.indexOf(avatar_file.type) == -1){
    errors_txt += "Данный формат авы не поддерживается <br />";
    console.log("Данный формат авы не поддерживается");
    accepted_format = false;
    valid_file = false;
    }
    if(accepted_format = true){ 
     if(avatar_file.size > 5242880){
    console.log("Размер файла должен быть <= 5 Мб");
    errors_txt += "Размер файла должен быть <= 5 Мб";
    valid_file = false;
        }
    }
    if(errors_txt !== ""){
    file_errors_span.style.display = "block";    
    file_errors_span.innerHTML = errors_txt;    
    valid_file = false;
    }
   if(valid_file == true){ 
file_info_txt += avatar_file.name + "<br />" + Math.ceil(((avatar_file.size/1024)/1024) * 10) / 10  + " Мб";    
avatar_info_span.style.display = "block";
avatar_info_span.innerHTML = file_info_txt;
var img_obj = new Image();
var imageUrl = URL.createObjectURL(avatar_file);
img_obj.src = imageUrl;
ava_canvas_ctx.fillStyle = "#FFFFFF";    
ava_canvas_ctx.fillRect(0,0,300,150);
 img_obj.onload = function(){
   URL.revokeObjectURL(imageUrl);	
ava_canvas_ctx.drawImage(img_obj, 0, 0, 300, 150);
is_empty_user_avatar.value = "false";
        }  
}
}
function check_nick_pattern(nickname_input){ 
		if(nickname_input.match(/[A-Za-zА-ЯабвгдежзийклмнопрстуфхцчшщЪыьэюя0-9]{2,20}/g) !== null) return true;
		else return false;
	}
function check_mail_pattern(email_input){ 
		if(email_input.match(/([A-Za-z0-9@])([\.])/g) !== null) return true;
		else return false;
	}
var common_errors_span = document.getElementById("common_errors_span"); 
var register = true;
   
var nickname_input = document.getElementById("nick");
var email_input = document.getElementById("email");
var nick_server_response_img = document.getElementById("nick_server_response_img"); 
var mail_server_response_img = document.getElementById("mail_server_response_img"); 
function send_form(event){
var common_errors_txt = "";
if(nickname_input.value !== ""){ 
if(check_nick_pattern(nickname_input.value) == false){
register = false;    
common_errors_txt += "Ник не соответствует формату<br />";
}   
} else{ 
    register = false;    
common_errors_txt += "Введите ник<br />";
}
if(email_input.value !== ""){
if(check_mail_pattern(email_input.value) == false){
register = false;    
common_errors_txt += "Email не соответствует формату<br />";
}   
}else { 
register = false;    
common_errors_txt += "Введите email<br />";
}
if(pass.value.length > 0 && pass.value.length < 6  ){
register = false;    
common_errors_txt += "Длина пароля < 6<br />";
}
if(check_passes() == false){
register = false;
common_errors_txt += "Пароли не совпадают либо пустые<br />";
}
if(nick_server_response_span.innerHTML !== ""){
if(nick_server_response_span.innerHTML === "Занят"){
register = false;
common_errors_txt += "Ник занят<br />";
} else if(nick_server_response_span.innerHTML === "Неверный ввод"){
register = false;
common_errors_txt += "Ник не соответствует формату<br />";
}
}
if(mail_server_response_span.innerHTML !== ""){
if(mail_server_response_span.innerHTML === "Занят"){
register = false;
common_errors_txt += "Email занят<br />";
} else if(mail_server_response_span.innerHTML === "Неверный ввод"){
register = false;
common_errors_txt += "Email не соответствует формату<br />";
}
}
if(captcha() == false){
register = false;
common_errors_txt += "Неверный ответ с какчи<br />";
}
common_errors_span.style.display = "inline";
common_errors_span.innerHTML = common_errors_txt;
return register;
}
function check_nick_ajax(nick_input){ 
    var nick_server_response_img = document.getElementById("nick_server_response_img"); 
var mail_server_response_img = document.getElementById("mail_server_response_img"); 
    
    
   var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function(){ 
if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
resp_to_json(xmlhttp.response);
}
} 
function resp_to_json(response){ 
var json_obj = JSON.parse(response); 
if(json_obj.server_response === "Неверный ввод" || json_obj.server_response === "Пусто" || json_obj.server_response === "Занят"){ 
nick_server_response_img.src = "imgs/qwick_registration_not_free.png";
nick_server_response_span.style.color = "red";
} else {
    nick_server_response_img.src = "imgs/qwick_registration_free.png";
nick_server_response_span.style.color = "green";
};

}
xmlhttp.open("GET", "handlers/check_nick_ajax.php?nick=" + nick_input.value, true);
xmlhttp.send();
}
function check_mail_ajax(mail_input){ 
   var xmlhttp = new XMLHttpRequest();
   xmlhttp.onreadystatechange = function(){ 
if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
resp_to_json(xmlhttp.response);
}
} 
function resp_to_json(response){ 
var json_obj = JSON.parse(response);
if(json_obj.server_response === "Неверный ввод" || json_obj.server_response === "Пусто" || json_obj.server_response === "Занят"){
mail_server_response_img.src = "imgs/qwick_registration_not_free.png";
mail_server_response_span.style.color = "red";
} else {
    mail_server_response_img.src = "imgs/qwick_registration_free.png";
mail_server_response_span.style.color = "green";
};

}
xmlhttp.open("GET", "handlers/check_mail_ajax.php?mail=" + mail_input.value, true);
xmlhttp.send();
}
</script>                   
                        
<div class="tabs_container w3-clear" style = "margin-bottom:-14px;">
  <button class="w3-half tablink w3-bottombar w3-light-grey w3-padding w3-border-blue-grey" onclick="openTab(event,'login_form')">Вход</button>
  <button class="w3-half tablink w3-bottombar w3-light-grey w3-padding" onclick="openTab(event, 'signin_form')">Регистрация</button>
</div>     

                         <!-- The Modal -->
<div class="modal lsform" style = "margin-top:5px;" id = "login_form">

  <!-- Modal Content -->
  <form class="modal-content" id = "auth_form" method = "POST" action="authorization.php" onsubmit = "return authorization()">
    
    <div class="container">

      <input type = "email" placeholder = "Емайл" name = "user_login" id = "login" required>


      <input type="password" name = "user_password" placeholder = "Пароль" id = "password" required>
      <span id = "second_click" style = "display:none;">&ensp; one click yet</span>

      <button type="submit" id = "enter_button"><div id = "enter_loader"></div>Ахуенно</button>
      <label>
    </label><br />
  
    </div>

    <div class="container" style="background-color:#f1f1f1">
          <span class="psw">Забыл <a href="forgot_pass.php" target = "_blank">пароль</a> нахуй!</span>
    </div>
  </form>
</div>


<div class = "modal lsform" style = "display:none" id = "signin_form">
 <form action = "handlers/qwick_registration_main_info.php" method = "POST"
          enctype="multipart/form-data" id = "#qwick_registration_form" name = "quick_registration_form" 
          onsubmit = "return send_form()">
  <div class = "container">

    <input type="text" placeholder="Ник" name = "nick" id = "nick" maxlength = "20" 
    pattern = "[a-zA-ZЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮабвгдежзийклмнопрстуфхцчшщЪыьэюяё0-9ё_]{2,20}" 
    onblur = "check_nick_ajax(this)" required />
    <div id = "nick_server_response_container">
    <img id = "nick_server_response_img" src = "imgs/white_space.png" width = "20" height = "20" alt = "nick_server_response_img" />
    <span id = "nick_server_response_span"></span>
    
    <span style = "color:gray; font-size:12px" required = "required">[a-z, A-Z _ ] {2-20 символов}</span>
    </div>

    <input type="email" placeholder="Емайл" name="email" id = "email" id = "email" required />
    
    <div id = "nick_sever_response_container"> 
    <img id = "mail_server_response_img" src = "imgs/white_space.png" width = "20" height = "20" alt = "mail_server_response_img" />
    <span id = "mail_server_response_span"></span>
    </div>

    <input type="password" placeholder="Пароль" name="pass" maxlength = "20" onblur = "password_length(this)" required />
    
    <div id = "password_length_container">
        <img id = "password_length_img" src = "imgs/white_space.png" width = "20" height = "20" alt = "password_length_img" />
        <span id = "password_length_span"></span> 
    
    </div> 

    <input type="password" placeholder="Повторить" name = "pass_confirm" id = "pass_confirm"  required />

<div id = "captcha" style = "margin-top:5px;">
Правильно нахуй!?
<div id = "captcha_imgs"><img src = "captcha/<?php 
$rand_pict = mt_rand(1,9);
echo $rand_pict;
?>.png" id = "first_digit" width = "50" height = "100" /> <img src = "captcha/<?php 
$rand_conv = mt_rand(0,2);
if($rand_conv == 1) echo 'bigger';
else if($rand_conv == 0) echo 'lesser';
else echo 'equall';   
?>.png" id = "conv_op" width = "50" height = "100" /> <img src = "captcha/<?php 
$rand_pict = mt_rand(1,9);
echo $rand_pict;
?>.png" id = "second_digit" width = "50" height = "100" />
</div>
                <div id = "radios_container" style = "margin:5px;">
                <input type = "radio" class = "w3-radio" name = "user_answer" id = "user_answer_true" value = "true" checked = "checked"/>Да<br />
                <input type = "radio" class = "w3-radio" name = "user_answer" id = "user_answer_false" value = "false"/>Не
                </div>
</div> 

    <button type="submit" id = "qwick_registration_button" class="registerbtn">Стать долбоебом</button>
  </div>

</form>
</div>

            <!-- End ProfileW3-Container -->
        </div>
    
    <!-- End Profile -->
      </div>



<!-- End Left Column -->
</div>

<style>

#user_wall_message{

    width:100%;
    resize:none;
    height:35px;
    overflow:hidden;

}
.multimedia_under_post {
    padding:5px;
}

.post_container{
    padding-bottom:5px;
    word-wrap:break-word;
}

  #preview_div_post_container{
      padding-top:10px;
      display:none;
  }

 #preview_div_post_img, 
 #preview_div_post_video{

    display:none;
 }
 
 .multimedia_post_preview{
     margin-right:5px;
     margin-top:10px;
     width:48%;
     
 }
 
 .close-cross{
     font-size:15px;
     color:gray;
     position:relative;
     bottom:23px;
     left:12px
 }
 
 .close-cross:hover{
     cursor:pointer;
 }
 
 .ahuenno_teller_avatar{
     width:50px;
     height:50px;
     border-radius:100%;
 }
 
</style>

<?php

/*  ИЗВЛЕКАЕМ ВСЕ СООБЩЕНИЯ НА СТЕНУ ИЗ БАЗЫ */
$sql = "SELECT wall_user_posts.nickname, wall_user_posts.message, wall_user_posts.date, wall_user_posts.whose_multimedia, wall_user_posts.multimedia_id, 
wall_user_posts.this_id AS post_id,wall_user_posts.type,wall_user_posts.post_sender_ahuenno,wall_user_posts.post_sender_gavno, additional_info.avatar FROM wall_user_posts" . 
" INNER JOIN additional_info ON wall_user_posts.nickname=additional_info.nickname WHERE page_id='{$login}' ORDER BY wall_user_posts.this_id DESC LIMIT 100";
    $query = $connection_handler->prepare($sql);
    $query->execute();
$posts = $query->fetchAll(PDO::FETCH_ASSOC);
$posts_count_on_wall = count($posts);

$sql = "SELECT COUNT(this_id) AS num_rows from wall_user_posts"; // Извлекаем все сообщения на стену из базы 
    $query = $connection_handler->prepare($sql);
    $query->execute();
$num_rows = $query->fetchAll(PDO::FETCH_ASSOC); // Получаем двумерный массив строк
 $total_posts_count  = $num_rows[0]['num_rows']; // Количество комментариев  

if($posts_count_on_wall > 0){
 for($i = 0; $i < $posts_count_on_wall; $i++ ){ // ОТОБРАЖАЕМ ВСЕ СООБЩЕНИЯ
        $post_text = tolink(nl2br($posts[$i]['message']));
        $post_type = $posts[$i]['type'];
        $iframe_for_multimedia_post = href2obj_post(nl2br($posts[$i]['message']));
     
      $whose_multimedia = $posts[$i]['whose_multimedia']; 
       $image_id = $posts[$i]['multimedia_id'];
     
     /* ПРОВЕРЯЕМ РАССКАЗАЛ ЛИ ПОЛЬЗОВАТЕЛЬ О ДАННОМ ПОСТЕ АХУЕННО */
        $sql = "SELECT * FROM `tell_to_bros_ahuenno_post` WHERE `teller`='{$posts[$i]['nickname']}' AND `post_id`={$posts[$i]['post_id']}"; 	
        $query = $connection_handler->prepare($sql); //Подготавливаем запрос
        $query->execute();
        $telled_ahuenno = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $telled_ahuenno_span = ''; // Там где написано рассказать браткам
        $post_sender_ahuenno = $posts[$i]['post_sender_ahuenno'];
        $ahuenno_teller_avatar = "";
        
        if(!empty($telled_ahuenno)){
           $post_sender_ahuenno = $posts[$i]['post_sender_ahuenno'];
       
        }         
 
         /* ПРОВЕРЯЕМ РАССКАЗАЛ ЛИ ПОЛЬЗОВАТЕЛЬ О ДАННОМ ПОСТЕ ГАВНО */
        $sql = "SELECT * FROM `tell_to_bros_gavno_post` WHERE `teller`='{$posts[$i]['nickname']}' AND `post_id`={$posts[$i]['post_id']}"; 	
        $query = $connection_handler->prepare($sql); 
        $query->execute();
        $telled_gavno = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $telled_gavno_span = ''; // Там где написано рассказать браткам
        $post_sender_gavno = $posts[$i]['post_sender_gavno'];
     
        if(!empty($telled_gavno)){
           $post_sender_gavno = $posts[$i]['post_sender_gavno'];
        }
  
     switch($post_type){
    case 'telled_ahuenno':      /* ИЗВЛЕКАЕМ АВТАР */
                            $sql = "SELECT * FROM `additional_info` WHERE `nickname`='{$post_sender_ahuenno}'"; 	
                            $query = $connection_handler->prepare($sql); //Подготавливаем запрос
                            $query->execute();
                            $result = $query->fetchAll(PDO::FETCH_ASSOC);
                            $ahuenno_teller_avatar =  $result[0]['avatar'];   
        
                            $post_text = "<header class = ahuenno_post_header>Ахуенно &rarr; <a href = user.php?zs=" . str_replace(" ", "%20", $post_sender_ahuenno) . " >
                            <img src = 'users/" . $ahuenno_teller_avatar . "' class = 'ahuenno_teller_avatar' /> {$post_sender_ahuenno}</a></header>
                            <div class = 'w3-panel w3-pale-green' style = margin-bottom:-1px>" . tolink(nl2br($posts[$i]['message'])) . "</div>";  
                            break;
    case 'telled_gavno': /* ИЗВЛЕКАЕМ АВТАР */
                            $sql = "SELECT * FROM `additional_info` WHERE `nickname`='{$post_sender_gavno}'"; 	
                            $query = $connection_handler->prepare($sql); //Подготавливаем запрос
                            $query->execute();
                            $result = $query->fetchAll(PDO::FETCH_ASSOC);
                            $gavno_teller_avatar =  $result[0]['avatar']; 
        
                        $post_text = "<header class = gavno_post_header>Гавно! &rarr; <a href = user.php?zs=" . str_replace(" ", "%20", $post_sender_gavno) . ">
                        <img src = 'users/" . $gavno_teller_avatar . "' class = 'ahuenno_teller_avatar' />{$post_sender_gavno}</a></header>
                          <div>" . tolink(nl2br($posts[$i]['message'])) . "</div>";
                          break;
                            
    case 'telled_ahuenno_common_image': 
                                        $post_text = "<header class = ahuenno_post_header>Ахуенно &rarr; <a href = 'user.php?zs=" . str_replace(" ","%20",$whose_multimedia) . "' target='_blank'>" . str_replace(" ","_",$whose_multimedia) . "</a> </header>
                                        <div class = 'w3-panel w3-pale-green' = margin-bottom:-1px><a href = 'common_images.php?image_id={$image_id}' target='_blank'><span style = 'display:none'>{$posts[$i]['message']}</span>https://frendors.com/common_images.php?image_id={$image_id}</a></div>"; 
                                        break;
    case 'telled_ahuenno_primary_image':$post_text = "<header class = ahuenno_post_header>Ахуенно &rarr; <a href = 'user.php?zs=" . str_replace(" ","%20",$whose_multimedia) . "' target='_blank'>" . str_replace(" ","%20",$whose_multimedia) . "</a> </header>
                                        <div class = 'w3-panel w3-pale-green' style = margin-bottom:-1px><a href = 'primary_album.php?zs=" . str_replace(" ","%20",$whose_multimedia) . "&image_id={$image_id}' target='_blank'><span style = 'display:none'>{$posts[$i]['message']}</span>https://frendors.com/primary_album.php?zs=" . str_replace(" ","%20",$whose_multimedia) . "&image_id={$image_id}</a></div>";  
                                        break;
    case 'telled_ahuenno_common_video': $post_text = "<header class = ahuenno_post_header>Ахуенно &rarr; <a href = 'user.php?zs=" . str_replace(" ","%20",$whose_multimedia) . "' target='_blank'>" . str_replace(" ","%20",$whose_multimedia) . "</a> </header>
                                        <div class = 'w3-panel w3-pale-green' style = margin-bottom:-1px><a href = 'https://frendors.com/common_videos.php#user_video_container_{$video_id}' target='_blank'>
                                        <span style = 'display:none'>{$posts[$i]['message']}</span>https://frendors.com/common_videos.php#user_video_container_{$video_id}</a></div>";  
                                        break;
    
    case 'telled_gavno_primary_image':  $post_text = "<header class = ahuenno_post_header>Гавно! &rarr; <a href = 'user.php?zs=" . str_replace(" ","%20",$whose_multimedia) . "' target='_blank'>" . str_replace(" ","%20",$whose_multimedia) . "</a> </header>
                                        <div class = 'w3-panel w3-pale-green' style = margin-bottom:-1px><a href = 'primary_album.php?zs=" . str_replace(" ","%20",$whose_multimedia) . "&image_id={$image_id}' target='_blank'>
                                        <span style = 'display:none'>{$posts[$i]['message']}</span>https://frendors.com/primary_album.php?zs=" . str_replace(" ","%20",$whose_multimedia) . "&image_id={$image_id}</a></div>"; 
                                        break;                                    
    case 'telled_ahuenno_user_video':   $post_text = "<header class = ahuenno_post_header>Ахуенно &rarr; <a href = 'user.php?zs=" . str_replace(" ","%20",$whose_multimedia) . "' target='_blank'>" . str_replace(" ","%20",$whose_multimedia) . "</a> </header>
                                        <div class = 'w3-panel w3-pale-green' style = margin-bottom:-1px><a href = 'user_videos.php?zs=" . str_replace(" ","%20",$whose_multimedia) . "#user_video_container_{$video_id}' target='_blank'><span style = 'display:none'>{$posts[$i]['message']}</span>https://frendors.com/user_videos.php?zs=" . str_replace(" ","%20",$whose_multimedia) . "#user_video_container_{$video_id}</a></div>"; 
                                        break; 
    case 'telled_gavno_user_video':     $post_text = "<header class = ahuenno_post_header>Гавно! &rarr; <a href = 'user.php?zs=" . str_replace(" ","%20",$whose_multimedia) . "' target='_blank'>" . str_replace(" ","%20",$whose_multimedia) . "</a> </header>
                                        <div class = 'w3-panel w3-pale-green' style = margin-bottom:-1px><a href = 'user_videos.php?zs=" . str_replace(" ","%20",$whose_multimedia) . "#user_video_container_{$video_id}' target='_blank'><span style = 'display:none'>{$posts[$i]['message']}</span>https://frendors.com/user_videos.php?zs=" . str_replace(" ","%20",$whose_multimedia) . "#user_video_container_{$video_id}</a></div>"; 
                                        break;                                     
    
                    }        
     
$posts_container .=     
      '<div class="w3-container w3-card w3-white w3-round w3-margin post_container" id = "user_wall_post_' . $posts[$i]['post_id'] . '"><br>
        <img src="users/' . $posts[$i]['avatar'] . '" alt="' . $posts[$i]['nickname'] . '" class="w3-left w3-circle w3-margin-right" style="width:60px">
        <h4><a class = "nick" target = "_blank" href = "user.php?zs=' . $posts[$i]['nickname'] . '">' . $posts[$i]['nickname'] . '</a></h4><br>
        <hr class="w3-clear">
        <div class = "post_text">' . $post_text . '</div>
        <div class = "multimedia_under_post w3-clear">' . $iframe_for_multimedia_post . '</div>
        <button type="button" class = "w3-button w3-theme" onclick = window.open(\'https://google.com/search?q=' . $posts[$i]['message'] . '\')>
        Google</button>
        <button type="button" class = "w3-button w3-theme" onclick = window.open(\'https://yandex.ru/search/?text='  . $posts[$i]['message'] . '\')>
        Yandex</button>
      <div>
      
        </div> 
      </div>';

 } /* Отображение в цикле постов*/

}

?>

<!-- Middle Column -->
    <div class="w3-col m7" id = "middle_side" style = "margin-top:0px">

      <div class="w3-container w3-card w3-white w3-round w3-margin" style = "height:100%"><br>
        <img src="/imgs/logo.png" alt="Frendors" class="w3-left w3-circle w3-margin-right" style="width:60px">
          <h1><a class = "nick" target = "_blank" href = "user.php?zs=Frendors">frendors.com</a></h1>
              <h2 style = "text-align:center">Cоциальная сеть для долбоебов</h2>
        
        <p>Ты долбоеб? <br /> Здесь нет модерации, цензуры и прочей хуйни <br /> Регистрируйся или иди нахуй</p>
        
        <hr class="w3-clear">
        
 <!-- Put this div tag to the place, where the Like block will be -->
<div id="vk_like" style = "margin-top:5px"></div>
<script type="text/javascript">
VK.Widgets.Like("vk_like", {type: "button", verb: 1,
pageTitle: 'frendors.com',
pageUrl: 'https://frendors.com/index.php',
pageImage: 'https://frendors.com/imgs/logo.png'
});
</script>   

      <!-- Your share button code -->
  <div class="fb-share-button" style = "margin-bottom:5px;margin-top:7px"
    data-href="https://www.frendors.com/index.php" 
    data-layout="button_count">
  </div>
        
      </div>


<style>
    
    .boxes {
display:inline-block;
margin:10px;
cursor:pointer;
width: 100%;
max-width: 100px;
height: auto;

    }

.boxes:hover {
transform:scale(1.05);	
box-shadow: 0 0 10px yellow;	
}

    
</style>

 <div class="w3-container w3-card w3-white w3-round w3-margin w3-padding">

<h2 id = "gde_vodka" class = "w3-center">Где водка</h2>
<p>Кто нажмет на одну из коробок, тот долбоеб</p>
<div class="w3-row">
  <div class="w3-col" style="width:110px">
      <img id = "sanych_emotions" src = "games\5bv\default_sanich.png" width = "100" height = "100"/>
    </div>
  <div class="w3-rest"> 
    Найдено: <span id = "founded"><?php echo $win; ?></span><br />
    Не найдено: <span id = "not_founded"><?php echo $loose; ?></span><br/>
    Всего попыток: <span id = "total"><?php echo $total; ?></span><br /> 
    Коэффициент везения: <span id = "lucky_coef">&nbsp;<?php echo $lucky_coef;  ?></span>% </div>
</div>

<hr class = "w3-clear" />

<div id = "boxes_container" class="w3-center">

         <img class = "boxes w3-card w3-round-large" id = "0" src = "games\5bv\closed_box.png" />

         <img class = "boxes w3-card w3-round-large" id = "1" src = "games\5bv\closed_box.png" />

         <img class = "boxes w3-card w3-round-large" id = "2" src = "games\5bv\closed_box.png" />

</div>

<button type = "button" id = "new_game" class = "w3-button w3-theme" onclick = "init_game();playAudio('games/5bv/audio/new_game.mp3');" >Сброс</button>


</div>

<script>

function playAudio(str){
    var audio = new Audio();
     audio.src = str;
    audio.load();
    audio.play();
}

   var bottles_arr = [0,1,2];
   var box_images = document.getElementsByClassName("boxes"); 
   var sanych_emotions = document.getElementById("sanych_emotions");
   var box_number_comp_choose = 0;
   
    var founded = document.getElementById("founded");
    var not_founded = document.getElementById("not_founded");
    var lucky_coef = document.getElementById("lucky_coef"); 
    var total_holder = document.getElementById("total");
   
    var win = <?php echo $win; ?>; 
       var loose = <?php echo $loose; ?>; 
   
   
   function user_choose(){

       var xmlhttp = new XMLHttpRequest(); 
       xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                var json = JSON.parse(xmlhttp.response);
    			
    			total_holder.innerHTML = json.total;
    			lucky_coef.innerHTML = json.lucky_coef;
			}
        };
if(box_number_comp_choose != parseInt(this.id)){ //НЕ УГАДАЛИ

    sanych_emotions.src = "games/5bv/grustny_sanych.png";	
    this.src = "games/5bv/empty_box.png";
    this.style.border = "2px solid red";
     playAudio("games/5bv/audio/net_blya.mp3");
    
    ++loose;

        for(var i = 0; i < box_images.length; i++){
                if(i == box_number_comp_choose){ // Выбор не совпал
                    box_images[i].src = "games/5bv/founded_bottles.png";
                    box_images[i].style.border = "2px solid blue";
                		} else {
                	    	box_images[i].src = 'games/5bv/empty_box.png';
                		}
        			}
            
}  else { // УГАДАЛИ
   
       sanych_emotions.src = "games/5bv/veselyi_sanich.png";
    this.src = "games/5bv/founded_bottles.png";
    this.style.border = "2px solid blue";
     playAudio("games/5bv/audio/pravilno.mp3");
    ++win;

            for(var i = 0; i < box_images.length; i++){
                if(i != box_number_comp_choose){ 
                        box_images[i].src = "games/5bv/empty_box.png";
                	} 
            	}
   
		} 
		
founded.innerHTML = win;
not_founded.innerHTML = loose;		

var formData = new FormData();
formData.append('win', win);
formData.append('loose', loose);

xmlhttp.open("POST", "games/5bv/5bv_handler_free.php", true);
xmlhttp.send(formData);

for(var i = 0; i < box_images.length; i++){ 
    box_images[i].onclick = "";
}

       
  }
   
   function init_game(){ 

box_number_comp_choose = bottles_arr[Math.floor(Math.random()*3)];

for(var i = 0; i < this.box_images.length; i++){
box_images[i].src = "games/5bv/closed_box.png";
box_images[i].style.border = "0px solid red";
box_images[i].onclick = user_choose;
}		

sanych_emotions.src = "games/5bv/default_sanich.png";

}
    
</script>

     <?php echo $posts_container; ?>
 
    <!-- End Middle Column -->
    </div>
   
 <!-- Right Column -->
    <div class="w3-col m2" id = "right-side">
      
      <div class="w3-card w3-round w3-white w3-center" style = "padding-bottom:5px;margin-bottom:10px">
        <div class="w3-container">
          
          <a href "https://www.youtube.com/channel/UCHDEprPkMA4ehijIHdA-eqg">
              <span>Админа ютуба</span>
            <iframe src="https://www.youtube.com/embed/DmscuICDHTA" frameborder = "0" style = "width:100%" allowfullscreen></iframe>
          </a>

          <a href = "https://www.youtube.com/channel/UCHDEprPkMA4ehijIHdA-eqg" target = "_blank">
              <button class="w3-button w3-block w3-theme-l4" >
                  <span style = "word-wrap:break-word">Try it <br /> now</span></button></a>
        </div>
      </div>

      <div class="w3-card w3-round w3-white w3-padding-16 w3-center">

               <!-- VK Widget -->
<div id="vk_subscribe"></div>
<script type="text/javascript">
VK.Widgets.Subscribe("vk_subscribe", {}, -175954919);
</script> 

<div id="vk_subscribe2"></div>
<script type="text/javascript">
VK.Widgets.Subscribe("vk_subscribe2", {}, -140218386);
</script> 

<div id="fb-root"></div>

                    <div>
                        <span>Подпишись или иди нахуй</span>
                    </div>

      </div>
      <br>
   
 <!--
 <div class="w3-card w3-round w3-white w3-center" style = "padding-bottom:5px;margin-bottom:10px">
        <div class="w3-container">
            
            <h2>А чо там?</h2>

    <p>Поможем найти братков, с которыми вы когда-то малафили<br />
    Узнать больше об братках, завести новых дур<br />
    Всегда быть на связи с братишками<br />    
 
</div>
</div> -->      
      
      <style>
          
          .user_online{
              height:30px;
              width:30px;
              border-radius:100%;
              margin:3px;
          }
          
      </style>

<?php
    
/* ВСЕ ПОЛЬЗОВАТЕЛИ ЗДЕСЯ */
$sql = "SELECT * FROM `main_info`"; 
    $query = $connection_handler->prepare($sql);
    $query->execute();
$all_users_last_action_time = $query->fetchAll(PDO::FETCH_ASSOC); 
$counter10 = 0;

$all_users_online_container = "";

for($i = 0; $i < count($all_users_last_action_time); $i++){
    if((time() - $all_users_last_action_time[$i]['last_action_time']) < 180 && 
    $counter10 != 10 && 
    $all_users_last_action_time[$i]['nickname'] !== $_SESSION['user']){
        ++$counter10;
        
    $sql = "SELECT `avatar` FROM `additional_info` WHERE `nickname`='" . $all_users_last_action_time[$i]['nickname'] . "'"; 
    $query = $connection_handler->prepare($sql);
    $query->execute();
$all_user_avatar = $query->fetchAll(PDO::FETCH_ASSOC);
$all_user_avatar = $all_user_avatar[0]['avatar'];
        $all_users_online_container .= "<section style = 'display:inline-block;'>" .
        
            "<a href = 'user.php?zs=" . $all_users_last_action_time[$i]['nickname'] . "' title = '" . $all_users_last_action_time[$i]['nickname'] . "' target = '_blank'>
            <img src = 'users/" . $all_user_avatar . "' class = 'user_online' title = '" . $all_users_last_action_time[$i]['nickname'] . "'/></a>" .
        
        "</section>";
    }
  
}

    if($counter10 > 0){
       echo ' <div class="w3-card w3-round w3-white w3-center">
        <div class="w3-container">' .
       $all_users_online_container . '</div>
       </div>';

    }

?>
    <!-- End Right Column -->
    </div>

<!-- The Grid -->
</div>

<!-- End Page Container -->
</div>

</body>
</html>

<?php ob_end_flush(); ?>
