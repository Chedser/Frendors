<?php ob_start(); ?>

<?php

session_start();
ini_set('display_errors', 'On');

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


/***********************************************************************************************************************************************************************/

function tolink($text) { // Превращение в ссылку
 
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

$id = trim(addslashes(htmlspecialchars($_GET['id'])));
$greetings = 'ASSHOLE';
$link = 'http://frendors.com/asshole.php';
$asshole_title = 'ASSHOLE';

if(!empty($id)){
    $sql = "SELECT *  FROM `asshole` WHERE `id`={$id}";	
    $query = $connection_handler->prepare($sql);
    $query->execute();
    $asshole = $query->fetchAll(PDO::FETCH_ASSOC);
        
        if(!empty($asshole)){
        $asshole_id = $asshole[0]['id'];
        $asshole_name = $asshole[0]['target'];
        $asshole_definition = $asshole[0]['definition'];
        $asshole_extra = $asshole[0]['extra'];

        $greetings = $asshole_name . ' — ' . $asshole_definition;
        
        $asshole_title = $greetings;
        
        $link = 'http://frendors.com/asshole.php?id=' . $id; 
            
        }else {
            header('Location: https://frendors.com/asshole.php');
            
        }
}

?>

<!DOCTYPE html>
<html>
<head>

<title><?php echo $asshole_title; ?></title>

<meta charset = "utf-8"/>    
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name = "description" content = "<?php echo $asshole_title; ?>" />
<meta name="keywords" content = "<?php echo $asshole_title; ?>, fuck you, abusement, go fuck yourself" / >
<meta name = "author" content = "Frendors">

<meta property="og:title" content="<?php echo $asshole_title; ?>"/>
<meta property="og:description" content="<?php echo $asshole_title; ?>"/>
<meta property="og:image" content="asshole.png">
<meta property="og:type" content="article"/>
<meta property="og:url" content= "//frendors.com/asshole.php" />

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
<script src = "https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.4/clipboard.min.js" type = "text/javascript"></script>

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

.link{
    cursor:pointer;
}

</style>
</head>

<body style = "background-color:#cefdce;">
    
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v6.0&appId=105917036567372&autoLogAppEvents=1"></script>

<!-- Page Container -->
<div class="w3-container w3-content" style="max-width:1400px;"> 

<!-- The Grid -->
<div class="row">
    <!-- Left Column -->
  <div class="w3-quarter" id = "left_side" style = "padding-top:15px; ">

<div class="w3-card w3-round w3-white" style = "padding-top:10px;">

  <img style = "display:block;margin:0 auto;border-radius:10px"
  src = "asshole.png" width = "170" height = "170" />

</div>

  <!-- End Left Column -->
  </div>

<script>
    
    // создаем объект, передавая ему селектор класса .btn
      var clip = new ClipboardJS('.link');
      
      // при успешном копировании, выводим в консоль скопированный текст
      clip.on("success", function(e) {
        alert("Скопировано: " + e.text);
      });
    
</script>

<script>
    
    function IsEmpty(obj){
        
        return obj.length == 0 || obj.value == "" || obj == null;
        
    }
    
    function showLink(){
   
   var target = document.getElementById("target_val");
    var definition = document.getElementById("definition_val");
    var extra = document.getElementById("extra_val");
   
     if (IsEmpty(target) || IsEmpty(definition)) {
        document.getElementById("txtHint").innerHTML = "Пусто";
        return;
    } 
    
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
               
                            var json_resp = JSON.parse(this.response);
                            console.log(json_resp);
                         
                            if(json_resp[0] === 'reserved'){ // Если уже существует
                            
                                    document.getElementById("txtHint").innerHTML = "Уже здесь";
                            
                                
                            }else{
                                 window.location.replace("https://frendors.com/asshole.php?id=" + json_resp[0]);
                            }
                    
                }
        };
        
        var formData = new FormData();
        formData.append('target',target.value.trim());
        formData.append('definition',definition.value.trim());
        formData.append('extra',extra.value.trim());
        
        xmlhttp.open("POST", "./handlers/asshole-handler.php", true);
        xmlhttp.send(formData);
    
        
    }
    
    function showLinkEnter(event){
var char = event.which || event.keyCode;  
if(char == 13){
showLink(document.getElementById('id'));   
}
    }
    
</script>


<!-- Middle Column -->
    <div class=w3-half id = middle_side style = margin-top:15px;padding:10px>
    
            <div class = "w3-container w3-card w3-white w3-round" style = "text-align:center; padding-bottom:5px">
 
<h1 style = "font-weight:bold; word-wrap:break-word;"><?php echo $greetings; ?></h1>

<div class="w3-container">
    
    <?php echo $asshole_extra; ?>
    
</div>

<div id = "form" class = "w3-panel w3-border w3-round w3-border-light-blue w3-padding" >

<div class="w3-container">
    <span style = "font-size:20px">Цель</span><br />
    <input type = "text" class = "w3-input w3-border w3-sand" maxlength = "50" id = "target_val" value = "" autocomplete="off" required /><br />
    <span style = "font-size:20px">Определялово</span><br />
    <input type = "text" class = "w3-input w3-border w3-sand" maxlength = "50" id = "definition_val" value = "" autocomplete="off" required/><br />
    <span style = "font-size:20px">Дополнительно</span><br />
    <textarea style = "resize:none;" class = "w3-input w3-border w3-sand" maxlength = "512" id = "extra_val" value = "" rows="4" cols="50" /></textarea>
</div>

<div id="txtHint" style = "margin-bottom:1px;"></div>
<input type = "submit" class = "w3-button w3-block w3-large w3-theme" value = "OK" style = "margin:5px 0px" onclick = "showLink()" />
</div>

<div style = "margin-bottom:5px">
    <button class="link w3-button w3-white w3-border w3-border-blue w3-round" data-clipboard-target="#link">Copy</button>
 <a id = "link" class = "w3-text-blue" href = "<?php echo $link; ?>"><?php echo $link; ?></a>
 </div>


<div>
                    <!-- Put this div tag to the place, where the Like block will be -->
        
            <div id="vk_like"></div>
            
        </div>    

        <script type="text/javascript">
        VK.Widgets.Like("vk_like", {type: "button", verb: 1,
        pageTitle: 'frendors.com',
        pageUrl: '<?php echo $link; ?>',
        pageImage: 'https://frendors.com/asshole.png'
        });
        </script>  

            </div>
    <?php 
    
    $assholes_block = '';
    
    $sql = "SELECT *  FROM `asshole` ORDER BY `date` DESC";	
    $query = $connection_handler->prepare($sql);
    $query->execute();
    $assholes = $query->fetchAll(PDO::FETCH_ASSOC);
    
   for($i = 0; $i < count($assholes); $i++){
      $assholes_block .=  '<div class="w3-container"   style = "word-wrap:break-word">
         
              <a href = "asshole.php?id=' . $assholes[$i]['id']  . '">' . $assholes[$i]['target'] . ' — ' . $assholes[$i]['definition'] .  '</a>
       
              <i  class = "fa fa-forward" style = "cursor:pointer" onclick = "window.open(\'https://yandex.ru/search/?text=' . $assholes[$i]['target'] . ' ' . $assholes[$i]['definition']  . '\')"></i>
   
         <div>' . $assholes[$i]['extra'] . '</div>

          </div><hr />';
   }

    ?>

    <div class = "w3-container w3-card  w3-white w3-round w3-padding" style = "margin-top:10px">
<h2>Цели | <?php echo count($assholes); ?></h2>
 <table class="w3-table w3-bordered">
     
     <?php echo $assholes_block; ?>
     
 </table>

    </div>
  
    <!-- End Middle Column -->
    </div>

 <!-- Right Column -->
    <div class="w3-quarter" id = "right-side">
      
      <div class="w3-card w3-round w3-white w3-center" style = "padding-bottom:5px;margin-bottom:10px">
        <div class="w3-container">
         
          <a href "https://www.youtube.com/channel/UCHDEprPkMA4ehijIHdA-eqg">
            <iframe src="https://www.youtube.com/embed/DmscuICDHTA" frameborder = "0" style = "width:100%" allowfullscreen></iframe>
          </a>

          <a href = "https://www.youtube.com/channel/UCHDEprPkMA4ehijIHdA-eqg" target = "_blank">
              <button class="w3-button w3-block w3-theme-l4" >
                  <span style = "word-wrap:break-word">Нажми</span></button></a>
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
