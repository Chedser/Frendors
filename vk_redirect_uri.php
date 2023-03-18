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
<title>Слоновое радио</title>
<meta charset = "utf-8" />
<link rel = "stylesheet" href = "css/normalize.css"  type = "text/css" />
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel = "stylesheet" src = "css/roboto/roboto.css">
<script src="bootstrap/js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

<script type="text/javascript" src="//vk.com/js/api/openapi.js?136"></script>
<script type="text/javascript" src="//vk.com/js/api/openapi.js?137"></script>
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

.audio_img {
  width:30px;
  height:30px;
  cursor:pointer;
}

.audio_img:hover{
    transform:scale(1.1);
}

</style>

</head>    

<body onload = "play_radio();">

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

echo 
        '<a href = user.php?zs=' . $_SESSION['user'] . ' >' . $_SESSION['user'] . '</a>';

}

?>

<main class = "container-fluid">
    
<div class = "row" style = "padding:10px">    
<!-- Modal -->
<div id="upload_audio_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style = "width:610px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" title = "Загрузить">Новое аудио</h4>
      </div>
      <div class="modal-body">
        
        <div>
    <h4 style = "text-align:center">Загружаем аудио</h4>
    <p style = "display:block; margin-left: 5px">Только mp3 </p>
    <p>Не закрывайте окно пока не появится кнопка "Ахуенно"</p>
    <p style = "display:block; margin-left: 5px"><= 16мБ </p>
    <form id = "upload_audio_form" >
    <input id = "MAX_FILE_SIZE" type="hidden" value="16000000" />
    Исполнитель<br />
    <input value = "" type = "text" maxlength = "80" autofocus="autofocus" id = "audio_author" size = "60" /><br /><br /> 
     Название<br />
    <input value = "" type = "text" maxlength = "80" id = "audio_name" size = "60" /><br /><br />
    Описание<br />
    <textarea maxlength = "1000" id = "audio_description" style = "resize:none" cols = "60" rows = "5"></textarea><br />
    <progress id="progressbar" value="0" max="100"></progress><span id = "progress_percents"></span>
    <input type = "file" style = "margin-bottom: 5px" id = "audio_file" accept = "audio/mp3" onchange = "check_file();" /><br />
   
    <p id = "audiofile_info"></p>
    <p id = "result_audio_uploading"></p>
    <button type = "button" id = "upload_button" onclick = "upload_audio();">Загрузить</button>
    </form>    
    <p style = "display:block; margin-left: 5px" id = "errors_audio_uploading"> </p>
     <p id = "success_audio_uploading"></p>
    <button id = "success_audio_uploading_button" style = "display:none;" type = "button" class="btn btn-primary btn-sm" data-dismiss="modal">Ахуенно</button>
</div>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      </div>
    </div>

  </div>
</div>    

<?php 

 // ищем количество аудио в базе 
    $sql = "SELECT COUNT(*) AS `audio_count` FROM  `audios`"; 
    $query = $connection_handler->prepare($sql);
    $query->execute(); 
    $audios = $query->fetchAll(PDO::FETCH_ASSOC);
    $audios_count = $audios[0]['audio_count'];
?>

<p>В базе <?php echo $audios_count; ?> аудио </p>
<div id = "radio" style = "margin-bottom:10px;"><img class = "audio_img"  src = "imgs/audio_buttons/pause.png" onclick = "pause(this)"/><img class = "audio_img"  src = "imgs/audio_buttons/next.png" onclick = "next()"/> <img class = "audio_img"  src = "imgs/audio_buttons/volume.png" onclick = "mute(this);"/>
<meter id = "volume_meter" value="9" min="0" max="9"></meter>
<input type="range" id="volume_ranger" min = "0" max = "100" value="100" style = "width:170px;cursor:pointer" onchange = "change_volume_ranger(this)">
Играет: <span id = "audio_author_span">?</span> - <span id = "audio_name_span">?</span> | <a id = "download_link" href = "#" download>скачать</a>
</div>


<?php 


 $response = file_get_contents('https://api.vk.com/method/users.search?count=1000&sort=0&fields=first_name,last_name,deactivated,photo_max_orig&country=1&city=95&sex=1&age_from=18&age_to=35&has_photo=1&v=5.62');


 $access_token = htmlspecialchars($_GET['code']);

$access_data = file_get_contents('https://oauth.vk.com/access_token?client_id=5558797&client_secret=QUT8b6NLZ7HAi1nawZrA&redirect_uri=https://frendors.com&code=7a6fa4dff77a228eeda56603b8f53806c883f011c40b72630bb50df056f6479e52a');

/* // ищем количество аудио в базе 
    $sql = "SELECT * FROM  `vk_users` ORDER BY `this_id` DESC"; 
    $query = $connection_handler->prepare($sql);
    $query->execute(); 
    $vk_users = $query->fetchAll(PDO::FETCH_ASSOC);
    $last_user_id =  $vk_users[0]['user_id'];
    
    ++$last_user_id;
    
    echo $last_user_id;

for($j = $last_user_id; $j < 400000000; $j++){

   $response = file_get_contents('https://api.vk.com/method/users.get?user_ids=' . $j . '&fields=id,first_name,last_name,deactivated,sex,city,photo_50,photo_100,photo_200_orig,photo_200,photo_400_orig&v=5.62');
    
    $obj = json_decode($response,true);
    $deactivated = $obj['response'][0]['deactivated'];

    $first_name = $obj['response'][0]['first_name'];
    $second_name = $obj['response'][0]['last_name'];
    $sex = $obj['response'][0]['sex'];
    $city = $obj['response'][0]['city']['title'];
    
    $photo_50 = $obj['response'][0]['photo_50']; 
    $photo_100 = $obj['response'][0]['photo_100']; 
    $photo_200_orig = $obj['response'][0]['photo_200_orig']; 
    $photo_200 = $obj['response'][0]['photo_200']; 
    $photo_400_orig = $obj['response'][0]['photo_400_orig']; 
    
    $avatars_arr_tmp = array($photo_200_orig,$photo_50,$photo_100,$photo_200,$photo_400_orig);
    $avatars_arr = array();
    
    for($i = 0; $i < count($avatars_arr_tmp); $i++){ // Добавляем непустые авы
        
            if((mb_strpos($avatars_arr_tmp[$i],'camera') === false)){ // Аву выложил пользователь
             array_push($avatars_arr, $avatars_arr_tmp[$i]);   
        }
      
    }
    
    $avatar = "";
    
    if(!empty($avatars_arr)){ // авы есть
       
           if(count($avatars_arr) == 1){ // Только одна гифка
               $avatar = $avatars_arr[0]; 
           }else{ // Гифок больше одной. Выбираем гифку с максимальной шириной
               
               $max_width = getimagesize($avatars_arr[0])[0];
               $max_avatar_index = 0;
               
                              for($k = 0; $k < count($avatars_arr); $k++){
                              
                              $width = getimagesize($avatars_arr[$k])[0];
                           if($width > $max_width){
                               $max_width = $width;
                               $max_avatar_index = $k;
                           }
                    }
                
                $avatar = $avatars_arr[$max_avatar_index];
           
        }
     
    }

    if(empty($deactivated) && !empty($avatar)){ // Страница пользователя активна, и есть ава
            $sql = "INSERT INTO `vk_users`(`user_id`,`first_name`,`second_name`,`sex`,`city`,`avatar`) VALUES ({$j},'{$first_name}','{$second_name}','{$sex}','{$city}','{$avatar}')";	
            $query = $connection_handler->prepare($sql); 
            $query->execute();
}
    
} */


?>

</div><!-- class=row -->

</main>    

</body>    

</html>    

<?php ob_end_flush(); ?>