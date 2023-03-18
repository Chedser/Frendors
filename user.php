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

// $fb_hash = crypt($hashed_string,'babushka_Misha');

 function parseDate($date){
  
  $result = "";
  
    
   if(preg_match('/(\d{4})-(\d{2})-(\d{2})\s(\d{2}):(\d{2}):(\d{2})/is',$date,$matches) === 1){
        $year = $matches[1];
      $month = $matches[2];
       $day = $matches[3];
       $hour = $matches[4];
       $min = $matches[5];
    
       
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
       
            if($hour[0] == '0'){
           
           $hour =  substr($hour, 1);
           
       }
       
            if($day[0] == '0'){
           
           $day =  substr($day, 1);
           
       }
       
       $result = $day . ' ' . $month . ' ' . $year . ' ' . $hour . ':' . $min;
       
   }
   
   return $result;
    
} 

 if(empty($login) || empty($nickname)){ 
header('Location: error_documents_fd/page_not_found.php'); 
exit();
} 

if(!empty($_SESSION['user'])){
    
 setcookie("user", $_SESSION['user'], time()+60*60*24*30); 
    
}

if(!empty($_COOKIE['user'])){
    
$_SESSION['user'] = $_COOKIE['user']; 
    
}

function session_isset(){ 
if(!empty($_SESSION['user'])){ 
return true;
} else {
return false;
}
}

 $count_on_page = 30;

 $page_number = $_GET['ls'];

  $sql = "SELECT this_id FROM wall_user_posts";
    $query = $connection_handler->prepare($sql);
    $query->execute();
$ps = $query->fetchAll(PDO::FETCH_ASSOC);

$totalPages = ceil(count($ps) / $count_on_page);

if($page_number > $totalPages){
    
    header('Location: user.php?zs=' . $login);
}else if(empty($page_number)){
    
    $page_number = 1;
    
}

 
  $offset = $page_number * $count_on_page - $count_on_page;
  $pags_count = 5;
  $current_pag = $page_number;

$back_btn = "";
$first_page_btn = "";

$sql = "SELECT this_id FROM wall_user_posts";
    $query = $connection_handler->prepare($sql);
    $query->execute();
$ps = $query->fetchAll(PDO::FETCH_ASSOC);

$totalPages = ceil(count($ps) / $count_on_page);

$page2left = "";
$page1left = "";
$page2right = "";
$page1right = "";



  // Проверяем нужны ли стрелки назад
if ($page_number != 1) {  $back_btn = '<a href="user.php?zs=' . $login  . '&ls=' . ($page_number - 1) . '" class="w3-button w3-small"><</a>';
                            $first_page_btn = '<a href="user.php?zs=' . $login  . '&ls=1" class="w3-button w3-small"><<</a>'; }
// Проверяем нужны ли стрелки вперед
if ($page_number != $totalPages) { $forward_btn = '<a href="user.php?zs=' . $login  . '&ls=' . ($page_number + 1) . '" class="w3-button w3-small">></a>';
                             }
// Находим две ближайшие станицы с обоих краев, если они есть

if(($page_number + 1) != $totalPages && $page_number != $totalPages){
      $last_page_btn = '<a href="user.php?zs=' . $login  . '&ls=' . $totalPages. '" class="w3-button w3-small">>></a>';
    
}

if($page_number - 2 > 0) {
                $page2left  = '<a href = user.php?zs=' . $login . '&ls=' . ($page_number - 2) .  ' class="w3-button w3-small">' . ($page_number - 2) .  '</a>';
              
}

if($page_number - 1 > 0) { 
     $page1left  = '<a href = user.php?zs=' . $login . '&ls=' . ($page_number - 1) .  ' class="w3-button w3-small">' . ($page_number - 1) .  '</a>';
    
}

if($page_number + 2 <= $totalPages) {
       $page2right  = '<a href = user.php?zs=' . $login . '&ls=' . ($page_number + 2) .  ' class="w3-button w3-small">' . ($page_number + 2) .  '</a>';
    
}

if($page_number + 1 <= $totalPages) {
   $page1right  = '<a href = user.php?zs=' . $login . '&ls=' . ($page_number + 1) .  ' class="w3-button w3-small">' . ($page_number + 1) .  '</a>';
    
}

$current_page = '<a href="user.php?zs=' . $login  . '&ls=' . $page_number . '" class="w3-button w3-small" style = "text-decoration:underline;">' . $page_number . '</a> ';

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
if(preg_match('/(^|[\n ])([\w]*?)(\/\/)?(vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=])+/is',$text) === 1){ 

        preg_match('/(^|[\n ])([\w]*?)(\/\/)?(vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=])+/is',$text, $multimedia_src_arr);  // Возвращает совпадение
        
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

function trunc($str){
    
    $result = $str;
    
    if(strlen($str) >= 40){
        
        $result = substr($result, 0, 40) . "...";
        
    }
    
   return $result; 
    
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
// СИСТЕМА НАГРАД И ПЫТОК 
 require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection_regards.php';
$connection_handler_regards->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

// ПОГОНЫ 
// отображаем все полковничьи погоны 
$sql = "SELECT COUNT(*) AS `coloner_straps` FROM `coloner_straps` WHERE `page_id`='{$login}'";	
$query = $connection_handler_regards->prepare($sql); 
$query->execute();
$coloner_pogons_count = $query->fetchAll(PDO::FETCH_ASSOC);      
$coloner_pogons_count = $coloner_pogons_count[0]['coloner_straps'];

// ОБНОВЛЯЕМ НАГРАДЫ В ТАБЛИЦЕ main_info 
$sql = "UPDATE `main_info` SET `rating`={$coloner_pogons_count} WHERE `nickname`='{$login}'";	
$query = $connection_handler->prepare($sql); 
$query->execute();

if($login === 'Adminto') {
    $coloner_pogons_count = "0/0";
}
/* $connection_handler_regards = null; */

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

       
/* // ИЗВЛЕКАЕМ НОВЫЕ АТИВНЫЕ ДИАЛОГИ ГДЕ СЕССИОННЫЙ ЯВЛЯЕТСЯ ПРИСОЕДИНЕННЫМ 
$sql = "SELECT COUNT(*) AS 'new_message_sessioner_joined' FROM `dialogs` WHERE `joined`='{$_SESSION['user']}'  AND `is_finished` = 0";	
$query = $connection_handler->prepare($sql); 
$query->bindParam(':joined', $_SESSION['user'], PDO::PARAM_STR); // Пользователь к к которому зашли. Принимают заявку
$query->execute();
$sessioner_joined_new_message_count = $query->fetchAll(PDO::FETCH_ASSOC);
$sessioner_joined_new_message_count = $sessioner_joined_new_message_count[0]['new_message_sessioner_joined'];         

// ИЗВЛЕКАЕМ НОВЫЕ АТИВНЫЕ ДИАЛОГИ ГДЕ СЕССИОННЫЙ ЯВЛЯЕТСЯ ИНИЦИАТОРОМ 
$sql = "SELECT COUNT(*) AS 'new_message_sessioner_initiator' FROM `dialogs` WHERE `initiator`='{$_SESSION['user']}'  AND `is_finished_for_initiator` = 0";	
$query = $connection_handler->prepare($sql); 
$query->bindParam(':joined', $_SESSION['user'], PDO::PARAM_STR); // Пользователь к к которому зашли. Принимают заявку
$query->execute();
$sessioner_initiator_new_dialog_count = $query->fetchAll(PDO::FETCH_ASSOC);
$sessioner_initiator_new_dialog_count = $sessioner_initiator_new_dialog_count[0]['new_message_sessioner_initiator']; */

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
            $last_user_status = 'Tell some storie';    
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
            $last_user_status = 'User have no stories now';  
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

<title><?php echo str_replace(" ","_",$login); ?></title>

<meta charset = "utf-8"/>    
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name = "description" content = "<?php echo $last_user_status_for_vk;  ?>" />
<meta name="keywords" content = "<?php echo $login; ?>, outmind, crazy, outstanding" / >
<meta name = "author" content = "<?php echo $login; ?>">

<meta property="og:title" content="<?php echo $login; ?>"/>
<meta property="og:description" content="<?php echo $last_user_status_for_vk;  ?>"/>
<meta property="og:image" content="https://frendors.com/users/<?php echo $avatar_for_vk; ?>">
<meta property="og:type" content="article"/>
<meta property="og:url" content= "//frendors.com/user.php?zs=<?php echo $login; ?>" />

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;700&display=swap">
<link rel="stylesheet" type="text/css" href="css/user_style.css">

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
  position:fixed;
  width:100%;
  z-index:10;
}

.topnav a {
  display: inline-block;
  padding: 14px 2.5%;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
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
       border-top:1px solid #6495ED;
       border-bottom:1px solid #6495ED;
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

</style>
</head>

<script>
    
    function set_delete_reason(radio_button){
    var hidden_for_delete_friend = document.getElementById("hidden_for_delete_friend");
hidden_for_delete_friend.value = radio_button.value;
}

function delete_friend(button,user_id){ // УДАЛЯЕМ  ПОЛЬЗОВАТЕЛЯ

var xmlhttp = new XMLHttpRequest();

var delete_friend_modal = document.getElementById("delete_friend_modal"); // Модальное окно
var deleted_friend_message = document.getElementById("deleted_friend_message"); // Сообщение об удалении из друзей
var delete_friend_reason_radios = document.getElementsByClassName("delete_friend_reason_radios"); // Радиокнопки
var delete_friend_button_under_ava = document.getElementById("delete_friend_button"); // Кнопка удаления из братков
var delete_friend_reason_radios_section = document.getElementById("delete_friend_reason_radios_section");
var delete_friend_close_button = document.getElementById("delete_friend_close_button");
var hidden_for_delete_friend = document.getElementById("hidden_for_delete_friend");

 xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
deleted_friend_message.style.display = "block"; // Показываем сообщение 
button.style.display = "none"; // Удаляем кнопку на модальном окне
delete_friend_button_under_ava.style.display = "none"; // Удаляем кнопку под авой
delete_friend_reason_radios_section.innerHTML = "<span style = font-size:18px>" + xmlhttp.response + "</span>";
    console.log("Ответ получен");
    
    
} 
}

var formData = new FormData();
formData.append('user_id', user_id);
formData.append('reason',  hidden_for_delete_friend.value);

xmlhttp.open("POST", "scripts/delete_friend.php", true);
xmlhttp.send(formData);

}

      function friend_request(button,user_id){ // ДОБАВЛЯЕМ ПОЛЬЗОВАТЕЛЯ
var xmlhttp = new XMLHttpRequest();
var wait_for_reply = document.getElementById("wait_for_reply_panel");
button.style.display = "none";
button.onclick = null;

 xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
wait_for_reply.style.display = "block";
    } 
}

var formData = new FormData();
formData.append('user_id', user_id);

xmlhttp.open("POST", "scripts/friend_request_from_session_user.php", true);
xmlhttp.send(formData);

}

function cancel_friend_request(button,user_id){
   var xmlhttp = new XMLHttpRequest();
var cancel_friend_request_field = document.getElementById("cancel_friend_request_panel");
button.style.display = "none";

xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
cancel_friend_request_field.style.display = "block";
    } 
}

var formData = new FormData();
formData.append('user_id', user_id);

xmlhttp.open("POST", "scripts/cancel_friend_request.php", true);
xmlhttp.send(formData);

}

/********************************************************************************************/

function send_private_message(user_id,button){// Отправляем сообщение пользователю
var private_message_box = document.getElementById("private_message_box");
var private_message_textarea = document.getElementById("private_message_textarea");
var private_message_server_response = document.getElementById("private_message_server_response");

if(private_message_textarea.value.length == 0 || 
private_message_textarea.value.match(/^\s+$/g)){
return;   
}

var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
private_message_textarea.value = "";
private_message_server_response.innerHTML = xmlhttp.response;
button.style.display = "none";
setTimeout(window.location.reload(),4000);

} 
}

var formData = new FormData();
formData.append('user_id', user_id);
formData.append('message', private_message_textarea.value.trim());

xmlhttp.open("POST", "scripts/send_private_message.php", true);
xmlhttp.send(formData);
}

function add_image(){
    
    var img_link_input = document.getElementById("img_link_input");
    var errors = document.getElementById("errors");

    if(img_link_input.value == ""){
        return;
    }
    
    if(!img_link_input.value.match(/(^|[\n ])([\w]*?)(https:\/\/pp.userapi.com\/)([a-zA-Z0-9_\-\/\-.?&;%=+]{1,256})$/ig) ||
    !img_link_input.value.match(/(^|[\n ])([\w]*?)(https?:\/\/sun[0-9]{1,100}-[0-9]{1,100}\.userapi\.com\/)([a-zA-Z0-9_\-\/\-.?&;%=+\,!]{1,256})$/ig) ||
    !img_link_input.value.match(/(https:\/\/pp.vk.me\/)([a-zA-Z0-9_\-\/\-.?&;%=+]{1,256})$/ig)){
       errors.style.display = "block"; 
    }else{
        
       var xmlhttp = new XMLHttpRequest();
       
       xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {

            errors.style.display = "block";
            errors.innerHTML = xmlhttp.response;
            setTimeout(window.location.reload(),3000);
            
            } 
        }
        
  var formData = new FormData();
  formData.append('link', img_link_input.value.trim());

   xmlhttp.open('POST', 'scripts/add_image_in_primary_album.php', true);
   xmlhttp.send(formData);
   
    }
    
}


</script>

<!-- MODALS -->
 
 <!-- Окно смены авы -->
  <div id="change_avatar_modal" class="w3-modal modal">
    <div class="w3-modal-content w3-animate-bottom w3-card-4">
      <header class="w3-container w3-pale-green"> 
        <span onclick="document.getElementById('change_avatar_modal').style.display='none'" 
        class="w3-button w3-display-topright">&times;</span>
         <h4>Change avatar</h4>
      </header>
      <div class="w3-container">
               <p>Formats: jpeg, png | <= 3мБ</p>
        
              <form id = "change_ava_form">
                <input id = "MAX_FILE_SIZE" name = "MAX_FILE_SIZE" type="hidden" value="3000000" />
                <input type = "file" style = "margin-bottom: 5px" name = "ava_file" id = "ava_file" accept = "image/jpeg,image/png" 
                        onchange = "choose_file(this)" /><br />
    
        <div class="container" id = "progressbar_container" style = "display:none">
                    
                      <div class="w3-border" >
                              <div class="w3-green progress" id = "progressbar" style="height:24px;width:0%"></div>
                              <span id = "progressbar_value"></span>
                    </div>
        </div>
    
    <canvas id = "ava_preview" style = "display:none">
    </canvas>
    
    <div id = "errors_ava_loading_div"></div>
    
         <button id = "change_ava_button" type="submit" class="w3-button w3-block w3-theme" style = "display:none">Поменять</button>
         
      </form><br />       

      <div id = "success_ava_loading_container" style = "display:none">    
                <span>Поменял</span><br>
                <button type="button" class="w3-button" onclick = "window.location.reload()">Ахуенно</button><br />
        </div>
      </div>
      <footer class="w3-container w3-pale-green">
        <p></p>
      </footer>
    </div>
 
  </div>
  
  <!-- Окно смены авы -->
  <div id="add_image_modal" class="w3-modal modal">
    <div class="w3-modal-content w3-animate-bottom w3-card-4">
      <header class="w3-container w3-pale-green"> 
        <span onclick="document.getElementById('add_image_modal').style.display='none'" 
        class="w3-button w3-display-topright">&times;</span>
         <h4>Вылаживаем картинку</h4>
      </header>
      <div class="w3-container">
               <p>Формат: https://pp.userapi.com/c850520/v850520265/8688/sixkEn0Xeao.jpg</p>
         Ссылка <input type = "text" pattern = "(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?([a-zA-Z0-9_\-.]{2,256})\.([a-zA-Z]{2,6})[\/]([a-zA-Z0-9_\/\-.?&;%=+])+(png|jpg|jpeg|gif)" class = "w3-input w3-border" maxlength = "300" id = "img_link_input" required = "required" /><br />
        <span id = "errors" style = "color:red;display:none">Данный тип ссылок не поддерживается</span><br />
     <button type="button" class="w3-button w3-block w3-theme" onclick = "add_image()" >Вылаживать</button>

      </div>
      <footer class="w3-container w3-pale-green">
        <p></p>
      </footer>
    </div>
 
  </div>
  
    <!-- Доебать случайного -->
  <div id="private_message_random_user_box" class="w3-modal modal">
    <div class="w3-modal-content w3-animate-bottom w3-card-4">
      <header class="w3-container w3-pale-green"> 
        <span onclick="document.getElementById('private_message_random_user_box').style.display='none'" 
        class="w3-button w3-display-topright">&times;</span>
         <h4>Доебать случайного</h4>
      </header>
      <div class="w3-container">

<textarea id = "private_message_random_user_textarea" class = "w3-border w3-padding" 
placeholder = "Да всякое вобщем" rows = "10"   maxlength = "3000" oninput = "this.placeholder = '';" 
onblur = "this.placeholder='Whatever you want'" autofocus = "autofocus" style = "resize:none;width:100%" > 
        </textarea><br />
<span id = "private_message_random_user_server_response" style = "position:relative;top:-10px"></span>
<span style = "display:block; font-size:12px; color:gray;">3000 symbols max</span>
<button type = "button" class = "w3-button w3-theme" onclick = send_private_random_user_message(this)>Ахуенно</button>
       
      </div>
      
      <footer class="w3-container w3-pale-green">
        <p></p>
      </footer>
    
    </div>
 
  </div>
  
  <?php 
  
  $user_to_delete = "";
  
  if($login != $_SESSION['user']){
      $user_to_delete = $login;
      
  }
  
  ?>
  
   <!-- Окно удаления из братков -->
  <div id="delete_friend_modal" class="w3-modal modal">
    <div class="w3-modal-content w3-animate-bottom w3-card-4">
      <header class="w3-container w3-pale-green"> 
        <span onclick="document.getElementById('delete_friend_modal').style.display='none'" 
        class="w3-button w3-display-topright">&times;</span>
         <h4>Delete from bros</h4>
      </header>
      
      <div class="w3-container">
           
           <section id = "delete_friend_reason_radios_section">
                <h3>Reason</h3> 
        <input type = "hidden" id = "hidden_for_delete_friend" value = "doebal">
        <input type = "radio" class = "delete_friend_reason_radios" name = "delete_friend_reason_radio" value = "doebal" onclick = "set_delete_reason(this)" checked = "checked"/> 
        <span class = "delete_friend_reason_radios_label">Fucking worried me</span><br />    
        <input type = "radio" class = "delete_friend_reason_radios" name = "delete_friend_reason_radio" value = "fufel" onclick = "set_delete_reason(this)" /> 
        <span class = "delete_friend_reason_radios_label">Fufel (asshole)</span><br />     
        <input type = "radio" class = "delete_friend_reason_radios" name = "delete_friend_reason_radio" value = "pidr" onclick = "set_delete_reason(this)" /> 
        <span class = "delete_friend_reason_radios_label">Fucking gay</span><br />      
        
       <button type="button" class="w3-button w3-theme" id = "delete_friend_close_button" 
       onclick = delete_friend(this,"<?php echo $user_to_delete; ?>") >Destroy</button>
        
        </section>
             
      </div>
      
      <footer class="w3-container w3-pale-green">
            <p></p>
      </footer>
    
    </div>
 
  </div>
  
  <?php 
  
  $message_to = "";
  
  if(session_isset() && 
                          $_SESSION['user'] !== $login){
      $message_to = $login;
      
  }
  
  ?>
  
     <!-- Окно личного сообщения -->
  <div id="doebat_modal" class="w3-modal modal">
    <div class="w3-modal-content w3-animate-bottom w3-card-4">
      <header class="w3-container w3-pale-green"> 
        <span onclick="document.getElementById('doebat_modal').style.display='none'" 
        class="w3-button w3-display-topright">&times;</span>
         <h4>Доебать</h4>
      </header>
      
      <div class="w3-container">
       
      <section id = "private_message_box_wrapper">
        <h5>Whatever you want</h5>
        <textarea id = "private_message_textarea" style = " resize:none;width:100%;" 
        placeholder = "Да всякое вобщем" rows = "10"   maxlength = "3000" oninput = "this.placeholder = '';" 
        onblur = "this.placeholder='Да всякое вобщем'" autofocus = "autofocus" ></textarea><br />
        <span id = "private_message_server_response"><span><br />
        <button type = "button" class = "w3-button w3-theme" onclick = send_private_message('<?php echo $message_to; ?>',this) >Ахуенно</button><br />

        </section>
  
      </div>
      
      <footer class="w3-container w3-pale-green">
            <p></p>
      </footer>
    
    </div>
 
  </div>
  
   <!-- End Modals  -->


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

<script><!-- Смена авы -->

var change_ava_form = document.getElementById("change_ava_form"); // Форма отправки авы
var change_ava_button = document.getElementById("change_ava_button"); // Кнопка, на которую нажимают, когда отправляют аву

var ava_file = document.getElementById("ava_file").files[0]; // Сам файл  
var ava_preview = document.getElementById("ava_preview"); // Превью авы
var ctx_canvas = ava_preview.getContext('2d');
var MAX_FILE_SIZE = document.getElementById("MAX_FILE_SIZE");  // Максимальный размер  файла

var success_ava_loading_container = document.getElementById("success_ava_loading_container"); // Появляется если аву отправили
var progressbar = document.getElementById("progressbar"); // Прогрессбар
var progressbar_container = document.getElementById("progressbar_container"); // Прогрессбар-контэйнер
var errors_ava_loading_div = document.getElementById("errors_ava_loading_div"); // Див ошибок     

var errors_txt = "";

var load_ava_flag = false; 

function choose_file(ava){

var ava_file = ava.files[0]; // Сам файл  
var accept = ["image/jpeg","image/png"]; // Список поддерживаемых файлов

   if(accept.indexOf(ava_file.type) == -1){
       errors_txt += "Неверный формат<br />";
    }else if(ava_file.size > 3000000){
      errors_txt += "Размер авы должен быть <= 1мБ<br>";
    }

        if(errors_txt === ""){
        ava_preview.style.display = "block"; // Показываем канву
         var image_obj = new Image();    
        var imageUrl = URL.createObjectURL(ava_file);    
        image_obj.src = imageUrl;
        image_obj.weight = 100;
        image_obj.height = 100;   
        load_ava_flag = true;
        change_ava_button.style.display = "block";

        image_obj.onload = function(){
        URL.revokeObjectURL(imageUrl);	
        ctx_canvas.drawImage(image_obj, 0, 0, 100, 100);
        }
        
    } else{
            errors_ava_loading_div.innerHTML = errors_txt;
    }

}


function upload(ava_file){ 
    var xmlhttp = new XMLHttpRequest();
   
   xmlhttp.upload.onprogress = function(event) { // Заполняем прогрессбар при загрузке
        
        if(event.lengthComputable){
          
          var loaded_persents = +((event.loaded / event.total) * 100);
          progressbar.style.width = loaded_persents + "%";
    
    }

};
 
 xmlhttp.onload = xmlhttp.onerror = function() {
    if (this.status == 200) {
                   change_ava_button.style.display = "none"; // Скрываем кнопку Сменить
                /*   success_ava_loading_container.style.display = "block"; // Показываем кнопку ахуенно */
                   ava_preview.style.display = "none"; // Скрываем канву
                   progressbar_container.style.display = "none"; // Скрываем прогрессбар
                  window.location.reload(); 
    } else {
      alert("Хуйня какая-то. Попробуйте еще раз. Я не ебу почему не отправилась ава. Честно");
    }
  };

        var formData = new FormData();
        formData.append('MAX_FILE_SIZE', MAX_FILE_SIZE.value);
        formData.append('ava_file',  ava_file);
        
        xmlhttp.open("POST", "handlers/change_ava.php", true);
        xmlhttp.send(formData);
}


/* Главная функция */

change_ava_form.onsubmit = function() {
   var ava_file = document.getElementById("ava_file").files[0]; // Сам файл   
    progressbar_container.style.display = "block";
    
    if (ava_file && load_ava_flag) {
      upload(ava_file);
    }
  
    return false;
}

</script>

<body class="w3-theme-l5">
    
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v6.0&appId=105917036567372&autoLogAppEvents=1"></script>    

<?php 

$topnav_content = "";

if(session_isset()){
    
    $topnav_content =  '<div class="topnav w3-light-blue" id="topnav" >
    <a href = user.php?zs=' . $_SESSION['user'] . ' ><img class = "topnav_img" src = "imgs/header/bumazhka.png" title = "Бумажка"></a>

     <a href = "dialogs.php"><img class="topnav_img" src="imgs/header/vdvoem_tuta.png" title="Личка">
      <span class="w3-badge w3-right  w3-small shift-bage w3-teal">' . $new_dialogs . '</span>
  </a>

  <a href="bros.php?zs=' . $_SESSION['user'] . '"><img class="topnav_img" src="imgs/header/bratki.png" title="Долбоебы">
      <span class="w3-badge w3-right w3-small shift-bage w3-teal " >' . $new_friend . '</span>
  </a>
  <a href="notices.php"><img class="topnav_img" src="imgs/header/opoves.png" title="Диндон">
      <span class="w3-badge w3-right w3-small shift-bage w3-teal">' . $notice_count_badge . '</span>
  </a>
  
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
        <a href="search.php" class="w3-bar-item w3-button">Найти</a>
        <a href="exit.php" class="w3-bar-item w3-button">Пойти нахуй</a>
      
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
                    <button type = button title = "Ахуенно" 
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
                    $online = '<img src = imgs/phone.png id = zdesya_img_under_main_avatar />';
                }else {
                     $online = '<img src = imgs/zdesya.png id = zdesya_img_under_main_avatar />';
                }
           
            } 

?>


<script>

function show_status_saver(){
 var x = document.getElementById("user_status_saver");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else {
    x.className = x.className.replace(" w3-show", "");
  }
}

function save_user_status(){
var send_status_to_wall_checkbox = document.getElementById("send_status_to_wall_checkbox");    
var user_status_saver = document.getElementById("user_status_saver");    
var user_status_textarea = document.getElementById("user_status_textarea");
var user_status = document.getElementById("user_status");
user_status_saver.style.display = "none";    
if(user_status_textarea.value === "" || user_status_textarea.value.match(/^\s+$/g)){return;}
var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                user_status.innerHTML = xmlhttp.response;
                user_status_textarea.value = "";
            }
        };

if(send_status_to_wall_checkbox.checked == true ){ // Отправляем коммент на стену
var xmlhttp2 = new XMLHttpRequest();
var page_id = '<?php echo $login ?>'; // Страница на которой оставили комментарий
var wall = document.getElementById('user_wall_posts');    

if(user_status_textarea.value === "" || user_status_textarea.value.match(/^\s+$/g)){
    return;
}

xmlhttp2.onreadystatechange = function() {
if(xmlhttp2.readyState == 4 && xmlhttp2.status == 200) {
var user_status_to_wall_container = document.createElement('DIV');
user_status_to_wall_container.innerHTML = user_status_textarea.value; 
user_status_textarea.value = "";

/* wall.insertBefore( user_status_to_wall_container,wall.children[0]); */

window.location.reload();    
    
} 
}

var formData = new FormData();
formData.append('user_wall_message',user_status_textarea.value.trim());
formData.append('page_id',page_id);

xmlhttp2.open("POST", "handlers/user_wall_posts.php", true);
xmlhttp2.send(formData);
/* window.location.reload(); */
}

var formdata = new FormData();
formdata.append('user_status', user_status_textarea.value.trim());
xmlhttp.open("POST", "scripts/user_status.php", true);
xmlhttp.send(formdata);

}

</script>

<script>

/* $(window).scroll(function(){
	var wt = $(window).scrollTop();
	var wh = $(window).height();
	var et = $('#end_lc').offset().top;
	var eh = $('#end_lc').outerHeight();
	var dh = $(document).height();   
	if (wt + wh >= et || wh + wt == dh || eh + et < wh){
		console.log('Элемент показан');
		var height = $('#left_side').height() + 100;
		
		$('#left_side').css("position","fixed");
		$('#middle_side').css("position","absolute");
	}
}); */

</script>

<style>
    
    #user_status_saver{
        background-color:white;
        display:none;
        border:1px solid gray;
        width:100%;
  padding:5px;
        
    }
    
    @media only screen and (min-width: 600px) {
       #user_status_saver{
    width:500px;
}
}
    
    
    #user_online_under_big_avatar_container{
        display:inline-block;
        position:relative;
        right:18px;
        bottom:47px;
    } 
    
    #wait_for_reply_panel, 
    #cancel_friend_request_panel,
    #deleted_friend_message{
        padding:5px;
        text-align:center;
    }
    
    #buttons_panel button,
    #buttons_panel .w3-panel {
        margin-bottom:5px;
    }
    
</style>

<?php

$top_margin = "";

if(session_isset()){
    $top_margin =  ' style = "margin-top:50px;"';   
}

?>

<!-- Page Container -->
<div class="w3-container w3-content" style="max-width:1400px;background-color:#fafafa;"> 

<!-- The Grid -->
<div class="row" <?php echo $top_margin; ?>>
    <!-- Left Column -->
  <div class="col-3 menu" style = "" id = "left_side">
     <!-- Profile -->
      <div class="w3-card w3-round w3-white block">
            <div class="w3-container">
                 <div id = "nick_pseudonick_container" style = "borrder:1px solid black">
                     <h4 class="w3-center nick" style = "word-wrap:break-word"><?php echo $nickname; ?></h4>
                     <h6 class="w3-center"><?php echo $pseudonick; ?></h6>
                 </div>
                 
                 <div class="w3-center" id = "main_avatar_container">
                     <img id = "main_avatar" src="<?php echo $avatar; ?>" style="height:106px;width:106px;border-radius:5px;display:inline-block"
                     alt="<?php echo "frendors | " . $avatar; ?>" onerror = this.src='users/default_ava.jpg' 
                     <?php echo $change_avatar_function; ?>>    
                     <div id = "user_online_under_big_avatar_container">
                         <?php echo $online;?>
                     </div>
                     </div>
                 <div id = "body_lifestyle_container">
                    <div id = "body_lifestyle_wrapper">
                             <h1 id = "nick"><?php echo str_replace(" ", "_", $body); ?></h1>&#8194;
                             <h1 id = "pseudonick"><?php echo $lifestyle; ?></h1>
                    </div>
                    <div id = "user_status" <?php  echo $show_status_saver_function . $user_status_style; ?>><?php echo $last_user_status; ?></div>
                    
                   <?php echo $user_status_saver; ?>
                    
                    
                </div>
    
<script>

function showInfo(){
 
    if (main_info_container.style.display === "block") {
      main_info_container.style.display = "none";
         } else {
      main_info_container.style.display = "block";
        }
}

    function mark_as_pidor(user_id,button){
   var marked_as_pidor_span = document.getElementById("marked_as_pidor_span");

    var xmlhttp = new XMLHttpRequest();

xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
         marked_as_pidor_span.innerHTML = xmlhttp.response;
         button.onclick = null;
    }
};

var formData = new FormData();
formData.append('user_id', user_id);

xmlhttp.open("POST", "scripts/mark_as_pidor.php", true);
xmlhttp.send(formData);    

}

</script>

<?php 
// СИСТЕМА НАГРАД И ПЫТОК 
 require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection_regards.php';
$connection_handler_regards->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

// ПОГОНЫ 
// отображаем все полковничьи погоны 
$sql = "SELECT COUNT(*) AS `coloner_straps` FROM `coloner_straps` WHERE `page_id`='{$login}'";	
$query = $connection_handler_regards->prepare($sql); 
$query->execute();
$coloner_pogons_count = $query->fetchAll(PDO::FETCH_ASSOC);      
$coloner_pogons_count = $coloner_pogons_count[0]['coloner_straps'];

// ОБНОВЛЯЕМ НАГРАДЫ В ТАБЛИЦЕ main_info 
$sql = "UPDATE `main_info` SET `rating`={$coloner_pogons_count} WHERE `nickname`='{$login}'";	
$query = $connection_handler->prepare($sql); 
$query->execute();

if($login === 'Adminto') {
    $coloner_pogons_count = "0/0";
}
/* $connection_handler_regards = null; */

?>

<div id = "coloner_pogons_count_container" style = "text-align:center;font-weight:normal;">
    <?php echo "Водка <span id = 'pogons_count_span'>" . $coloner_pogons_count . "</span>";  ?>
</div>
<!-- <a id = "info_a" onclick = "showInfo()" style = "display:inline-block">Info</a> -->
        <?php 
        if(session_isset() && $login == $_SESSION['user']) 
        echo '<a href = "edit_user_info.php" style ="color:gray;display:inline-block;float:right;text-decoration:none;">ред.</a>'; 
        ?>

<div id = "main_info_container">
<table id = "main_info" style = "border-collapse:separate; border-spacing: 0px 3px">
   <form action = "edit_user_info_handler.php" method = "POST"> <tr>
        <tr>
        <td style = "text-decoration:underline;;">Mood</td>
        <td id = "mood" style = "text-decoration:underline;"><?php echo $mood . " | "; 
        if($login == $_SESSION['user'])
        echo  '<a id = "change_mood_link" style = "color:black;" style href = "#" title = "редактировать" onclick = "show_change_mood_select()">a&rarr;A</a> 
        <section id = "change_mood_section" style = "display:none;border:1px solid black;padding:5px;">
            <select name = "mood_option" id = "mood_option">
            <option value = "" >New mood:</option>
            <option value = "ahuenno">Ахуенно блять ахуенно</option>
            <option value = "smeyus">Сижу и смеюсь</option>
            <option value = "horoshee">Хорошее сразу</option>
            <option value = "kak_ptichka">Как птичка гадит</option>
            <option value = "kak_zemlya">Как земля</option>
            <option value = "ploho_stalo">Плохо стало</option>
            <option value = "vsyo_ravno">Да мне вообще всё равно</option>
        </select>
        <button type = "button" class = "btn btn-primary btn-sm" style = "position:relative;" onclick = "change_mood()">Ахуенно</button>
        </section>
        </td>
       
        <script> <!-- Редактируем настроение -->
        
        function show_change_mood_select(){
        var change_mood_section = document.getElementById("change_mood_section");    
            change_mood_section.style.display = "inline-block";
}

function change_mood(){
var mood = document.getElementById("mood");
var change_mood_section = document.getElementById("change_mood_section");
var mood_option = document.getElementById("mood_option");  

if(mood_option.value === ""){
    return;
}

var xmlhttp = new XMLHttpRequest();

xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
mood.innerHTML = xmlhttp.response;
change_mood_section.style.display = "none";
    } 
}

xmlhttp.open("GET", "handlers/change_mood.php?mood=" + mood_option.value, true);  
xmlhttp.send();
}        
        
        </script>'; ?>
        
        </tr>
        <td>Столица:</td>
        <td><?php echo $city; ?></td>
        
    </tr>
    <tr>
        <td>Пол:</td>
        <td><?php echo $sex; ?></td>
    </tr>
    <tr>
        <td>Возраст:</td>
        <td><?php echo $age; ?></td>
    </tr>
    <tr>
        <td>СП:</td>
        <td><?php echo $sp; ?></td>
    </tr>
    
    <tr>
        <td>Характер</td>
        <td><?php echo $temper; ?></td>
    </tr>

    <tr>
        <td>Училище</td>
        <td><?php echo $education; ?></td>
    </tr>
    <tr>
        <td>Религия</td>
        <td><?php echo $religion; ?></td>
    </tr>
    <tr>
        <td>Спортивные увлечения</td>
        <td><?php echo $sport; ?></td>
    </tr>
    
    <tr>
        <td>Игры</td>
        <td><?php echo $games; ?></td>
    </tr>
    <tr>
      
        <td></td>
    </tr>
    </form>
</table>
</div>
            
            <!-- End ProfileW3-Container -->
        </div>
    
    <!-- End Profile -->
      </div>

<script>

/* ПОГОНЫ */

function give_coloner_pogons(){
var pogons_count_span = document.getElementById("pogons_count_span");
var page_id = "<?php echo $login; ?>";
var xmlhttp = new XMLHttpRequest();

xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
pogons_count_span.innerHTML = xmlhttp.response;
    } 
}

play_audio("sounds/click.mp3");

xmlhttp.open("GET", "scripts/reg_torts/regards/coloner_pogons.php?page_id=" + page_id, true);  
xmlhttp.send();    
}

</script>


<?php 

if(session_isset()){

/* Награды */
$give_coloner_pogons = "";

if($login !== $login_session){ // Сидим на чужой странице

}

$inc_rating_link = "";
if($login == $login_session){
$inc_rating_link = "<a href = 'inc_points.php'>купить</a>";    
}

$groups_button = "";

if($login !== $_SESSION['user']){

}

}

if(session_isset() && 
           $login != $_SESSION['user']){ //авторизовались и сидим на ЧУЖОЙ странице

/* ИЩЕМ ОТПРАВЛЯЛИ ЛИ МЫ ЗАЯВКУ ПОЛЬЗОВАТЕЛЮ. ЕСЛИ НЕ ОТПРАВЛЯЛИ, ТО ОТОБРАЖАЕМ КНОПКУ -ВБРАТКИ-, ЕСЛИ ОТПРАВЛЯЛИ ОТОБРАЖАЕМ ЖДЕМ ПОДТВЕРЖДИЯ  */   
$sql = "SELECT * FROM `friend_requests` WHERE (`requester1`='{$login_session}' AND `requester2`='{$login}') OR (`requester1`='{$login}' AND `requester2`='{$login_session}')";
$query = $connection_handler->prepare($sql); 
$query->execute();
$requests = $query->fetchAll(PDO::FETCH_ASSOC);

/* ИЩЕМ ЯВЛЯЕМСЯ ЛИ ДРУЗЬЯМИ. ЕСЛИ ЯВЛЯЕМСЯ ОТОБРАЖАЕМ КНОПКУ -УНИЧТОЖИТЬ-, ЕСЛИ НЕ ЯВЛЯЕМСЯ ОТОБРАЖАЕМ КНОПКУ -ВБРАТКИ-*/   
$sql = "SELECT * FROM `friends` WHERE (`friend1`='{$login_session}' AND `friend2`='{$login}') OR (`friend1`='{$login}' AND `friend2`='{$login_session}')";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$friend = $query->fetchAll(PDO::FETCH_ASSOC);

/* ИЩЕМ АЙДИ ПОЛЬЗОВАТЕЛЯ */
$sql = "SELECT user_id from main_info WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $login, PDO::PARAM_STR);
$query->execute();
$user_id = $query->fetchAll(PDO::FETCH_ASSOC);
$user_id = $user_id[0]['user_id'];

$sql = "SELECT * FROM mark_as_pidor WHERE marked_id='{$user_id}'"; // Выбираем время последней активности пользователя	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);

$marked_as_pidor_count = "";

if(count($result) > 0){
    $marked_as_pidor_count = count($result);
}

$marked_as_pidor_span = "<span id = 'marked_as_pidor_span'>" . $marked_as_pidor_count . "</span>";

if(empty($requests) && !empty($friend)){ // В друзьях. Пользователь добавил. Очистил строку запроса
 $delete_friend_vbratki_button = "<button id = 'delete_friend_button' class = 'w3-button w3-block w3-theme'" . 
 " onclick=document.getElementById('delete_friend_modal').style.display='block'" . " >Пошел нахуй!</button>
  <div id = 'deleted_friend_message' class = 'w3-panel w3-pale-green' style = 'display:none;'>Гавно!</div>";
    } else if(empty($requests) && empty($friends)) { // В друзьях нет. Отображаем кнопку ВБРАТКИ
     $delete_friend_vbratki_button = "<button id = 'vbratki_button' onclick = friend_request(this,{$user_id}) class = 'w3-button w3-block w3-round w3-light-blue' >В долбоебы</button>
      <div id = 'wait_for_reply_panel' class = 'w3-panel w3-pale-green'  style = 'display:none;'>Ждем бля</div>";    
    }else if(!empty($requests) && empty($friends)){ // Посылали запрос пользователю. 
    
    if($login == $requests[0]['requester1']){
    $wait_for_reply_panel = "<div id = 'wait_for_reply_panel' class = 'w3-panel w3-pale-green'>Добавляй нахуй!</div>";
          
    } else if($login == $requests[0]['requester2']){
        $cancel_friend_request_button =  "<button id = 'cancel_friend_request_button' class = 'w3-button w3-block w3-theme' 
                                        onclick = cancel_friend_request(this,{$user_id})>Отменить запрос</button>
                                        <div id = 'cancel_friend_request_panel' class = 'w3-panel w3-pale-green'  style = 'display:none;'>Отменено нахуй!</div>";         
    }
        
}
 
 /* ИЩЕМ АЙДИ ПОЛЬЗОВАТЕЛЯ */
$sql = "SELECT user_id from main_info WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $nickname, PDO::PARAM_STR);
$query->execute();
$user_id = $query->fetchAll(PDO::FETCH_ASSOC);
$user_id = $user_id[0]['user_id'];
 
 /* Погоны */
$give_coloner_pogons = ' onclick = "give_coloner_pogons();"';
$rating_button = '<button type = "button"  class = "w3-button w3-block w3-round w3-light-blue" id = "give_strap_button" ' . $give_coloner_pogons . ' 
                                    title = "Дать погону" style = "background-color:#f5f5f5;">
                         <div id = "give_strap_button_wrapper" style = "font-weight:normal;">Дать водки</div>
                    </button>';

if($login == $_SESSION['user'] || $login == 'Adminto'){ // у админа рейтинга нет погону не от ображаем. кнопка на своей странице не отображается
$rating_button = "";    
}
 
 $doebat_button = "<button id = doebat_button class = 'w3-button w3-block w3-round w3-light-blue' onclick=document.getElementById('doebat_modal').style.display='block'>Доебать</button>";
 $mark_as_pidor_button = '<button id = "mark_as_pidor_button" class = "w3-button w3-block w3-round w3-light-blue" 
 onclick = "mark_as_pidor(' . $user_id . ',this)" >Посчитать пидором ' . $marked_as_pidor_span . '</button>';

$buttons_container = '<div class="w3-card w3-round w3-white w3-padding-16" id = "buttons_panel" style = "margin-bottom:10px">
        <div class="w3-container">' .
        $delete_friend_vbratki_button . 
        $wait_for_reply_panel . 
        $cancel_friend_request_button  . 
        $doebat_button .
        $groups_button .
        $rating_button .
        $mark_as_pidor_button . '</div></div>';

}

?>

<?php 

if($login === 'Frendors'){
    $buttons_container = "";
}

echo $buttons_container;

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

/* (function check_new_messages_in_user_chat(){
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

//scrollBottom();

setTimeout(check_new_messages_in_user_chat,5000);

}

var formData = new FormData();
formData.append('last_message_id', last_message_id_user_chat.value);

xmlhttp.open("POST", "scripts/user_chat_new_messages.php", true);
xmlhttp.send(formData);

})() */

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

//scrollBottom();

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

//scrollBottom();

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

<script>

var private_message_random_user_box = document.getElementById('private_message_random_user_box');
function show_private_message_random_user_box(){
private_message_random_user_box.style.display = "block";    
}

function close_private_message_randon_user_box(){
private_message_random_user_box.style.display = "none";   
}

function send_private_random_user_message(button){
var private_message_random_user_textarea = document.getElementById("private_message_random_user_textarea");
var private_message_random_user_server_response = document.getElementById("private_message_random_user_server_response");
if(private_message_random_user_textarea.value === ""){return;}

var xmlhttp = new XMLHttpRequest();

xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      private_message_random_user_textarea.innerHTML = "";
      private_message_random_user_server_response.innerHTML = xmlhttp.response;
      setTimeout(window.location.reload(),5000);
    }
};

var formData = new FormData();
formData.append('message', private_message_random_user_textarea.value);

xmlhttp.open("POST", "scripts/send_private_message_to_random_user.php", true);
xmlhttp.send(formData);    
private_message_random_user_textarea.value = "";
private_message_random_user_box.style.display = "none";     
}

</script>

 <?php if(session_isset()) {
echo "<div class='w3-card w3-round w3-white w3-padding' style = 'margin-top:-15px;margin-bottom:10px'>
            <div class='w3-container'>
            <button type = 'button' class = 'w3-button w3-block w3-round w3-light-blue' style = 'word-wrap:break-word'" . 
         " onclick = 'show_private_message_random_user_box()' title = 'doebutt randomly user' >
          Доебслуч
        </button> </div>
</div>"; 
}

?>

<style>
    
    .bro_img{
        width:55px;
        height:55px;
        border-radius:100%;
        padding:5px;
        display:inline-block;
        text-align:center;
    }
    
</style>

<?php 
/* ВСЕ ДРУЗЬЯ */

/* ИЩЕМ  ТЕХ ДРУЗЕЙ КОТОРЫЕ ОТПРАВЛЯЛИ ЗАЯВКУ ПОЛЬЗОВАТЕЛЮ */
$sql = "SELECT friend1,friend2, additional_info.avatar AS avatar FROM `friends`" . 
" INNER JOIN additional_info ON additional_info.nickname=friends.friend1 WHERE `friend2`='{$login}'"; 	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$friends_from = $query->fetchAll(PDO::FETCH_ASSOC);
$friends_from_count = count($friends_from);

$friends_container = "";

for($i = 0; $i < count($friends_from); $i++){
    $friends_container .= "<a href = 'user.php?zs={$friends_from[$i]['friend1']}' title = '{$friends_from[$i]['friend1']}'><img src = 'users/{$friends_from[$i]['avatar']}'  class = 'bro_img' /></a>";
    if($i == 9){break;}
}

/* ИЩЕМ  ТЕХ ДРУЗЕЙ КОТОРЫМ ПОЛЬЗОВАТЕЛЬ ОТПРАВИЛ ЗАЯВКУ */
$sql = "SELECT friend1,friend2, additional_info.avatar AS avatar FROM `friends`" . 
" INNER JOIN additional_info ON additional_info.nickname=friends.friend2 WHERE `friend1`='{$login}'"; 	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$friends_to = $query->fetchAll(PDO::FETCH_ASSOC);
$friends_to_count = count($friends_to);

for($i = 0; $i < count($friends_to); $i++){
    $friends_container .= "<a href = 'user.php?zs={$friends_to[$i]['friend2']}&ls=" . $page_number ."' title = '{$friends_to[$i]['friend2']}'><img src = 'users/{$friends_to[$i]['avatar']}'  class = 'bro_img' /></a>";
       if($i == 9){break;}
}

$friends_all_count = $friends_from_count + $friends_to_count; 

/*-*****************************************************************************/

        /* ОБЩИЕ ДРУЗЬЯ */
        
        if($login != $login_session){ /* СИДИМ НА ЧУЖОЙ СТРАНИЦЕ */
        
        /* ИЩЕМ ДРУЗЕЙ, КОТОРЫЕ ОТПРАВЛЯЛИ ЗАЯВКУ СЕССИОННОМУ И ПОЛЬЗОВАТЕЛЮ */
        $common_friends_from = array(); // ОБЩИЕ ДРУЗЬЯ, КОТОРЫЕ ОТПРАВЛЯЛИ ЗАЯВКУ СЕССИОННОМУ И К КОТОРОМУ ЗАШЛИ
        
        /* ИЩЕМ  ТЕХ ДРУЗЕЙ КОТОРЫЕ ОТПРАВЛЯЛИ ЗАЯВКУ СЕССИОННОМУ */
        $sql = "SELECT friend1,friend2, additional_info.avatar AS avatar FROM `friends`" . 
        " INNER JOIN additional_info ON additional_info.nickname=friends.friend1 WHERE `friend2`='{$login_session}'"; 	
        $query = $connection_handler->prepare($sql); //Подготавливаем запрос
        $query->execute();
        $friends_from_of_sessioner = $query->fetchAll(PDO::FETCH_ASSOC);
        $friends_from_of_sessioner_count = count($friends_from_of_sessioner);
        
        /* ИЩЕМ  ТЕХ ДРУЗЕЙ КОТОРЫЕ ОТПРАВЛЯЛИ ЗАЯВКУ ПОЛЬЗОВАТЕЛЮ, К КОТОРОМУ ЗАШЛИ */
        $sql = "SELECT friend1,friend2, additional_info.avatar AS avatar FROM `friends`" . 
        " INNER JOIN additional_info ON additional_info.nickname=friends.friend1 WHERE `friend2`='{$login}'"; 	
        $query = $connection_handler->prepare($sql); //Подготавливаем запрос
        $query->execute();
        $friends_from_of_login = $query->fetchAll(PDO::FETCH_ASSOC);
        $friends_from_of_login_count = count($friends_from_of_login);
        
        $common_friends_from = array();
        
        for($i = 0; $i < $friends_from_of_sessioner_count; $i++){
                 for($j = 0; $j < $friends_from_of_login_count; $j++){
                        if($friends_from_of_sessioner[$i]['friend1'] === $friends_from_of_login[$j]['friend1'] ){
                            array_push($common_friends_from, $friends_from_of_login[$j]['friend1']); 
                        }
                    
                 }   
        }
        
        $common_friends_from_outp = "";
        for($i = 0; $i < count($common_friends_from); $i++){
        $sql = "SELECT * FROM `additional_info` WHERE `nickname` = '{$common_friends_from[$i]}'"; 	
        $query = $connection_handler->prepare($sql); 
        $query->execute();
        $avatar = $query->fetchAll(PDO::FETCH_ASSOC);
        $avatar = $avatar[0]['avatar'];
           $common_friends_from_outp .= "<a href = 'user.php?zs={$common_friends_from[$i]}&ls={$page_number}' title = '{$common_friends_from[$i]}'><img src = 'users/{$avatar}'  class = 'bro_img' /></a>"; 
        }
        
        /* ИЩЕМ ДРУЗЕЙ, КОТОРЫМ ОТПРАВЛЯЛ ЗАЯВКУ СЕССИОННЫЙ И ПОЛЬЗОВАТЕЛ */
        $common_friends_to = array(); // ОБЩИЕ ДРУЗЬЯ, КОТОРЫМ ОТПРАВЛЯЛ ЗАЯВКУ СЕССИОННЫЙ И К КОТОРОМУ ЗАШЛИ
        
        /* ИЩЕМ  ТЕХ ДРУЗЕЙ КОТОРЫМ ОТПРАВЛЯЛ ЗАЯВКУ СЕССИОННЫЙ */
        $sql = "SELECT friend1,friend2, additional_info.avatar AS avatar FROM `friends`" . 
        " INNER JOIN additional_info ON additional_info.nickname=friends.friend1 WHERE `friend1`='{$login_session}'"; 	
        $query = $connection_handler->prepare($sql);
        $query->execute();
        $friends_to_of_sessioner = $query->fetchAll(PDO::FETCH_ASSOC);
        $friends_to_of_sessioner_count = count($friends_to_of_sessioner);
        
        /* ИЩЕМ  ТЕХ ДРУЗЕЙ КОТОРЫМ ОТПРАВЛЯЛ ЗАЯВКУ ПОЛЬЗОВАТЕЛЬ, К КОТОРОМУ ЗАШЛИ */
        $sql = "SELECT friend1,friend2, additional_info.avatar AS avatar FROM `friends`" . 
        " INNER JOIN additional_info ON additional_info.nickname=friends.friend1 WHERE `friend1`='{$login}'"; 	
        $query = $connection_handler->prepare($sql); 
        $query->execute();
        $friends_to_of_login = $query->fetchAll(PDO::FETCH_ASSOC);
        $friends_to_of_login_count = count($friends_to_of_login);
        
        $common_friends_to = array();
        
        for($i = 0; $i < $friends_to_of_sessioner_count; $i++){
                 for($j = 0; $j < $friends_to_of_login_count; $j++){
                        if($friends_to_of_sessioner[$i]['friend2'] === $friends_to_of_login[$j]['friend2'] ){
                           array_push($common_friends_to, $friends_to_of_login[$j]['friend2']); 
                        }
                    
                 }   
        }
        
        $common_friends_to_outp = "";
        for($i = 0; $i < count($common_friends_to); $i++){
        $sql = "SELECT * FROM `additional_info` WHERE `nickname` = '{$common_friends_to[$i]}'"; 	
        $query = $connection_handler->prepare($sql); 
        $query->execute();
        $avatar = $query->fetchAll(PDO::FETCH_ASSOC);
        $avatar = $avatar[0]['avatar'];
           $common_friends_to_outp .= "<a href = 'user.php?zs={$common_friends_to[$i]}&ls={$page_number}' title = '{$common_friends_to[$i]}'>
           <img src = 'users/{$avatar}'  class = 'bro_img' /></a>"; 
        }
        
        $common_friends_total = array();
        
        if(!empty($common_friends_to)){ // ДОБАВЛЯЕМ В ОБЩИЙ МАССИВ
            for($i = 0;$i < count($common_friends_to); $i++){
            array_push($common_friends_total, $common_friends_to[$i]);
                if($i == 9){break;}
                
            }
        }
        
        if(!empty($common_friends_from)){
            
            for($i = 0;$i < count($common_friends_from); $i++){
            array_push($common_friends_total, $common_friends_from[$i]);
                   if($i == 9){break;}
                }
        }
        
        $common_friends_total_outp .= $common_friends_from_outp . $common_friends_to_outp; // ВСЕ ОБЩИЕ ДРУЗЬЯ
        
        $common_friends_total_count = count($common_friends_total);
        
        }
 /********************************************************************************/
 
if($friends_all_count > 0){

    if($common_friends_total_count > 0){
         $common_friends_total_outp = '<div class="w3-container">
 <header style = "border-bottom:1px solid #F5F7F8">
         <a href = "common_bros.php?zs=' . str_replace(" ","%20",$login) . '" style = "text-decoration:none;">Общие</a>   
          <span id = "bros_common_count" >' .  $common_friends_total_count . '</span>
 </header>' .
     $common_friends_total_outp .
'</div>';
    }

echo '<div class="w3-card w3-round w3-white">
       <div class="w3-container">
<header id = "bros_all_header"  style = "border-bottom:1px solid #F5F7F8"><a href = "bros.php?zs=' . $login . '" style = "text-decoration:none">Долбоебы  <span id = "bros_all_count">' .  $friends_all_count . '</span></a></header>
<div class = "w3-center">';

echo $friends_container . $common_friends_total_outp;

echo '</div>
    </div>
    </div>';
}

?>

  <!-- End Left Column -->
  </div>
  
 <script>

function expand_textarea(obj){
obj.style.height = "70px";

}

function link_preview_post(textarea){ // Превью ссылки поста
     
     
     var preview_div_post_img = document.getElementById("preview_div_post_img"); // рисунок
     var preview_div_post_video = document.getElementById("preview_div_post_video"); // видео

     var pattern_for_youtube = new RegExp(/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)([a-zA-Z0-9\-]{1,256})/ig); // https://youtube.com;
    // youtube.com
      if(pattern_for_youtube.test(textarea.value)){ // Возвращает true
                console.log("Обнаружено видео ютуб");

                preview_div_post_video.style.display = "block";
                var link = textarea.value.match(pattern_for_youtube);
                var hash = link[link.length - 1].replace(/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtube\.com\/watch\?v=)/,""); // извлекаем хэш 
                preview_div_post_video.src = "https://youtube.com/embed/" + hash; 
    }
    
       var pattern_for_youtube_m = new RegExp(/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtu.be\/)([a-zA-Z0-9\-_]{1,256})/ig); // https://youtube.com;
    // youtube.com
      if(pattern_for_youtube_m.test(textarea.value)){ // Возвращает true
                console.log("Обнаружено видео ютуб");

                preview_div_post_video.style.display = "block";
                var link = textarea.value.match(pattern_for_youtube_m);
                var hash = link[link.length - 1].replace(/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(youtu.be\/)/,""); // извлекаем хэш 
                preview_div_post_video.src = "https://youtube.com/embed/" + hash; 
    }
    
    var pattern_for_pornhub = new RegExp(/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(rt\.)?(pornhub\.com\/view_video.php\?viewkey=)([a-zA-Z0-9]{1,256})/ig); // https://pornhub.com;
    // pornhub.com
      if(pattern_for_pornhub.test(textarea.value)){ // Возвращает true
                console.log("Обнаружено видео pornhub");

                preview_div_post_video.style.display = "block";
                var link = textarea.value.match(pattern_for_pornhub);
                var hash = link[link.length - 1].replace(/(^|[\n ])([\w]*?)(https?:\/\/)?(www.)?(rt\.)?(pornhub\.com\/view_video.php\?viewkey=)/,""); // извлекаем хэш 
                preview_div_post_video.src = "https://pornhub.com/embed/" + hash; 
    }  

     var pattern_for_vk_video = new RegExp(/(^|[\n ])([\w]*?)(\/\/)?(vk\.com\/video_ext\.php\?oid=)([a-zA-Z0-9&-=])+/ig); // //vk.com/video_ext.php?oid=-29544671&id=456241231&hash=127efa9e264dd8be&hd=2
    // //vk.com/video_ext.php?oid=-29544671&id=456241231&hash=127efa9e264dd8be&hd=2
      if(pattern_for_vk_video.test(textarea.value)){ // Возвращает true
                console.log("Обнаружено видео от вк");

                preview_div_post_video.style.display = "block";
                var link = textarea.value.match(pattern_for_vk_video);
                preview_div_post_video.src = link[link.length - 1]; 
    }


//sun
   var pattern_http_frendors_com_img  = new RegExp(/(^|[\n ])([\w]*?)(https?:\/\/sun[0-9]{1,100}-[0-9]{1,100}\.userapi\.com\/)([a-zA-Z0-9_\-\/\-.?&;%=+\,!]{1,256})/ig); // http(s)://frendors.com/ изображение
   if(pattern_http_frendors_com_img.test(textarea.value)){ // Возвращает true
              
            console.log("Обнаружено изображение");  

            var link = textarea.value.match(pattern_http_frendors_com_img);
            preview_div_post_img.style.display = "block"; // Показываем див
         
            preview_div_post_img.src = link[link.length - 1].replace(" ",""); // Отображаем картинку

}

//pp
   var pattern_http_frendors_com_img  = new RegExp(/(https:\/\/pp.userapi.com\/)([a-zA-Z0-9_\-\/\-.?&;%=+]{1,256})$/ig); // http(s)://frendors.com/ изображение
   if(pattern_http_frendors_com_img.test(textarea.value)){ // Возвращает true
              
            console.log("Обнаружено изображение");  

            var link = textarea.value.match(pattern_http_frendors_com_img);
            preview_div_post_img.style.display = "block"; // Показываем див
         
            preview_div_post_img.src = link[link.length - 1].replace(" ",""); // Отображаем картинку

}

}

function sendPost(){
var xmlhttp = new XMLHttpRequest();
var post_textarea = document.getElementById("user_wall_message"); // Сообщение

if(post_textarea.value === "" || post_textarea.value.match(/^\s+$/g)){return;}
post_textarea.rows = 1;
   
xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
window.location.reload();
} 
}

var formData = new FormData();
formData.append('user_wall_message', post_textarea.value.trim());

xmlhttp.open("POST", "handlers/user_wall_posts.php", true);
xmlhttp.send(formData);    

post_textarea.value = "";    

}

function send_post_enter_key(event){
var char = event.key;  

if((event.ctrlKey) && ((event.keyCode == 0xA)||(event.keyCode == 0xD))) {
sendPost();    
}   
}

/***********************************************************************************************/

function delete_post(post,delete_post_cross){
var delete_post_message = document.getElementById("delete_post_message_" + post);

var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
    delete_post_cross.onclick = null;
    delete_post_cross.style.display = "none";
    window.location.reload();
    } 
}

 var formData = new FormData();
        formData.append('post', post);
        
        xmlhttp.open("POST", "scripts/delete_post.php", true);
        xmlhttp.send(formData);

}

function delete_comment(comment,delete_comment_cross){

var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      delete_comment_cross.onclick = null;
    delete_comment_cross.style.display = "none";
    window.location.reload();
    } 
}

 var formData = new FormData();
        formData.append('comment', comment);
        
        xmlhttp.open("POST", "scripts/delete_post.php", true);
        xmlhttp.send(formData);

}


function tell_to_bros_ahuenno_post(post_id,button){
var likers_count_container = document.getElementById("likers_count_" + post_id); 
var likers_count = +likers_count_container.innerHTML;

if(likers_count == "" || likers_count == null){
    likers_count = 0;
}

    var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {

    if(xmlhttp.response.trim() == "!"){
        likers_count_container.innerHTML += xmlhttp.response;
    }else{
           ++likers_count;
            likers_count_container.innerHTML = likers_count;
        
    }
    
    button.onclick = null;
   
    } 
}

var formData = new FormData();
formData.append('post_id', post_id);

xmlhttp.open("POST", "scripts/tell_to_bros_ahuenno_post.php", true);
xmlhttp.send(formData);
    
}

function tell_to_bros_gavno_post(post_id,button){
var dislikers_count_container = document.getElementById("dislikers_count_" + post_id); 
var dislikers_count = +dislikers_count_container.innerHTML;

if(dislikers_count == "" || dislikers_count == null){
    dislikers_count = 0;
}

    var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {

    if(xmlhttp.response.trim() == "!"){
        dislikers_count_container.innerHTML += xmlhttp.response;
    }else{
           ++dislikers_count;
            dislikers_count_container.innerHTML = dislikers_count;
        
    }
    
    button.onclick = null;
   
    } 
}

var formData = new FormData();
formData.append('post_id', post_id);

xmlhttp.open("POST", "scripts/tell_to_bros_gavno_post.php", true);
xmlhttp.send(formData);
    
}

function send_story(){
    var story_name = document.getElementById("story_name");
    var story_textarea = document.getElementById("story_textarea");
    var story_server_response = document.getElementById("story_server_response");
    var errors_txt = "";
    var error_exist = false;
    
     if(story_name.value === ""){
    errors_txt += "Где название нахуй!?<br />";
    error_exist = true;
    }
    
    if(story_name.value.match(/^\s+$/g)){
   errors_txt += "Одни пробелы нахуй!<br />";
    error_exist = true;
    }
    
    if(story_textarea.value.match(/^\s+$/g)){
    errors_txt += "Одни пробелы в содержании нахуй!<br />";
    error_exist = true;
}

if(story_textarea.value === ""){
   errors_txt += "Где история нахуй!?<br />";
    error_exist = true;
    } 

if(error_exist == true){
    story_server_response.innerHTML = errors_txt;
    return;
}

var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
story_textarea.value = "";
story_name.value = "";
 story_server_response.innerHTML = xmlhttp.response;
setTimeout(window.location.reload(),3000);
} 
}

var formData = new FormData();
formData.append('name', story_name.value.trim());
formData.append('text', story_textarea.value.trim());

xmlhttp.open("POST", "scripts/write_user_story.php", true);
xmlhttp.send(formData);

}

</script>

<style>

#user_wall_message, 
.comment_textarea{

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
 
 .date{
     font-size:12px;
 }
 
 /*****************************************/
 
 .reply_post_block{
     margin-top:-20px;
 }
 
 textarea{
     resize:none;
 }
 
 .doebat_comment_span{
     font-size:12px;
     cursor:pointer;
 }
 
 .doebat_comment_span:hover{
     text-decoration:underline;
 }
 
 .comment_textarea_container{
     display:none;
 }
 
 .comment_textarea{
     
 }
 
</style>

<?php 

$post_textarea = "";

if(session_isset()){
    
    if($page_number == 1){
    $post_textarea = 
    '<div class="w3-row-padding">
        <div class="w3-col m12">
          <div class="w3-card w3-round w3-white">
            <div class="w3-container w3-padding">
            
            <div id = "post_textarea_container">
            <textarea id = "user_wall_message" placeholder = "пиши" class="w3-border w3-padding" 
                            onkeypress = "send_post_enter_key(event)" maxlength = "1000" oninput = "expand_textarea(this);link_preview_post(this)"></textarea>
                    <button type="button" class="w3-button w3-block w3-round w3-light-blue" onclick = sendPost() style = "background: #87CEEB url(/img/maslaev__icon.png) no-repeat center right 28%;"></i>Ахуенно</button> 
            </div>    
            
            <div id = "post_preview_container">
            
                <img id = preview_div_post_img class = "w3-half multimedia_post_preview"   />
                <iframe id = preview_div_post_video class = "w3-half multimedia_post_preview" ></iframe>
             
             </div> 
            
            </div>
          
          </div>
        </div>
      </div>';
    }
}

?>

  


<?php

/*  ИЗВЛЕКАЕМ ВСЕ СООБЩЕНИЯ НА СТЕНУ ИЗ БАЗЫ */
$sql = "SELECT wall_user_posts.nickname, wall_user_posts.message, wall_user_posts.date, wall_user_posts.whose_multimedia, wall_user_posts.multimedia_id,  wall_user_posts.this_id,
wall_user_posts.this_id AS post_id,wall_user_posts.type,wall_user_posts.post_sender_ahuenno,wall_user_posts.post_sender_gavno,wall_user_posts.page_id, 
additional_info.avatar FROM wall_user_posts" . 
" INNER JOIN additional_info ON wall_user_posts.nickname=additional_info.nickname ORDER BY wall_user_posts.this_id DESC LIMIT {$offset}, {$count_on_page}";
    $query = $connection_handler->prepare($sql);
    $query->execute();
$posts = $query->fetchAll(PDO::FETCH_ASSOC);
$posts_count_on_wall = count($posts);

$sql = "SELECT COUNT(this_id) AS num_rows from wall_user_posts"; // Извлекаем все сообщения на стену из базы 
    $query = $connection_handler->prepare($sql);
    $query->execute();
$num_rows = $query->fetchAll(PDO::FETCH_ASSOC); // Получаем двумерный массив строк
 $total_posts_count  = $num_rows[0]['num_rows']; // Количество комментариев 
 
 $posts_container = "";

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
    case 'telled_ahuenno':     
                            $sql = "SELECT * FROM `additional_info` WHERE `nickname`='{$post_sender_ahuenno}'"; 	
                            $query = $connection_handler->prepare($sql); //Подготавливаем запрос
                            $query->execute();
                            $result = $query->fetchAll(PDO::FETCH_ASSOC);
                            $ahuenno_teller_avatar =  $result[0]['avatar'];   
        
                            $post_text = "<header class = ahuenno_post_header>Ахуенно &nbsp;<span>&rarr;</span>&nbsp; 
                            <a href = user.php?zs=" . str_replace(" ", "%20", $post_sender_ahuenno) . " >
                            <img src = 'users/" . $ahuenno_teller_avatar . "' class = 'ahuenno_teller_avatar' /> {$post_sender_ahuenno}</a></header>
                            <div class = 'w3-panel' style = 'margin-bottom:-1px;word-wrap:break-word'>" . tolink(nl2br($posts[$i]['message'])) . "</div>";  
                            break;
    case 'telled_gavno': 
                            $sql = "SELECT * FROM `additional_info` WHERE `nickname`='{$post_sender_gavno}'"; 	
                            $query = $connection_handler->prepare($sql); //Подготавливаем запрос
                            $query->execute();
                            $result = $query->fetchAll(PDO::FETCH_ASSOC);
                            $gavno_teller_avatar =  $result[0]['avatar']; 
        
                        $post_text = "<header class = gavno_post_header>Гавно! &rarr; <a href = user.php?zs=" . str_replace(" ", "%20", $post_sender_gavno) . ">
                        <img src = 'users/" . $gavno_teller_avatar . "' class = 'ahuenno_teller_avatar' />{$post_sender_gavno}</a></header>
                          <div style = 'word-wrap:break-word'>" . tolink(nl2br($posts[$i]['message'])) . "</div>";
                          break;
                            
    case 'telled_ahuenno_common_image': 
                                        
                                        $post_text = "<header class = ahuenno_post_header>Ахуенно &rarr; <a href = 'user.php?zs=" . str_replace(" ","%20",$whose_multimedia) . "' target='_blank'>" . str_replace(" ","_",$whose_multimedia) . "</a> </header>
                                        <div class = 'w3-panel' = margin-bottom:-1px><a href = 'common_images.php?image_id={$image_id}' target='_blank'><span style = 'display:none'>{$posts[$i]['message']}</span>https://frendors.com/common_images.php?image_id={$image_id}</a></div>"; 
                                        break;
    case 'telled_ahuenno_primary_image':
                                        $sql = "SELECT * FROM `additional_info` WHERE `nickname`='{$whose_multimedia}'"; 	
                                        $query = $connection_handler->prepare($sql); //Подготавливаем запрос
                                        $query->execute();
                                        $result = $query->fetchAll(PDO::FETCH_ASSOC);
                                        $ahuenno_teller_avatar =  $result[0]['avatar'];   
    
                                        $post_text = "<header class = ahuenno_post_header>Ахуенно &rarr; 
                                        <a href = 'user.php?zs=" . str_replace(" ","%20",$whose_multimedia) . "' target='_blank'>
                                        <img src = 'users/" . $ahuenno_teller_avatar . "' class = 'ahuenno_teller_avatar' />" . str_replace(" ","%20",$whose_multimedia) . "</a> </header>
                                        <div class = 'w3-panel' style = margin-bottom:-1px>
                                        <a href = 'primary_album.php?zs=" . str_replace(" ","%20",$whose_multimedia) . "&image_id={$image_id}' target='_blank' style='word-wrap:break-word;'>
                                        https://frendors.com/primary_album.php?zs=" . str_replace(" ","%20",$whose_multimedia) . "&image_id={$image_id}</a></div>";  
                                        break;
    case 'telled_ahuenno_common_video': $post_text = "<header class = ahuenno_post_header>Ахуенно &rarr; <a href = 'user.php?zs=" . str_replace(" ","%20",$whose_multimedia) . "' target='_blank'>" . str_replace(" ","%20",$whose_multimedia) . "</a> </header>
                                        <div class = 'w3-panel' style = margin-bottom:-1px><a href = 'https://frendors.com/common_videos.php#user_video_container_{$video_id}' target='_blank'>
                                        <span style = 'display:none'>{$posts[$i]['message']}</span>https://frendors.com/common_videos.php#user_video_container_{$video_id}</a></div>";  
                                        break;
    
    case 'telled_gavno_primary_image':  $post_text = "<header class = ahuenno_post_header>Гавно! &rarr; <a href = 'user.php?zs=" . str_replace(" ","%20",$whose_multimedia) . "' target='_blank'>" . str_replace(" ","%20",$whose_multimedia) . "</a> </header>
                                        <div class = 'w3-panel' style = margin-bottom:-1px><a href = 'primary_album.php?zs=" . str_replace(" ","%20",$whose_multimedia) . "&image_id={$image_id}' target='_blank'>
                                        <span style = 'display:none'>{$posts[$i]['message']}</span>https://frendors.com/primary_album.php?zs=" . str_replace(" ","%20",$whose_multimedia) . "&image_id={$image_id}</a></div>"; 
                                        break;                                    
    case 'telled_ahuenno_user_video':   $post_text = "<header class = ahuenno_post_header>Ахуенно &rarr; <a href = 'user.php?zs=" . str_replace(" ","%20",$whose_multimedia) . "' target='_blank'>" . str_replace(" ","%20",$whose_multimedia) . "</a> </header>
                                        <div class = 'w3-panel' style = margin-bottom:-1px><a href = 'user_videos.php?zs=" . str_replace(" ","%20",$whose_multimedia) . "#user_video_container_{$video_id}' target='_blank'><span style = 'display:none'>{$posts[$i]['message']}</span>https://frendors.com/user_videos.php?zs=" . str_replace(" ","%20",$whose_multimedia) . "#user_video_container_{$video_id}</a></div>"; 
                                        break; 
    case 'telled_gavno_user_video':     $post_text = "<header class = ahuenno_post_header>Гавно! &rarr; <a href = 'user.php?zs=" . str_replace(" ","%20",$whose_multimedia) . "' target='_blank'>" . str_replace(" ","%20",$whose_multimedia) . "</a> </header>
                                        <div class = 'w3-panel' style = margin-bottom:-1px><a href = 'user_videos.php?zs=" . str_replace(" ","%20",$whose_multimedia) . "#user_video_container_{$video_id}' target='_blank'><span style = 'display:none'>{$posts[$i]['message']}</span>https://frendors.com/user_videos.php?zs=" . str_replace(" ","%20",$whose_multimedia) . "#user_video_container_{$video_id}</a></div>"; 
                                        break; 
                                        
     case 'mark_as_pidor':     $post_text = "<div>
     Cчитаю пользователя  <a href = 'user.php?zs=" . str_replace(" ","%20",$posts[$i]['page_id']) . "' target='_blank'>" . str_replace(" ","%20",$posts[$i]['page_id']) . "</a> пидором
     </div>";
                             
    break;
    
        case 'add_friend':     $post_text = "<div>
     <a href = 'user.php?zs=" . str_replace(" ","%20",$posts[$i]['page_id']) . "' target='_blank'>" . str_replace(" ","%20",$posts[$i]['page_id']) . "</a> и 
          <a href = 'user.php?zs=" . str_replace(" ","%20",$posts[$i]['nickname']) . "' target='_blank'>" . str_replace(" ","%20",$posts[$i]['nickname']) . "</a> два братка-долбоеба
     </div>";
                                      
                                        break; 

                    }        
     
                            /* ПРОВЕРЯЕМ КОЛИЧЕСТВО О ДАННОМ ПОСТЕ АХУЕННО */
                            $sql = "SELECT COUNT(*) as 'likers_count' FROM `tell_to_bros_ahuenno_post` WHERE `post_id`={$posts[$i]['post_id']}"; 	
                            $query = $connection_handler->prepare($sql); 
                            $query->execute();
                            $likers = $query->fetchAll(PDO::FETCH_ASSOC);
                            $likers_count = $likers[0]['likers_count'];
                            
                            $tell_to_bros_ahuenno_function = "";
                            
                            if(!empty($_SESSION['user'])){
                                 $tell_to_bros_ahuenno_function = " onclick = tell_to_bros_ahuenno_post(" . $posts[$i]['post_id'] . ",this)";
                            }
                            
                        if($likers_count == 0){
                            $likers_count = "";
                        }
                        
                         /* ПРОВЕРЯЕМ КОЛИЧЕСТВО О ДАННОМ ПОСТЕ ГАВНО */
                            $sql = "SELECT COUNT(*) as 'dislikers_count' FROM `tell_to_bros_gavno_post` WHERE `post_id`={$posts[$i]['post_id']}"; 	
                            $query = $connection_handler->prepare($sql); 
                            $query->execute();
                            $dislikers = $query->fetchAll(PDO::FETCH_ASSOC);
                            $dislikers_count = $dislikers[0]['dislikers_count'];
                            
                            $tell_to_bros_gavno_function = "";
                            
                            if(!empty($_SESSION['user'])){
                                 $tell_to_bros_gavno_function = " onclick = tell_to_bros_gavno_post(" . $posts[$i]['post_id'] . ",this)";
                            }
                            
                        if($dislikers_count == 0){
                            $dislikers_count = "";
                        }
    
    /****************************************************************************************************************************************************/ 
  
  $delete_post_cross = "";
  
    if(strcmp($_SESSION['user'], $posts[$i]['nickname']) === 0) { // ОТОБРАЖАЕМ ЗНАЧЕК ОТОБРАЖЕНИЯ ПОСТА
                    $delete_post_cross = '<i class="fa fa-close close-cross" id = "delete_post_cross_' . $posts[$i]['post_id'] . '" 
                         title = "Ну пааа пачисти эту хуйню та блин" onclick = delete_post('. $posts[$i]['post_id'] . ',this)></i>';    
                         
                }
        /***************************************************************************************************************************************************/

    $posts_container .= '<div class="w3-content" style="max-width:700px">

<div class="w3-card w3-white w3-round w3-margin"><br>
       
        <div class="w3-row w3-padding">
          <div class="w3-right w3-opacity date">' . parseDate($posts[$i]['date']) . $delete_post_cross . ' </div>
            <a href= "user.php?zs=' . $posts[$i]['nickname'] . '" target=_blank>
                <img src = "users/' . $posts[$i]['avatar'] . '" alt="' . $posts[$i]['nickname'] . '" class="w3-left w3-circle w3-margin-right" 
                style="width:60px;height:60px;position:relative;bottom:20px"></a>
    
            <h4><a href= user.php?zs=' . $posts[$i]['nickname'] . '  target=_blank>' . $posts[$i]['nickname'] . '</a></h4><br>
               
               <hr class="w3-clear" style = "margin-top:-10px;">
              <div class = "post_text" style = "margin-top:-10px;"><p style="word-wrap:break-word;">' . $post_text . '</p></div>
              <div class = "multimedia_under_post w3-clear">' . $iframe_for_multimedia_post . '</div>  
    <div class = "post_buttons_container">
              <button type="button" class="w3-button w3-round w3-light-blue w3-margin-bottom" ' . $tell_to_bros_ahuenno_function  . '>
              <i class="fa fa-thumbs-up"></i>Ахуенно <i class = "likers_count" id = "likers_count_' . $posts[$i]['post_id'] . '">' . $likers_count . '</i></button> 
             <button type="button" class="w3-button w3-round w3-light-blue w3-margin-bottom"' . $tell_to_bros_gavno_function  . '>
             <i class="fa fa-thumbs-down"></i>Гавно! <i class = "dislikers_count" id = "dislikers_count_' . $posts[$i]['post_id'] . '">' . $dislikers_count . ' </i></button>
    </div>
       
        </div>
 
      </div>

  </div>';

 } /* Отображение в цикле постов*/


}

?>

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
    
    .story_link{
        text-decoration:none;
        cursor:pointer;
        
    }

</style>

<script >
    
    function showAddImageModal(){
        document.getElementById('add_image_modal').style.display="block";
    }
    
</script>

<!-- Middle Column -->
    <div class="w3-col m7" id = "middle_side" style = "margin-top:15px;">
        
    <?php  // Узнаем количество картинок в первичном альбоме
    
    $add_image_a = "";
   
        $sql = "SELECT * FROM `user_images_primary_album` WHERE `user`='{$login}' ORDER BY `this_id` DESC";
        $query = $connection_handler->prepare($sql);
        $query->execute();
        $images_in_primary_album = $query->fetchAll(PDO::FETCH_ASSOC);
    
    if(!empty($_SESSION['user']) && $login === $_SESSION['user']){
        
            if(count($images_in_primary_album) > 0){
                $add_image_a = "<span id = add_img_a onclick = showAddImageModal()> | вылаживать</span>";
            }else{
                 $add_image_a = "<span id = add_img_a onclick = showAddImageModal()> Вылаживать картинки</span>";
            }
        
    }
   
  if(count($images_in_primary_album) > 0){ // Картинки в альбоме есть
   echo  '<div class="w3-card w3-round w3-center w3-white" style = "width:99%;margin:0 auto;margin-bottom:10px;">
               <div class="w3-container w3-padding">
        <header style = "border-bottom:1px solid #F5F7F8"><a href = "user_albums.php?zs=' . $login .'" style = "text-decoration:none;">Картинки  ' . 
                count($images_in_primary_album) . ' </a>' . $add_image_a . '</header>';

   for($i = 0; $i < count($images_in_primary_album); $i++){
                if($i == 4){
                    break;
                }           
                
                $avatars_outp .= '<img class = " user_img w3-image  w3-padding-small" onclick= window.location.replace("primary_album.php?zs=' . $login . '&image_id=' . $images_in_primary_album[$i]['this_id']  . '&redirect=user") 
                                src = ' . $images_in_primary_album[$i]['link'] . '  />';
                
            }

 echo $avatars_outp;

 echo  '</div></div>';

}else{
   
   if($login == $_SESSION['user']){
    echo '<div class="w3-card w3-round w3-center w3-white" style = "width:99%;margin:0 auto;margin-bottom:10px;">
               <div class="w3-container w3-padding">
        <header>' . $add_image_a . '</header></div></div>';
   }
}
?> 

    <?php 

$stories_container = "";
$new_story_link = ""; 
$new_story_input = "";
$link_input_container = "";
$total = "";
$total_about_malafilnya = "";

if($_SESSION['user'] == $login){ // Сидим на своей странице

/* ИЗВЛЕКАЕМ СВОИ ИСТОРИИ */
 $sql = "SELECT * FROM `user_stories` WHERE `author`='{$_SESSION['user']}' ORDER BY `this_id` DESC"; 
    $query = $connection_handler->prepare($sql);
    $query->execute();
$user_stories = $query->fetchAll(PDO::FETCH_ASSOC); 

    $new_story_link = '<a class = "story_link" title = "Write something good" onclick = document.getElementById("new_story_modal").style.display="block">новая</a>';
 
$new_story_input = '<div id="new_story_modal" class="w3-modal modal">
    <div class="w3-modal-content w3-animate-bottom w3-card-4">
      <header class="w3-container w3-pale-green"> 
        <span onclick=document.getElementById("new_story_modal").style.display="none" 
        class="w3-button w3-display-topright">&times;</span>
         <h4>Новая история</h4>
      </header>
    
      <div class="w3-container">

            <h4 style = "color:#2398D6">Заголовок</h4>    
            <input type = "text" id = "story_name" maxlength = "1000" class = "w3-input w3-border" required = "required" /><br />
        <h4 style = "color:#2398D6;">История</h4>
        <textarea id = "story_textarea" class = "w3-input w3-border" style = "resize:none;" rows = "4" maxlength = "3100" required = "required"></textarea><br />
        <span id = "story_server_response"></span>
        <button type = "button" class="w3-button w3-block w3-theme" style = "cursor:pointer;" onclick = "send_story()">Ахуенно</button>
        
      </div>
     
      <footer class="w3-container w3-pale-green">
        <p></p>
      </footer>
    </div>
 
  </div>';

$link_input_container = $new_story_link . $new_story_input;

    if(empty($user_stories)){ // Историй нет. Отображаем ссылку на историю
    
        $total = $link_input_container;
        $total_about_malafilnya = $link_input_container;
        
        
         $stories_container = '<div class = "w3-container w3-round w3-card w3-white w3-padding w3-margin">
                                <header class = "w3-center">   
                                        <a style = "cursor:pointer" onclick = document.getElementById("new_story_modal").style.display="block">Написать историю</a>
                                </header>'
                        . $new_story_input .
                        '</div>';
        
    
    
    } else { // Истории есть
        
        $new_story_link = '<a class = "story_link_new" title = "Write something good">новая</a>';
         $total = "<header style = 'border-bottom:1px solid #F5F7F8;'>
                         <a href = 'user_stories.php?zs={$login}' style = 'text-decoration:none;'>Истории </a>
                         <span>" . count($user_stories) . "</span> | " .  $link_input_container . " </header>";
          $total_about_malafilnya = "<span style = 'color:#2398D6;cursor:pointer;' onclick = 'showStoryContainer()'>  истории " . count($user_stories) . "</span>";  
            
        $user_stories_count = count($user_stories);
        $user_stories_count_for = "";
        
        switch($user_stories_count){
            case 1: $user_stories_count_for = 1;
                    break;
            case 2: $user_stories_count_for = 2;
                    break;        
            case 3: $user_stories_count_for = 3;
                    break;
            
           default: $user_stories_count_for = 3;
        }
        
        
                for($i = 0; $i < $user_stories_count_for; $i++){
             
                     $stories_container .= "<div class='w3-container'>
                                                <div class = 'w3-content  w3-padding w3-hover-light-grey'>
                                                    <a class = 'story_link' href = user_story.php?id=" . $user_stories[$i]['this_id'] . ">" . $user_stories[$i]['name'] . "</a>
                                                </div>
                      
                                        </div>";
                     
            } // Выводим истории
    
    $stories_container = '<div class = "w3-container w3-round w3-card w3-white w3-padding w3-margin">' .
                               $total .
                               $stories_container .
    '                    </div>';
    
    
    } // истории есть

} 
else { // Сидим на чужой странице
   
   /* ИЗВЛЕКАЕМ СВОИ ИСТОРИИ */
 $sql = "SELECT * FROM `user_stories` WHERE `author`='{$login}' ORDER BY `this_id` DESC LIMIT 3"; 
    $query = $connection_handler->prepare($sql);
    $query->execute();
$user_stories = $query->fetchAll(PDO::FETCH_ASSOC);  
$user_stories_count = count($user_stories);

 /* ИЗВЛЕКАЕМ СВОИ ИСТОРИИ ДЛЯ ОТОБРАЖЕНИЯ КОЛИЧЕСТВА */
 $sql = "SELECT * FROM `user_stories` WHERE `author`='{$login}' ORDER BY `this_id`"; 
    $query = $connection_handler->prepare($sql);
    $query->execute();
$user_stories_for_count = $query->fetchAll(PDO::FETCH_ASSOC);  
$user_stories_count_for_count = count($user_stories_for_count);

    if(!empty($user_stories)){ // Истории есть
       
    $total = "<header style = 'border-bottom:1px solid #F5F7F8;'>
                         <a href = 'user_stories.php?zs={$login}' style = 'text-decoration:none;'>Истории ". count($user_stories) . "</a>
                </header>";
    $total_about_malafilnya = "<span style = 'color:#2398D6;cursor:pointer;' onclick = 'showStoryContainer()'>истории " . $user_stories_count_for_count . "</span>";  
    $user_stories_count_for = "";
    
    switch($user_stories_count){
        case 1: $user_stories_count_for = 1;
                break;
        case 2: $user_stories_count_for = 2;
                break;        
        case 3: $user_stories_count_for = 3;
                break;
        
       default: $user_stories_count_for = 3;
    }
    
    
    for($i = 0; $i < $user_stories_count_for; $i++){
    
    $sql = "SELECT COUNT(*) AS `likes_count` FROM `user_stories_like_under_story` WHERE `story_id`={$user_stories[$i]['this_id']}";	
    $query = $connection_handler->prepare($sql); 
    $query->execute();
    $likes_count_story = $query->fetchAll(PDO::FETCH_ASSOC);
    $likes_count_story = $likes_count_story[0]['likes_count']; 
    
    $sql = "SELECT COUNT(*) AS `dislikes_count` FROM `user_stories_dislike_under_story` WHERE `story_id`={$user_stories[$i]['this_id']}";	
    $query = $connection_handler->prepare($sql); 
    $query->execute();
    $dislikes_count_story = $query->fetchAll(PDO::FETCH_ASSOC);
    $dislikes_count_story = $dislikes_count_story[0]['dislikes_count']; 
     
     $stories_container .= "<div>
     <div>
         <a class = 'story_link' href = user_story.php?id=" . $user_stories[$i]['this_id'] . ">" . $user_stories[$i]['name'] . "</a>
    </div>
    
    <div class = 'likes_dislikes_story_container'>" .
        "<i class = 'fa fa-thumbs-up' >
        <span id = likes_story_counter_span_" . $id . " color = '#2398D6'>"  . $likes_count_story  . "</span>
        </i>
        <span class = dislikes_story_container   >
                <i id = dislikes_story_counter_span_" . $id . " class = 'fa fa-thumbs-down'>" . $dislikes_count_story . "</i>
        </span>
        </div>
    </div>";
     
            }

    $stories_container = '<div class = "w3-container w3-round w3-card w3-white w3-padding w3-margin">' .
                                $total .
                                $stories_container .
    '                    </div>';
    
    }

}

?>
    <?php echo $stories_container;    ?>    
     <?php echo $post_textarea; ?>
  

  
  <div class="w3-card w3-round w3-white w3-margin" id = "">
 
  <div class="w3-center">

<?php echo $first_page_btn . $back_btn . $page2left . $page1left . $current_page  .  $page1right . $page2right .   $forward_btn . $last_page_btn; ?>


 
</div>
 
  </div>
  
     <?php echo $posts_container; ?>
    
    <!-- End Middle Column -->
    </div>
    
    
 <!-- Right Column -->
    <div class="w3-col m2" id = "right-side">

      <div class="w3-card w3-round w3-white w3-padding-16 w3-center">

               <!-- VK Widget -->
<div id="vk_subscribe"></div>
<script type="text/javascript">
VK.Widgets.Subscribe("vk_subscribe", {}, -140218386);
</script> 
                    <div>
                        <span>Подписывайся <br /> или иди нахуй</span>
                    </div>

      </div>

      <br />
      
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
        
            "<a href = 'user.php?zs=" . $all_users_last_action_time[$i]['nickname'] . "' title = '" . $all_users_last_action_time[$i]['nickname'] . "'>
            <img src = 'users/" . $all_user_avatar . "' class = 'bro_img' title = '" . $all_users_last_action_time[$i]['nickname'] . "'/></a>" .
        
        "</section>";
    }
  
}

    if($counter10 > 0){
       echo ' <div class="w3-card w3-round w3-white w3-center" style = "margin-bottom:10px">
        <div class="w3-container">' .
       $all_users_online_container . '</div>
       </div>';

    }

?>

<div class="w3-card w3-round w3-white w3-center">
            <div class="w3-container">
<h6 style = "border-bottom:1px solid #F5F7F8">Случайные долбоебы</h6>                
        
       <?php 

/* ВСЕ ПОЛЬЗОВАТЕЛИ ЗДЕСЯ */
    $sql = "SELECT * FROM `main_info`"; 
    $query = $connection_handler->prepare($sql);
    $query->execute();
    $all_users = $query->fetchAll(PDO::FETCH_ASSOC); 
    $all_users_count = count($all_users);

    $i = 0;
    
    $ichoose = mt_rand(2,$all_users_count - 1); // выбираем id
    $choosed_ids = array();
    $users_container = "";
 
    while($i < 12){
      
       $sql = "SELECT * FROM `main_info` WHERE `user_id`={$ichoose}"; 
            $query = $connection_handler->prepare($sql);
            $query->execute();
            $tmp_id_q = $query->fetchAll(PDO::FETCH_ASSOC);
            $tmp_id = $tmp_id_q[0]['user_id'];
      
                  if($tmp_id_q != null && !in_array($ichoose,$choosed_ids)){
                     
                     
                     $sql = "SELECT * FROM `additional_info` WHERE `user_id`={$tmp_id}"; 
                        $query = $connection_handler->prepare($sql);
                        $query->execute();
                        $avatar = $query->fetchAll(PDO::FETCH_ASSOC);
                        $avatar = $avatar[0]['avatar'];
                        
                         $users_container .= "<div style = 'display:inline-block'><a href = 'user.php?zs=" . $tmp_id_q[0]['nickname'] . "&ls=" . $page_number . "' title = '" .  $tmp_id_q[0]['nickname'] . "'>
                                                        <img class = 'bro_img' src = 'users/{$avatar}' />
                                                </a>
                                                </div>"; 
                     
                      array_push($choosed_ids, $tmp_id);
                      $i++;
                  }
     
      $ichoose = mt_rand(2,$all_users_count - 1);

    } 


 echo $users_container;

?>
        
    </div>

</div>

<div class="w3-card w3-round w3-white w3-center" style = "margin-top:10px">
    
    <iframe src="https://store.steampowered.com/widget/1861310/" frameborder="0" width="100%" height="190"></iframe>

</div>

<div class="w3-card w3-round w3-white w3-center" style = "margin-top:10px">
            <div class="w3-container">
<h6 style = "border-bottom:1px solid #F5F7F8;word-wrap:break-word">Новости</h6>                
        
       <?php 
  
$news_token = '2df38fddae844317bdf700656e1a31f1';  
       
$news = json_decode(file_get_contents("https://newsapi.org/v2/everything?q=технологии&sortBy=popularity&apiKey=" . $news_token));

$count = count($news->articles);

$id = mt_rand(0, $count - 1);

$title = $news->articles[$id]->title;
$description = $news->articles[$id]->description;
$url = $news->articles[$id]->url;

$url = "<a href={$url} target=_blank style = text-decoration:underline>Подробнее...</a>";

$response = $description . '<br />' . $url;
       
  echo $response;
       
       ?>
        
    </div>

</div>



    <!-- End Right Column -->
    </div>

<!-- The Grid -->
</div>

<!-- End Page Container -->
</div>

</body>
</html>

<?php ob_end_flush(); ?>
