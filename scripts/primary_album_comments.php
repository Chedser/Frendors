<?php
ob_start();
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
header("Content-type: text/plain; charset='utf-8'");

if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

$image_id = (int)htmlspecialchars($_POST['image_id']);
$comment = htmlspecialchars($_POST['comment']);

if(!empty($image_id) && !empty($comment)){

/* ВСТАВЛЯЕМ КОММЕНТ В ТАБЛИЦУ */
$sql = "INSERT INTO `comments_primary_album`(`user`,`image_id`,`text`) VALUES ('{$_SESSION['user']}',{$image_id},'{$comment}')";
$query = $connection_handler->prepare($sql);
$query->execute();

$last_insert_id = $connection_handler->lastInsertId();

/* ИЗВЛЕКАЕМ ИНФОРМАЦИЮ ОБ ИЗОБРАЖЕНИИ. УЗНАЕМ КОМУ ОНО ПРИНАДЛЕЖИТ */
$sql = "SELECT * FROM `user_images_primary_album` WHERE `this_id`=" . $image_id;	
$query = $connection_handler->prepare($sql); 
$query->execute();
$image_info = $query->fetchAll(PDO::FETCH_ASSOC);

/* ЕСЛИ ПОЛЬЗОВАТЕЛЬ КОММЕНТИТ НЕ СВОЮ КАРТИНКУ, ТО ОПОВЕЩАЕМ ПОЛЬЗОВАТЕЛЕЙ И ТОГО, ЧЬЮ КАРТНКУ ПРОКОММЕНТИЛИ */
if($image_info[0]['user'] !== $_SESSION['user']){
    /* ОПОВЕЩАЕМ ВСЕХ ПОЛЬЗОВАТЕЛЕЙ */
    $sql = "INSERT INTO `common_notice`(`noticer`,`type`,`whose_multimedia`,`multimedia_id`,`comment_id`,`link`,`comment_text`) VALUES ('" . $_SESSION['user'] . "','primary_image_comment','" . $image_info[0]['user'] . "'," . $image_id . "," . $last_insert_id  . ",'" . $image_info[0]['link'] . "','" . $comment . "')";
    $query = $connection_handler->prepare($sql);
    $query->execute();

    /* ОПОВЕЩАЕМ  ПОЛЬЗОВАТЕЛЯ */
    $sql = "INSERT INTO `notice`(`noticer`,`noticed`,`type`,`multimedia_id`,`comment_id`,`link`,`comment_text`) VALUES ('" . $_SESSION['user'] . "','" . $image_info[0]['user'] ."','primary_image_comment'," . $image_id . "," . $last_insert_id  . ",'" . $image_info[0]['link'] . "','" . $comment . "')";
    $query = $connection_handler->prepare($sql);
    $query->execute();
    
}

}

ob_end_flush(); 
?>

