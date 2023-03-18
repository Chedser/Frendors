
<?php
ob_start();

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(empty($_SERVER['HTTP_REFERER'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

$city = htmlspecialchars($_POST['city']);
$sex = htmlspecialchars($_POST['sex']);
$age = htmlspecialchars($_POST['age']);
$sp = htmlspecialchars($_POST['sp']);
$education = htmlspecialchars($_POST['education']);
$lifestyle = htmlspecialchars($_POST['lifestyle']);
$body = htmlspecialchars($_POST['body']);
$religion = htmlspecialchars($_POST['religion']);
$temper = htmlspecialchars($_POST['temper']);
$sport = htmlspecialchars($_POST['sport']);
$games = htmlspecialchars($_POST['games']);
$add_nickname = htmlspecialchars($_POST['add_nickname']);

$login = htmlspecialchars($_SESSION['user']);

$data = array('city' => $city, 'sex' => $sex, 'age' => $age, 'sp' => $sp, 'education' => $education, 'lifestyle' => $lifestyle, 'body' => $body, 'temper' => $temper, 'religion' => $religion, 'sport' => $sport,'games' => $games);

$i = 0;
foreach($data as $key => $value){
if(!empty($data[$key])){ // Вставляем в базу непустые данные
$sql = "UPDATE additional_info SET {$key}='{$value}'  WHERE nickname='{$login}'"; 
    $query = $connection_handler->prepare($sql);
    $query->execute();
++$i;
    }
}

if(!empty($add_nickname) && preg_match('/[A-Za-zА-Яа-я0-9]{2,20}/',$add_nickname)){
$add_nickname = htmlspecialchars($_POST['add_nickname']);
$sql = "UPDATE main_info SET `add_nickname`='{$add_nickname}'  WHERE nickname='{$login}'"; 
    $query = $connection_handler->prepare($sql);
    $query->execute();
++$i;
}


?>
<!DOCTYPE html>

<html>
<head>
<title>Редактируем инфу</title>
<meta charset = "utf-8"/>
<link rel = "stylesheet" href = "../css/normalize.css"  type = "text/css" />    
<style>

body {
width: 1000px;
background-color:#a4aa8f;
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
</head>    

<body>
<table>
    <tr>
    <td>
    <?php if($i == 0){
    echo "<p style='color:green'>Вы действительно что-то меняли?</p>" . 
        "<a style = 'color: yellow' href = '../user.php?zs={$login}'>Нет блять</a>";
        }
        else echo "<p style = 'color:white'>Изменения сохранены</p>" .
             "<a style = 'color: yellow'  href = '../user.php?zs={$login}'>Ахуенно</a>";;
    ?>
    </td>
    </tr>
    <tr>
        <td>
      
        </td>
    </tr>
</table>    
    
</body>

</html> 
<?php ob_end_flush(); ?>