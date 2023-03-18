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

$post_id = (int) htmlspecialchars($_POST['post_id']);

if(!empty($post_id) && !empty($_SESSION['user'])){

    // ИЩЕМ РАССКАЗАЛ ЛИ О ПОСТЕ ГАВНО
    $sql = "SELECT * FROM `tell_to_bros_gavno_post` WHERE `teller`='{$_SESSION['user']}' AND  `post_id`={$post_id}"; 
    $query = $connection_handler->prepare($sql);
    $query->execute();
    $tell_to_bros_gavno_post = $query->fetchAll(PDO::FETCH_ASSOC);
    
    if(empty($tell_to_bros_gavno_post)){
    
     // ИЩЕМ РАССКАЗАЛ ЛИ О ПОСТЕ АХУЕННО
    $sql = "SELECT * FROM `tell_to_bros_ahuenno_post` WHERE `teller`='{$_SESSION['user']}' AND `post_id`={$post_id}"; 
    $query = $connection_handler->prepare($sql);
    $query->execute();
    $tell_to_bros_ahuenno_post = $query->fetchAll(PDO::FETCH_ASSOC);
                    
                    if(empty($tell_to_bros_ahuenno_post)){
                // ВСТАВЛЯЕМ В ТАБЛИЦУ РАССКАЗАННЫХ ПОСТОВ
                    $sql = "INSERT INTO `tell_to_bros_ahuenno_post`(`teller`,`post_id`) VALUES('{$_SESSION['user']}',{$post_id})"; 
                    $query = $connection_handler->prepare($sql);
                    $query->execute();
                
                // ИЗВЛЕКАЕМ ИНФОРМАЦИЮ О ПОСТЕ
                $sql = "SELECT * FROM `wall_user_posts` WHERE `this_id`={$post_id}";	
                $query = $connection_handler->prepare($sql); 
                $query->execute();
                $post_info = $query->fetchAll(PDO::FETCH_ASSOC);      
                
                $post_sender = $post_info[0]['nickname']; // Тот кто оставил пост
                $post_text = $post_info[0]['message']; // Текст поста
                $page_id = $post_info[0]['page_id']; // Страница поста
                
                /*******************************************************************************************************/
                
                // ВСТАВЛЯЕМ В ТАБЛИЦУ ПОСТОВ
                    $sql = "INSERT INTO `wall_user_posts`(`page_id`,`nickname`,`message`,`post_sender_ahuenno`,`type`) VALUES('{$_SESSION['user']}','{$_SESSION['user']}','{$post_text}','{$post_sender}','telled_ahuenno')"; 
                    $query = $connection_handler->prepare($sql);
                    $query->execute(); 
                
                    echo "Братки знают";
                        
                    }echo "!";

    }else{
        echo "!";
    }

        if($post_sender !== $_SESSION['user']){ // Пост отправил не сессионный. Оповещаем отправителя 
        
            // ПРОВЕРЯЕМ ЕСТЬ ЛИ УЖЕ ОПОВЕЩЕНИЕ В ТАБЛИЦЕ
            $sql = "SELECT * FROM `notice` WHERE `post_id`={$post_id} AND `is_ahuenno_teller`=1";
            $query = $connection_handler->prepare($sql);
            $query->execute();  
            $ahuenno_teller_notice = $query->fetchAll(PDO::FETCH_ASSOC);
            
            if(empty($ahuenno_teller_notice)){
        
            // СМОТРИМ НА ЧЬЕЙ СТРАНИЦЕ ОСТАВЛЕН ПОСТ 
           $whose_page = ""; 
            // ПОСТ ОСТАВЛЕН НА НАШЕЙ СТРАНИЦЕ 
            if($page_id === $_SESSION['user']){
            
            $whose_page = "своей странице";
                
            } else if($page_id !== $_SESSION['user']) { // На чужой
            
            $whose_page = "вашей странице";
            
            if($post_sender !== $page_id){
                    $whose_page = "странице пользователя <a href = user.php?zs={$page_id}>{$page_id}</a>";    
            }
        
        }
            
                             // ВСТАВЛЯЕМ ОПОВЕЩЕНИЕ В ТАБЛИЦУ  
                             $sql = "INSERT INTO `notice`(`noticer`,`noticed`,`description`,`type`,`post_sender`,`page`,`post_id`,`post_text`,`is_ahuenno_teller`) VALUE ('{$_SESSION['user']}','{$post_sender}','{$whose_page}','tell_ahuenno_post','{$post_sender}','{$page_id}',{$post_id},'{$post_text}',1)";
                            $query = $connection_handler->prepare($sql);
                            $query->execute();  
                            
                                    // ОПОВЕЩАЕМ ВСЕХ ПОЛЬЗОВАТЕЛЕЙ 
                            $sql = "INSERT INTO `common_notice`(`noticer`,`type`,`page`,`post_sender`,`post_id`,`post_text`) VALUES ('" . $_SESSION['user'] . "','tell_to_bros_ahuenno_post','{$whose_page}','{$post_sender}',{$post_id},'{$post_text}')";
                            $query = $connection_handler->prepare($sql);
                            $query->execute();
                       
            }

        }

} 

ob_end_flush(); 
?>

