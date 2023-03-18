<?php ob_start(); ?>

<?php

session_start();
ini_set('display_errors', 'Off');

header('Location: https://store.steampowered.com/app/1861310/Nevedomo/');
exit;

header ("Content-Type: text/html; charset=UTF-8");

  if(!empty($_COOKIE['user'])){
    header ("Location: user.php?zs=" . $_COOKIE['user']);
    exit();
} 

require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/user_info.php';

$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

$login_session = 'Frendors';
$login = 'Frendors';

$facebook_client_id = '105917036567372';
$facebook_client_secret = '9aabc3fc9c30da1a922f615a1dbf2687';

$hashed_string = $facebook_client_id . $facebook_client_secret;

// $fb_hash = crypt($hashed_string,'babushka_Misha');


/***********************************************************************************************************************************************************************/

?>

<!DOCTYPE html>
<html lang="ru-RU">
<head>
    	<title>Индексная | Социальная сеть для долбоебов | frendors.com</title>
	<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name = "description" content = "frendors.com — социальная сеть для долбоебов. Здесь нет модерации, цензуры и прочей хуйни. Регистрируйся или иди нахуй" />
<meta name="keywords" content = "социальная сеть для долбоебов,долбоебы,чудики,придурки" / >
<meta name = "author" content = "Vectorflex">
<meta property="og:title" content="frendors.com"/>
<meta property="og:description" content="frendors.com — социальная сеть для долбоебов. Здесь нет модерации, цензуры и прочей хуйни. Регистрируйся или иди нахуй"/>
<meta property="og:image" content="index_logo.png">
<meta property="og:type" content="article"/>
<meta property="og:url" content= "//frendors.com/user.php?zs=Frendors" />

	<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;700&display=swap" rel="stylesheet">
	<link  href="/css/style.css" rel="stylesheet" type="text/css">
	<link  href="/css/media.css" rel="stylesheet" type="text/css">
	<link  href="/css/shit.css" rel="stylesheet" type="text/css">
 <script type="text/javascript" src="//vk.com/js/api/openapi.js?137"></script> 

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
        
        </script> 
        
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

</head>
<body>
	<div class="header">
		<div class="container">
			<nav class="navigation">
				<div class="logo">
					<a href="#">
						<img src="img/logo.png">
					</a>
				</div>
				<div class="menu">
					<ul>
						<li><a href="/fuck-you.php" target = "blank">Послать нахуй</a></li>
					</ul>
					<div class="header__buttons">
						<button class="reg__btn">Регистратитя</button>
						<button class="login__btn">Войдите</button>
					</div>
				</div>
				<div class="menuToggle icon">
                    <div class="hamburger"></div>
                </div>
			</nav>
		</div>
	</div>
	<div class="info__section">
		<div class="container">
			<div class="info__section__wrapper">
				<div class="main__side">
					<div class="main__title">
						<div class="main__title__wrapper">
							<h1>Социальная сеть для долбоебов!</h1>
							<p>Ты долбоеб?<br />
							Здесь нет модерации, цензуры и прочей хуйни<br />
							Регистрируйся или иди нахуй<br />
							У нас лучшая социальная сеть в России... <br />
							Остальные — хуйня
							</p>
						</div>	
					</div>	
			
				</div>
				<div class="aside">
				
					<div class="aside__group">
			
						 <div class = "subs_container">
                  
                       <div class = "vk_auth_container">
                           <div id="vk_auth"></div>
						</div> 
				
				<div class="w3-card w3-round w3-white w3-center" style = "margin-top:10px">
    
                            <iframe src="https://store.steampowered.com/widget/1861310/" frameborder="0" width="100%" height="190"></iframe>

                </div>
				
					</div>	
			
				</div>
			</div>
		</div>	
	</div>

	<div class="modal-overlay">
		<div class="reg__modal">
			<a class="close-modal">
	  			<svg viewBox="0 0 20 20">
					<path fill="#000000" d="M15.898,4.045c-0.271-0.272-0.713-0.272-0.986,0l-4.71,4.711L5.493,4.045c-0.272-0.272-0.714-0.272-0.986,0s-0.272,0.714,0,0.986l4.709,4.711l-4.71,4.711c-0.272,0.271-0.272,0.713,0,0.986c0.136,0.136,0.314,0.203,0.492,0.203c0.179,0,0.357-0.067,0.493-0.203l4.711-4.711l4.71,4.711c0.137,0.136,0.314,0.203,0.494,0.203c0.178,0,0.355-0.067,0.492-0.203c0.273-0.273,0.273-0.715,0-0.986l-4.711-4.711l4.711-4.711C16.172,4.759,16.172,4.317,15.898,4.045z"></path>
	  			</svg>
			</a>
			<div class="modal-content">
 <form action = "handlers/qwick_registration_main_info.php" method = "POST"
          enctype="multipart/form-data" name = "quick_registration_form" 
          onsubmit = "return send_form()">
  <div class = "container">

    <input type="text" placeholder="Ник" name = "nick" id = "nick" maxlength = "20" 
    pattern = "[a-zA-ZЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮабвгдежзийклмнопрстуфхцчшщЪыьэюяё0-9ё_]{2,20}" 
    onblur = "check_nick_ajax(this)" required />
    <div id = "nick_server_response_container">
    <img id = "nick_server_response_img" src = "imgs/white_space.png" width = "20" height = "20" alt = "nick_server_response_img" />
    <span id = "nick_server_response_span"></span>
    
    <span style = "color:gray; font-size:12px" required = "required">[a-z, A-Z _ ] {2-20 символов}</span>
    </div>

    <input type="email" placeholder="Емайл" name="email" id = "email" onblur = "check_mail_ajax(this)" required />
    
    <div id = "nick_sever_response_container"> 
    <img id = "mail_server_response_img" src = "imgs/white_space.png" width = "20" height = "20" alt = "mail_server_response_img" />
    <span id = "mail_server_response_span"></span>
    </div>

    <input type="password" placeholder="Пароль" id = "pass" name="pass" maxlength = "20" onblur = "password_length(this)" required />
    
    <div id = "password_length_container">
        <img id = "password_length_img" src = "imgs/white_space.png" width = "20" height = "20" alt = "password_length_img" />
        <span id = "password_length_span"></span> 
    
    </div> 

    <input type="password" placeholder="Повторить" name = "pass_confirm" id = "pass_confirm"  required />

<div id = "captcha" style = "margin-top:5px;">
Правильно нахуй!?
<div id = "captcha_imgs"><img src = "captcha/<?php 
$rand_pict = mt_rand(1,9);
echo $rand_pict;
?>.png" id = "first_digit" width = "50" height = "100" /> <img src = "captcha/<?php 
$rand_conv = mt_rand(0,2);
if($rand_conv == 1) echo 'bigger';
else if($rand_conv == 0) echo 'lesser';
else echo 'equall';   
?>.png" id = "conv_op" width = "50" height = "100" /> <img src = "captcha/<?php 
$rand_pict = mt_rand(1,9);
echo $rand_pict;
?>.png" id = "second_digit" width = "50" height = "100" />
</div>
                <div id = "radios_container" style = "margin:5px;">
                <input type = "radio" class = "w3-radio" name = "user_answer" id = "user_answer_true" value = "true" checked = "checked"/>Правильна!<br />
                <input type = "radio" class = "w3-radio" name = "user_answer" id = "user_answer_false" value = "false"/>Нет бля
                </div>
</div> 
  <span id = "common_errors_span"> </span>
    <button type="submit" id = "qwick_registration_button" class="quick__reg__btn">Стать долбоебом</button>
  </div>

</form>
			</div>
  		</div>
	</div>

	<div class="login-modal-overlay">
		<div class="login__modal">
			<a class="close-modal">
				<svg viewBox="0 0 20 20">
					<path fill="#000000" d="M15.898,4.045c-0.271-0.272-0.713-0.272-0.986,0l-4.71,4.711L5.493,4.045c-0.272-0.272-0.714-0.272-0.986,0s-0.272,0.714,0,0.986l4.709,4.711l-4.71,4.711c-0.272,0.271-0.272,0.713,0,0.986c0.136,0.136,0.314,0.203,0.492,0.203c0.179,0,0.357-0.067,0.493-0.203l4.711-4.711l4.71,4.711c0.137,0.136,0.314,0.203,0.494,0.203c0.178,0,0.355-0.067,0.492-0.203c0.273-0.273,0.273-0.715,0-0.986l-4.711-4.711l4.711-4.711C16.172,4.759,16.172,4.317,15.898,4.045z"></path>
				</svg>
			</a>
			<div class="modal-content">
				<form class="login__form" id = "auth_form" method = "POST" action="authorization.php" onsubmit = "return authorization()">
				
					<input type="email" name="user_login" placeholder="Email" id = "login" required>
					<input type="password" name="user_password" placeholder="Пароль" id = "password" required>
					<span id = "second_click" style = "display:none;">&ensp; one click yet</span>
					<div class="enter__wrap">
					<button type="submit" class="enter__btn" id = "enter_button">
					    <div id = "enter_loader"></div>Ахуенно</button>
					</div>	
					<div class="forget__password">
						<p>Забыл <a href="forgot_pass.php" target="_blank">пароль</a> нахуй!</p>
					</div>
				</form>
			</div>
		</div>	
	</div>	

<div id="msg_pop">
<h4>У нас куки</h4>
<button class = "closeCookieBtn">Иди нахуй</button>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="js/script.js"></script>
<script>
    
    (function checkCookie() {
  var user = getCookie("bratok");
  if (user == "" || user == null) {
     showCookieBlock();
  } 
})()
</script>

</body>
</html>

<?php ob_start(); ?>