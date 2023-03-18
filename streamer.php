<?php ob_start(); ?>

<?php

session_start();
ini_set('display_errors', 'Off');

  header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
  header("Last-Modified: " . gmdate("D, d M Y H:i:s")." GMT");
  header("Cache-Control: no-cache, must-revalidate");
  header("Cache-Control: post-check=0,pre-check=0", false);
  header("Cache-Control: max-age=0", false);
  header("Pragma: no-cache");

require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/user_info.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

$facebook_client_id = '105917036567372';
$facebook_client_secret = '9aabc3fc9c30da1a922f615a1dbf2687';

$hashed_string = $facebook_client_id . $facebook_client_secret;

$fb_hash = crypt($hashed_string,'babushka_Misha');

function session_isset(){ 
if(!empty($_SESSION['user'])){ 
return true;
} else {
return false;
}
}

if(!empty($_COOKIE['user'])){ // Запомнить здеся
    $_SESSION['user'] = $_COOKIE['user']; 
}

if(session_isset()){
$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute(); 
    
}

/* ОС пользователя */
if(session_isset()){ 
 $user_os = strtolower($_SERVER['HTTP_USER_AGENT']);
 $user_os_in_bd = "";
if(stripos($user_os,'android') !== false || 
            stripos($user_os,'mobile') !== false || 
            stripos($user_os,'iphone') !== false || 
            stripos($user_os,'ipod') !== false || 
            stripos($user_os,'ipad') !== false )  {
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

function href2obj($text) { // Превращение из ссылки в объект под постом

$multimedia_under_post_arr = array();

// Видео с ютуба
     if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)([a-zA-Z0-9\-_]{1,256})/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)([a-zA-Z0-9\-_]{1,256})/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $outp_src = "";
        $multimedia_under_post_for_arr = "";
        
        $hash = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)/is',"",$multimedia_src_arr[0]);
        
        $outp_src = "https://www.youtube.com/embed/" . $hash;
        $multimedia_under_post_for_arr = "<div class = 'container-iframe'>
                                                <iframe class = 'responsive-iframe' src = '" . $outp_src . "' frameborder = '0'></iframe>
                                            </div>";
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

     } 
     
// Видео с ютуба
     if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtu\.be\/)([a-zA-Z0-9\-_]{1,256})/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtu\.be\/)([a-zA-Z0-9\-_]{1,256})/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $outp_src = "";
        $multimedia_under_post_for_arr = "";
        
        $hash = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtu\.be\/)/is',"",$multimedia_src_arr[0]);
        
        $outp_src = "https://www.youtube.com/embed/" . $hash;
        $multimedia_under_post_for_arr = "<div class = 'container-iframe'>
                                                <iframe class = 'responsive-iframe' src = '" . $outp_src . "' frameborder = '0'></iframe>
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
        $multimedia_under_post_for_arr = "<div class = 'container-iframe'>
                                                <iframe class = 'responsive-iframe' src = '" . $outp_src . "' frameborder = '0'></iframe>
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
                                                <iframe class = 'responsive-iframe' src = '" . $outp_src . "' frameborder = '0'></iframe>
                                            </div>";
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

     } 


/**********************************************************************************************************************************************************************************/
// Видео с вк
if(preg_match('/(^|[\n ])([\w]*?)(\/\/)?(vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=])+/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(\/\/)?(vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=])+/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $multimedia_under_post_for_arr = "<div class = 'container-iframe'>
                                                <iframe class = 'responsive-iframe' src = '" . $multimedia_src_arr[0] . "' frameborder = '0'></iframe>
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
     
// Картинка   
     if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([a-zA-Z0-9_\-.]{2,256})\.([a-zA-Z]{2,6})[\/]([a-zA-Z0-9_\/\-.?&;%=+])+(png|jpg|jpeg|gif)(\?extra=[a-zA-Z0-9_\-\/\-.?&;%=+]{1,256})?/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([a-zA-Z0-9_\-.]{2,256})\.([a-zA-Z]{2,6})[\/]([a-zA-Z0-9_\/\-.?&;%=+])+(png|jpg|jpeg|gif)(\?extra=[a-zA-Z0-9_\-\/\-.?&;%=+]{1,256})?/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $outp_src = "";
        $multimedia_under_post_for_arr = "";
       
        $multimedia_under_post_for_arr = "<div class = 'img_container'>
                <img class = 'w3-half w3-round' src = '" . $multimedia_src_arr[0] . "' onerror = this.src='imgs/file_not_found.png' />
        </div>";
        
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

     } 

/* // FD страница   
     if(preg_match('/(^|[\n ])([w]*?)(https?:\/\/)?(www\.)?(frendors\.com[\/]?)+(([a-zA-Z0-9\.=_\-\?&]{8,256}))?/is',$text) === 1){ 

        preg_match('/(^|[\n ])([w]*?)(https?:\/\/)?(www\.)?(frendors\.com[\/]?)+(([a-zA-Z0-9\.=_\-\?&]{8,256}))?/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $outp_src = "";
        $multimedia_under_post_for_arr = "";
        
        $outp_src = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?/is',"https://",$multimedia_src_arr[0]);

        $multimedia_under_post_for_arr = "<iframe class = 'frendors_page_iframe_under_post' src = '" . $outp_src . "'></iframe>";
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

     }   */   


$multimedia_relult = "";


for($i = 0; $i < count($multimedia_under_post_arr); $i++){
    
    $multimedia_result .= $multimedia_under_post_arr[$i];
    
}

 return $multimedia_result;

}

function href2obj_post($text) { // Превращение из ссылки в объект под постом

$multimedia_under_post_arr = array();

// Видео с ютуба
     if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([m\.]*)?(youtube\.com\/watch\?v=)([a-zA-Z0-9\-_]{1,256})/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([m\.]*)?(youtube\.com\/watch\?v=)([a-zA-Z0-9\-_]{1,256})/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $outp_src = "";
        $multimedia_under_post_for_arr = "";
        
        $hash = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([m\.]*)?(youtube\.com\/watch\?v=)/is',"",$multimedia_src_arr[0]);
        
        $outp_src = "https://www.youtube.com/embed/" . $hash;
        $multimedia_under_post_for_arr = "<iframe class = 'w3-half multimedia_under_post' src = '" . $outp_src . "' height = '200' frameborder = '0' allowfullscreen></iframe>";
        array_push($multimedia_under_post_arr,$multimedia_under_post_for_arr);

     } 
     
     // Видео с ютуба
     if(preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([m\.]*)?(youtu\.be\/)([a-zA-Z0-9\-_]{1,256})/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([m\.]*)?(youtu\.be\/)([a-zA-Z0-9\-_]{1,256})/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
        $outp_src = "";
        $multimedia_under_post_for_arr = "";
        
        $hash = preg_replace('/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([m\.]*)?(youtu\.be\/)/is',"",$multimedia_src_arr[0]);
        
        $outp_src = "https://www.youtube.com/embed/" . $hash;
        $multimedia_under_post_for_arr = "<iframe class = 'w3-half multimedia_under_post' src = '" . $outp_src . "' height = '200' frameborder = '0' allowfullscreen></iframe>";
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

if(session_isset()){ // авторизовались

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

}
?>

<!DOCTYPE html>
<html>
<head>

<title>Streamer</title>

<meta charset = "utf-8"/>    
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<meta name = "description" content = "Streamer" />
<meta name="keywords" content = "streamer,stream,news" / >
<meta name = "author" content = "frendors">

<meta property="og:title" content="Streamer"/>
<meta property="og:description" content="News"/>
<meta property="og:image" content="users/<?php echo $avatar_for_vk; ?>">
<meta property="og:type" content="article"/>
<meta property="og:url" content= "//frendors.com/streamer.php" />

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
<script type="text/javascript" src="//vk.com/js/api/openapi.js?167"></script>
<script type=text/javascript>
  VK.init({apiId: 6686305, 
  onlyWidgets: true});
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<?php

if (!session_isset()){

echo "<script type='text/javascript'>
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
        
        </script>";
}


?>

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

.block{
    margin-bottom:5px;
}

.img_container img{
  padding:5px;
}

.video_under_post{
    width:100%;
    height:auto;
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

.online_img{
    width:20px;
    height:20px;
}

</style>
</head>

<?php

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
}

?>

<body class="w3-theme-l5 " onload = "scrollBottom()" >
 <div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v6.0&appId=105917036567372&autoLogAppEvents=1"></script>
<?php 

$topnav_content = "";


if(session_isset()){
    
    $topnav_content =  '<div class="topnav" id="topnav" >
    <a href = user.php?zs=' . $_SESSION['user'] . ' ><img class = "topnav_img" src = "imgs/header/bumazhka.png" title = "Paperapp"></a>
  <a href = "dialogs.php" class = "w3-hide-small"><img class="topnav_img" src="imgs/header/vdvoem_tuta.png" title="Two here">
      <span class="w3-badge w3-right  w3-small shift-bage w3-teal">' . $new_dialogs . '</span>
  </a>
  <a href="bros.php?zs=' . $_SESSION['user'] . '" class = "w3-hide-small"><img class="topnav_img" src="imgs/header/bratki.png" title="Bros">
      <span class="w3-badge w3-right w3-small shift-bage w3-teal " >' . $new_friend . '</span>
  </a>
  <a href="notices.php" class = "w3-hide-small"><img class="topnav_img" src="imgs/header/opoves.png" title="Notices">
      <span class="w3-badge w3-right w3-small shift-bage w3-teal">' . $notice_count_badge . '</span>
  </a>
  <a href="groups.php?zs=' . $_SESSION['user'] . '"><img class="topnav_img" src="imgs/header/handcuffs.png" title="Гауптвахты"></a>
  <a href="streamer.php"><img class="topnav_img" src="imgs/header/lenta.png" title="Stream"></a>

  <a href="javascript:void(0);" class="icon dropbtn" onclick="dropDown()">
    <i class="fa fa-bars dropbtn"></i>' . $green_spot .
  '</a>
  
  <div id="drp_dn" class = "drp_dn" class="w3-card">
        <a href="user.php?zs=' . $_SESSION['user'] . '" class="w3-bar-item w3-button">Paperapp</a>
        <a href="dialogs.php" class="w3-bar-item w3-button">Two here 
        <span class="w3-badge w3-right  w3-small w3-teal">' . $new_dialogs . '</span>
        </a>
        <a href="bros.php?zs=' . $_SESSION['user'] . '" class="w3-bar-item w3-button">Bross   
        <span class="w3-badge w3-right w3-small w3-teal " >' . $new_friend .  '</span>
        </a>
        <a href="notices.php" class="w3-bar-item w3-button">Notices  
            <span class="w3-badge w3-right w3-small w3-teal">' . $notice_count_badge . '</span>
        </a>
        <a href = "chat.php" class="w3-bar-item w3-button">Chatbot</a>
        <a href="fun_select.php" class="w3-bar-item w3-button">Checkers</a>
        <a href="radio.php" target = _blank class="w3-bar-item w3-button">Cicrusongs</a>
        <a href="malafil.php" class="w3-bar-item w3-button">Malafil</a>
        <a href="common_images.php" class="w3-bar-item w3-button">Images</a>
      
        <a href="streamer.php" class="w3-bar-item w3-button">Whater drips</a>
    </div>
    </div>';
    
}

?>

 <?php echo $topnav_content; ?>
 
 <?php

$change_avatar_function = "";

if(session_isset() && $login === $login_session){
    $change_avatar_function = " onclick=document.getElementById('change_avatar_modal').style.display='block'";
}

?>

<?php 

$user_status_saver = "";

if(session_isset()){
    $user_status_saver = '<div id = "user_status_saver" class = "w3-panel w3-display-container">
                    <input  type = text id = user_status_textarea style = "margin-top:10px;margin-left:10px; margin-bottom:10px;"
                    class = "w3-input w3-border" oninput = this.placeholder=""
                    onblur = "this.placeholder = News to"' . ' maxlength = "300" placeholder = "News to" autofocus = autofocus /><br />  
                    <div style = position:relative;bottom:15px><input type = checkbox id = send_status_to_wall_checkbox 
                    name = send_status_to_wall_checkbox title = "Статус отобразится у вас на стене" 
                    value = status_to_wall class = w3-check /> <label>Отправить на малафильню</label></div>
                    <button type = button title = "Ahuenno" 
                      class = "w3-button w3-theme w3-display-bottomright" onclick = save_user_status();>Aхуенно</button>
                    </div>';
    
}

?>

<?php 

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

$online = ""; /* Текст, который будет отображаться в месте онлайн */

        if(($current_time - $last_action_time) <= 180){ // Разница <= 180 секунд
            
                /* ПРОВЕРЯЕМ С КАКОГО УСТРОЙСТВА ЗАЩЕЛ ПОЛЬЗОВАТЕЛЬ */
                $sql = "SELECT * FROM `main_info` WHERE `nickname`='{$login}'"; 	
                $query = $connection_handler->prepare($sql); //Подготавливаем запрос
                $query->execute();
                $user_os = $query->fetchAll(PDO::FETCH_ASSOC);
                $user_os = $user_os[0]['os'];

            if($user_os === 'mobile'){
                    $online = '<img src = imgs/phone.png class = "online_img" />';
                }else {
                     $online = '<img src = imgs/zdesya.png class = "online_img" />';
                }
           
            } 

?>



<?php

$top_margin = "";

if(session_isset()){
    $top_margin =  ' style = "margin-top:50px;"';   
}

?>

<!-- Page Container -->
<div class="w3-container w3-content" style="max-width:1400px;background-color:#cefdce;"> 

<!-- The Grid -->
<div class="row" <?php echo $top_margin; ?>>
    <!-- Left Column -->
  <div class="col-3 menu" style = "" id = "left_side">


      
<?php
if(!session_isset()){  
    echo            ' <div class="w3-card w3-round w3-white w3-center" style = "padding-bottom:5px;margin-bottom:10px">
                        <div class="w3-container"><div id = "unauthed_topnav_container">
                        <img src = "user_page_logo.png" width = "15" height = "15" style = "display:block"/>
                    
                    <a href="radio.php" target = _blank  style = "display:inline-block">Circusongs</a> 
                    <div id="vk_auth"></div>
                     
                    <div class="fb-login-button" data-size="medium" style = "margin-top:5px;"
                            data-button-type="continue_with" data-layout="default"  
                            data-auto-logout-link="false" data-use-continue-as="true" data-onlogin="checkLoginState()">
                    </div>
                            
             
                </div>
        </div>
</div>'; 
}

?>      

<style>

.user_chat_popover{
  display:none;
  position:relative;
  top:-5px;
  margin-top:-160px;
  padding:5px;
  background-color:#009999;
  width:150px;
  min-height:30px;
  border-radius:5px;
  color:white;        
}

.user_chat_popover::after {
    content: ''; 
    position: absolute; /* Абсолютное позиционирование */
    left: 20px; bottom: -20px; /* Положение треугольника */
    border: 10px solid transparent; /* Прозрачные границы */
    border-top: 10px solid #009999; /* Добавляем треугольник */
   }

.user_chat_popover_item{
    display:block;
    border-radius:5px;
    padding:2px;
}

.user_chat_popover_item:hover{
    background-color:black;
    opacity:0.8;
    cursor:pointer;
}

.user_chat_nick{
    color:#2398D6;
    
}

.user_chat_nick a{
    
    text-decoration:none;
       cursor:pointer;
}

.user_chat_link{
    color:#2398D6;
    font-size:10px;
    cursor:pointer;
}

#user_chat_messages{
    height:300px; 
    border-bottom:1px solid #F5F7F8;
    word-wrap: break-word;
    overflow-y:auto;
    padding:10px;
    font-weight:normal;
}

</style>

<style>

</style>

 <?php
$last_message_id = "";

/* СООБЩЕНИЯ ПОЛЬЗОВАТЕЛЬСКОГО ЧАТА */
$sql = "SELECT * FROM `user_chat` ORDER BY time ASC"; 
    $query = $connection_handler->prepare($sql);
    $query->execute();
$messages = $query->fetchAll(PDO::FETCH_ASSOC); // Все сообщения

$user_messages = "";
?>
  
   <!-- UserChat -->
      <div class="w3-card w3-round w3-white">
           <div class="w3-container">
        <h6 style = "border-bottom:1px solid #F5F7F8">Chat malafil</h6>
       
          <div id="user_chat_messages">
            
            <?php 
                 for($i = 0; $i < count($messages); $i++){
     
     $popover_fun = "";
     $popover = "";
     
     if($messages[$i]['nickname'] !== $_SESSION['user']){
     
         $popover_fun = " oncontextmenu = 'show_user_chat_tooltip(this);return false;'";
         $popover = "<div class = 'user_chat_popover' id = 'user_chat_popover_" . $messages[$i]['this_id'] . "'>" .
     "<span class = 'user_chat_popover_item' onclick = send_special_phrase_to_chatter('" . str_replace(" ", "_", $messages[$i]['nickname']) . "','" . $messages[$i]['this_id'] . "','Zdrastitya!')>Greetings</span>" .
     "<span class = 'user_chat_popover_item' onclick = send_special_phrase_to_chatter('" . str_replace(" ", "_", $messages[$i]['nickname']) . "','" . $messages[$i]['this_id'] . "','Great_blya!Award_wait_you!')>Give award</span>" .
     "<span class = 'user_chat_popover_item' onclick = send_special_phrase_to_chatter('" . str_replace(" ", "_", $messages[$i]['nickname']) . "','" . $messages[$i]['this_id'] . "','Wow_respect!')>Show respect</span>" .
     "<span class = 'user_chat_popover_item' onclick = send_special_phrase_to_chatter('" . str_replace(" ", "_", $messages[$i]['nickname']) . "','" . $messages[$i]['this_id'] . "','I_dont_fucking_care_it')>Show indiffernce</span>" .
     "<span class = 'user_chat_popover_item' onclick = send_special_phrase_to_chatter('" . str_replace(" ", "_", $messages[$i]['nickname']) . "','" . $messages[$i]['this_id'] . "','You_fucking_lying')>Show distrust</span>" .
     "<span class = 'user_chat_popover_item' onclick = send_special_phrase_to_chatter('" . str_replace(" ", "_", $messages[$i]['nickname']) . "','" . $messages[$i]['this_id'] . "','Fuck_you!Shit!')>Fuck you</span>" .
     "</div>";
         
    }
    
    $doebat_function =  "<span class = 'user_chat_link' onclick = " . "doebat('" . str_replace(" ","_",$messages[$i]['nickname']) . "')" . ">doebutt</span>";
    
    if($messages[$i]['nickname'] === $_SESSION['user'] || !session_isset()){
            $doebat_function = "";    
    }
   
     $user_messages .= "<section>" .
     $popover .
     "<span class = 'user_chat_nick'><a href = '../user.php?zs=" . $messages[$i]['nickname'] . "' data-message_id = " . $messages[$i]['this_id'] . "  title = 'Нажмите на правую кнопку мыши, чтобы воспользоваться дополнительными функциями'" .  $popover_fun . ">" . $messages[$i]['nickname'] . 
     "</a></span> " . $doebat_function .  "&ensp;" . tolink($messages[$i]['message']) . "</section>";
         $last_message_id =  $messages[$i]['this_id'];
       }
echo  $user_messages;
 
    ?>
     
          </div><!-- UserChatMessages -->
   
    <?php  
       
    $send_message_box = "";

     if(session_isset()){
        $send_message_box = '<div id = "user_typing_div" style = "visibility:hidden"></div>        

        <section id = "send_message_box">
            <textarea id = "user_chat_textarea" style = "color:black;resize:none;width:100%" rows = "4" maxlength = "200" 
            required = "required" onkeypress = "send_user_chat_message_enter(event);"></textarea><br />
            <button type="button" class= "w3-button w3-block w3-theme" style = "margin-bottom:10px;" onclick = "send_user_chat_message();">Ahuenno</button>
        </section>    

<input type = "hidden" id = "last_message_id_user_chat" value = "' . $last_message_id . '">';

} 

echo    $send_message_box; ?>  

          </div><!-- UserChatContainer -->

      </div><!-- UserChat -->
   
      <br>  
  
  <script>
 /* $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
}); */

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

</script>

<script>

function scrollBottom(){
var user_chat_messages = document.getElementById("user_chat_messages"); 
user_chat_messages.scrollTop = user_chat_messages.scrollHeight;
}        

function tolink(message){
    return message.replace(/^(https?:\/\/)?(www\.)?(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;#%=+,])*)*)/ig, "<a href=//$3 target = _blank>$3</a>").
    replace(/^(ftps?:\/\/)?(www\.)?(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;#%=+,])*)*)/ig, "<a href=//$3 target = _blank>$3</a>").
    replace(/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/ig, "$1<a href=mailto:$2@$3 target = _blank>$2@$3</a>").
    replace(/(^|[\n ])([\w]*?)(\[url href=)(https?:\/\/)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;#%=+,])*)*)(\])([a-zA-Z0-9йцукенгшщзхфывапролджэячсмитьбюЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮ!?@.\s\n]{2,80})+(\[\/url\])/, "$1$2<a href='$4$5' target = _blank>$11</a>"). 
    replace(/(^|[\n ])([\w]*?)(\[url href=)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;%=+,])*)*)(\])([a-zA-Z0-9йцукенгшщзхфывапролджэячсмитьбюЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮ!?@.\s\n]{2,80})+(\[\/url\])/, "$1$2<a href='http://$4' target = _blank>$10</a>");
}
/****************************************************************************************************************************************/

var last_message_id_user_chat = document.getElementById("last_message_id_user_chat"); // Айди последнего сообщения

(function check_new_messages_in_user_chat(){
var user_chat_messages = document.getElementById("user_chat_messages"); 

var last_message_id_user_chat = document.getElementById("last_message_id_user_chat"); // Айди последнего сообщения

var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {

parse_response_to_json(xmlhttp.response);

} 

}

function parse_response_to_json(response){ 
    
   function tolink(message){
    return message.replace(/^(https?:\/\/)?(www\.)?(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;#%=+,])*)*)/ig, "<a href=//$3 target = _blank>$3</a>").
    replace(/^(ftps?:\/\/)?(www\.)?(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;#%=+,])*)*)/ig, "<a href=//$3 target = _blank>$3</a>").
    replace(/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/ig, "$1<a href=mailto:$2@$3 target = _blank>$2@$3</a>").
    replace(/(^|[\n ])([\w]*?)(\[url href=)(https?:\/\/)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;#%=+,])*)*)(\])([a-zA-Z0-9йцукенгшщзхфывапролджэячсмитьбюЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮ!?@.\s\n]{2,80})+(\[\/url\])/, "$1$2<a href='$4$5' target = _blank>$11</a>"). 
    replace(/(^|[\n ])([\w]*?)(\[url href=)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;%=+,])*)*)(\])([a-zA-Z0-9йцукенгшщзхфывапролджэячсмитьбюЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮ!?@.\s\n]{2,80})+(\[\/url\])/, "$1$2<a href='http://$4' target = _blank>$10</a>");
}

var parsed = JSON.parse(response); 
var new_messages_container = "";
var sessioner = "<?php echo $_SESSION['user']; ?>";
var doebat_function = "";

if(parsed.no_messages === "true"){ // Сообщений нет
   console.log("No new messages in user chat"); 
    setTimeout(check_new_messages_in_user_chat,5000); 
    return;
}

play_audio("sounds/click.mp3");

for(i = 0; i < parsed.new_messages.length - 1; i++){
   
   var popover = "";
   var popover_fun = "";
   
    if(parsed.new_messages[i].nick !== sessioner){ // Отправил не сессионный
        doebat_function = "<span style = 'color:#FFD101; font-size:10px;cursor:pointer' onclick = doebat('" + parsed.new_messages[i].nick + "')>доебать</span>&ensp;";
        popover = "<div class = 'user_chat_popover' id = 'user_chat_popover_" + parsed.new_messages[i].id + "'>" +
     "<span class = 'user_chat_popover_item' onclick = send_special_phrase_to_chatter('" + parsed.new_messages[i].nick.replace(" ","_") + "','" + parsed.new_messages[i].id +  "','Здраститя!')>Поздороваться</span>" +
     "<span class = 'user_chat_popover_item' onclick = send_special_phrase_to_chatter('" + parsed.new_messages[i].nick.replace(" ","_") + "','" + parsed.new_messages[i].id +  "','Молодец_блять!Премию_получишь!')>Выписать премию</span>" +
     "<span class = 'user_chat_popover_item' onclick = send_special_phrase_to_chatter('" + parsed.new_messages[i].nick.replace(" ","_") + "','" + parsed.new_messages[i].id + "','Воо_уважаю!')>Проявить уважение</span>" +
     "<span class = 'user_chat_popover_item' onclick = send_special_phrase_to_chatter('" + parsed.new_messages[i].nick.replace(" ","_") + "','" + parsed.new_messages[i].id + "','Да_похуй_вообще_бля')>Показать безразличие</span>" +
     "<span class = 'user_chat_popover_item' onclick = send_special_phrase_to_chatter('" + parsed.new_messages[i].nick.replace(" ","_") + "','" + parsed.new_messages[i].id + "','Да_пиздишь_ты')>Выразить недоверие</span>" +
     "<span class = 'user_chat_popover_item' onclick = send_special_phrase_to_chatter('" + parsed.new_messages[i].nick.replace(" ","_") + "','" + parsed.new_messages[i].id + "','Пошел_нахуй!Гавно!')>Послать нахуй</span>" +
     "</div>";
        popover_fun = " oncontextmenu = 'show_user_chat_tooltip(this);return false;'";
    }
   
    new_messages_container += "<section>" + popover + "<span><a href = '../user.php?zs=" + parsed.new_messages[i].nick + "' data-message_id = " + parsed.new_messages[i].id + " style = 'color:#01FF27' title = 'Браток'" + popover_fun + ">" + parsed.new_messages[i].nick + 
     "</a></span> " + doebat_function + tolink(parsed.new_messages[i].message) + "</section>";
}

last_message_id_user_chat.value = parsed.new_messages[parsed.new_messages.length - 1].last_message_id;

var new_messages_node = document.createElement("SECTION");
new_messages_node.innerHTML = new_messages_container; 

user_chat_messages.appendChild(new_messages_node);
  console.log("New messages in user chat"); 

scrollBottom();

setTimeout(check_new_messages_in_user_chat,5000);

}

var formData = new FormData();
formData.append('last_message_id', last_message_id_user_chat.value);

xmlhttp.open("POST", "scripts/user_chat_new_messages.php", true);
xmlhttp.send(formData);

})()

/************************************************************************************************************************************************************************************************/

function send_user_chat_message(){
var user_chat_messages = document.getElementById("user_chat_messages");    
var user_chat_textarea = document.getElementById("user_chat_textarea");
var sessioner = "<?php echo $_SESSION['user'] ; ?>";
var doebat_function = "";

var last_message_id_user_chat = document.getElementById("last_message_id_user_chat"); 

function parse_response_to_json(response){ 

play_audio("sounds/click.mp3");

var parsed = JSON.parse(response); 
var new_messages_container = "";

for(i = 0; i < parsed.new_messages.length - 1; i++){
    
   var popover = "";
   var popover_fun = "";
   
    if(parsed.new_messages[i].nick !== sessioner){ // Отправил не сессионный
        doebat_function = "<span style = 'font-size:10px;cursor:pointer' onclick = doebat('" + parsed.new_messages[i].nick + "')>доебать</span>&ensp;";
        popover = "<div class = 'user_chat_popover' id = 'user_chat_popover_" + parsed.new_messages[i].id + "'>" +
     "<span class = 'user_chat_popover_item' onclick = send_special_phrase_to_chatter('" + parsed.new_messages[i].nick.replace(" ","_") + "','" + parsed.new_messages[i].id +  "','Здраститя!')>Поздороваться</span>" +
     "<span class = 'user_chat_popover_item' onclick = send_special_phrase_to_chatter('" + parsed.new_messages[i].nick.replace(" ","_") + "','" + parsed.new_messages[i].id +  "','Молодец_блять!Премию_получишь!')>Выписать премию</span>" +
     "<span class = 'user_chat_popover_item' onclick = send_special_phrase_to_chatter('" + parsed.new_messages[i].nick.replace(" ","_") + "','" + parsed.new_messages[i].id + "','Воо_уважаю!')>Проявить уважение</span>" +
     "<span class = 'user_chat_popover_item' onclick = send_special_phrase_to_chatter('" + parsed.new_messages[i].nick.replace(" ","_") + "','" + parsed.new_messages[i].id + "','Да_похуй_вообще_бля')>Показать безразличие</span>" +
     "<span class = 'user_chat_popover_item' onclick = send_special_phrase_to_chatter('" + parsed.new_messages[i].nick.replace(" ","_") + "','" + parsed.new_messages[i].id + "','Да_пиздишь_ты')>Выразить недоверие</span>" +
     "<span class = 'user_chat_popover_item' onclick = send_special_phrase_to_chatter('" + parsed.new_messages[i].nick.replace(" ","_") + "','" + parsed.new_messages[i].id + "','Пошел_нахуй!Гавно!')>Послать нахуй</span>" +
     "</div>";
        popover_fun = " oncontextmenu = 'show_user_chat_tooltip(this);return false;'";
        
    }
   
    new_messages_container += "<section>" + popover + "<span><a href = '../user.php?zs=" + parsed.new_messages[i].nick + "' data-message_id = " + parsed.new_messages[i].id + " title = 'Браток'" + popover_fun + ">" + parsed.new_messages[i].nick + 
     "</a></span> " + doebat_function + tolink(parsed.new_messages[i].message) + "</section>";
}

last_message_id_user_chat.value = parsed.new_messages[parsed.new_messages.length - 1].last_message_id;

var new_messages_node = document.createElement("SECTION");
new_messages_node.innerHTML = new_messages_container; 

user_chat_messages.appendChild(new_messages_node);

scrollBottom();

}

var xmlhttp = new XMLHttpRequest();

if(user_chat_textarea.value === "" || user_chat_textarea.value.match(/^\s+$/g)){return;}    
 xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                parse_response_to_json(xmlhttp.response);
          /*   window.location.reload(); */
            }
        };

var formData = new FormData();
formData.append('user_chat_message', user_chat_textarea.value.replace(/\n/g,""));
formData.append('last_message_id', last_message_id_user_chat.value);

xmlhttp.open("POST", "scripts/user_chat.php", true);
xmlhttp.send(formData);  

moveCaretToStart(user_chat_textarea);
user_chat_textarea.focus();
user_chat_textarea.value = "";
}


function send_user_chat_message_enter(event){
     var char = event.which || event.keyCode;  
if(char == 13){
send_user_chat_message();   
}
}

function doebat(username){
var user_chat_textarea = document.getElementById("user_chat_textarea");

user_chat_textarea.innerHTML = username + ", "; 

user_chat_textarea.focus();    

console.log(username);
    
}  

/*****************************************************************************************************************/
var is_closed_popover = true;

function show_user_chat_tooltip(chatter_link){ // Для контекстного меню пользователя
     var message_id = chatter_link.getAttribute("data-message_id");
     var popover = document.getElementById("user_chat_popover_" + message_id); 
     
     if(is_closed_popover){
         is_closed_popover = false;
         popover.style.display = "block";
     } else {
         is_closed_popover = true;
         popover.style.display = "none";
     }

}

function send_special_phrase_to_chatter(chatter,popover_id,special_phrase){
var user_chat_messages = document.getElementById("user_chat_messages");    
var sessioner = "<?php echo $_SESSION['user'] ; ?>";
var doebat_function = "";

var popover = document.getElementById("user_chat_popover_" + popover_id);

if(chatter === "<?php echo $_SESSION['user'] ?>"){
alert("Хуй блять");    
return;}

function parse_response_to_json(response){ 

play_audio("sounds/click.mp3");

var parsed = JSON.parse(response); 
var new_messages_container = "";

for(i = 0; i < parsed.new_messages.length - 1; i++){
       if(parsed.new_messages[i].nick !== sessioner){
        doebat_function = "<span style = 'font-size:10px;cursor:pointer' onclick = doebat('" + parsed.new_messages[i].nick.replace(" ","_") + "')>доебать</span>&ensp;";
    }
     
    new_messages_container += "<section><span><a href = '../user.php?zs=" + parsed.new_messages[i].nick + "' title = 'Браток' >" + parsed.new_messages[i].nick + 
     "</a></span> " + doebat_function + parsed.new_messages[i].message + "</section>";
}

last_message_id_user_chat.value = parsed.new_messages[parsed.new_messages.length - 1].last_message_id;

var new_messages_node = document.createElement("SECTION");
new_messages_node.innerHTML = new_messages_container; 

user_chat_messages.appendChild(new_messages_node);

scrollBottom();

}

var xmlhttp = new XMLHttpRequest();

 xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                parse_response_to_json(xmlhttp.response);
         
            }
        };

var formData = new FormData();
formData.append('user_chat_message', chatter + ", " + special_phrase.replace(/_/g," "));
formData.append('last_message_id', last_message_id_user_chat.value);

xmlhttp.open("POST", "scripts/user_chat.php", true);
xmlhttp.send(formData);  

popover.style.display = "none";
is_closed_popover = true;

user_chat_textarea.focus();   

}

</script>

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
 
 .user_img{
     width:50px;
     height:50px;
     display:inline-block;
 }
 
</style>


<style>
    
    .user_img{
        cursor:pointer;  
        width:150px;
        height:150px;
        border-radius:12px;
    }
    
    #add_img_a{
        cursor:pointer;
    }
    
     #add_img_a:hover{
        text-decoration:none;
    }
    
    h4{
        display:inline;
    }

</style>

<!-- Middle Column -->
    <div class="w3-col m7" id = "middle_side">

<?php
 /* ИЗВЛЕКАЕМ ОБЩИЕ ОПОВЕЩЕНИЯ */
$sql = "SELECT * FROM `common_notice` ORDER BY `this_id` DESC LIMIT 30";
$query = $connection_handler->prepare($sql);
$query->execute();
$common_notice = $query->fetchAll(PDO::FETCH_ASSOC);

   for($i = 0; $i < count($common_notice); $i++){

        $sql = "SELECT `avatar` FROM `additional_info` WHERE `nickname`='{$common_notice[$i]['noticer']}'";	
        $query = $connection_handler->prepare($sql); 
        $query->execute();
        $noticer_avatar = $query->fetchAll(PDO::FETCH_ASSOC);
        $noticer_avatar = $noticer_avatar[0]['avatar'];
   
   
        $sql = "SELECT last_action_time FROM main_info WHERE nickname='{$common_notice[$i]['noticer']}'"; // Выбираем время последней активности пользователя	
        $query = $connection_handler->prepare($sql); //Подготавливаем запрос
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $last_action_time = $result[0]['last_action_time'];

        $online = ""; /* Текст, который будет отображаться в месте онлайн */
        
        $current_time = time();
        
        if(($current_time - $last_action_time) <= 180){ // Разница <= 180 секунд
            
                /* ПРОВЕРЯЕМ С КАКОГО УСТРОЙСТВА ЗАЩЕЛ ПОЛЬЗОВАТЕЛЬ */
                $sql = "SELECT * FROM `main_info` WHERE `nickname`='{$data[$i]['nickname']}'"; 	
                $query = $connection_handler->prepare($sql); 
                $query->execute();
                $user_os = $query->fetchAll(PDO::FETCH_ASSOC);
                $user_os = $user_os[0]['os'];
            
            if($user_os === 'mobile'){
                    $online_user = '<img src = imgs/phone.png class = online_img />';
                }else{
                        $online = '<img src = imgs/zdesya.png class = online_img />';
                }
            }
 
    switch($common_notice[$i]['type']){      
 
       // Новый пользователь
      case 'new_user': 
    
                       echo "<div class='w3-container w3-card w3-white w3-round w3-margin post_container' id = 'common_notice_{$common_notice[$i]['this_id']}'><br>
                    <img src='users/{$noticer_avatar}' alt='{$common_notice[$i]['noticer']}' class='w3-left w3-circle w3-margin-right' style='width:60px'>
                                <span class='w3-right w3-opacity'>{$common_notice[$i]['date']}</span>
                    <h4>
                        <a class = 'nick' href = 'user.php?zs=" . str_replace(" ", "%20",$common_notice[$i]['noticer']) . "'>{$common_notice[$i]['noticer']}</a>
                    </h4>
                    <br />
                          теперь долбоеб
                    </div>"; 
           
        break;
        
         // Добавил вбратки
      case 'confirm_friend_request': 
    
                       echo "<div class='w3-container w3-card w3-white w3-round w3-margin post_container' id = 'common_notice_{$common_notice[$i]['this_id']}'><br>
                    <img src='users/zs326/user_ava_326.jpg' alt='GreenBot' class='w3-left w3-circle w3-margin-right' style='width:60px'>
                                <span class='w3-right w3-opacity'>{$common_notice[$i]['date']}</span>
                    <h4>
                        <a class = 'nick' href = 'user.php?zs=" . str_replace(" ", "%20",$common_notice[$i]['friend_sender']) . "'>{$common_notice[$i]['friend_sender']}</a>
                    </h4> 
                        и 
                    <h4>
                        <a class = 'nick' href = 'user.php?zs=" . str_replace(" ", "%20",$common_notice[$i]['friend_getter']) . "'>{$common_notice[$i]['friend_getter']}</a>
                    </h4><br />
                    
                        два долбоеба
                    
                    <br />
                 
                    </div>"; 
           
        break;
 
  case 'add_image_in_primary_album': 
      $link = $common_notice[$i]['link'];
      $image_id = $common_notice[$i]['multimedia_id'];
      
       echo "<div class='w3-container w3-card w3-white w3-round w3-margin post_container' id = 'common_notice_{$common_notice[$i]['this_id']}' ><br>
        <img src='users/{$noticer_avatar}' alt='{$noticer_avatar}' class='w3-left w3-circle w3-margin-right' style='width:60px'>
        
        <span class='w3-right w3-opacity'>{$common_notice[$i]['date']} </span>
        
        <h4>
        <a class = 'nick' href = 'user.php?zs=" . str_replace(" ", "%20",$common_notice[$i]['noticer']) . "'>" .$common_notice[$i]['noticer'] . "</a>
        </h4> добавил картинку в первичный <br />
   
            <hr class='w3-clear' style = 'margin-top:30px'> 
        
        <div class = 'img_container'>
             <a href = primary_album.php?zs={$common_notice[$i]['noticer']}&image_id=" . $image_id . " target=_blank>
             <img src={$link} class = 'w3-half w3-rounded'  onerror = this.src='imgs/file_not_found.png' />
             </a> 
        </div>
        
        <div class = 'links_container'>
            <a href = {$link} target = _blank>Оригинал</a>&ensp;|&ensp;
            <a href=primary_album.php?zs={$common_notice[$i]['noticer']}&image_id={$image_id} target = _blank>Тудой >>></a>
        </div>
      
      </div>"; 
      
      break;
 
     // Пользователь оставил сообщение на своей странице 
           case 'user_wall_post_self_page': 
               
                                            $post_id = $common_notice[$i]['post_id'];                            
                                            $description = $common_notice[$i]['description']; 
                                            $post_text = $common_notice[$i]['post_text'];
                                            $post_id = $common_notice[$i]['post_id'];
                                            $page = $common_notice[$i]['page'];
                                            $post_sender = $common_notice[$i]['noticer'];
                                            
                                             $multimedia = href2obj($post_text);
              
        echo "<div class='w3-container w3-card w3-white w3-round w3-margin post_container' id = 'user_wall_post_" . $post_id . "'><br>
        
        <img src='users/" . $noticer_avatar . "' alt='" . $noticer_avatar . "' class='w3-left w3-circle w3-margin-right' style='width:60px'>
        <span class='w3-right w3-opacity'>" . $common_notice[$i]['date'] . " </span>
        
        <h4>
            <a class = 'nick' href = 'user.php?zs=" .  str_replace(" ", "%20",$post_sender) . "'>" .  $post_sender . "</a>
        </h4><br>
        
            <hr class='w3-clear'>
        
        <div class = 'post_text'>" . tolink($post_text) . "</div>
        <div class = 'multimedia_under_post'>" . $multimedia . "</div>       
         <a href = user.php?zs=" . str_replace(" ", "%20",$post_sender) . "#user_wall_post_{$post_id}>Тудой >>></a>
      </div>"; 
  
               break;
 
  // Пользователь оставил пост на чужой странице
      case 'user_wall_post_other_page': 
          
                                            $post_id = $common_notice[$i]['post_id'];                            
                                            $description = $common_notice[$i]['description']; 
                                            $post_text = $common_notice[$i]['post_text'];
                                            $post_id = $common_notice[$i]['post_id'];
                                            $page = $common_notice[$i]['page'];
                                            $post_sender = $common_notice[$i]['noticer'];
                                            
                                             $multimedia = href2obj($post_text);
              
        echo "<div class='w3-container w3-card w3-white w3-round w3-margin post_container' id = 'user_wall_post_" . $post_id . "'><br>
        
        <img src='users/" . $noticer_avatar . "' alt='" . $image_commenter . "' class='w3-left w3-circle w3-margin-right' style='width:60px'>
        <span class='w3-right w3-opacity'>" . $common_notice[$i]['date'] . " </span>
        
        <h4>
            <a class = 'nick' href = 'user.php?zs=" .  str_replace(" ", "%20",$post_sender) . "'>" .  $post_sender . "</a>
        </h4> 
        &rArr;
        <h4>
        
            <a class = 'nick' href = 'user.php?zs=" .str_replace(" ", "%20",$post_sender) . "'>{$page}</a>
        
        </h4><br /><br />
        
            <hr class='w3-clear'>
        
        <div class = 'post_text'>" . tolink($post_text) . "</div>
        <div class = 'multimedia_under_post'>" . $multimedia . "</div>       
         <a href = user.php?zs=" . str_replace(" ", "%20",$page) . "#user_wall_post_{$post_id}>Тудой >>></a>
      </div>"; 
       
          break;
 
     case 'primary_image_comment': 
                                    $image_commenter = $common_notice[$i]['noticer'];
                                    $link = $common_notice[$i]['link'];
                                    $whose_image = $common_notice[$i]['whose_multimedia'];
                                    $image_id = $common_notice[$i]['multimedia_id'];
                                    $comment_text = $common_notice[$i]['comment_text'];
                                    $comment_id = $common_notice[$i]['comment_id'];
                                    
                                    $multimedia = href2obj($comment_text);

             echo "<div class='w3-container w3-card w3-white w3-round w3-margin post_container' id = 'user_wall_post_" . $post_id . "'><br>
        
       
        <span class='w3-right w3-opacity'>" . $common_notice[$i]['date'] . " </span>
       
               <hr class='w3-clear'>
        
         <div class = 'img_container'>
             
            <a href = primary_album.php?zs=" . str_replace(" ", "%20",$whose_image) . "&image_id={$image_id} target = _blank>
            <img class = 'w3-half w3-round' src = {$link} />
            </a>
        </div> 
        
            <div class = 'links_container'>
    
            <a href = {$link} target = _blank>Original</a>&ensp;|&ensp;
            <a href=primary_album.php?zs={$whose_image}&image_id={$image_id} target = _blank>Goto >>></a><br />
        <img src='users/" . $noticer_avatar . "' alt='" . $image_commenter . "' class='w3-circle w3-margin-top' style='width:60px'>
       
        <h4>
            <a class = 'nick' href = 'user.php?zs="  . str_replace(" ", "%20",$image_commenter) . "'>" .  $image_commenter . "</a>
        </h4> &rArr;
        <h4>
            <a class = 'nick' href = user.php?zs=" . str_replace(" ", "%20",$whose_image) . " target = _blank>{$whose_image}</a>
        </h4><br /><br />
       
        <div class = 'post_text'>" . tolink($comment_text) . "</div>
        <div class = 'multimedia_under_post w3-clear'>" . $multimedia . "</div>  
       
        </div>

      </div>"; 
           
           break; 
 
  // Пользователь рассказал ахуенно о посте
           case 'tell_to_bros_ahuenno_post': 
               
                                           $post_text = $common_notice[$i]['post_text'];
                                            $post_id = $common_notice[$i]['post_id'];
                                            $post_sender = $common_notice[$i]['post_sender'];
           
                                           $multimedia = href2obj($post_text);
               
               echo "<div class='w3-container w3-card w3-white w3-round w3-margin post_container' id = 'user_wall_post_" . $post_id . "'><br>
        
        <img src='users/" . $noticer_avatar . "' alt='" . $noticer_avatar . "' class='w3-left w3-circle w3-margin-right' style='width:60px'><span class='w3-right w3-opacity'>" . $common_notice[$i]['date'] . " </span>
        <h4>
            <a class = 'nick' href = 'user.php?zs=" . str_replace(" ", "%20",$common_notice[$i]['noticer']) . "'>" . str_replace(" ", "_", $common_notice[$i]['noticer']) . "</a>
        </h4><br />
        Ахуенно &rArr; 
     
        <h4>
            <a class = 'nick' href = 'user.php?zs=" .  $post_sender . "'>" .  $post_sender . "</a>
        </h4><br>
        
            <hr class='w3-clear'>
        
        <div class = 'post_text'>" . tolink($post_text) . "</div>
        <div class = 'multimedia_under_post'>" . $multimedia . "</div>       
         <a href = user.php?zs=" . str_replace(" ", "%20",$post_sender) . "#user_wall_post_{$post_id}>Тудой >>></a>
      </div>"; 
        break;
 
   
                // Написал свою историю
   /*   case 'user_story': 
                                            
                                            $user_story_id = $common_notice[$i]['user_story_id'];                            
                                            $user_story_name = $common_notice[$i]['user_story_name'];
                                            $user_story_text = $common_notice[$i]['user_story_text'];
                                           
          $trunced_user_story_name = $user_story_name;

            if(strlen($user_story_name) > 80){
                $trunced_user_story_name =  mb_substr($user_story_name,0,80) . "...";
            } 
            
            $trunced_user_story_text = $user_story_text;

            if(strlen($user_story_text) > 80){
                $trunced_user_story_text =  mb_substr($user_story_text,0,80) . "...";
            } 
            
             echo "<div class = 'w3-container w3-card w3-white w3-round w3-margin post_container' id = comment_post_notice_{$common_notice[$i]['this_id']}>
            <div class = 'img_container'>
                <a href = user.php?zs=" . str_replace(" ","%20",$common_notice[$i]['noticer']) . " title = " . str_replace(" ", "_",$common_notice[$i]['noticer']) . ">
            <img class = 'w3-left w3-circle w3-margin-right' src = 'users/{$noticer_avatar}' style = 'width:60px;' />" . $online . "</a>
            </div> 
            <div class = user_wall_post_notice_description>
            <a href = user.php?zs=" . str_replace(" ", "%20",$common_notice[$i]['noticer']) . ">{$common_notice[$i]['noticer']}</a>wrote storie 
            <a data-toggle = collapse data-target = '#full_text_user_story_{$common_notice[$i]['this_id']}'>{$trunced_user_story_name}</a> on his paperapp</div>
            <div  id = full_text_user_story_{$common_notice[$i]['this_id']} class = 'panel-collapse collapse'>
            
            <div class='well well-sm' style = 'color:black;word-wrap:break-word;'>" .
            tolink($trunced_user_story_name) .
            "</div>
            
            </div>
            <div class = comment_post_notice_date>{$common_notice[$i]['date']}</div>
            
            <div style = 'height:1px; border:1px dashed white'></div>
            
            <div style = 'color:blue;word-wrap:break-word'>" .
            tolink($trunced_user_story_text) . "<br />
            <a href = user_story.php?id=" . $user_story_id . ">Go to >>></a>
            </div>
            
            </div>";
           
             break; */
        
        case 'user_story': 
            
                                            $user_story_id = $common_notice[$i]['user_story_id'];                            
                                            $user_story_name = $common_notice[$i]['user_story_name'];
                                            $user_story_text = $common_notice[$i]['user_story_text'];
       
        $trunced_user_story_name = $user_story_name;

            if(strlen($user_story_name) > 80){
                $trunced_user_story_name =  mb_substr($user_story_name,0,80) . "...";
            } 
            
            $trunced_user_story_text = $user_story_text;

            if(strlen($user_story_text) > 80){
                $trunced_user_story_text =  mb_substr($user_story_text,0,80) . "...";
            }        
       
        echo "<div class='w3-container w3-card w3-white w3-round w3-margin post_container' id = 'user_wall_post_" . $post_id . "'><br>
        
        <img src='users/" . $noticer_avatar . "' alt='" . $noticer_avatar . "' class='w3-left w3-circle w3-margin-right' style='width:60px'>
        <span class='w3-right w3-opacity'>" . $common_notice[$i]['date'] . " </span>
        
        <h4>
            <a class = 'nick' href = 'user.php?zs="  .  str_replace(" ","%20",$common_notice[$i]['noticer']) . "'>" .  $common_notice[$i]['noticer'] . "</a>
        </h4><br>
            wrote story  <a href = user_story.php?id=" . $user_story_id . "> | {$trunced_user_story_name} | </a> on his paperapp
            <hr class='w3-clear'>
        
          <div style = 'word-wrap:break-word'>" .
            tolink($trunced_user_story_text) . "<br />
            <a href = user_story.php?id=" . $user_story_id . ">Тудой >>></a>
            </div>
     
      </div>"; 
  
            break;
        
        
    } 
       
}  
  
?>

    <!-- End Middle Column -->
    </div>
  
 <!-- Right Column -->
    <div class="w3-col m2" id = "right-side">

<div class="" style = "padding:5px;margin-bottom:10px">
<div class="w3-container">  <!-- VK Widget -->
<div id="vk_groups"></div>
<script type="text/javascript">
VK.Widgets.Group("vk_groups", {mode: 4, height: "400"}, 175954919);
</script>
</div>
</div>

<div class="fb-group" data-href="https://www.facebook.com/groups/outminded/" data-width="220" 
data-show-social-context="true" 
data-show-metadata="true"></div>

    <!-- End Right Column -->
    </div>

<!-- The Grid -->
</div>

<!-- End Page Container -->
</div>

</body>
</html>

<?php ob_end_flush(); ?>
