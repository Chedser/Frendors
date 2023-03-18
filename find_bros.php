<?php
ob_start();
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/user_info.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
error_reporting(0);
$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();

 if(empty($_SESSION['user'])){
header('Location: index.php');
exit();   
} 

function session_isset(){ // Пользователь вошел
if(!empty($_SESSION['user'])){ // Пользователь вошел через логин-пароль
return true;
} else {
return false;
    }
}

?>

<!DOCTYPE html>

<html>
<head>
    <title>Друга надо</title>
    <meta charset = "utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name = "description" content = "Братки" />
    <meta name="keywords" content = "александр неминуев,зеленый слоник, бердянск,больничка, сергей пахомов, владимир епифанцев,александр маслаев,александр осмоловский,сладкий хлеб,азов,украина,путин,политика" / >
    <meta name = "author" content = "Александр Неминуев">
    
<link rel = "stylesheet" href = "css/normalize.css"  type = "text/css" />
<script src="bootstrap/js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

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
    width: 100%;
    background-color:#cefdce;
    margin:0 auto;
    height:100%;
 }

main {
    padding: 10px;
    border-left: 2px double blue;
    border-right: 2px double blue;
    padding-bottom: 90px;
}

a {
 color:blue;    
}    

#online_checkbox:hover{
transform:scale(1.05);    
}
 
header { /* Шапка */
margin-bottom: 5px;
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

#private_message_box {
    margin-top:10px;
}

</style>    
   
<style>   

/* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {display:none;}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

</style>
    
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

if(session_isset()){ echo 
'<a href = user.php?zs=' . $_SESSION['user'] . '>' . $_SESSION['user'] . '</a>'; 
}
?>

<style>

input[type = "text"]{
   
   padding:5px;
   border-radius:5px;
    
}

input[type="text"]:focus{
   background-color: #98DDDE;
   box-shadow:5px 5px 5px #7FFFD4;
}

input[type="radio"]:checked{

background-color: #98DDDE;
box-shadow:0px 0px 5px #7FFFD4;
     
 }

#live_search_container {
     margin-right:10px;
 }

#sorting {
 margin-left:190px;
 margin-top:-37px;
}

#live_search_div {
    display:none;
    padding:5px;
    width:183px;
    min-height:30px;
    background-color:white;
    margin-left:1px;
    border-bottom-left-radius:5px;
    border-bottom-right-radius:5px;
}


</style>

<main class = "container-fluid">

<div class = "row">

<div>

<!-- Rounded switch -->

<input type = "hidden" id = "is_online_hidden" value="false" />

<label  class="switch" >
  <input type="checkbox"  onclick="toggle_online();" />
  <div class="slider round"></div>
</label>

<span style="color:blue; position:relative;top:-15px;">Здеся</span><br />

<div id = "live_search_container">

<input type = "text" id = "live_search_input" placeholder = "друга надо" onkeyup = "live_search(this)" />
<div id = "live_search_div"></div>

</div>

<div id = "sorting">
<input type = "radio" name = "sorting"  value = "hleb" checked = "checked" onclick = "set_sorting_value(this)" /> Хлеб <br />
<input type = "radio" name = "sorting" value = "rating" onclick = "set_sorting_value(this)" /> Погоны
<input type = "hidden" id = "hidden_for_sorting" value = "hleb" />
</div><br />

<!-- <button  type = "button" class = "btn btn-primary" onclick = "find_bro();">Найти братка</button> -->
<p>Если вы считаете, что поиск ебет мозги перезагрузите страницу и попробуйте еще раз</p>    
</div>

<!-- Отправка личного сообщения пользователю-->
<div class="modal fade" id="private_message_box" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Отправка личного сообщения</h4>
        </div>

<div class="modal-body">
<section id = "private_message_box_wrapper">
    <input type = "hidden" id = "receiver_hidden_field" value = "">
<span>Да всё что хошь</span>
<textarea class="form-control" id = "private_message_textarea" style = " resize:none;" 
placeholder = "Да всякое вобщем" cols = "50" rows = "10"   maxlength = "3000" oninput = "this.placeholder = '';" onblur = "this.placeholder='Да всякое вобщем'" autofocus = "autofocus" ></textarea><br />
<button type = "button" onclick = send_private_message() class="btn btn-primary">Ахуенно</button>
<span id = "private_message_errors"></span>
<span style = "position:relative;left:200px;">Максимум 3000 символов</span>
</section>
</div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Нахуй</button>
        </div>
      </div>
      
    </div>
  </div>

<hr />

<?php 

if(session_isset()){

$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();    
    
}

$sql = "SELECT COUNT(user_id) AS num_rows FROM main_info"; // Извлекаем всех братков
    $query = $connection_handler->prepare($sql);
    $query->execute();
$num_rows = $query->fetchAll(PDO::FETCH_ASSOC); // Получаем двумерный массив строк

$users_count  = $num_rows[0]['num_rows']; // Количество братков

?>

<span>Всего: <span style = "text-decoration:underline;" id = "users_count"><?php echo $users_count; ?></span></span>

<div id = "results">
<?php 

$sql = "SELECT main_info.nickname, main_info.last_action_time AS last_action_time,  additional_info.avatar FROM main_info INNER JOIN additional_info ON main_info.user_id=additional_info.user_id ORDER BY `hleb` DESC";
    $query = $connection_handler->prepare($sql);
    $query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);
    
$sql = "SELECT COUNT(user_id) AS num_rows FROM main_info"; // Извлекаем всех братков
    $query = $connection_handler->prepare($sql);
    $query->execute();
$num_rows = $query->fetchAll(PDO::FETCH_ASSOC); // Получаем двумерный массив строк

if($users_count > 0){
    
for($i = 0; $i < $users_count; $i++ ){ // Отображаем пользователей
    if(!empty($result[$i]['avatar']) && !empty($result[$i]['nickname'])){    

$wait_for_add_friend = "<table id = wait_for_add_friend_{$i}>
    <tr>
    <td colspan = '2' style = 'background-color:yellow;padding:5px;border-radius:5px;text-align:center;'>Ждем подтверждения</td>
    </tr>
    </table>"; // Кнопка ждем подтверждения

$sql = "SELECT user_id from main_info WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $result[$i]['nickname'], PDO::PARAM_STR);
$query->execute();
$user_id = $query->fetchAll(PDO::FETCH_ASSOC);
$user_id = $user_id[0]['user_id'];  

$vbratki =  "<button type = 'button' class='btn btn-default btn-sm' onclick = friend_request(this,'" . $user_id . "','{$i}')>Вбратки</button>";
$doebat = "<button type = 'button' class='btn btn-success btn-sm' data-toggle='modal' data-target='#private_message_box' style = 'margin-left:5px;' onclick = show_private_message_box('" . $user_id . "') >Доебать</button>";
$button = ""; // Кнопка уничтожить/вбратки
$online = "<span style = 'color:gray;position:relative;top:-10px;'>Здеся</span>";

if(($current_time - $result[$i]['last_action_time']) > 180){
$online = "";     
 }

/* ПРОВЕРЯЕМ ЕСТЬ ЛИ ЗАПРОСЫ В ДРУЗЬЯ */
$sql = "SELECT * FROM `friend_requests` WHERE (`requester1`='" . $_SESSION['user'] . "' AND `requester2`='" . $result[$i]['nickname'] . "') OR (`requester1`='" . $result[$i]['nickname'] . "' AND `requester2`='" . $_SESSION['user'] . "')";
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$requests = $query->fetchAll(PDO::FETCH_ASSOC);    

/* ПРОВЕРЯЕМ ЯВЛЯЕМСЯ ЛИ ДРУЗЬЯМИ */
$sql = "SELECT * FROM `friends` WHERE (`friend1`='" . $_SESSION['user'] . "' AND `friend2`='" . $result[$i]['nickname'] . "') OR (`friend1`='" . $result[$i]['nickname'] . "' AND `friend2`='"  . $_SESSION['user'] . "')";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$friend = $query->fetchAll(PDO::FETCH_ASSOC);

/* Проверяем является ли данный пользователь сессионным пользователем */
if($result[$i]['nickname'] === $_SESSION['user']){ // Отображаем только аву и ник
$wait_for_add_friend = null;
$doebat = null;
}

/**********************************************************************************************************************/

if(!empty($requests) && empty($requests)) { // Проверяем отправляли ли ему заявку в друзья или он отправлялю Отправляем  кнопу ДОЕБАТЬ И кнопку ОТМЕНИТЬ
  $button = "";
} else { // Отображаем кнопки вбратки/уничтожить и ДОЕБАТЬ
$wait_for_add_friend = null;    
    // ПРОВЕРЯЕМ ЯВЛЯЕМСЯ ЛИ ДРУЗЬЯМИ    
    if(!empty($friend)){ // Являемся друзьями. Отображаем кнопу УНИЧТОЖИТЬ
      $button = $delete_friend;  
    }else {
        $button = $vbratki;
    }

}

/**********************************************************************************************************************/

$button_doebat = '<div id = "button_doebat_wrapper" style = "margin-top:5px;">' . $button . $doebat . '</div>';

echo "<section style = 'border-bottom:1px solid white; width:250px; '>
    <table style = 'border-collapse:separate; border-spacing:5px 5px'>
    <tr>
    <td style = 'width:20px'><img src = '../users/" . $result[$i]['avatar'] . "' width = '50' height = '50' style = 'border:1px solid black; border-radius:10px;' /></td>
   <td><a style='position:relative;top:-18px;position:relatiove;top:-10px;' href = '../user.php?zs=" . $result[$i]['nickname'] . "'/>" . $result[$i]['nickname'] ."</a><br />" . 
 $online . "</td>
    </tr>
    </table>". 
$wait_for_add_friend  .
"<div id = add_del_friend_result_{$i}  style = 'background-color:yellow;padding:5px;border-radius:5px;text-align:center; display:none;'></div>" .
"<table>
    <div id = buttons_{$i} style = 'padding-bottom:5px'>" .    
$button_doebat .
 "</div>
    </table>
</section>";
            
        }
    }
} 
?>
</div>

</div><!-- class row -->

</main>    

</body> 

<script>


/***********************************************************************************************/

var is_online_hidden = document.getElementById("is_online_hidden");
var hidden_for_sorting = document.getElementById("hidden_for_sorting");
var online_flag = false;
var users_count_span = document.getElementById("users_count"); 
var results = document.getElementById("results");


function set_sorting_value(input_radio){
    hidden_for_sorting.value = input_radio.value;
}

/***************************************************************/    

function parse_response(response){
        var parsed = JSON.parse(response);
        var sessioner = "<?php echo $_SESSION['user']; ?>";
        var users_container = "";
        
        users_count_span.innerHTML = parsed.users[parsed.users.length - 1].users_count;
  
  if(parsed.users[parsed.users.length - 1].users_count === "0"){
      results.innerHTML = "";
      return;
  }
  
  
    for(var i = 0; i < parsed.users.length - 1; i++){
         
             var nick = parsed.users[i].nick;
             var avatar =  parsed.users[i].avatar;
             
             var online =  parsed.users[i].online;
             var wait_for_add_friend = parsed.users[i].wait_for_add_friend;
             var button = parsed.users[i].button; // vbratki, cancel_request, delete_friend, sessioner
             var doebat = parsed.users[i].doebat; 
             var id = parsed.users[i].id; 
             
             var button_doebat = "";
          
                if(online === "true"){
                    online = "<span style = 'color:gray;position:relative;top:-10px;'>Здеся</span>";
                } else {
                    online = "";
                }
                
                if(wait_for_add_friend === "true"){
                    wait_for_add_friend = "<table id = wait_for_add_friend_" + i + ">" +
                                            "<tr>" +
                                            "<td colspan = '2' style = 'background-color:yellow;padding:5px;border-radius:5px;text-align:center;'>Ждем подтверждения</td>" +
                                            "</tr>" +
                                            "</table>";
                    } else {
                                wait_for_add_friend = "";
                    }
       
               if(doebat === "true"){
                   doebat = "<button type = 'button' class='btn btn-success btn-sm' data-toggle='modal' data-target='#private_message_box' style = 'margin-left:5px;' onclick = show_private_message_box('" + id + "') >Доебать</button>";
               } else {
                    doebat = "";
            }
       
            switch(button){
                case "vbratki": button = "<button type = 'button' class='btn btn-default btn-sm' onclick = friend_request(this,'" + id + "','" + i +  "')>Вбратки</button>";
                                break;
                
                case "delete_friend": button = ""; break;                
                            
                case "sessioner": button = "";
                                  doebat = "";
                                  wait_for_add_friend = "";
                                  break;
            }   
               
    
    button_doebat = "<div id = 'button_doebat_wrapper' style = 'margin-top:5px;'>" + button + doebat + "</div>";    
     
    users_container += "<section style = 'border-bottom:1px solid white; width:250px; '>" +
                      "<table style = 'border-collapse:separate; border-spacing:5px 5px'>" +
                      "<tr>" +
                      "<td style = 'width:20px'><img src = 'users/" + avatar + "' width = '50' height = '50' style = 'border:1px solid black; border-radius:10px;' /></td>" +
                      "<td><a style='position:relative;top:-18px;position:relatiove;top:-10px;' href = 'user.php?zs=" + nick.replace(/\s/g,'%20') + "'/>" + nick.replace(/\s/g,'_') + "</a><br />" + 
                       online + "</td>" +
                      "</tr>" +
                      "</table>" + 
                      wait_for_add_friend  +
                      "<div id = add_del_friend_result_" + i + "  style = 'background-color:yellow;padding:5px;border-radius:5px;text-align:center; display:none;'></div>" +
                      "<table>" +
                      "<tr><div id = buttons_" + i + " style = 'padding-bottom:5px'>" +    
                      button_doebat +
                      "</tr></div>" +
                      "</table>" +
                      "</section>";    
        
    } // for(var i = 1; i < parsed.users.length; i++)
    
  results.innerHTML = users_container;      
}

/***********************************************************************/


function live_search(input_text){
  
  var live_search_div = document.getElementById("live_search_div");
  var xmlhttp = new XMLHttpRequest();
/*  live_search_div.style.display = "block"; */
  
  this.placeholder = "";
  
  if(input_text.value === ""){
        toggle_online(); /* Если чо удалить потом */
        this.placeholder = "друга надо";
        return;
  }

  var formData = new FormData();
  formData.append('users_to_search', input_text.value);
  formData.append('sorting', hidden_for_sorting.value);
    
xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            parse_response(xmlhttp.response); // Отображаем пользователей в диве результатов 
            }
};

xmlhttp.open("POST", "scripts/find_bros_live_search.php", true);
xmlhttp.send(formData);
    
}

/**********************************************************************/


/* function find_bro(){

var xmlhttp = new XMLHttpRequest();

var formData = new FormData();

xmlhttp.open("POST", "handlers/find_bros_handler.php", true);


 xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            
            parse_response(xmlhttp.response); 
              
            }
};

if(is_online_hidden.value === "true"){
    formData.append('online', 'true');
}else {
    formData.append('online', 'false');
}

xmlhttp.send(formData);
    
} */

function toggle_online() {

       var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
              parse_response(xmlhttp.response); 
            }
        };
        
var formData = new FormData();
formData.append('sorting', hidden_for_sorting.value);

xmlhttp.open("POST", "handlers/find_bros_handler.php", true);

if(online_flag == false){
    is_online_hidden.value = "true"; 
    online_flag = true;
    formData.append('online', 'true');
}else {
    is_online_hidden.value = "false";
    online_flag = false;
    formData.append('online', 'false');
}

xmlhttp.send(formData);
}

/***********************************************************************************************/

function set_delete_friend_under_ava(deleted_friend,id){
    var hidden_for_delete_friend_under_ava = document.getElementById("hidden_for_delete_friend_under_ava");
    var hidden_for_delete_message_under_ava = document.getElementById("hidden_for_delete_message_under_ava");
    hidden_for_delete_message_under_ava.value = id;
    hidden_for_delete_friend_under_ava.value = deleted_friend;
}

function set_delete_reason(radio_button){
    var hidden_for_delete_friend = document.getElementById("hidden_for_delete_friend");
hidden_for_delete_friend.value = radio_button.value;
}

function delete_friend(button){ // УДАЛЯЕМ  ПОЛЬЗОВАТЕЛЯ

var xmlhttp = new XMLHttpRequest();
var hidden_for_delete_message_under_ava = document.getElementById("hidden_for_delete_message_under_ava"); // Айди

var delete_friend_modal = document.getElementById("delete_friend_modal"); // Модальное окно

var add_del_friend_result = document.getElementById("add_del_friend_result_" + hidden_for_delete_message_under_ava.value); // Сообщение об удалении из друзей

var delete_friend_reason_radios = document.getElementsByClassName("delete_friend_reason_radios"); // Радиокнопки
var delete_friend_button_under_ava = document.getElementById("delete_friend_button_under_ava"); // Модальное окно
var delete_friend_reason_radios_section = document.getElementById("delete_friend_reason_radios_section");
var delete_friend_close_button = document.getElementById("delete_friend_close_button");
var delete_friend_button_under_ava = document.getElementById("delete_friend_button_under_ava_"+ hidden_for_delete_message_under_ava.value);
var hidden_for_delete_friend_under_ava = document.getElementById("hidden_for_delete_friend_under_ava"); // Для кнопки под авой
var hidden_for_delete_friend = document.getElementById("hidden_for_delete_friend"); // Для кнопки под авой

var buttons = document.getElementById("buttons_" + hidden_for_delete_message_under_ava.value);

reason = hidden_for_delete_friend.value;

 xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
add_del_friend_result.style.display = "block"; // Показываем сообщение 
add_del_friend_result.innerHTML = "Гавно!";
button.style.display = "none"; // Удаляем кнопку на модальном окне
delete_friend_button_under_ava.style.display = "none"; // Удаляем кнопку под авой
delete_friend_reason_radios_section.innerHTML = "<span style = font-size:18px>" + xmlhttp.response + "</span>"; 
button.style.display = "none";
buttons.style.display = "none";  
    } 
}

var formData = new FormData();
formData.append('friend2', hidden_for_delete_friend_under_ava.value);
formData.append('reason',  reason);

xmlhttp.open("POST", "scripts/delete_friend.php", true);
xmlhttp.send(formData);

}

function friend_request(button,user_id, id){ // ДОБАВЛЯЕМ ПОЛЬЗОВАТЕЛЯ
var xmlhttp = new XMLHttpRequest();
var add_del_friend_result = document.getElementById("add_del_friend_result_" + id);
var buttons = document.getElementById("buttons_" + id);

 xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
button.style.display = "none";
add_del_friend_result.style.display = "block";
add_del_friend_result.innerHTML = "Ждем подтверждения";
    } 
}


var formData = new FormData();
formData.append('user_id', user_id);

xmlhttp.open("POST", "scripts/friend_request_from_session_user.php", true);
xmlhttp.send(formData);

}

var receiver_hidden_field = document.getElementById("receiver_hidden_field");
var transparent_field = document.getElementById("transparent-field");

function show_private_message_box(user_id){ // Открываем окно для ввода сообщения
receiver_hidden_field.value = user_id;
}

function send_private_message(){// Отправляем сообщение пользователю
var private_message_box = document.getElementById("private_message_box");
var private_message_textarea = document.getElementById("private_message_textarea");
var private_message_errors = document.getElementById("private_message_errors");

if(private_message_textarea.value.length == 0){
return;   
}

var xmlhttp = new XMLHttpRequest();

var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
private_message_textarea.value = "";	
private_message_errors.innerHTML = xmlhttp.response;
setTimeout(window.location.reload(),3000);
} 
}

var formData = new FormData();
formData.append('user_id', receiver_hidden_field.value);
formData.append('message',private_message_textarea.value);

xmlhttp.open("POST", "scripts/send_private_message.php", true);
xmlhttp.send(formData);

receiver_hidden_field.value = ""; 
}

function  close_private_message_box(){ // Закрываем окно отправки сообщения
var private_message_box = document.getElementById("private_message_box");	
private_message_box.style.display = "none";
transparent_field.style.display = "none";
return false;	
}

</script>

</html>
<?php ob_end_flush(); ?>