<?php 
ob_start();
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
error_reporting(E_ALL);

$login = $_GET['zs'];
if(empty($login)){
    header('Location: index.php');
    exit();
}


?>

<!DOCTYPE html>

<html>

<head>
<title>
некоторые ребята
</title>
<meta charset = "utf-8">
<link rel = "stylesheet" src = "css/roboto/roboto.css">
<script src="../bootstrap/js/jquery.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

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
    width: 1000px;
    background-color:#79C753; 
    margin:0 auto;
    height:100%;
    margin-left:200px;
}

main {
    padding: 10px;
    width:2500px;
    position:relative;
    left:70px;
    padding-bottom: 90px;
   
}

#good_people {
    border:1px solid black;
    border-bottom:none;
    border-top:none;
    border-left:1px solid blue;
    width:750px;
    min-height:900px;
    float:left;
}

.people_table thead {
    border-bottom:1px solid black;
}

.people_table thead td:nth-child(5) {
    border-right:none;
}

.people_table thead td {
    border-right:1px solid black;
    padding:3px;
    width:160px;
    text-align:center;
    font-size:18px;
}

.people_table tbody tr td {
    border-right:1px solid black;
}

#evil_people {
     border-bottom:none;
    border-right:1px solid blue;
    width:600px;
    min-height:900px;
    margin-left:750px;
    margin-top:20px;
}

.good_avatar {
  width:100px;
  height:100px;
  display:block;
  margin-bottom:10px;
  position:relative;
  left:25px;
  border-radius:5px;
}

.evil_avatar {
  width:100px;
  height:100px;
  display:block;
  margin-bottom:10px;
  position:relative;
  left:15px;
  border-radius:5px;
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

<?php 
// КОЛИЧЕСТВО ДОБРЫХ ДЕЛ
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection_regards.php';
$connection_handler_regards->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

$sql = "SELECT * FROM `777_bottles` WHERE `page_id`='{$login}'";  
    $query = $connection_handler_regards->prepare($sql);
    $query->execute();
$bottles = $query->fetchAll(PDO::FETCH_ASSOC); 

$sql = "SELECT * FROM `pelmen` WHERE `page_id`='{$login}'";  
    $query = $connection_handler_regards->prepare($sql);
    $query->execute();
$pelmen = $query->fetchAll(PDO::FETCH_ASSOC); 

$sql = "SELECT * FROM `premium` WHERE `page_id`='{$login}'";  
    $query = $connection_handler_regards->prepare($sql);
    $query->execute();
$premium = $query->fetchAll(PDO::FETCH_ASSOC); 

$sql = "SELECT * FROM `leitenant_straps` WHERE `page_id`='{$login}'";  
    $query = $connection_handler_regards->prepare($sql);
    $query->execute();
$leitenant_straps = $query->fetchAll(PDO::FETCH_ASSOC); 

$sql = "SELECT * FROM `traheya` WHERE `page_id`='{$login}'";  
    $query = $connection_handler_regards->prepare($sql);
    $query->execute();
$traheya = $query->fetchAll(PDO::FETCH_ASSOC); 

$good_people_count = count($bottles) + count($pelmen) + count($premium) + count($leitenant_straps) + count($traheya);

$connection_handler_regards = null;

?>

<?php 

$whose_people = "Ваши некоторые ребята";

if($login != $_SESSION['user']){
    $whose_people = "Некоторые ребята пользователя " . $login;    
}

echo "<a href = 'user.php?zs=" . $login . "'> <<< Назад</a>";

echo "<h4 style = 'position:relative;left:500px;color:blue;'>" . $whose_people . "</h4>";

?>
<section id = "good_people">
<h4 style = "text-align:center;border-bottom:1px solid white;padding-bottom:5px;">Хорошие такие да | <?php echo $good_people_count; ?></h4>

<table class = "people_table">
    <thead>
   <tr>
    <td>777 бутылку<br /><?php echo count($bottles); ?></td>
    <td>пельмень<br /><?php echo count($pelmen); ?></td> 
    <td>премия без хуев<br /><?php echo count($premium); ?></td>
    <td>погона лейтенанта<br /><?php echo count($leitenant_straps); ?></td>
    <td>трахея Капитана<br /><?php echo count($traheya); ?></td>
    </tr>    
    </thead>
<tbody>

<tr>

    <td><br />
     <?php 
    
    for($i = 0; $i < count($bottles);$i++){
    
    $sql = "SELECT `avatar` FROM `additional_info` WHERE `nickname`='{$bottles[$i]['clicker']}'";  
    $query = $connection_handler->prepare($sql);
    $query->execute();
$avatar = $query->fetchAll(PDO::FETCH_ASSOC); 
$avatar = $avatar[0]['avatar'];   
    
    echo '<a href = user.php?zs=' . $bottles[$i]['clicker'] . ' title = ' . $bottles[$i]['clicker'] . '><img src = users/' . $avatar . ' class = "good_avatar" /></a>';    
    
    }
    
    ?>
    </td>
    <td><br />
        
     <?php 
    
    for($i = 0; $i < count($pelmen);$i++){
    
    $sql = "SELECT `avatar` FROM `additional_info` WHERE `nickname`='{$pelmen[$i]['clicker']}'";  
    $query = $connection_handler->prepare($sql);
    $query->execute();
$avatar = $query->fetchAll(PDO::FETCH_ASSOC); 
$avatar = $avatar[0]['avatar'];   
    
    echo '<a href = user.php?zs=' . $pelmen[$i]['clicker'] . ' title = ' . $pelmen[$i]['clicker'] . '><img src = users/' . $avatar . ' class = "good_avatar" /></a>';    
    
    }
    
    ?>    
        
    </td> 
    <td><br />
    
     <?php 
    
    for($i = 0; $i < count($premium);$i++){
    
    $sql = "SELECT `avatar` FROM `additional_info` WHERE `nickname`='{$premium[$i]['clicker']}'";  
    $query = $connection_handler->prepare($sql);
    $query->execute();
$avatar = $query->fetchAll(PDO::FETCH_ASSOC); 
$avatar = $avatar[0]['avatar'];   
    
    echo '<a href = user.php?zs=' . $premium[$i]['clicker'] . ' title = ' . $premium[$i]['clicker'] . '><img src = users/' . $avatar . ' class = "good_avatar" /></a>';    
    
    }
    
    ?>    
    
    </td>
    <td><br />
    
    <?php 
    
    for($i = 0; $i < count($leitenant_straps);$i++){
    
    $sql = "SELECT `avatar` FROM `additional_info` WHERE `nickname`='{$leitenant_straps[$i]['clicker']}'";  
    $query = $connection_handler->prepare($sql);
    $query->execute();
$avatar = $query->fetchAll(PDO::FETCH_ASSOC); 
$avatar = $avatar[0]['avatar'];   
    
    echo '<a href = user.php?zs=' . $leitenant_straps[$i]['clicker'] . ' title = ' . $leitenant_straps[$i]['clicker'] . '><img src = users/' . $avatar . ' class = "good_avatar" /></a>';    
    
    }
    
    ?>    
    
    
    </td>
    <td><br />
    
     <?php 
    
    for($i = 0; $i < count($traheya);$i++){
    
    $sql = "SELECT `avatar` FROM `additional_info` WHERE `nickname`='{$traheya[$i]['clicker']}'";  
    $query = $connection_handler->prepare($sql);
    $query->execute();
$avatar = $query->fetchAll(PDO::FETCH_ASSOC); 
$avatar = $avatar[0]['avatar'];   
    
    echo '<a href = user.php?zs=' . $traheya[$i]['clicker'] . ' title = ' . $traheya[$i]['clicker'] . '><img src = users/' . $avatar . ' class = "good_avatar" /></a>';    
    
    }
    
    ?>    
   
    </td>    
</tr>

</tbody>

</table>

</section>

<section id = "evil_people">

<?php 
// КОЛИЧЕСТВО ПЫТОК
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection_tortures.php';
$connection_handler_tortures->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

$sql = "SELECT * FROM `po_dihalke` WHERE `page_id`='{$login}'";  
    $query = $connection_handler_tortures->prepare($sql);
    $query->execute();
$po_dihalke = $query->fetchAll(PDO::FETCH_ASSOC); 

$sql = "SELECT * FROM `po_ebalu` WHERE `page_id`='{$login}'";  
    $query = $connection_handler_tortures->prepare($sql);
    $query->execute();
$po_ebalu = $query->fetchAll(PDO::FETCH_ASSOC); 

$sql = "SELECT * FROM `forks` WHERE `page_id`='{$login}'";  
    $query = $connection_handler_tortures->prepare($sql);
    $query->execute();
$vilka = $query->fetchAll(PDO::FETCH_ASSOC); 

$sql = "SELECT * FROM `plates` WHERE `page_id`='{$login}'";  
    $query = $connection_handler_tortures->prepare($sql);
    $query->execute();
$tarelka = $query->fetchAll(PDO::FETCH_ASSOC); 

$sql = "SELECT * FROM `akagi_kaga` WHERE `page_id`='{$login}'";  
    $query = $connection_handler_tortures->prepare($sql);
    $query->execute();
$akagi_kaga = $query->fetchAll(PDO::FETCH_ASSOC); 

$evil_people_count = count($po_dihalke) + count($po_ebalu) + count($vilka) + count($tarelka) + count($akagi_kaga);

$connection_handler_tortures = null;

?>    
    
<h4 style = "text-align:center;border-bottom:1px solid white;padding-bottom:5px;">Злые люди | <?php echo $evil_people_count; ?></h4>

<table class = "people_table">
    <thead>
    <tr>
        <td>подыхалке<br /><?php echo count($po_dihalke); ?></td>
        <td>поебалу<br /><?php echo count($po_ebalu); ?></td> 
        <td>вилка<br /><?php echo count($vilka); ?></td>
        <td>тарелка<br /><?php echo count($tarelka); ?></td>
        <td>акагикага<br /><?php echo count($akagi_kaga); ?></td>
    </tr>
    </thead>

<tbody>
<tr>    
    <td><br />
     <?php 
    
    for($i = 0; $i < count($po_dihalke);$i++){
    
    $sql = "SELECT `avatar` FROM `additional_info` WHERE `nickname`='{$po_dihalke[$i]['clicker']}'";  
    $query = $connection_handler->prepare($sql);
    $query->execute();
$avatar = $query->fetchAll(PDO::FETCH_ASSOC); 
$avatar = $avatar[0]['avatar'];   
    
    echo '<a href = user.php?zs=' . $po_dihalke[$i]['clicker'] . ' title = ' . $po_dihalke[$i]['clicker'] . '><img src = users/' . $avatar . ' class = "evil_avatar" /></a>';    
    
    }
    
    ?>    
    
    </td>
    <td><br />
     <?php 
    
    for($i = 0; $i < count($po_ebalu);$i++){
    
    $sql = "SELECT `avatar` FROM `additional_info` WHERE `nickname`='{$po_ebalu[$i]['clicker']}'";  
    $query = $connection_handler->prepare($sql);
    $query->execute();
$avatar = $query->fetchAll(PDO::FETCH_ASSOC); 
$avatar = $avatar[0]['avatar'];   
    
    echo '<a href = user.php?zs=' . $po_ebalu[$i]['clicker'] . ' title = ' . $po_ebalu[$i]['clicker'] . '><img src = users/' . $avatar . ' class = "evil_avatar" /></a>';    
    
    }
    
    ?>    
    </td> 
    <td><br />
     <?php 
    
    for($i = 0; $i < count($vilka);$i++){
    
    $sql = "SELECT `avatar` FROM `additional_info` WHERE `nickname`='{$vilka[$i]['clicker']}'";  
    $query = $connection_handler->prepare($sql);
    $query->execute();
$avatar = $query->fetchAll(PDO::FETCH_ASSOC); 
$avatar = $avatar[0]['avatar'];   
    
    echo '<a href = user.php?zs=' . $vilka[$i]['clicker'] . ' title = ' . $vilka[$i]['clicker'] . '><img src = users/' . $avatar . ' class = "evil_avatar" /></a>';    
    
    }
    
    ?>    
    
    </td>
    <td><br /><?php 
    
     for($i = 0; $i < count($tarelka);$i++){
    
    $sql = "SELECT `avatar` FROM `additional_info` WHERE `nickname`='{$tarelka[$i]['clicker']}'";  
    $query = $connection_handler->prepare($sql);
    $query->execute();
$avatar = $query->fetchAll(PDO::FETCH_ASSOC); 
$avatar = $avatar[0]['avatar'];   
    
    echo '<a href = user.php?zs=' . $tarelka[$i]['clicker'] . ' title = ' . $tarelka[$i]['clicker'] . '><img src = users/' . $avatar . ' class = "evil_avatar" /></a>';    
    
    }
    
    ?></td>
    <td><br />
    <?php 
    
     for($i = 0; $i < count($akagi_kaga);$i++){
    
    $sql = "SELECT `avatar` FROM `additional_info` WHERE `nickname`='{$akagi_kaga[$i]['clicker']}'";  
    $query = $connection_handler->prepare($sql);
    $query->execute();
$avatar = $query->fetchAll(PDO::FETCH_ASSOC); 
$avatar = $avatar[0]['avatar'];   
    
    echo '<a href = user.php?zs=' . $akagi_kaga[$i]['clicker'] . ' title = ' . $akagi_kaga[$i]['clicker'] . '><img src = users/' . $avatar . ' class = "evil_avatar" /></a>';    
    
    }
    
    ?>
    </td>    
</tr>
</tbody>

</table>

</section>   


</main>    

</body>

</html>

<?php ob_end_flush(); ?>