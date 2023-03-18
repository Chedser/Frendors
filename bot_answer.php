<?php ob_start(); ?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection_bot.php';

?>
<!DOCTYPE html>
<html>
<title>Ответ бота</title>
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

<style>
#user_wall_message{

    width:500px;
    resize:none;
    height:300px;
    overflow:hidden;

}
</style>
<!-- !PAGE CONTENT! -->
<div class="w3-main w3-content" style="max-width:600px;margin-top:20px">
<h1 style = "text-align:center;"><?php echo $peer_id; ?></h1>

 <div id = "post_textarea_container">
            <textarea id = "user_wall_message" placeholder = "пиши" class="w3-border w3-padding" 
                            onkeypress = "send_post_enter_key(event)" maxlength = "1000" oninput = ""></textarea>
                    <button type="button" class="w3-button w3-block w3-round w3-light-blue" onclick = sendPost() style = "background: #87CEEB url(/img/maslaev__icon.png) no-repeat center right 28%;"></i>Ахуенно</button> 
</div>    

<div class="w3-display-container">


<div class="w3-dropdown-click w3-display-middle" style = "margin-top:50px">

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
formData.append('message', post_textarea.value.trim());
formData.append('peer_id', <?php echo $peer_id; ?>);

xmlhttp.open("POST", "handlers/bot_answer.php", true);
xmlhttp.send(formData);    

post_textarea.value = "";    

}

function send_post_enter_key(event){
var char = event.key;  

if((event.ctrlKey) && ((event.keyCode == 0xA)||(event.keyCode == 0xD))) {
sendPost();    
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
