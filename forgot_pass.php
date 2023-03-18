<!DOCTYPE html>

<html>
<head>    
    <title>Восстановление пароля</title>
<meta charset='utf-8' />
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

table {
    border-collapse:separate;
    border-spacing: 7px 5px;
    }    
td {
color:black;
width:60px;
}  

#restore_pass_button {
    cursor: pointer; 
    display:inline-block;
    background-color:blue;
    color:white;
    padding:5px;
    border-radius:5px;
}

#restore_pass_button:hover {
    box-shadow:0 0 10px rgba(0,0,0,0.5);
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
    
    <h3 style = "color: blue">Забыли пароль нахуй!</h3>
    <p>Еще раз пароль забываешь -- по ебалу получаешь нахуй</p>
    <p>Если зарегался через соцсети, то спроси пароль у Паши Дурова или Марка Цукенберга</p>
    <p>Если зарегался на <a href="https://frendors.com">frendors.com</a>, то восстанавливай хули</p>
    <form id = "restore_pass_form" name = "restore_pass_form">
<table>
    <tr>
        <td>Nickname:</td> 
        <td><input style = "color:black" type = "text"  id = "login" required = "required" /></td>
    </tr>
        <tr>
        <td>Email:</td> 
            <td><input style = "color:black" type = "email" id = "email" required = "required"/></td>
        </tr>    
</table>
<div type = "button" id = "restore_pass_button" onclick = "restore_pass();">Recover</div><br />  
</form>
  
    
    <p style = "color:yellow" id = "server_response"></p>
    <p style = "color:red;display:block; margin-top:0" id = "errors"></p>
   
</main>          
<script>
var login = document.getElementById("login");
var email = document.getElementById("email");
var pattern_id = "/\d/g";    
var submit_form = true;
var show_errors = document.getElementById("errors");
var server_response = document.getElementById("server_response");
var restore_pass_form = document.getElementById("restore_pass_form");

function restore_pass(){
var txt_count = "";        
    if(login.value === "" || login === null ){
    submit_form = false;
    txt_count += "Введите логин<br />";
    }

if(email.value === "" || email === null ){
    submit_form = false;
    txt_count += "Введите email<br />";
    }

show_errors.innerHTML = txt_count;    

if(submit_form == true){
  
var xmlhttp = new XMLHttpRequest();

xmlhttp.onreadystatechange = function() {
if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
restore_pass_form.style.display = "none";
server_response.innerHTML = xmlhttp.response;
    } 
}    

var formData = new FormData();
formData.append('login', login.value);
formData.append('email', email.value);

xmlhttp.open("POST","handlers/forgot_pass_handler.php",true)
xmlhttp.send(formData);
}
    
}
</script>    
</body>    
    
</html>    