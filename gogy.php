<?php 	
 ob_start();
 header ("Content-Type: text/html; charset=UTF-8");
 
 ?>

<!DOCTYPE html>

<?php
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
<title>Гоги знает</title>
<meta charset = "utf-8" />
<link rel = "stylesheet" href = "css/normalize.css"  type = "text/css" />
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel = "stylesheet" src = "css/roboto/roboto.css">
<script src="bootstrap/js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

<meta name = "description" content = 'Gogy - поисковик для поехавших с возможностью добавления и редактирования информации о сайте без регистрации' />
<meta name="keywords" content = "gogy,google,социальная сеть для поехавших,гугл,поисковик для поехавших,зеленый слоник,бердянск,больничка,сергей пахомов,владимир епифанцев,александр маслаев,александр осмоловский,сладкий хлеб,азов,украина,пахом,голова,трэш фильмы,артхаус,человеческая многоножка" / >
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name = "author" content = "Александр Неминуев">

<meta property="og:title" content="Gogy"/>
<meta property="og:description" content="Gogy - поисковик для поехавших с возможностью добавления и редактирования информации о сайте без регистрации"/>
<meta property="og:image" content="//frendors.com/gogy.png">
<meta property="og:type" content="website"/>
<meta property="og:url" content= "//frendors.com/gogy.php" />

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
    margin:0 auto;
    width: 100%;
    padding:5px;
    background-color:#cefdce; 
    
}

main {
    padding: 10px;
    border-left:1px solid blue;
    border-right:1px solid blue;
    width:100%;
    margin-left:-15px;
    padding-bottom: 90px;
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

    <main>

<style>

*{
    padding:0;
    margin:0;
}

.sitecontainer{
        border-top:1px solid white;
        border-bottom:1px solid white;
        margin:5px;
        padding:5px 0;
        cursor:pointer;
        max-height:300px;
}

.sitecontainer:hover{
    background-color:white;
    opacity:0.8;
}

.sitetitle{
    border-bottom:1px solid black;
    font-size:20px;
    font-weight:bold;
    color:blue;
    word-wrap:break-word;
}

.sitedescription{
    word-wrap:break-word;
    font-size:16px;
    overflow-y:auto;
}

input[type=text],input[type=password],input[type=email],textarea{
          padding:5px;
          border-radius:5px;
 }
 
 textarea{
     resize:none;
 }
 
input[type=checkbox],input[type=radio]{
    width:30px;
    height:30px;
    cursor:pointer;
}

 input[type=text]:focus,input[type=password]:focus,input[type=email]:focus,input[type=checkbox]:focus,textarea:focus{
     background-color: #98DDDE;
     box-shadow: 0px 0px 1px #7FFFD4;
}

</style>
 <div class="pluso" id = "pluso_content" data-background="transparent" data-options="medium,round,line,horizontal,counter,theme=03" data-services="vkontakte,odnoklassniki,facebook,twitter,google,moimir,email,print"></div>
<a href = "index.php" style = "font-size:25px" target = "_blank">frendors.com</a><br />

<img src = 'gogy.png' height = "100" width="150" /><br>
<span style = "font-size:20px;">Поисковик для поехавших</span>

<hr style = "border:1px dashed white" />

<div id = "add_site_container">
       
       <section>
<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#add_domain_modal" style = "width:100%;color:black;margin-top:3px;margin-bottom:3px;word-wrap:break-word" >Добавить любой домен<br />в формате frendors.com</button><br />
</section>

<!-- Modal -->
<div id="add_domain_modal" class="modal fade" role="dialog">
  <div class="modal-dialog"  style = "width:65%;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Добавьте любой домен в поехавший <a href='gogy.php' target = "_blank">Гоги каталог</a> вида frendors.com</h4>
      </div>
      <div class="modal-body">
       Домен <input title = "название сайта. например, frendors.com" type = "text" id = "sitename" maxlength = "80" style = "width:100%"><br />
       Заголовок <input title = "например,социальная сеть для поехавших" type = "text" id = "sitetitle" maxlength = "80" style = "width:100%"><br />
       Описание <textarea  title = "про чо сайт" id = "sitedescription" maxlength = "256" style = "width:100%"></textarea>
<span id = "sitename_errors_span" style = "display:block"></span>
<button type = "button" onclick = "add_site()" class = "btn btn-success" style = "margin:3px">Ахуенно</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script>
  
function add_site(){
    
    function parse_response_to_json(response){
       var server_response = JSON.parse(response); 
       return server_response.status;
    }
    
    var sitename = document.getElementById("sitename");
    var sitetitle = document.getElementById("sitetitle");
    var sitedescription = document.getElementById("sitedescription");
    
      var errors_txt = "";
      var sitename_errors_span = document.getElementById("sitename_errors_span");
      
      var sendflag = true;
   
    if(sitename.value == "" || sitename.value.match(/^\s+$/ig)){
       errors_txt += "Пустое название нахуй!<br />"; 
    sendflag = false;
    }
    
     if(sitetitle.value == "" || sitetitle.value.match(/^\s+$/ig)){
       errors_txt += "Пустой заголовок нахуй!<br />"; 
    sendflag = false;
    }
    
     if(sitedescription.value == "" || sitedescription.value.match(/^\s+$/ig)){
       errors_txt += "Пустое описание нахуй!<br />"; 
    sendflag = false;
    }
    
    if(!sitename.value.match(/^([a-zA-Z0-9_\-]{2,256})+([\.])+([a-zA-Z]{2,6})+$/ig)){
        errors_txt += "Название сайта должно быть в формате frendors.com<br />"; 
       sendflag = false;
    }
    
    if(sendflag == false){
       sitename_errors_span.innerHTML = errors_txt;
        return;
    }
 
 var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
    var response = parse_response_to_json(xmlhttp.response);
    
    if(response === 'not_exist'){
        sitename_errors_span.innerHTML = "Домен не существует"; 
         } else if(response === 'site_in_db') {
         sitename_errors_span.innerHTML = "Домен уже есть в базе"; 
    } else if(response === 'site_created'){
   sitename_errors_span.innerHTML = "Домен успешно добавлен";
      sitename.value = "";
      sitetitle.value = "";
       sitedescription.value = "";
       setTimeout(window.location.reload(),3000);
    }else{
       sitename_errors_span.innerHTML = "Ошибка ввода нахуй! Сами подумайте почему"; 
    }
        
    } 
}

var formData = new FormData();
formData.append('sitename', sitename.value.trim());
formData.append('sitetitle', sitetitle.value.trim());
formData.append('sitedescription', sitedescription.value.trim());

xmlhttp.open('POST', 'add_site_to_search.php', true);
xmlhttp.send(formData);

}    
    
</script>

<!-- Modal -->
<div id="edit_title_modal" class="modal fade" role="dialog">
  <div class="modal-dialog"  style = "width:65%;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <input type = "hidden" id = "site_id_hidden" />
        <h3 id = "sitetitleh3"></h3>
        <h4 class="modal-title">Редактировать заголовок</h4>
      </div>
      <div class="modal-body">
       Заголовок <input title = "например,социальная сеть для поехавших" type = "text" id = "sitetitle_input" maxlength = "80" style = "width:100%" oninput = "clear_errors_sitetitle_input()" ><br />
      <span id = "sitetitle_errors_span" style = "display:block"></span>
<button type = "button" onclick = "edit_sitetitle()" class = "btn btn-success" style = "margin:3px">Ахуенно</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Нахуй</button>
      </div>
    </div>

  </div>
</div>

<script>

 function clear_errors_sitetitle_input(){
        document.getElementById("sitetitle_errors_span").innerHTML = "";
    }

function set_site_id(id,sitetitle){

var site_id_hidden = document.getElementById("site_id_hidden");
var sitetitle_input = document.getElementById("sitetitle_inut");
var sitetitleh3 = document.getElementById("sitetitleh3"); 

sitetitleh3.innerHTML = sitetitle;
site_id_hidden.value = id;
}

function edit_sitetitle(){

var site_id_hidden = document.getElementById("site_id_hidden");
var sitetitle_input = document.getElementById("sitetitle_input");
var sitetitle_in_container = document.getElementById("sitetitle_in_container_" + site_id_hidden.value);
var sitetitle_errors_span = document.getElementById("sitetitle_errors_span");

    if(sitetitle_input.value == "" || sitetitle_input.value.match(/^\s+$/ig)){
       sitetitle_errors_span.innerHTML = "Пустой заголовок нахуй!"; 
   return;
    }

var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {

var server_response = JSON.parse(xmlhttp.response); 

    if(server_response.status === "true"){
        sitetitle_in_container.innerHTML = sitetitle_input.value;
        sitetitle_input.value = "";
        sitetitle_errors_span.innerHTML = "Заголовок изменен";
    }else{
       sitetitle_errors_span.innerHTML = "Произошла какая-то хуйня"; 
    }
} 
}

var formData = new FormData();

formData.append('id', site_id_hidden.value.trim());
formData.append('title', sitetitle_input.value.trim());

xmlhttp.open('POST', 'edit_sitetitle.php', true);
xmlhttp.send(formData);
    
}

</script>

<!-- Modal -->
<div id="edit_description_modal" class="modal fade" role="dialog">
  <div class="modal-dialog"  style = "width:65%;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <input type = "hidden" id = "site_id_hidden_description" />
        <h3 id = "sitedescriptionh3"></h3>
        <h4 class="modal-title">Редактировать описание</h4>
      </div>
      <div class="modal-body">
       Описание <textarea  title = "про чо сайт" id = "sitedescription_input" maxlength = "256" style = "width:100%"></textarea><br />
      <span id = "sitedescription_errors_span" style = "display:block"></span>
<button type = "button" onclick = "edit_description()" class = "btn btn-success" style = "margin:3px">Ахуенно</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Нахуй</button>
      </div>
    </div>

  </div>
</div>

<script>

 function clear_errors_sitedescription_input(){
        document.getElementById("sitedescription_errors_span").innerHTML = "";
    }

function set_site_id_for_description(id,sitedescription){

var site_id_hidden = document.getElementById("site_id_hidden_description");
var sitedescription_input = document.getElementById("sitedescription_inut");
var sitedescriptioneh3 = document.getElementById("sitedescriptionh3"); 

sitedescriptionh3.innerHTML = sitedescription;
site_id_hidden.value = id;
}

function edit_description(){

var site_id_hidden = document.getElementById("site_id_hidden_description");
var sitedescription_input = document.getElementById("sitedescription_input");
var sitedescription_in_container = document.getElementById("sitedescription_in_container_" + site_id_hidden.value);
var sitedescription_errors_span = document.getElementById("sitedescription_errors_span");

    if(sitedescription_input.value == "" || sitedescription_input.value.match(/^\s+$/ig)){
       sitedescription_errors_span.innerHTML = "Пустое описание нахуй!"; 
   return;
    }

var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {

var server_response = JSON.parse(xmlhttp.response); 

    if(server_response.status === "true"){
        sitedescription_in_container.innerHTML = sitedescription_input.value;
        sitedescription_input.value = "";
        sitedescription_errors_span.innerHTML = "Описание изменено";
    }else{
       sitedescription_errors_span.innerHTML = "Произошла какая-то хуйня"; 
    }
} 
}

var formData = new FormData();

formData.append('id', site_id_hidden.value.trim());
formData.append('description', sitedescription_input.value.trim());

xmlhttp.open('POST', 'edit_sitedescription.php', true);
xmlhttp.send(formData);
    
}

</script>

<?php 
    /* ИЗВЛЕКАЕМ ИЗ БД ДОМЕНЫ */
$sql = "SELECT *  FROM `sites`";	
$query = $connection_handler->prepare($sql);
$query->execute();
$domains_result = $query->fetchAll(PDO::FETCH_ASSOC);
 
 
 for($i = 0; $i < count($domains_result); $i++){ // УДАЛЯЕМ ИЗ БАЗЫ НЕСУЩЕСТВУЮЩИЕ ДОМЕНЫ
     
                                 if(checkdnsrr($domains_result[$i]['sitename']) == false){// Сайта уже не существует. Удаляем сайт из базы
                                        
                                        $sql = "DELETE FROM `sites` WHERE `sitename`='{$domains_result[$i]['sitename']}'";
                                        $query = $connection_handler->prepare($sql);
                                        $query->execute();
                            }
     
 }
 
     /* ИЗВЛЕКАЕМ ИЗ БД ДОМЕНЫ */
$sql = "SELECT *  FROM `sites`  ORDER BY `this_id` DESC";	
$query = $connection_handler->prepare($sql);
$query->execute();
$domains = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<input type = "text" id = "qwery_input" maxlength = "300" style = "width:100%" oninput = "clear_errors_qwery_input()" />
<span id = "qwery_errors_span"></span>
<button type = "button" class = "btn btn-success" onclick = "get_results()" style = "margin: 3px 45%">А чо там?</button>
<span id = "results_count_span" style = "color:red"><?php echo count($domains); ?></span>

<hr style = "border:1px dashed white;margin:0px" />

<script>
    
       function clear_errors_qwery_input(){
        document.getElementById("qwery_errors_span").innerHTML = "";
    }
    
    function get_results(){
        
         function parse_response_to_json(response){
          var response_arr = JSON.parse(response); 
          var results_count_span = document.getElementById("results_count_span");
          var results = "";     
          var results_container = document.getElementById("results_container");
           
           if(response_arr.sites.length != 0){
           
           for(var i = 0; i < response_arr.sites.length - 1; i++){
               results += '<section class = "sitecontainer" id = "sitecontainer_' + response_arr.sites[i].id + '">' +
		'<div class = "sitetitle"><a href = //' + response_arr.sites[i].sitename + ' target=_blank>' + response_arr.sites[i].sitename + '<span style = "color:black"> | </span><span id = "sitetitle_in_container_' + response_arr.sites[i].id + '">' + response_arr.sites[i].title + '</span></a>' + 
		' <a title = "редактировать заголовок" type="button" data-toggle="modal" data-target="#edit_title_modal" style = "color:green;font-size:12px;" onclick = set_site_id("'+ response_arr.sites[i].id  + '","' + response_arr.sites[i].sitename + '")>ред.</a>' +
		'</div>' +
		'<div class = "sitedescription">' +
		'<span id = sitedescription_in_container_'+ response_arr.sites[i].id + '>' +  response_arr.sites[i].description + '</span> ' +
		'<a title = "редактировать описание" type="button" data-toggle="modal" data-target="#edit_description_modal" style = "color:green;font-size:12px;" onclick = set_site_id_for_description("'+ response_arr.sites[i].id  + '","' + response_arr.sites[i].sitename + '")>ред.</a>' +
		'</div>' +
		'</section>';
        
           }
          
           results_container.innerHTML = results;
           results_count_span.innerHTML = response_arr.sites[response_arr.sites.length - 1].count;
            }else{
                    results_count_span.innerHTML = "Нету нихуя!";
            }
      }
        
    /********************************************************************************************/    
        
      var qwery_input = document.getElementById("qwery_input");
      var qwery_errors_span = document.getElementById("qwery_errors_span");
     var results_count_span = document.getElementById("results_count_span");
     var results_container = document.getElementById("results_container");
   
    if(qwery_input.value == "" || qwery_input.value.match(/^\s+$/ig)){
       qwery_errors_span.innerHTML = "Пусто нахуй!"; 
       return;
    }
   
  var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
    parse_response_to_json(xmlhttp.response);

    } 
}

var formData = new FormData();
formData.append('sites_qwery', qwery_input.value.trim());

xmlhttp.open('POST', 'sites_qwery.php', true);
xmlhttp.send(formData);
 
    }
    
</script>

<section id = "results_container">

<?php

    /* ИЗВЛЕКАЕМ ИЗ БД ДОМЕНЫ */
$sql = "SELECT *  FROM `sites`";	
$query = $connection_handler->prepare($sql);
$query->execute();
$domains_result = $query->fetchAll(PDO::FETCH_ASSOC);
 
 
 for($i = 0; $i < count($domains_result); $i++){ // УДАЛЯЕМ ИЗ БАЗЫ НЕСУЩЕСТВУЮЩИЕ ДОМЕНЫ
     
                                 if(checkdnsrr($domains_result[$i]['sitename']) == false){// Сайта уже не существует. Удаляем сайт из базы
                                        
                                        $sql = "DELETE FROM `sites` WHERE `sitename`='{$domains_result[$i]['sitename']}'";
                                        $query = $connection_handler->prepare($sql);
                                        $query->execute();
                            }
     
 }
 
     /* ИЗВЛЕКАЕМ ИЗ БД ДОМЕНЫ */
$sql = "SELECT *  FROM `sites`  ORDER BY `this_id` DESC";	
$query = $connection_handler->prepare($sql);
$query->execute();
$domains = $query->fetchAll(PDO::FETCH_ASSOC);

$sitecontainer = "";

for($i = 0; $i < count($domains); $i++){
    
    $sitename = 'http://' . $domains[$i]['sitename'];
 
$content =file_get_contents($sitename);
   
    //domelement
		$dom = new DOMDocument();	//создаем объект
	 	$dom->loadHTML($content);	//загружаем контент
	    $metas =  $dom->getElementsByTagName('meta'); 
	
        $img = "";
        $img_src = "";
		
				for ($k = 0; $k < $metas->length; $k++) {
		$name =	$metas->item($k)->getAttribute('property');	//вытаскиваем из тега атрибут name
		
    		 if($name === 'og:image'){
    		   $img_src = $metas->item($k)->getAttribute('content');	//вытаскиваем из тега атрибут name
       		  $img = "<img src = " . $img_src . " height = '50' width = '50' style = 'margin:5px' />";
       		  break;
    		 }   
	
		}
		
		/************************************************************************/
		
		$sitecontainer .= '<section class = "sitecontainer" id = "sitecontainer_' . $domains[$i]['this_id']  . '">
		<div class = "sitetitle"><a href = ' . $sitename .' target=_blank>' . str_replace('http://','',$sitename) . '<span style = "color:black"> | </span><span id = "sitetitle_in_container_' . $domains[$i]['this_id'] . '">' . $domains[$i]['title'] . '</span></a> 
		<a title = "редактировать заголовок" type="button" data-toggle="modal" data-target="#edit_title_modal" style = "color:green;font-size:12px;" onclick = set_site_id("'. $domains[$i]['this_id']  .'","' . str_replace('http://','',$sitename) . '")>ред.</a></div>
		<div class = "sitedescription">' .
		 $img .   '<span id = sitedescription_in_container_' . $domains[$i]['this_id'] .'>' . $domains[$i]['description'] . 
		 '</span> <a title = "редактировать описание" type="button" data-toggle="modal" data-target="#edit_description_modal" style = "color:green;font-size:12px;" onclick = set_site_id_for_description("'. $domains[$i]['this_id']  .'","' . str_replace('http://','',$sitename) . '")>ред.</a>' .
		'</div>
		</section>';

       }
       
       echo $sitecontainer;

?>
</section>
    </main>    

<script type="text/javascript">(function() {
  if (window.pluso)if (typeof window.pluso.start == "function") return;
  if (window.ifpluso==undefined) { window.ifpluso = 1;
    var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
    s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
    s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
    var h=d[g]('body')[0];
    h.appendChild(s);
  }})();
</script>

</body>    

</html>    

<?php ob_end_flush(); ?>