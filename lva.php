
<!DOCTYPE html>
<html lang="ru">
<head>
<title>Link VK Adapter</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name = "description" content = "link vk adapter" />
<meta name="keywords" content = "link,vk,adapter">
<meta name = "author" content = "Поехавший">

<meta property="og:title" content= "Link VK Adapter"/>
<meta property="og:description" content="Преобразуем ссылку вк в наглядную форму, чтобы повыебываться"/>
<meta property="og:image" content="/games/yopuman/logo.png">
<meta property="og:type" content="article"/>
<meta property="og:url" content= "//frendors.com/lva.html" />

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel = "stylesheet" href = "../css/normalize.css"  type = "text/css" />
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="lva.min.js"></script>

<!-- Put this script tag to the <head> of your page -->
<script type="text/javascript" src="https://vk.com/js/api/openapi.js?168"></script>

<script type="text/javascript">
  VK.init({apiId: 6686305, onlyWidgets: true});
</script>

<style>

* {
  box-sizing: border-box;
}

html {
  font-family: "Lucida Sans", sans-serif;
}

/* Style the body */
body {
  font-family: Arial, Helvetica, sans-serif;
  max-width:1400px;
  background-color:#cefdce;
  margin: 0;
}

/* Column container */
.row {  
  display: -ms-flexbox; /* IE10 */
  display: flex;
  -ms-flex-wrap: wrap; /* IE10 */
  flex-wrap: wrap;
}

/* Main column */
.main {   
  -ms-flex: 70%; /* IE10 */
  flex: 70%;
  padding: 20px;
}

/* Responsive layout - when the screen is less than 700px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 700px) {
  .row {   
    flex-direction: column;
  }
}

input{
    margin-top:10px;
    
}

button{
    
    margin-top:2px;
    margin-bottom:15px;
    
}

</style>
</head>
<body>

<!-- Page content -->
<div class="w3-content w3-padding-large w3-margin w3-center" id="portfolio">

<h1>Link Vk Adapter</h1>

<div id = "desc_block">
    <p>Здравствуй, дорогой друг! Если ты заебался набирать ссылку вида [id7357521359|гражданин Залупа], чтобы повыебываться перед людями, то тебе сюда</p>
</div>

<div class = "w3-row">
        
        <div style = "width:100%;margin:auto;max-width:360px" >
        
        <input class="w3-input w3-border" placeholder="введи сюда ссылку вк" type="text" id="inp_0" maxlength="256">
        <input class="w3-input w3-border" style = "margin-top:3px;" placeholder="Обращение к пользователю (необязательно)" type="text" id="inp_-1" maxlength="256">
        <button class="w3-button w3-block w3-round w3-medium w3-border w3-wide w3-khaki">Go!</button>
                                                       <span id="erspan"></span>
        <input class="w3-input w3-border" placeholder="Здесь будет ссылка1" type="text" id="inp_1" style="margin-top:25px;">
        <button class="w3-button w3-block w3-round w3-medium w3-border w3-wide w3-khaki" id="1">Copy 1</button>
        
         <input class="w3-input w3-border" placeholder="Здесь будет ссылка2" id="inp_2" type="text">
         <button class="w3-button w3-block w3-round w3-medium w3-border w3-wide w3-khaki" id="2">Copy 2</button>
         
         <input class="w3-input w3-border" placeholder="Здесь будет ссылка3" id="inp_3" type="text">
        <button class="w3-button w3-block w3-round w3-medium w3-border w3-wide w3-khaki" id="3">Copy 3</button>
        </div>
<div style = "margin-top:-10px;"><span style = "font-size:12px;">Примечание: если не ввести обращение, то оно заменится на XXX. Так что ебитесь сами</span></div>
</div>

<div style = "margin-top:10px;">
<!-- Put this div tag to the place, where the Comments block will be -->
<div id="vk_comments"></div>
<script type="text/javascript">
VK.Widgets.Comments("vk_comments", {limit: 20, attach: "*"});
</script>
</div>
<!-- End page content -->
</div>


</body>
</html>


