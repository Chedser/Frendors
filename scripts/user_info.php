<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

$login = $_GET['zs'];
    
/* ИЩЕМ НИК ПОЛЬЗОВАТЕЛЯ */    
$sql = "SELECT nickname from main_info WHERE nickname=:login_get"; 
    $query = $connection_handler->prepare($sql);
    $query->bindParam(':login_get', $login, PDO::PARAM_STR);
    $query->execute(); 
$result = $query->fetchAll(PDO::FETCH_ASSOC);

$nickname = $result[0]['nickname']; // Ник пользователя

/* ИЩЕМ АВУ ПОЛЬЗОВАТЕЛЯ */    
$sql = "SELECT additional_info.avatar  FROM additional_info INNER JOIN main_info " . 
    " ON additional_info.user_id=main_info.user_id  WHERE main_info.nickname=:login_get"; 
    $query = $connection_handler->prepare($sql);
    $query->bindParam(':login_get', $login, PDO::PARAM_STR);
    $query->execute(); 
$result = $query->fetchAll(PDO::FETCH_ASSOC);

$avatar = 'users/' . $result[0]['avatar']; // Ава пользователя

/* ИЩЕМ ГОРОД */
$sql = "SELECT additional_info.mood  FROM additional_info INNER JOIN main_info " . 
    " ON additional_info.user_id=main_info.user_id  WHERE main_info.nickname=:login_get"; 
    $query = $connection_handler->prepare($sql);
    $query->bindParam(':login_get', $login, PDO::PARAM_STR);
    $query->execute(); 
$result = $query->fetchAll(PDO::FETCH_ASSOC);

$mood = $result[0]['mood'];

switch($mood){
   case 'ahuenno': $mood = 'Ахуенно блять ахуенно';
                   break;
    case 'smeyus': $mood = 'Сижу и смеюсь';
                   break;               
    case 'horoshee': $mood = 'Хорошее сразу';
                   break;               
    case 'kak_ptichka': $mood = 'Как птичка гадит';
                   break;               
    case 'kak_zemlya': $mood = 'Как земля';
                   break;
    case 'ploho_stalo': $mood = 'Плохо стало';
                   break;               
    case 'vsyo_ravno': $mood = 'Да мне вообще всё равно';
                   break;
    default: $mood = 'Любое';               
    
}

/* ИЩЕМ ГОРОД */
$sql = "SELECT additional_info.city  FROM additional_info INNER JOIN main_info " . 
    " ON additional_info.user_id=main_info.user_id  WHERE main_info.nickname=:login_get"; 
    $query = $connection_handler->prepare($sql);
    $query->bindParam(':login_get', $login, PDO::PARAM_STR);
    $query->execute(); 
$result = $query->fetchAll(PDO::FETCH_ASSOC);

$city = $result[0]['city'];

switch($city){
    case 'berdyansk': $city = 'Бердянск';
                      break;
    case 'azov': $city = "Азов штоли";
                break;
    case 'shanhai': $city = "Шанхай";
                break;
    case 'v_derevne': $city = "В деревне";
                break;
    case 'kaliningrad': $city = "Калининград йобта";
                break;   
    case 'kenigsberg': $city = "Кенигсберг блять";
                break;
    case 'svetly': $city = 'Рыболовецкий колхоз "За Родину", город Светлый';
                break;    
    default: $city = "Любой";   

}

/* ИЩЕМ ПОЛ */    
$sql = "SELECT additional_info.sex  FROM additional_info INNER JOIN main_info " . 
    " ON additional_info.user_id=main_info.user_id  WHERE main_info.nickname=:login_get"; 
    $query = $connection_handler->prepare($sql);
    $query->bindParam(':login_get', $login, PDO::PARAM_STR);
    $query->execute(); 
$result = $query->fetchAll(PDO::FETCH_ASSOC);

$sex = $result[0]['sex'];

if($sex == 'lob') {
         $sex = 'Лоб';
} else if($sex === 'dura') {
                    $sex = "Дура";
} else if($sex === 'poka_ne_skazhu'){
                    $sex = "Пока не скажу";
}
else $sex = 'Пока не скажу';    

/* ИЩЕМ ВОЗРАСТ */
$sql = "SELECT additional_info.age  FROM additional_info INNER JOIN main_info " . 
    " ON additional_info.user_id=main_info.user_id  WHERE main_info.nickname=:login_get"; 
    $query = $connection_handler->prepare($sql);
    $query->bindParam(':login_get', $login, PDO::PARAM_STR);
    $query->execute(); 

$result = $query->fetchAll(PDO::FETCH_ASSOC);

$age = $result[0]['age'];

$age_lang_vars = array(
                        'let20' => array('Лет 20', '20 years'),
                        '70let' => array('70 лет', '70 years'),
                        'any' => array('Любой', 'Any')
                        );

if($age === 'let_20') {
    $age = 'Лет 20 ёбта';
} else if($age === '70_let') {
    $age = '70 лет';
}else $age = 'Любой';    
    
/* ИЩЕМ CЕМЕЙНОЕ ПОЛОЖЕНИЕ */
$sql = "SELECT additional_info.sp  FROM additional_info INNER JOIN main_info " . 
    " ON additional_info.user_id=main_info.user_id  WHERE main_info.nickname=:login_get"; 
    $query = $connection_handler->prepare($sql);
    $query->bindParam(':login_get', $login, PDO::PARAM_STR);
    $query->execute(); 
$result = $query->fetchAll(PDO::FETCH_ASSOC);

$sp = $result[0]['sp']; // Семейное положение пользователя

 switch($sp){
    case 'est_dura': $sp = "Есть дура";
                      break;
    case 'est_durak': $sp = "Есть дурак";
                break;
    case 'duru_nado': $sp = "Дуру надо";
                break;
    case 'druga_nado': $sp = "Друга надо";
                break;
    case 'ne_hochetsya': $sp = "Ничхочеца мне ничего";
                break;   
    default: $sp = "Любое";   
}

/* ИЩЕМ ЖИЗНЕННЫЙ СТИЛЬ */ 
$sql = "SELECT additional_info.lifestyle  FROM additional_info INNER JOIN main_info " . 
    " ON additional_info.user_id=main_info.user_id  WHERE main_info.nickname=:login_get"; 
    $query = $connection_handler->prepare($sql);
    $query->bindParam(':login_get', $login, PDO::PARAM_STR);
    $query->execute(); 
$result = $query->fetchAll(PDO::FETCH_ASSOC);

$lifestyle = $result[0]['lifestyle']; // Жизненная позиция    

switch($lifestyle){
    case 'bratishka': $lifestyle = "Братишка";
                      break;
    case 'poehavshy': $lifestyle = "Поехавший";
                break;
    case 'tov_kapitan': $lifestyle = "товарищ Капитан";
                break;
    case 'polkovnik': $lifestyle = "Полковник";
                break;
    case 'stepan_grozny': $lifestyle = "Степан Грозный";
                break; 
    case 'chapaev': $lifestyle = "Чапаев";
                break;
    case 'admiral_yamamoto': $lifestyle = "адмирал Ямамото";
                break;
    case 'zadornov': $lifestyle = "Задорнов нахуй!";
                break;                 
    case 'rebyata': $lifestyle = "Некоторые ребята";
                break;
    case 'hor_paren': $lifestyle = "Хороший парень";
                break;
    case 'zl_ludi': $lifestyle = "Злые люди";
                break;        
    case 'fufel': $lifestyle = "Фуфел";
                break;
    case 'pidr': $lifestyle = "Пидр";
                break;
    case 'leitenant-pidaras': $lifestyle = "лейтенант-пидарас";
                break;
    case 'michalkin': $lifestyle = "Мычалкин";
                break; 
    case 'lesovichek': $lifestyle = "Лесовичок";
                break;                     
    case 'hirurg': $lifestyle = "Хирург";
                break;
    case 'golova': $lifestyle = "Голова";
                break;
    case 'mat': $lifestyle = "Мать то";
                break;     
    default: $lifestyle = null;
}

/* ИЩЕМ ТЕЛОСЛОЖЕНИЕ */ 
$sql = "SELECT additional_info.body  FROM additional_info INNER JOIN main_info " . 
    " ON additional_info.user_id=main_info.user_id  WHERE main_info.nickname=:login_get"; 
    $query = $connection_handler->prepare($sql);
    $query->bindParam(':login_get', $login, PDO::PARAM_STR);
    $query->execute(); 
$result = $query->fetchAll(PDO::FETCH_ASSOC);

$body = $result[0]['body']; // Семейное положение пользователя    

switch($body){
    case 'buivol': $body = "Буйвол";
                      break;
    case 'los': $body = "Лось";
                break;
    case 'kaban': $body = "Кабан";
                break;
     case 'svini': $body = "Свиньи";
                break;
    case 'tigr': $body = "Тигр";
                break;
    case 'pelmen': $body = "Пельмень";
                break;            
    case 'orel': $body = "Орел";
                break; 
    case 'tsaplya': $body = "Цапля";
                break;
     case 'cherv': $body = "Червь";
                break;            
default: $body = null;   

}

/* ИЩЕМ ХАРАКТЕР */ 
$sql = "SELECT additional_info.temper  FROM additional_info INNER JOIN main_info " . 
    " ON additional_info.user_id=main_info.user_id  WHERE main_info.nickname=:login_get"; 
    $query = $connection_handler->prepare($sql);
    $query->bindParam(':login_get', $login, PDO::PARAM_STR);
    $query->execute(); 
$result = $query->fetchAll(PDO::FETCH_ASSOC);

$temper = $result[0]['temper']; // Семейное положение пользователя    

if($temper === 'spokoiny'){
$temper = "Спокойный такой характер";
} else if($temper === 'zver'){
$temper = "Зверь нахуй";
} else {
$temper = "Любой";
}

/* ИЩЕМ УЧИЛИЩЕ */ 
$sql = "SELECT additional_info.education  FROM additional_info INNER JOIN main_info " . 
    " ON additional_info.user_id=main_info.user_id  WHERE main_info.nickname=:login_get"; 
    $query = $connection_handler->prepare($sql);
    $query->bindParam(':login_get', $login, PDO::PARAM_STR);
    $query->execute(); 
$result = $query->fetchAll(PDO::FETCH_ASSOC);

$education = $result[0]['education']; // Семейное положение пользователя    

if($education === 'v_shestom'){
$education = "В шестом";
} else if($education === 'ne_pomnu'){
$education = "Не помню ничего";
} else {
$education = "Любой";
}   

/* ИЩЕМ РЕЛИГИОЗНЫЕ ВЗГЛЯДЫ */ 
$sql = "SELECT additional_info.religion  FROM additional_info INNER JOIN main_info " . 
    " ON additional_info.user_id=main_info.user_id  WHERE main_info.nickname=:login_get"; 
    $query = $connection_handler->prepare($sql);
    $query->bindParam(':login_get', $login, PDO::PARAM_STR);
    $query->execute(); 
$result = $query->fetchAll(PDO::FETCH_ASSOC);

$religion = $result[0]['religion']; // Семейное положение пользователя    

switch($religion){
    case 'v_tserkov_hodil': $religion = "В церковь ходил";
                      break;
    case 'fehta-mehta': $religion = 'Фехта мехта блять';
                break;
    case 'bog_est': $religion = 'Бог есть блять. Азм езмь блять';
                break;
    case 'ne_zrya_raspyali': $religion = 'Не зря его распяли';
                break;
    default: $religion = 'Любая';   
}

/* ИЩЕМ СПОРТИВНЫЕ УВЛЕЧЕНИЯ */ 
$sql = "SELECT additional_info.sport  FROM additional_info INNER JOIN main_info " . 
    " ON additional_info.user_id=main_info.user_id  WHERE main_info.nickname=:login_get"; 
    $query = $connection_handler->prepare($sql);
    $query->bindParam(':login_get', $login, PDO::PARAM_STR);
    $query->execute(); 
$result = $query->fetchAll(PDO::FETCH_ASSOC);

$sport = $result[0]['sport']; // Семейное положение пользователя    

switch($sport){
    case 'otzhimayus': $sport = 'ОТЖИМААЮСЬ блять!';
                      break;
    case 'turnichok': $sport = "На турничок влезу так 'Оп!'";
                break;
     case 'gimnastika': $sport = 'Специальные такие тайзюцьвань';
                break;            
    case 'box': $sport = "Мать то в бокс отвела";
                break;
  
    default: $sport = "Любые";   
}

/* ИЩЕМ ИГРЫ */ 
$sql = "SELECT additional_info.games  FROM additional_info INNER JOIN main_info " . 
    " ON additional_info.user_id=main_info.user_id  WHERE main_info.nickname=:login_get"; 
    $query = $connection_handler->prepare($sql);
    $query->bindParam(':login_get', $login, PDO::PARAM_STR);
    $query->execute(); 
$result = $query->fetchAll(PDO::FETCH_ASSOC);

$games = $result[0]['games']; // Семейное положение пользователя    

switch($games){
    case 'checkers': $games = "Шашки";
                      break;
    case 'cards': $games = "Карты";
                break;
     case 'pohui': $games = "Да похуй вообще бля";
                break;            
   
    default: $games = "Да похуй вообще бля";   
}

?>