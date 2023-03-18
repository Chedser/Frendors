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

$video_id = htmlspecialchars($_POST['video_id']);
$comment = htmlspecialchars($_POST['comment']);

if(!empty($video_id) && !empty($comment)){

/* ВСТАВЛЯЕМ КОММЕНТ В ТАБЛИЦУ */
$sql = "INSERT INTO `common_videos_comments`(`user`,`video_id`,`comment_text`) VALUE ('{$_SESSION['user']}',{$video_id},'{$comment}')";
$query = $connection_handler->prepare($sql);
$query->execute();

$last_insert_id = $connection_handler->lastInsertId();

// ИЗВЛЕКАЕМ ИНФОРМАЦИЮ О ВИДОСЕ
$sql = "SELECT * FROM `common_videos` WHERE `this_id`=" . $video_id;	
$query = $connection_handler->prepare($sql); 
$query->execute();
$video_info = $query->fetchAll(PDO::FETCH_ASSOC);

// ЕСЛИ ПОЛЬЗОВАТЕЛЬ КОММЕНТИТ НЕ СВОЙ ВИДОС, ТО ОПОВЕЩАЕМ ПОЛЬЗОВАТЕЛЕЙ И ТОГО, ЧЕЙ ВИДОС ПРОКОММЕНТИЛИ 
 if($video_info[0]['user'] !== $_SESSION['user']){
    // ОПОВЕЩАЕМ ВСЕХ ПОЛЬЗОВАТЕЛЕЙ 
    $sql = "INSERT INTO `common_notice`(`noticer`,`type`,`whose_multimedia`,`multimedia_id`,`comment_id`,`link`,`comment_text`) VALUES ('" . $_SESSION['user'] . "','common_video_comment','" . $video_info[0]['user'] . "'," . $video_id . "," . $last_insert_id  . ",'" . $video_info[0]['link'] . "','" . $comment . "')";
    $query = $connection_handler->prepare($sql);
    $query->execute();

    // ОПОВЕЩАЕМ  ПОЛЬЗОВАТЕЛЯ 
    $sql = "INSERT INTO `notice`(`noticer`,`noticed`,`type`,`multimedia_id`,`comment_id`,`link`,`comment_text`) VALUES ('" . $_SESSION['user'] . "','" . $video_info[0]['user'] ."','common_video_comment'," . $video_id . "," . $last_insert_id  . ",'" . $video_info[0]['link'] . "','" . $comment . "')";
    $query = $connection_handler->prepare($sql);
    $query->execute();
    
} 

}

ob_end_flush(); 
?>

