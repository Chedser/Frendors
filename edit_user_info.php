
<?php
ob_start();
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';

$login = $_SESSION['user'];

if(empty($login)){
header('Location:' . $_SERVER['DOCUMENT_ROOT'] . '/index.php');
exit();
}

$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();

?>

<!DOCTYPE html>
<html>
<head>
<title>Редактируем инфу</title>
<meta charset = "utf-8"/>
<link rel = "stylesheet" href = "../css/normalize.css"  type = "text/css" />    

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
width: 1000px;
   background-color:#79C753;
    margin:0 auto;
    height:100%;
    width: 70%;    
    padding: 10px;   
}

table {
    position:absolute;
    top:30%;
    left:30%;    
    border-collapse:separate; 
    border-spacing: 0px 3px;
    border:1px solid blue;
    padding: 10px;    
    
    }

td {
width: 270px;
color:white;    
}
    
td:nth-child(1) {
width:200px;
}    
      
</style>    

<script>
function fucking_quotes(){
var nick = document.getElementById("pseudonik");
nick.onkeyup = function(){
    this.value=this.value.replace(/["]/,'');
    this.value=this.value.replace(/[\s_-]/,'');
    this.value=this.value.replace(/[&ёЁ%=+*.?~`!@#№$;%:^?|]/,''); 
    this.value=this.value.replace(/[,/<'>\\]/,'');
    this.value=this.value.replace(/[()]/,'');
    }
}
</script>      

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

<form action = "../handlers/edit_user_info_handler.php" method = "POST" onsubmit = "return check_pseudonick('add_nickname')">

           <table> 
 
            <tr>
            <tr><td><a href = "user.php?zs=<?php echo $_SESSION['user']; ?>"> <<< Назад</a></td><td></td><td></td></tr>
            <td> Псевдоник:</td>
            <td><input type = "text" id = "pseudonik" name = "add_nickname" maxlength = "30" style = "color:black;" size = "30" pattern = "[A-Za-zА-Яа-я0-9]{2,30}"></td>
            <td>— от 2-х до 20-ти символов. Русские(кроме ё) и английские буквы, цифры</td>
            </tr>    
            
            <tr>
            <td>Столица:</td>
            <td>
            <select name = "city" style = "color:black" tabindex = "7">
            <option value = "" style = "color:black" >Ваша столица:</option>
            <option value = "berdyansk" >Бердянск</option>
            <option value = "azov" >Азов штоля</option>
            <option value = "shanhai" >Шанхай</option>
            <option value = "v_derevne" >В деревне</option>
            <option value = "kaliningrad" >Калининград епта!</option>
            <option value = "kenigsberg" >Кенигсберг блять</option>
            <option value = "svetly" >Рыболовецкий колхоз "За родину".Город Светлый</option>
            </select>
            </td><td></td>
        </tr>
    
     <tr>
        <td>Пол:</td>
        <td> 
            <input type = "radio" name = "sex" value = "lob" tabindex = "5"/>&nbsp;Лоб<br />
            <input type = "radio" name = "sex" value = "dura" tabindex = "6"/>&nbsp;Дура<br />
            <input type = "radio" name = "sex" value = "poka_ne_skazhu" tabindex = "7"/>&nbsp;Пока не скажу<br />
            </td><td></td>
    </tr>
    
    <tr>
            <td>Возраст: </td>
            <td>
            <input type = "radio" name = "age" value = "let_20" />Лет 20<br />
            <input type = "radio" name = "age" value = "70_let" />70 лет
            </td><td></td>
            </tr>    
        <tr>
            <td>Семейное положение:</td>
            <td>
            <select name = "sp" id = "sp" style = "color:black">
                <option value = "">Ваше семейное положение:</option>
                <option value = "est_dura">Есть дура</option>
                <option value = "est_durak">Есть дурак</option>
                <option value = "duru_nado">Дуру надо</option>
                <option value = "druga_nado">Друга надо</option>
                <option value = "ne_hochetsya">Не хочеца мне ничего</option>
            </select>    
            </td><td></td>
        
        </tr>    
        <tr>
            <td>Училище:</td>
            <td>
            <input type = "radio" name = "education" value = "v_shestom"  tabindex = "8" />&nbsp;В шестом<br />
            <input type = "radio" name = "education" value = "ne_pomnu" tabindex = "9" />&nbsp;Не помню ничего<br />
            </td><td></td>
          
        </tr>
        
        <tr>
            <td>Жизненная позиция:</td>
            <td>
            <select name = "lifestyle" id = "select" style = "color:black" tabindex = "10">
            <option value = "" >Ваша жизненная позиция:</option>
            <option value = "bratishka">Братишка</option>
            <option value = "poehavshy">Поехавший</option>
            <option value = "tov_kapitan">товарищ Капитан </option>
            <option value = "polkovnik">Полковник</option>
            <option value = "stepan_grozny">Степан Грозный</option>
            <option value = "chapaev">Чапаев</option>
            <option value = "admiral_yamamoto">Адмирал Ямамото</option>
            <option value = "zadornov">Задорнов нахуй!</option>
			<option value = "hor_paren">Хороший парень</option>
			<option value = "zl_ludi">Злые люди</option>
			<option value = "fufel">Фуфел</option>
			<option value = "pidr">Пидр</option>
			<option value = "leitenant-pidaras">Лейтенант-пидарас</option>
			<option value = "michalkin">Мычалкин</option>
			<option value = "lesovichek">Лесовичок</option>
			<option value = "hirurg">Хирург</option>
            <option value = "golova">Голова</option>
            <option value = "mat">Мать то</option>
            </select>
            </td><td></td>
         
        </tr>
        <tr>
            <td>Телосложение:</td>
            <td>
            <select name = "body" id = "body" style = "color:black" tabindex = "11">
            <option value = "" >Ваше телосложение:</option>
            <option value = "buivol">Буйвол</option>
            <option value = "los">Лось</option>
            <option value = "svini">Свиньи</option>
            <option value = "kaban">Кабан</option>
            <option value = "pelmen">Пельмень</option>
            <option value = "tigr">Тигр</option>
            <option value = "orel">Орел</option>
            <option value = "tsaplya">Цапля</option>
            <option value = "cherv">Червь</option>
            </select>
            </td><td></td>
        
        </tr>
        <tr>
            <td>Характер: </td>
            <td>
            <input type = "radio" name = "temper" value = "spokoiny" tabindex = "8" />&nbsp;Спокойный такой характер<br />
            <input type = "radio" name = "temper" value = "zver" tabindex = "9" />&nbsp;Зверь то<br />
			</td>
        </tr>    
        <tr>
            <td>Религия: </td>
            <td>
            <input type = "radio" name = "religion" value = "v_tserkov_hodil" />В церковь ходил<br />
            <input type = "radio" name = "religion" value = "fehta-mehta" />Фехта мехта, блять<br />
            <input type = "radio" name = "religion" value = "bog_est" />Бог есть, блять. Азм езмь, блять <br />
             <input type = "radio" name = "religion" value = "ne_zrya_raspyali" />Не зря его распяли <br />
            </td>
            </tr>    
         <tr>
            <td>Спортивные увлечения:</td>
            <td>
        <select name = "sport" style = "color:black">
            <option value = "" >Ваши спортивные увлечения:</option>
            <option value = "otzhimayus">ОТЖИМАААЮСЬ, блять!</option>
            <option value = "gimnastika">Специальные такие тайзюцьвань</option>
            <option value = "turnichok">На турничок влезу так "Оп!"</option>
            <option value = "box">Мать то в бокс отвела</option>
        </select>
            </td>
            <td></td>
        </tr>
        
         <tr class = "not_required_raw">
            <td>Любимые игры:</td>
            <td>
        <select name = "games" id = "games" style = "color:black;">
            <option value = "" >Ваши любимые игры:</option>
            <option value = "checkers">Шашки</option>
            <option value = "cards">Карты</option>
            <option value = "pohui">Да похуй вообще бля</option>
        </select>
            </td>
            <td></td>
        </tr>  
        
        <tr>
            <td><button type = "submit" id = "form_submit" style = "color:blue">Сохранить</button></td>
            <td><button type = "button" onclick = "window.history.go(-1)" style = "color:black">Назад</button></td>
</tr>
<tr>
    <td><hr /></td>
    <td><hr /></td>
    <td></td>
</tr>
<tr>
<td style = "font-size:15px">Меняем пароль?</td>
<td ></td> <td></td>   
</tr>
<tr>
    <td>Старый пароль:</td>
    <td><input type = "password" name = "old_pass" id = "old_pass" style = "color:black"></td><td></td>
</tr>
<tr>
    <td>Новый пароль:</td>
    <td><input type = "password" name = "new_pass" id = "new_pass" style = "color:black"></td><td></td>
</tr>
<tr>
    <td><button type = "button" onclick = "change_pass()" id = "new_pass" style = "color:blue" >Изменить</button></td><td></td>
</tr>
<tr>
    <td id = "errors"></td>
    <td></td><td></td>
</tr>    
</table>  
</form>

<script type = "text/javascript">    

var old_pass = document.getElementById("old_pass");
var new_pass = document.getElementById("new_pass");
var errors = document.getElementById("errors");    
var nickname = "<?php echo htmlspecialchars($_SESSION['user']); ?>";   

function change_pass(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
    var json_obj = JSON.parse(xmlhttp.response);    
    errors.innerHTML = json_obj.server_response;
        if(json_obj.server_response === "Укажите старый пароль" || json_obj.server_response === "Старый пароль указан неверно" || json_obj.server_response === "Укажите новый пароль"  || json_obj.server_response === "Длина пароля должна быть >= 6 символов" || json_obj.server_response === "Нахуя его менять то?"){
                errors.style.color = "red";
                } else {
                errors.style.color = "green";
                old_pass.value = "";
                new_pass.value = "";     
                }   
            }
}

xmlhttp.open("GET", "handlers/change_pass.php?old_pass=" + old_pass.value + "&new_pass=" + new_pass.value + "&nickname=" + nickname, true);
xmlhttp.send();
}

function check_pseudonick(pseudonik){
var pseudonick = document.getElementById(pseudonik);    
if(pseudonick.match(/[A-Za-zА-Яа-я0-9]{2,30}/g) === null){
alert("— от 2-х до 30-ти символов. Русские(кроме ё) и английские буквы, цифры.");
return false;    
}
return true;    
}
</script>    
</body>    

</html>
<?php ob_end_flush();   ?>