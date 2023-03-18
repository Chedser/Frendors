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

$id =  (int)trim(htmlspecialchars($_POST['id'])); 
$description = trim(htmlspecialchars($_POST['description']));

if(!empty($id) && !empty($description)){

                /* ПРОВЕРЯЕМ ЕСТЬ ЛИ ТАКОЙ САЙТ В БАЗЕ */
                $sql = "UPDATE `sites` SET `description`='{$description}' WHERE `this_id`={$id}";
                $query = $connection_handler->prepare($sql);
                if($query->execute()){
                    echo '{"status":"true"}';
                };
                
}
ob_end_flush(); 
?>

