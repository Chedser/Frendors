<?php
ob_start();
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

//error_reporting(0);

ini_set('display_errors', 'Off');

function session_isset(){ // Пользователь вошел
if(!empty($_SESSION['user'])){ // Пользователь вошел через логин-пароль
return true;
} else {
return false;
}
}

if(empty($_SESSION['user'])){
header('Location: index.php'); // Редиректим на index.php
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

?>

<!DOCTYPE html>
<html>
<head>
<title>Сидим тута</title>
<meta charset = "utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/media.css">
		<link rel="stylesheet" type="text/css" href="css/shit.css">
	<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;700&display=swap" rel="stylesheet" />

<style>
    
    .mini_avatar {
	display: inline-block;
	width: 25px;
	height: 25px;
	border-radius: 100%;
	background: #A5A5A5;
}

.nahui_a{
    
    display:block;
    margin-top:10px;
     margin-left:10px;

}

.new_msg{
    
    background-color:LightGray;
    
}

.you_span{
    
    position:relative;
    bottom:10px;
    color:gray;
    
}
    
     </style>

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

<?php 

$sql = "SELECT * FROM `additional_info` WHERE `nickname`='{$_SESSION['user']}'";	
$query = $connection_handler->prepare($sql); 
//$query->bindParam(':joined', $_SESSION['user'], PDO::PARAM_STR); // Пользователь к к которому зашли. Принимают заявку
$query->execute();
$user_avatar = $query->fetchAll(PDO::FETCH_ASSOC);
$user_avatar = $user_avatar[0]['avatar'];


/* ИЗВЛЕКАЕМ НОВЫЕ АТИВНЫЕ ДИАЛОГИ */
$sql = "SELECT * FROM `dialogs` WHERE (`joined`='{$_SESSION['user']}'  AND `is_finished` = 0) OR (`initiator`='{$_SESSION['user']}'  AND `is_finished_for_initiator` = 0)  ORDER BY date DESC";	
$query = $connection_handler->prepare($sql); 
//$query->bindParam(':joined', $_SESSION['user'], PDO::PARAM_STR); // Пользователь к к которому зашли. Принимают заявку
$query->execute();
$new_msgs = $query->fetchAll(PDO::FETCH_ASSOC);
  
$new_msgs_container = "";

for($i = 0; $i < count($new_msgs); $i++ ){
    
      $whose_avatar = "";
    
    if($new_msgs[$i]['joined'] === $_SESSION['user']){
        
         $whose_avatar = $new_msgs[$i]['initiator'];
        
    }else if($new_msgs[$i]['initiator'] === $_SESSION['user']){
        
        $whose_avatar = $new_msgs[$i]['joined'];
        
    }

$sql = "SELECT * FROM `additional_info` WHERE `nickname`='{$whose_avatar}'";	
$query = $connection_handler->prepare($sql); 
$query->bindParam(':joined', $_SESSION['user'], PDO::PARAM_STR); // Пользователь к к которому зашли. Принимают заявку
$query->execute();
$avatar = $query->fetchAll(PDO::FETCH_ASSOC);

$avatar = $avatar[0]['avatar'];    
$last_message =   $new_msgs[$i]['last_message'];  
$date =  parseDate($new_msgs[$i]['date']);
$id = $new_msgs[$i]['this_id'];

$left_avatar = "";

if($new_msgs[$i]['whose_last_message'] === $_SESSION['user']){
    
    $left_avatar = "<img src=users/{$user_avatar} class = mini_avatar> <span class = you_span>ты</span>";
    
}
  
     
      $new_msgs_container .= "<div class='incoming__message__user new_msg'
      onclick = window.location.replace('dialog.php?id=" . $id . "')>
							<div class=incoming__message__avatar>
								<img src=users/{$avatar}>
							</div>
							<div class=incoming__message__data>
								<a href=''>{$whose_avatar}</a>
								<p class=message__date style = word-wrap: break-word>{$date}</p>
							</div>
							<div class=incoming__message__text>
								{$left_avatar}
								<p>{$last_message}</p>
							</div>
						</div>";
    
}

/*********************************************************************************************/

/* ИЗВЛЕКАЕМ НОВЫЕ ЗАВЕРШЕННЫЕ ДИАЛОГИ */
$sql = "SELECT * FROM `dialogs` WHERE (`joined`='{$_SESSION['user']}'  AND `is_finished` = 1) OR (`initiator`='{$_SESSION['user']}'  AND `is_finished_for_initiator` = 1)  ORDER BY date DESC";	
$query = $connection_handler->prepare($sql); 
//$query->bindParam(':joined', $_SESSION['user'], PDO::PARAM_STR); // Пользователь к к которому зашли. Принимают заявку
$query->execute();
$finished_msgs = $query->fetchAll(PDO::FETCH_ASSOC);
  
$finished_msgs_container = "";

for($i = 0; $i < count($finished_msgs); $i++ ){
    
      $whose_avatar = "";
    
    if($finished_msgs[$i]['joined'] === $_SESSION['user']){
        
         $whose_avatar = $finished_msgs[$i]['initiator'];
        
    }else if($finished_msgs[$i]['initiator'] === $_SESSION['user']){
        
        $whose_avatar = $finished_msgs[$i]['joined'];
        
    }

$sql = "SELECT * FROM `additional_info` WHERE `nickname`='{$whose_avatar}'";	
$query = $connection_handler->prepare($sql); 
//$query->bindParam(':joined', $_SESSION['user'], PDO::PARAM_STR); // Пользователь к к которому зашли. Принимают заявку
$query->execute();
$avatar = $query->fetchAll(PDO::FETCH_ASSOC);

$avatar = $avatar[0]['avatar'];    
$last_message =   $finished_msgs[$i]['last_message'];  
$date =  parseDate($finished_msgs[$i]['date']);
$id = $finished_msgs[$i]['this_id'];

$left_avatar = "";

if($finished_msgs[$i]['whose_last_message'] === $_SESSION['user']){
    
    $left_avatar = "<img src=users/{$user_avatar} class = mini_avatar> <span class = you_span>ты</span>";
    
}
  
     
     $finished_msgs_container .= "<div class=incoming__message__user 
      onclick = window.location.replace('dialog.php?id=" . $id . "')>
							<div class=incoming__message__avatar>
								<img src=users/{$avatar}>
							</div>
							<div class=incoming__message__data>
								<a href=''>{$whose_avatar}</a>
								<p class=message__date>{$date}</p>
							</div>
							<div class=incoming__message__text>
								{$left_avatar}
								<p style = word-wrap: break-word>{$last_message}</p>
							</div>
						</div>";
    
}

$new_msgs_count = count($new_msgs);
$finished_msgs_count = count($finished_msgs);
$total_msgs_count = $new_msgs_count + $finished_msgs_count;

$header_msgs = "";

if($new_msgs_count > 0){
  
  $header_msgs = "<p>Не попиздели $new_msgs_count | Попиздели $finished_msgs_count | Всего $total_msgs_count</p>";  
    
}else{
    
     $header_msgs = "<p>$total_msgs_count</p>";
    
}

?>

	<div class="user__messages">
		<div class="container">
			<div class="user__messages__wrapper">
			
			<a href = user.php?zs=<?php echo $_SESSION['user']; ?> class = nahui_a>Нахуй</a>
			
				<div class="user__messages__title">
					<h2>Ваши сообщения</h2>
				<?php echo $header_msgs; ?>	
				</div>
				<div class="user__messages__unreaded">
					<div class="incoming__message">
					
					<?php echo $new_msgs_container; ?>
					<?php echo $finished_msgs_container; ?>

					</div>
				</div>
			</div>
		</div>
	</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="js/script.js"></script>

</body>    

</html>    

<?php ob_end_flush(); ?>
