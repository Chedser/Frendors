<?php 

$langfr = $_COOKIE['langfr'];

if(empty($langfr)){ /* Куков нет. Грузим версию на русском */
        setcookie("langfr", "ru", time()+60*60*24*30);
}

$lang_choose = 0; // 0 - русский, 1 - английский

if($langfr === 'en'){
    $lang_choose = 1;    
    } else if($langfr === 'ru'){
            $lang_choose = 0;    
}

$lang_vars = array(
                    'detailed_regging' => array("Подробная регистрация","Detailed regging")
                    );

?>

<!DOCTYPE html>

<html>
<head>
    <title><?php echo $lang_vars['detailed_regging'][$lang_choose]; ?></title>
    <meta charset = "utf-8" />
    <link rel = "stylesheet" href = "css/normalize.css"  type = "text/css" />
    <link rel = "stylesheet" src = "css/roboto/roboto.css">
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
    height: 100%;
    min-height:100%;
    background-color:#79C753;
    border-radius: 7px;
}

main {
    width:70%;
    min-width:70%;
    height:inherit;
    padding: 10px;
    margin:0 auto;
    border-left: 2px double blue;
}

main h2{
    color:blue;
}

main form {
    width:1000px;
}

input[type = "text"],input[type = "password"], button{
	color:black;
}	

tr{
border-left: 2px solid green;
}
 
td{
    color:black;
	padding:10px;
	border-bottom: 1px solid red;
}

main table {
margin-bottom: 10px;	
}

.required{
	color:red;	
}

input[type="text"], input[type="password"],input[type="email"]{
    padding:5px;
    border-radius:5px;
}

input[type = "text"]:focus, input[type = "email"]:focus{
    background-color: aqua;
    box-shadow:5px 5px 5px aqua;
    outline-color: chartreuse;
}

input[type = "password"]:focus{
    background-color: #B76BA3;
    box-shadow:5px 5px 5px #B76BA3;
    outline-color: darkviolet;
}

input[type="radio"]{
    cursor:pointer;
}

input[type="radio"]:checked{
     box-shadow:0px 0px 5px aqua; 
}

select, option {
color:black;
cursor:pointer;
padding:5px;
}

option:nth-child(1){
color:gray;
}

#errors {
display:inline-block;
color: yellow;	
background-color: red;
border-left:3px solid green;
border-raduis: 5px;
}
    
#form_submit_button {
background: #9dd53a; /* Old browsers */
background: -moz-linear-gradient(top,  #9dd53a 0%, #a1d54f 50%, #80c217 51%, #7cbc0a 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top,  #9dd53a 0%,#a1d54f 50%,#80c217 51%,#7cbc0a 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom,  #9dd53a 0%,#a1d54f 50%,#80c217 51%,#7cbc0a 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#9dd53a', endColorstr='#7cbc0a',GradientType=0 ); /* IE6-9 */ 
color:black;
}

#form_submit_button:hover{
    box-shadow: 0 0 10px rgba(0,0,0,0.5);
}

#form_submit_button:active{
background: #7cbc0a; /* Old browsers */
background: -moz-linear-gradient(top, #7cbc0a 0%, #80c217 49%, #a1d54f 50%, #9dd53a 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top, #7cbc0a 0%,#80c217 49%,#a1d54f 50%,#9dd53a 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom, #7cbc0a 0%,#80c217 49%,#a1d54f 50%,#9dd53a 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#7cbc0a', endColorstr='#9dd53a',GradientType=0 ); /* IE6-9 */
}

#languages_container {
    margin-left:350px;
    margin-top:-40px;
}

#russia_flag_img {
    width:30px;
    height:30px;
    cursor:pointer;
}

 #england_flag_img {
    width:30px;
    height:30px;
    margin-left:4px;
    cursor:pointer;
}

#russia_flag_img:hover, #england_flag_img:hover {
     transform:scale(1.1);
}

#russia_flag_img:active, #england_flag_img:active {
     transform:scale(1.0);
}
   
    </style>
  <script>
function fucking_quotes(){
var nick = document.getElementById("nick");
nick.onkeyup = function(){
    this.value=this.value.replace(/["]/,'');
    this.value=this.value.replace(/[\s-]/,'_');
    this.value=this.value.replace(/[&ёЁ%=+*.?~`!@#№$;%:^?|]/,''); 
    this.value=this.value.replace(/[,/<'>\\]/,'');
    this.value=this.value.replace(/[()]/,'');
}
}
</script> 

<script>

function set_lang(lang){ // Функция чтобы установить язык
    var date = new Date();
    date.setTime(date.getTime() + (30*24*60*60*1000));
    var expires = "expires="+ date.toUTCString();
    document.cookie = "langfr=" + lang + "; " + expires;
   /* alert(get_lang('langfr')); */
   
   window.location.reload(); // Перезагружаем, чтоб установить язык
   
}

 function get_lang(cname) { // Вспомогательная функция, чтобы получить куку 
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

</script>

</head>


<?php 

$lang_vars = array(
                    'detailed_regging' => array('Подробная регистрация','Detailed regging'),
                    'main' => array('<<< Главная','<<< Main'),
                    'nick' => array('Ник: ','Nick: '),
                    'nick_pattern' => array('[a-z A-Z а-я А-Я кроме ё _ ] {2-20 symbols}','[a-z A-Z а-я А-Я except ё _ ] {2-20 symbols}'),
                    'password' => array('Пароль: ','Password: '),
                    'password_again' => array('Пароль еще раз: ','Password confirm: '),
                    'password_pattern' => array('{6-20 символов}','{6-20 symbols}'),
                    'show_pass' => array('Показать','Show'),
                    'ava' => array('Ава: ','Ava: '),
                    'kakcha_against_evil_people' => array('Какча против злых людей: ','Kakcha against evil people: '),
                    'is_it_right' => array('Выражение верно?','Is it right?'),
                    'yes' => array('Да','Yep'),
                    'no' => array('Нет','Nope'),
                    'required' => array(' &mdash; обязательно для заполнения',' &mdash; required')
                    );

?>

<body onload = "fucking_quotes();">

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

<input type = "hidden" id = "is_empty_canvas" value = "true" />        
<main>
       <p id = "errors"></p>
	<h2><?php echo $lang_vars['detailed_regging'][$lang_choose]; ?></h2>
	<div id = "languages_container">
            
            <img id = "russia_flag_img" title = "Русский" src = "imgs/russia_flag.png" onclick = "set_lang('ru')">
            <img id = "england_flag_img" title = "English" src = "imgs/england_flag.png" onclick = "set_lang('en')">
    <!--  <button type = "button" onclick = "alert(get_lang('langfr'))"> Check lang </button> -->
    </div>  
	<a href = "index.php"><?php echo $lang_vars['main'][$lang_choose]; ?></a>
	<form id = "form" action = "handlers/user_registration_handler.php" onsubmit = "return check_form()" enctype="multipart/form-data" method = "POST">
    <table>
    <tbody>
        <tr>
            <td><?php echo $lang_vars['nick'][$lang_choose]; ?><span class = "required">*</span></td>
            <td><input type = "text" name = "nick" id = "nick" required = "required" autofocus = "autofocus" pattern = "[A-Za-zйцукенгшщзхъфывапролджэячсмитьбюЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮа-я0-9_]{2,20}" maxlength = "20" tabindex = "1"  onblur = "nick_free();" /></td>
            <td><?php echo $lang_vars['nick_pattern'][$lang_choose]; ?></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td><p id = "server_nick_response"></p>
            </td>
        </tr>
        <tr>
            <td>Email: <span class = "required">*</span></td>
            <td><input style = "color:black" type = "email" name = "email" id = "email" onkeyup="this.value=this.value.replace(/\s/,'');" onblur = "mail_free();" required = "required" tabindex = "2" /></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td><p id = "server_mail_response_holder"></p></td>
        </tr>
        
        <tr>
			<td><?php echo $lang_vars['password'][$lang_choose]; ?> <span class = "required">*</span></td>
			<td><input type = "password" name = "pass" id = "pass" required = "required" tabindex = "3" maxlength = "20"/></td>
			<td></td>
		</tr>
		<tr>
		      <td><?php echo $lang_vars['password_again'][$lang_choose]; ?> <span style = "color:red;">*</span></td>
		      <td><input type = "password" name = "pass_confirm" id = "pass_confirm" required = "required" maxlength = "20" tabindex = "4" /></td>
		      <td><p><?php echo $lang_vars['password_pattern'][$lang_choose]; ?></p>
			  <button type = "button" class="btn btn-primary btn-sm" id = "show_pass_btn" onclick = "show_pass();" ><?php echo $lang_vars['show_pass'][$lang_choose]; ?></button></td>
        </tr>
         <tr>
        <input type = "hidden" name = "MAX_FILE_SIZE" value = "3000000"/>
        <td><?php echo $lang_vars['ava'][$lang_choose]; ?></td>
             <td id = "avatar_for_preview"><span>Максимум 3 Мб</span><br /><input type = "file" name = "avatar" value = "Выберите аву" id = "avatar" accept="image/jpeg,image/png" onchange = "check_file(this);"  />
                 <canvas id = "preview_photo_canvas" style = "margin-top:10px;margin-bottom:-50px"></canvas>
                 <p id = "show_file_info"></p>
                 <p id = "show_file_errors" style = "color:red"></p>
             </td>
            <td></td>
        </tr>
        <tr>
            <td><?php echo $lang_vars['kakcha_against_evil_people'][$lang_choose]; ?></td>
            <td><img src = "captcha/<?php 
header('Content-Type: text/html; charset=utf-8');
$rand_pict = mt_rand(1,9);
echo $rand_pict;
?>.png" id = "first_digit" width = "50" height = "100" /> <img src = "captcha/<?php 
header('Content-Type: text/html; charset=utf-8');
$rand_conv = mt_rand(0,2);

if($rand_conv == 1) echo 'bigger';
else if($rand_conv == 0) echo 'lesser';
else echo 'equall';   
?>.png" id = "conv_op" width = "50" height = "100" /> <img src = "captcha/<?php 
header('Content-Type: text/html; charset=utf-8');
$rand_pict = mt_rand(1,9);
echo $rand_pict;
?>.png" id = "second_digit" width = "50" height = "100" /></td>
            <td>
                <span><?php echo $lang_vars['is_it_right'][$lang_choose]; ?></span><br />
                <input type = "radio" name = "user_answer" id = "user_answer_true" value = "true" checked = "checked"/><?php echo $lang_vars['yes'][$lang_choose]; ?><br />
                <input type = "radio" name = "user_answer" id = "user_answer_false" value = "false"/><?php echo $lang_vars['no'][$lang_choose]; ?>
            </td>
        </tr>    
        <tr>
            <td colspan = "2"><span class = "required">*</span><?php echo $lang_vars['required'][$lang_choose]; ?></td>
        <td></td>
        </tr>
        <tr>
        <td colspan = "3"></td>
        </tr>
        
        <!-- Допольнительная информация -->
        <?php
        
        $lang_vars = array(
                            'additional_info' => array('Дополнительная информация','Additional info'),
                            'capital' => array('Столица: ','Capital: '), 
                            'your_capital' => array('Ваша столица: ','Your capital: '),
                            'berdyansk' => array('Бердянск','Berdyansk'),
                            'azov' => array('Aзов штоля','Azov shtolya'),
                            'shanghai' => array('Шанхай','Shanghai'),
                            'in_village' => array('В деревне','In village'),
                            'kaliningrad' => array('Калининград ёбта!','Kaliningrad yobta!'),
                            'kenigsberg' => array('Кенигсберг блять','Kenigsberg blyat'),
                            'kolhoz' => array('Рыболовецкий колхоз "За Родину", город Светлый','Fishing collective "For Motherland", Light city'),
                            'sex' => array('Пол: ', 'Sex: '),
                            'lob' => array('Лоб', 'Brow'),
                            'dura' => array('Дура', 'Fool-girl'),
                            'poka_ne_skazhu' => array('Пока не скажу', "You don't fucking care it"),
                            'age' => array('Возраст: ', 'Age: '),
                            'let20' => array('Лет 20', '20 years'),
                            '70let' => array('70 лет', '70 years'),
                            'sp' => array('Семейное положение: ', 'Marital status: '),
                            'your_sp' => array('Ваше cемейное положение: ', 'Your marital status: '),
                            'fool_girl_in_stock' => array('Есть дура', 'Fool-girl in stock'),
                            'fool_guy_in_stock' => array('Есть дурак', 'Fool-guy in stock'),
                            'duru_nado' => array('Дуру надо', 'Fool-girl nesessary'),
                            'druga_nado' => array('Друга надо', 'Fool-guy nesessary'),
                            'i_want_nothing' => array('Не хочеца мне ничего', 'I want nothing'),
                            'college' => array('Училище: ', 'College: '),
                            'v_shestom' => array('В шестом', 'At sixth'),
                            'ne_pomnu_nichego' => array('Не помню ничего', 'I remember nothing')
                            );
        
        ?>
        
        <tr>
            <td colspan = "3" style = "color:blue"><?php echo $lang_vars['additional_info'][$lang_choose]; ?></td>
        </tr>
               
        <tr>
            <td><?php echo $lang_vars['capital'][$lang_choose]; ?></td>
            <td>
            <select name = "city" tabindex = "7">
            <option value = "" ><?php echo $lang_vars['your_capital'][$lang_choose]; ?></option>
            <option value = "berdyansk" ><?php echo $lang_vars['berdyansk'][$lang_choose]; ?></option>
            <option value = "azov" ><?php echo $lang_vars['azov'][$lang_choose]; ?></option>
            <option value = "shanhai" ><?php echo $lang_vars['shanghai'][$lang_choose]; ?></option>
            <option value = "v_derevne" ><?php echo $lang_vars['in_village'][$lang_choose]; ?></option>
            <option value = "kaliningrad" ><?php echo $lang_vars['kaliningrad'][$lang_choose]; ?></option>
            <option value = "kenigsberg" ><?php echo $lang_vars['kenigsberg'][$lang_choose]; ?></option>
            <option value = "svetly" ><?php echo $lang_vars['kolhoz'][$lang_choose]; ?></option>
            </select>
            </td>
            <td></td>
        </tr>
        
         <tr>
        <td><?php echo $lang_vars['sex'][$lang_choose]; ?></td>
        <td> 
            <input type = "radio" name = "sex" value = "lob" tabindex = "5"/>&nbsp;<?php echo $lang_vars['lob'][$lang_choose]; ?><br />
            <input type = "radio" name = "sex" value = "dura" tabindex = "6"/>&nbsp;<?php echo $lang_vars['dura'][$lang_choose]; ?><br />
                 <input type = "radio" name = "sex" value = "poka_ne_skazhu" checked = "checked" tabindex = "7"/>&nbsp;<?php echo $lang_vars['poka_ne_skazhu'][$lang_choose]; ?><br />
            </td>
        <td></td>
        </tr>
        
        <tr>
            <td><?php echo $lang_vars['age'][$lang_choose]; ?></td>
            <td>
            <input type = "radio" name = "age" value = "let_20" /><?php echo $lang_vars['let20'][$lang_choose]; ?><br />
            <input type = "radio" name = "age" value = "70_let" /><?php echo $lang_vars['70let'][$lang_choose]; ?>
            </td>
            <td></td>
        </tr>    
        <tr>
            <td><?php echo $lang_vars['sp'][$lang_choose]; ?></td>
            <td>
            <select name = "sp" id = "sp">
                <option value = ""><?php echo $lang_vars['your_sp'][$lang_choose]; ?></option>
                <option value = "est_dura"><?php echo $lang_vars['fool_girl_in_stock'][$lang_choose]; ?></option>
                <option value = "est_durak"><?php echo $lang_vars['fool_guy_in_stock'][$lang_choose]; ?></option>
                <option value = "duru_nado"><?php echo $lang_vars['duru_nado'][$lang_choose]; ?></option>
                <option value = "druga_nado"><?php echo $lang_vars['druga_nado'][$lang_choose]; ?></option>
                <option value = "ne_hochetsa"><?php echo $lang_vars['i_want_nothing'][$lang_choose]; ?></option>
            </select>    
            </td>
            <td></td>
        </tr>    
        <tr>
            <td><?php echo $lang_vars['college'][$lang_choose]; ?></td>
            <td>
            <input type = "radio" name = "education" value = "v_shestom" tabindex = "8" />&nbsp;<?php echo $lang_vars['v_shestom'][$lang_choose]; ?><br />
            <input type = "radio" name = "education" value = "ne_pomnu" tabindex = "9" />&nbsp;<?php echo $lang_vars['ne_pomnu_nichego'][$lang_choose]; ?><br />
            </td>
            <td></td>
        </tr>
        
        <?php 
        
        $lang_vars = array(
                                'life_position' => array('Жизненная позиция: ','Life attitude: '),
                                'your_life_style' => array('Ваша жизненная позиция: ','Your life style: '),
                                'bratishka' => array('Братишка','Bro guy'),
                                'poehavshy' => array('Поехавший','Outheaded'),
                                'kapitan' => array('товарищ Капитан','comrade Captain'),
                                'polkovnik' => array('Полковник','Colonel'),
                                'stepan_grozny' => array('Степан Грозный','Stepan Grozny'),
                                'chapaev' => array('Чапаев','Chapaev'),
                                'admiral_yamamoto' => array('адмирал Ямамото','admiral Yamamoto'),
                                'some_guys' => array('Некоторые ребята','Some guys'),
                                'zadornov' => array('Задорнов нахуй!','Zadornov nahui!'),
                                'good_guy' => array('Хороший парень','Good guy'),
                                'zlie_ludi' => array('Злые люди','Evil people'),
                                'fufel' => array('Фуфел','Fufel'),
                                'pidr' => array('Пидр','Fag'),
                                'leitenant_pidaras' => array('Лейтенант-пидарас','Leitenant-fag'),
                                'mychalkin' => array('Мычалкин','Mychalkin'),
                                'lesovichek' => array('Лесовичок','Woodguy'),
                                'hirurg' => array('Хирург','Surgeon'),
                                'golova' => array('Голова','Head'),
                                'mat_to' => array('Мать то','Mother to')
                                );
        ?>
        
        
        <tr>
            <td><?php echo $lang_vars['life_position'][$lang_choose]; ?></td>
            <td>
            <select name = "lifestyle" id = "select" tabindex = "10">
            <option value = "" ><?php echo $lang_vars['your_life_style'][$lang_choose]; ?></option>
            <option value = "bratishka"><?php echo $lang_vars['bratishka'][$lang_choose]; ?></option>
            <option value = "poehavshy"><?php echo $lang_vars['poehavshy'][$lang_choose]; ?></option>
            <option value = "tov_kapitan"><?php echo $lang_vars['kapitan'][$lang_choose]; ?></option>
            <option value = "polkovnik"><?php echo $lang_vars['polkovnik'][$lang_choose]; ?></option>
            <option value = "stepan_grozny"><?php echo $lang_vars['stepan_grozny'][$lang_choose]; ?></option>
            <option value = "chapaev"><?php echo $lang_vars['chapaev'][$lang_choose]; ?></option>
            <option value = "admiral_yamamoto"><?php echo $lang_vars['admiral_yamamoto'][$lang_choose]; ?></option>
            <option value = "rebyata"><?php echo $lang_vars['some_guys'][$lang_choose]; ?></option>
            <option value = "zadornov"><?php echo $lang_vars['zadornov'][$lang_choose]; ?></option>
			<option value = "hor_paren"><?php echo $lang_vars['good_guy'][$lang_choose]; ?></option>
			<option value = "zl_ludi"><?php echo $lang_vars['zlie_ludi'][$lang_choose]; ?></option>
			<option value = "fufel"><?php echo $lang_vars['fufel'][$lang_choose]; ?></option>
			<option value = "pidr"><?php echo $lang_vars['pidr'][$lang_choose]; ?></option>
			<option value = "leitenant-pidaras"><?php echo $lang_vars['leitenant_pidaras'][$lang_choose]; ?></option>
			<option value = "michalkin"><?php echo $lang_vars['mychalkin'][$lang_choose]; ?></option>
			<option value = "lesovicheck"><?php echo $lang_vars['lesovichek'][$lang_choose]; ?></option>
			<option value = "hirurg"><?php echo $lang_vars['hirurg'][$lang_choose]; ?></option>
            <option value = "golova"><?php echo $lang_vars['golova'][$lang_choose]; ?></option>
            <option value = "mat"><?php echo $lang_vars['mat_to'][$lang_choose]; ?></option>
            </select>
            </td>
            <td></td>
        </tr>
        <tr>
            
        <?php 
        
        $lang_vars = array(
                            'body_type' => array('Телосложение:', 'Body type:'),
                            'your_body_type' => array('Ваше телосложение: ', 'Your body type: '),
                            'buivol' => array('Буйвол', 'Buffalo'),
                            'los' => array('Лось', 'Elk'),  
                            'svini' => array('Свиньи', 'Pigs'),    
                            'kaban' => array('Кабан', 'Boar'),
                            'pelmen' => array('Пельмень', 'Dumpling'),
                            'tiger' => array('Тигр', 'Tiger'),   
                            'orel' => array('Орел', 'Eagle'),
                            'tsaplya' => array('Цапля', 'Heron'),
                            'cherv' => array('Червь', 'Worm')   
                           );
        
        ?>    
            
            <td><?php echo $lang_vars['body_type'][$lang_choose]; ?></td>
            <td>
            <select name = "body" id = "body" tabindex = "11">
            <option value = "" ><?php echo $lang_vars['your_body_type'][$lang_choose]; ?></option>
            <option value = "buivol"><?php echo $lang_vars['buivol'][$lang_choose]; ?></option>
            <option value = "los"><?php echo $lang_vars['los'][$lang_choose]; ?></option>
            <option value = "svini"><?php echo $lang_vars['svini'][$lang_choose]; ?></option>
            <option value = "kaban"><?php echo $lang_vars['kaban'][$lang_choose]; ?></option>
            <option value = "pelmen"><?php echo $lang_vars['pelmen'][$lang_choose]; ?></option>
            <option value = "tigr"><?php echo $lang_vars['tiger'][$lang_choose]; ?></option>
            <option value = "orel"><?php echo $lang_vars['orel'][$lang_choose]; ?></option>
            <option value = "tsaplya"><?php echo $lang_vars['tsaplya'][$lang_choose]; ?></option>
            <option value = "cherv"><?php echo $lang_vars['cherv'][$lang_choose]; ?></option>
            </select>
            </td>
            <td></td>
        </tr>
        <tr>
            
            <?php 
            
                    $lang_vars = array(
                                        'haracter' => array('Характер: ','Temper: '),
                                        'spokoiny' => array('Спокойный такой характер','So calm'),
                                        'zver' => array('Зверь нахуй!','Beast nahui!'),
                                        'religion' => array('Религия: ','Religion: '),
                                        'v_tserkov_hodil' => array('В церковь ходил','I went in church'),
                                        'fehta_mehta' => array('Фехта мехта блять','Fehta mehta blyat'),
                                        'bog_est' => array('Бог есть блять. Азм езмь блять','God exist blyat. Azm esm blyat'),
                                        'ne_zrya_ego_raspyali' => array('Не зря его распяли','He was crucified not in vain'),
                                        'sport' => array('Спортивные увлечения: ','Sport passion: '),
                                        'your_sport' => array('Ваши спортивные увлечения:','Your sport passion:'),
                                        'pushups' => array('ОТЖИМААЮСЬ блять!','PUSHINGUUPS blyat!'),
                                        'taizutsuan' => array('Специальные такие тайзюцьвань','Special so taizutsvan'),
                                        'turnichok' => array("На турничок влезу так 'Оп!'","I'll climb up on bar such 'Hop'"),
                                        'box' => array("Мать то в бокс отвела","Mother took to boxing"),
                                        'favorite_games' => array("Любимые игры: ","Favorite games: "),
                                        'your_favorite_games' => array("Ваши любимые игры: ","Your favorite games: "),
                                        'checkers' => array("Шашки","Checkers"),
                                        'cards' => array("Карты","Cards"),
                                        'i_dont_fucking_care_it' => array("Да похуй вообще бля","I don't fucking care it"),
                                        'oformit' => array("Оформить как надо","Execute properly"),
                                        'clear' => array("Почистить","Clear")
                                        );
            
            ?>
            
            <td><?php echo $lang_vars['haracter'][$lang_choose]; ?></td>
            <td>
            <input type = "radio" name = "temper" value = "spokoiny" tabindex = "8" />&nbsp;<?php echo $lang_vars['spokoiny'][$lang_choose]; ?><br />
            <input type = "radio" name = "temper" value = "zver" tabindex = "9" />&nbsp;<?php echo $lang_vars['zver'][$lang_choose]; ?><br />
			</td>
            <td></td>
        </tr>    
        <tr>
            <td><?php echo $lang_vars['religion'][$lang_choose]; ?></td>
            <td>
            <input type = "radio" name = "religion" value = "v_tserkov_hodil" /><?php echo $lang_vars['v_tserkov_hodil'][$lang_choose]; ?><br />
            <input type = "radio" name = "religion" value = "fehta-mehta" /><?php echo $lang_vars['fehta_mehta'][$lang_choose]; ?><br />
            <input type = "radio" name = "religion" value = "bog_est" /><?php echo $lang_vars['bog_est'][$lang_choose]; ?><br />
             <input type = "radio" name = "religion" value = "ne_zrya_raspyali" /><?php echo $lang_vars['ne_zrya_ego_raspyali'][$lang_choose]; ?><br />
            </td>
            <td></td>
        </tr>    
          <tr>
            <td><?php echo $lang_vars['sport'][$lang_choose]; ?></td>
            <td>
        <select name = "sport" id = "body" tabindex = "11">
            <option value = "" ><?php echo $lang_vars['your_sport'][$lang_choose]; ?></option>
            <option value = "otzhimayus"><?php echo $lang_vars['pushups'][$lang_choose]; ?></option>
            <option value = "gimnastika"><?php echo $lang_vars['taizutsuan'][$lang_choose]; ?></option>
            <option value = "turnichok"><?php echo $lang_vars['turnichok'][$lang_choose]; ?></option>
            <option value = "box"><?php echo $lang_vars['box'][$lang_choose]; ?></option>
        </select>
            </td>
            <td></td>
        </tr>  
        
        <tr>
            <td><?php echo $lang_vars['favorite_games'][$lang_choose]; ?></td>
            <td>
        <select name = "games" id = "games" tabindex = "12">
            <option value = "" ><?php echo $lang_vars['your_favorite_games'][$lang_choose]; ?></option>
            <option value = "checkers"><?php echo $lang_vars['checkers'][$lang_choose]; ?></option>
            <option value = "cards"><?php echo $lang_vars['cards'][$lang_choose]; ?></option>
            <option value = "pohui"><?php echo $lang_vars['i_dont_fucking_care_it'][$lang_choose]; ?></option>
        </select>
            </td>
            <td></td>
        </tr>  
        
        <tr>
            <td><button type = "submit" class="btn btn-success" id = "form_submit_button"><?php echo $lang_vars['oformit'][$lang_choose]; ?></button></td>
            <td><button type = "reset" id = "form_reset" class="btn btn-warning" style = "color:black"><?php echo $lang_vars['clear'][$lang_choose]; ?></button></td>
            <td></td>
        </tr>
   
    </tbody>
    </table>
      
	</form>
  
    </main>
 <script>
/**
ВСПОМОГАТЕЛЬНЫЕ ФУНКЦИИ
**/   
   //Показываем пароль    
    var isHidden = true; //Состояние скрытости пароля. Изначально скрыт  
	
	<?php
	
	$lang_vars = array(
	                    'hide_pass' => array('Скрыть','Hide'),
	                    'show_pass' => array('Показать','Show')
	                    );
	
	?>
	
	function show_pass(){
    var pass = document.getElementById("pass"); //Первое поле
	var pass_confirm = document.getElementById("pass_confirm"); //Второе поле
	if(pass.value.length === 0 && pass_confirm.value.length === 0) return;
	if(isHidden){ // Если скрыто
	pass.type = "text";
	pass_confirm.type = "text";
    isHidden = false; //Уже не скрыто
	show_pass_btn.innerHTML = "<?php echo $lang_vars['hide_pass'][$lang_choose]; ?>";
	}else { // Если не скрыто
	pass.type = "password";
	pass_confirm.type = "password";
    isHidden = true; //Уже скрыто
	show_pass_btn.innerHTML = "<?php echo $lang_vars['show_pass'][$lang_choose]; ?>";
	}
}
	
/*	function check_mail_pattern(email){ // Проверяем правильность ввода почты
		if(email.match(/^([a-z0-9_-]+\.)*[a-z0-9_-.]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/g) !== null) return true;
		else return false;
	} */
	
var server_response_nick_holder = document.getElementById("server_nick_response");
var nick = document.getElementById("nick");     
function nick_free(){ //Проверяем существование ника. Функция для отправки формы
var xmlhttp = new XMLHttpRequest(); //Создаём запрос

xmlhttp.onreadystatechange = function(){ // Получаем ответ сервера
if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
resp_to_json(xmlhttp.response); // Преобразуем ответ сервера в JSON объект и отображаем его в демо
}
} 

xmlhttp.open("GET", "handlers/check_nick.php?nick_to_find=" +  nick.value, true); //Открываем соединение
xmlhttp.send(); //Посылаем запрос обработчику

function resp_to_json(response){ // Функция для обработки ответа сервера. Возвращает JSON - объект
var json_obj = JSON.parse(response); // Преобразовываем ответ сервера в JSON объект
if(json_obj.server_response === "Ник занят" || json_obj.server_response === "Поле для ника пусто" || json_obj.server_response === "Ник не может состоять из одного символа" || json_obj.server_response === "Формат ника не прошел проверку" ){
server_response_nick_holder.style.color = "red";
} else server_response_nick_holder.style.color = "yellow";

if(get_lang('langfr') === 'en'){
    switch(json_obj.server_response){
        case "Ник занят": json_obj.server_response = "Reserved"; break;
        case "Поле для ника пусто": json_obj.server_response = "Empty nick field"; break;
        case "Ник не может состоять из одного символа": json_obj.server_response = "Nick length can't be equal to one symbol"; break;
        case "Формат ника не прошел проверку": json_obj.server_response = "Wrong nick format"; break;
        case "Ник свободен": json_obj.server_response = "Free"; break;
    }
}

server_response_nick_holder.innerHTML = json_obj.server_response;
console.log(json_obj.server_response);
}

}

var server_mail_response_holder = document.getElementById("server_mail_response_holder");
var mail = document.getElementById("email");
function mail_free(){ //Проверяем существование почты. Функция для отправки формы
var xmlhttp = new XMLHttpRequest(); //Создаём запрос
xmlhttp.onreadystatechange = function(){ // Получаем ответ сервера

if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
resp_to_json(xmlhttp.response); // Преобразуем ответ сервера в JSON объект и отображаем его в демо

}
} 

xmlhttp.open("GET", "handlers/check_mail.php?mail_to_find=" +  mail.value, true); //Открываем соединение
xmlhttp.send(); //Посылаем запрос обработчику

function resp_to_json(response){ // Функция для обработки ответа сервера. Возвращает JSON - объект
var json_obj = JSON.parse(response); // Преобразовываем ответ сервера в JSON объект
if(json_obj.server_response === "Поле для почты пусто" || json_obj.server_response === "Почта занята" ){
server_mail_response_holder.style.color = "red";
} else server_mail_response_holder.style.color = "yellow";

if(get_lang('langfr') === 'en'){
    switch(json_obj.server_response){
        case "Почта занята": json_obj.server_response = "Reserved"; break;
        case "Поле для почты пусто": json_obj.server_response = "Empty email field"; break;
        case "Почта свободна": json_obj.server_response = "Free"; break;
    }
}

server_mail_response_holder.innerHTML = json_obj.server_response;
console.log(json_obj.server_response);
}

}     

 var show_file_errors = document.getElementById("show_file_errors"); // Показываем ошибки     
 
 function check_file(file){
    var form = document.getElementById("form");
    var avatar_for_preview = document.getElementById("avatar_for_preview");
    var preview_photo_canvas = document.getElementById("preview_photo_canvas");
    var is_empty_canvas = document.getElementById("is_empty_canvas");
var ctx_canvas = preview_photo_canvas.getContext('2d');
    var avatar = document.getElementById("avatar").files[0]; //Файл для авы
    var show_file_info = document.getElementById("show_file_info"); //Показываем свойства файла
    var txt_file_info = "";
    
    
/************************************/    
    var name_tr = "Имя: ";
    var size_tr = "Размер: ";
    var type_tr = "Тип: ";
    var mb_tr = "Мб<br />";
    var wrong_ava_format = "Данный формат авы не поддерживается <br />";
    var wrong_ava_size = "Размер файла должен быть <= 3 Мб <br />";
    
    if(get_lang('langfr') === 'en'){
    
     name_tr = "Name: ";
     size_tr = "Size: ";
     type_tr = "Type: ";
     mb_tr = "Mb<br />";
     wrong_ava_format = "Wrong ava format <br />";
     wrong_ava_size = "Ava size should be <= 3 Mb";    
        
    }
    
/*************************************/    
    
    txt_file_info += name_tr + avatar.name + "<br />";
    txt_file_info += size_tr + Math.ceil(((avatar.size/1024)/1024) * 10) / 10 + mb_tr;
    txt_file_info += type_tr + avatar.type + "<br />"; 
    show_file_info.innerHTML = txt_file_info; 
    
    var accept = ["image/jpeg","image/png"]; // Список поддерживаемых файлов
    var txt_file_errors = "";
    if(accept.indexOf(avatar.type) == -1){
    txt_file_errors = wrong_ava_format;
    }else if(avatar.size > 3000000){
    txt_file_errors = wrong_ava_size;
    }
    
    if(txt_file_errors === ""){
      var image_obj = new Image();    
    var imageUrl = URL.createObjectURL(file.files[0]);    
    image_obj.src = imageUrl;
    image_obj.weight = 100;
    image_obj.height = 100;
    
    if(is_empty_canvas.value === "true"){ // Канва пустая
  
    image_obj.onload = function(){
   URL.revokeObjectURL(imageUrl);	
ctx_canvas.drawImage(image_obj, 0, 0, 100, 100);
        }
is_empty_canvas.value = "false";    
        
    }else {
ctx_canvas.fillStyle = "#838B83";    
ctx_canvas.fillRect(0,0,100,100);
 image_obj.onload = function(){
   URL.revokeObjectURL(imageUrl);	
ctx_canvas.drawImage(image_obj, 0, 0, 100, 100);
        }  
is_empty_canvas.value = "false";        
    
}
}
show_file_errors.innerHTML = txt_file_errors; 
return true;
 }     

/* КАПЧА */
function captcha(){    
/* Вспомогательные переменные */
var first_digit_tmp = document.getElementById("first_digit");
var second_digit_tmp = document.getElementById("second_digit");
var conv_op_tmp = document.getElementById("conv_op");
var user_answer = document.getElementsByName('user_answer');

/* Основные переменные */    
var first_digit = parseInt(first_digit_tmp.src.slice(-5,-4)); // Первая цифра
var second_digit = parseInt(second_digit_tmp.src.slice(-5,-4)); // Вторая цифра
var conv_op = conv_op_tmp.src.slice(-10,-9); // Сравнение цифр. 'b' -- больше, 'l' -- меньше 'e' -- равно
var user_answer_value = ""; // Ответ пользователя  
var submit_form = true; //Флаг отправки формы      

for(var i = 0; i < user_answer.length; i++){ // Получаем значение активной радиокнопки
    if(user_answer[i].checked){
    user_answer_value = user_answer[i].value;    
        }
}

// ЗНАК БОЛЬШЕ
    if(conv_op === 'b'){ 
    if((first_digit > second_digit) && (user_answer_value === "true")){ //Первая цифра больше второй и пользователь ответил 'Да'
    console.log("Первая цифра больше второй и пользователь ответил 'Да'. Отправляем форму");
    } else if((first_digit > second_digit) && (user_answer_value === "false")){ //Первая цифра больше второй и пользователь ответил 'Нет'
    submit_form = false; // Не отправляем форму
    console.log("Первая цифра больше второй и пользователь ответил 'Нет'. НЕ отправляем форму");
    } else if((first_digit < second_digit) && (user_answer_value === "true")){ //Первая цифра меньше второй и пользователь ответил 'Да'
      submit_form = false; // Не отправляем форму
      console.log("Первая цифра меньше второй и пользователь ответил 'Да'. НЕ отправляем форму");
    } else if((first_digit < second_digit) && (user_answer_value === "false")){ // Первая цифра меньше второй и пользователь ответил 'Нет'
    console.log("Первая цифра меньше второй и пользователь ответил 'Нет'. Отправляем форму");
    } else if((first_digit == second_digit) && (user_answer_value === "false")){ //Первая цифра равна второй и пользователь ответил 'Нет'
        console.log("Первая цифра равна второй и пользователь ответил 'Нет'. Отправляем форму");
    } else if((first_digit == second_digit) && (user_answer_value === "true")){ //Первая цифра равна второй и пользователь ответил 'Нет'
      submit_form = false; // Не отправляем форму
      console.log("Первая цифра равна второй и пользователь ответил 'Да'. НЕ отправляем форму");
    }
    } 
    
    //ЗНАК МЕНЬШЕ
    else if(conv_op === 'l'){ 
if((first_digit < second_digit) && (user_answer_value === "true")){ //Первая цифра меньше второй и пользователь ответил 'Да'
    console.log("Первая цифра меньше второй и пользователь ответил 'Да'. Отправляем форму");
    } else if((first_digit < second_digit) && (user_answer_value === "false")){ //Первая цифра больше второй и пользователь ответил 'Нет'
    submit_form = false; // Не отправляем форму
    console.log("Первая цифра меньше второй и пользователь ответил 'Нет'. НЕ отправляем форму");
    } else if((first_digit > second_digit) && (user_answer_value === "true")){ //Первая цифра больше второй и пользователь ответил 'Да'
      submit_form = false; // Не отправляем форму
      console.log("Первая цифра больше второй и пользователь ответил 'Да'. НЕ отправляем форму");
    } else if((first_digit > second_digit) && (user_answer_value === "false")){ // Первая цифра больше второй и пользователь ответил 'Нет'
    console.log("Первая цифра меньше второй и пользователь ответил 'Нет'. Отправляем форму");
        }else if((first_digit == second_digit) && (user_answer_value === "false")){ //Первая цифра равна второй и пользователь ответил 'Нет'
        console.log("Первая цифра равна второй и пользователь ответил 'Нет'. Отправляем форму");
    } else if((first_digit == second_digit) && (user_answer_value === "true")){ //Первая цифра равна второй и пользователь ответил 'Нет'
      submit_form = false; // Не отправляем форму
      console.log("Первая цифра равна второй и пользователь ответил 'Да'. НЕ отправляем форму");
    } 
    }
    
    // ЗНАК РАВНО
    else if(conv_op === 'e'){ 
if((first_digit == second_digit) && (user_answer_value === "true")){ // Цифры равны и пользователь ответил 'Да'
console.log("Цифры равны и пользователь ответил 'Да'. Отправляем форму");
}else if((first_digit == second_digit) && (user_answer_value === "false")){ // Цифры равны и пользователь ответил 'Нет'
submit_form = false; // Не отправляем форму
  console.log("Цифры  равны и пользователь ответил 'Нет'. НЕ отправляем форму");
}
 else if((first_digit !== second_digit) && (user_answer_value === "false")){ // Цифры НЕ равны и пользователь ответил 'Нет'
    console.log("Цифры НЕ равны и пользователь ответил 'Нет'. Отправляем форму");
}else if((first_digit !== second_digit) && (user_answer_value === "true")){ // Цифры НЕ равны и пользователь ответил 'Да'
submit_form = false; // Не отправляем форму
console.log("Цифры НЕ равны и пользователь ответил 'Да'. НЕ отправляем форму");
}

} // Конец знак равно

return submit_form;    
} //Конец функции     

/**
ГЛАВНАЯ ФУНКЦИЯ.
Валидация формы.
**/
	function check_form(){ 
    var submit_form_flag = true; // Главный флаг отправки формы
    var pass = document.getElementById("pass");	
	var pass_confirm = document.getElementById("pass_confirm");
	var error_list = document.getElementById("errors");

        
	var txt = ""; // Переменная для хранения ошибок
/*	var email_pattern = document.getElementById("email");
   	if(check_mail_pattern(email_pattern.value) !== true) { // Если почта НЕ соответствует паттерну

        var invalid_email_format = "Формат почты не прошел проверку<br />";  
          
        if(get_lang('langfr') === 'en'){
            
            invalid_email_format = "Invalid email format<br />";
            
            }

	txt += invalid_email_format;
	submit_form_flag = false;
	console.log("Формат почты не соответствует паттерну");
    }else {
	console.log("Паттерн почты  прошел проверку"); 
	} */
			
	if(pass.value !== pass_confirm.value){ //Проверка первого и второго пароля
	submit_form_flag = false;
 
	var passwords_not_equal = "Пароли не совпадают<br />";  
          
        if(get_lang('langfr') === 'en'){
            
            passwords_not_equal = "Passwords isn't identical<br />";
            
        }
	
	txt += passwords_not_equal;
   console.log("Пароли не совпадают"); 
	} else {
	console.log("Проверка паролей прошла успешно");
	}
	
	if(pass.value.length < 6){
	
	var password_length = "Длина пароля должна быть >=6 символов<br />";  
          
        if(get_lang('langfr') === 'en'){
            
            password_length = "Password length should be >=6  symbols<br />";
            
        }
	
	txt += password_length;
	submit_form_flag = false;
	} else {
	console.log("Длина пароля норм");	
	}
    
    if(server_response_nick_holder.innerHTML === "Ник занят" || server_response_nick_holder.innerHTML === "Reserved"){
        
        var nick_var = "";
        
        if(server_response_nick_holder.innerHTML === "Reserved"){
            nick_var = " nick";
        }
        
        txt += server_response_nick_holder.innerHTML + nick_var + "<br />";
        submit_form_flag = false;
    } else if(server_response_nick_holder.innerHTML === "Поле для ника пусто" || server_response_nick_holder.innerHTML === "Empty nick field" ){
        txt += server_response_nick_holder.innerHTML + "<br />";
        submit_form_flag = false;
    }else if(server_response_nick_holder.innerHTML === "Ник не может состоять из одного символа" || server_response_nick_holder.innerHTML  === "Nick length can't be equal to one symbol"){
        txt += server_response_nick_holder.innerHTML + "<br />";
        submit_form_flag = false;
    }else if(server_response_nick_holder.innerHTML === "Формат ника не прошел проверку" || server_response_nick_holder.innerHTML === "Wrong nick format" ){
        txt += server_response_nick_holder.innerHTML + "<br />";
        submit_form_flag = false;
    }
    
    switch (server_mail_response_holder.innerHTML){
    case "Поле для почты пусто": 
            txt += "Поле для почты пусто<br />";
            submit_form_flag = false;
            console.log("Поле для почты пусто");
            break;
    case "Empty email field": 
            txt += "Empty email field<br />";
            submit_form_flag = false;
            console.log("Поле для почты пусто");
            break;
            
   /* case "Формат почты не прошел проверку": 
            txt += "Формат почты не прошел проверку<br />";
            submit_form_flag = false;
            console.log("Формат почты не прошел проверку");
            break; */
    case "Почта занята": 
            txt += "Почта занята<br />";
            submit_form_flag = false;
            console.log("Почта занята");
            break;
     case "Reserved": 
            txt += "Reserved mail<br />";
            submit_form_flag = false;
            console.log("Почта занята");
            break;        
    }
      
    if(!captcha()){ // Каптча введена неправильно
    submit_form_flag = false;
    
    var unknown_kakcha_answer = "Неправильный ответ на вопрос с какчи<br />";  
          
            if(get_lang('langfr') === 'en'){
            
                unknown_kakcha_answer = "Wrong kakcha response<br />";
        
            }
    
    txt += unknown_kakcha_answer;   
    }
        
    if(show_file_errors.innerHTML !== ""){ //Если что-то есть ошибках файла
    txt += show_file_errors.innerHTML;
    submit_form_flag = false;
    console.log(show_file_errors.innerHTML);
    }    
    
    error_list.innerHTML = txt;
	
	return submit_form_flag;
	}
           
    </script>  
    </body>
    
    
    
</html>
