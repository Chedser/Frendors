<?php
ob_start();
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
header("Content-type: text/plain; charset='utf-8'");

if(empty($_SERVER['HTTP_REFERER'])){
header('Location: head_answers.php'); 
exit();   
}

header("Content-type: application/json; charset='utf-8'");

$sitename = str_replace(" ", "",htmlspecialchars($_POST['sitename'])); 
$sitetitle = trim(htmlspecialchars($_POST['sitetitle']));
$sitedescription = trim(htmlspecialchars($_POST['sitedescription'])); 

if(!empty($sitename) && !empty($sitetitle) && !empty($sitedescription)){

    if(preg_match('/^([a-zA-Z0-9_\-]{2,256})+([\.])+([a-zA-Z]{2,6})+$/is',$sitename)){ //  Проверяем соответствуе ли сайт паттерну 

          if(checkdnsrr($sitename) != false){ // Проверяем существует ли такой сайт
 
                /* ПРОВЕРЯЕМ ЕСТЬ ЛИ ТАКОЙ САЙТ В БАЗЕ */
                $sql = "SELECT * FROM `sites` WHERE `sitename`='{$sitename}'";
                $query = $connection_handler->prepare($sql);
                $query->execute();
                $site_exist = $query->fetchAll(PDO::FETCH_ASSOC);

                             if(!empty($site_exist)){ // САЙТ ЕСТЬ В БАЗЕ
                                 
                                 if(checkdnsrr($sitename) == false){// Сайта уже не существует. Удаляем сайт из базы
                                        
                                        $sql = "DELETE FROM `sites` WHERE `sitename`='{$sitename}'";
                                        $query = $connection_handler->prepare($sql);
                                        if($query->execute()){echo '{"status":"not_exist"}'; exit();}
                            }
                            
                            echo '{"status":"site_in_db"}';
                                 
                    }else{
                        
                                        /* ВСТАВЛЯЕМ САЙТ В ТАБЛИЦУ */
                    $sql = "INSERT INTO `sites`(`sitename`,`title`,`description`) VALUES ('" . $sitename . "','" . $sitetitle . "','" . $sitedescription . "')";
                    $query = $connection_handler->prepare($sql);
                    if($query->execute()){
                        echo '{"status":"site_created"}';
                        exit();
                    }
    
                }
     
            }else{
        echo '{"status":"not_exist"}';          
    }  
        
}
    
}
ob_end_flush(); 
?>

