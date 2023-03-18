<?php 
ob_start();
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
error_reporting(E_ALL);

if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: index.php'); // Редиректим на index.php
exit();   
}

?>

<!DOCTYPE html>

<html>

<head>
<title>
Покупаем погоны
</title>
<meta charset = "utf-8">
<link rel = "stylesheet" src = "css/roboto/roboto.css">
<script src="../bootstrap/js/jquery.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

<style>
body {
    font-family:'Roboto';
    width: 1000px;
    background-color:#79C753; 
    margin:0 auto;
    height:100%;
    margin-left:200px;
}

main {
    padding: 10px;
    width:80%;
    float:right;
    margin-left:-15px;
    padding-bottom: 90px;
    min-height:820px;
    border-left:1px solid blue;
    border-right:1px solid blue;
}

p, span{
    font-size:18px;
}

</style>

</head>

<body>

<main>    

<form action='handlers/buy_good_handler.php' method=POST onsubmit = "return buy_strap();" style = "display:inline-block;padding:5px;position:relative;left:300px;border:1px solid blue;">
 <h3 style = "margin-left:40px;color:blue;">Покупка погоны</h3>
  <span>Вам нужно</span> <input type = "text" name = "straps_count" id = "straps_count" value = "10" oninput = "show_total_sum(this)" maxlength = "3"  pattern = "[0-9]{1,3}" /> <span> погон</span><br />
 <span> К оплате:</span> <span id = "total_sum">10,7 (примерно)</span><br/>
  <span id = "errors_span" style = "display:none;color:red;"></span><br />
<input type=submit value='Оплатить' class="btn btn-primary" style = "margin-left:70px;">
</form>
<p>Стоимость одной погоны 1 р. При покупке одной погоны ваш рейтинг увеличивается на 1 единицу</p>
<p>Если вы все сделали правильно, то на ваш email должно прийти письмо с дальнейшими инструкциями</p>
<p>По всем вопросам обращаться к <a href = 'https://vk.com/vectorflex'>админу</a>, сообщив ему номер заказа.</p>
</main>

<script>

function show_total_sum(straps_count){
var total_sum = document.getElementById("total_sum");
var errors_span = document.getElementById("errors_span");   

straps_count.onkeyup = function(){
    this.value=this.value.replace(/[^0-9]/,'');
    errors_span.innerHTML = "";   
}
if(straps_count.value == null || straps_count.value == "0" || straps_count.value == ""){
total_sum.innerHTML = "?";    

} else {
total_sum.innerHTML = Math.round(((+straps_count.value * 1.07)*100)/100) + " (примерно)";    
}

} 

/* ГЛАВНАЯ ФУНКЦИЯ */
function buy_strap(){
var straps_count =  document.getElementById("straps_count");
var errors_span = document.getElementById("errors_span");    

 if(straps_count.value === null || straps_count.value === "0" || straps_count.value === ""){
errors_span.style.display = "inline";
errors_span.innerHTML = "Неверно указана сумма";
return false; 
}   
 
 return true;
    
}

</script>

</body>

</html>

<?php ob_end_flush(); ?>