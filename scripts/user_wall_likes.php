<?php
ob_start();
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
header("Content-Type: application/json; charset=UTF-8");

if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

$post_id = (int) htmlspecialchars($_POST['post_id']);

if(!empty($_SESSION['user']) && !empty($post_id)){ // Ставим лайк
$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();

/* ПРОВЕРЯЕМ СТАВИЛ ЛИ ПОЛЬЗОВАТЕЛЬ ЛАЙК */
$sql = "SELECT * FROM `likes` WHERE `liker`='{$_SESSION['user']}' AND `post_id`={$post_id}";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$likes_user = $query->fetchAll(PDO::FETCH_ASSOC);      

if(empty($likes_user)){ /* Пользователь лайк НЕ ставил */

        /***************************************************************************************************************/
        
        /* ПРОВЕРЯЕМ СТАВИЛ ЛИ ПОЛЬЗОВАТЕЛЬ ДИЗЛАЙК */
        $sql = "SELECT * FROM `dislikes` WHERE `disliker`='{$_SESSION['user']}' AND `post_id`={$post_id}";	
        $query = $connection_handler->prepare($sql); 
        $query->execute();
        $dislikes_user = $query->fetchAll(PDO::FETCH_ASSOC); 
        
        if(empty($dislikes_user)){
        
        // ИЗВЛЕКАЕМ ИНФОРМАЦИЮ О ПОСТЕ
        $sql = "SELECT *  FROM `wall_user_posts` WHERE `this_id`={$post_id}";	
        $query = $connection_handler->prepare($sql);
        $query->execute();
        $post_info = $query->fetchAll(PDO::FETCH_ASSOC);
        $post_sender = $post_info[0]['nickname'];
        $post_text = $post_info[0]['message']; 
        $page_id = $post_info[0]['page_id']; 

        /* Заносим лайк в БД */
        $sql = "INSERT INTO `likes`(`liker`,`page`,`post_id`) VALUES ('{$_SESSION['user']}','{$page_id}',{$post_id})";	
        $query = $connection_handler->prepare($sql); 
        $query->execute();

        if($post_sender !== $_SESSION['user']){ // Пост отправил не сессионный. Оповещаем отправителя 
        
            // ПРОВЕРЯЕМ ЕСТЬ ЛИ УЖЕ ОПОВЕЩЕНИЕ В ТАБЛИЦЕ
            $sql = "SELECT * FROM `notice` WHERE `post_id`={$post_id} AND `is_post_liker`=1";
            $query = $connection_handler->prepare($sql);
            $query->execute();  
            $like_notice = $query->fetchAll(PDO::FETCH_ASSOC);
            
            if(empty($like_notice)){
        
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
             $sql = "INSERT INTO `notice`(`noticer`,`noticed`,`description`,`type`,`post_sender`,`page`,`post_id`,`post_text`,`is_post_liker`) VALUE ('{$_SESSION['user']}','{$post_sender}','{$whose_page}','like_post','{$post_sender}','{$page_id}',{$post_id},'{$post_text}',1)";
            $query = $connection_handler->prepare($sql);
            $query->execute();  
            
            }
        
        }
        
}

        /*****************************************************************************************************************/

/* Отображаем все лайки на данном посте */    
$sql = "SELECT COUNT(*) AS `likes_count` FROM `likes` WHERE `post_id`={$post_id}";	
$query = $connection_handler->prepare($sql); 
$query->execute();
$likes_count_all = $query->fetchAll(PDO::FETCH_ASSOC);      
$likes_count_all = $likes_count_all[0]['likes_count'];

$likes_count = '[{"likes_count": "' . $likes_count_all . '"},';

/*  ИЗВЛЕКАЕМ ВСЕХ ЛАЙКЕРОВ */
$sql = "SELECT * FROM `likes` WHERE `post_id`={$post_id} ORDER BY `date` DESC LIMIT 4";
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$likers = $query->fetchAll(PDO::FETCH_ASSOC);      

if(!empty($likers)){

$likers_imgs_output = $likes_count;

for($i = 0; $i < count($likers); $i++){
    
    /*  ИЗВЛЕКАЕМ АВУ ЛАЙКЕРА */
$sql = "SELECT `avatar` FROM `additional_info` WHERE `nickname`='{$likers[$i]['liker']}'";
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$liker_img = $query->fetchAll(PDO::FETCH_ASSOC);
$liker_img = $liker_img[0]['avatar'];
    
$likers_imgs_output .= '{"liker_img":"' . $liker_img .  '","liker_name":"' . $likers[$i]['liker'] . '"},';    
    
    } //for($i = 0; $i < count($likers); $i++) 

/* Убираем последнюю запятую */
$likers_imgs_output = substr($likers_imgs_output, 0, -1);
 
$likers_imgs_output .= "]"; 
    
echo $likers_imgs_output;    
    
}//if(!empty($likers))
} // if(empty($likes_user))

 else { /* Пользователь лайк уже ставил  */
$current_time = time(); // Время захода пользователя на страницу
$sql = "UPDATE main_info SET last_action_time=:last_action_time WHERE nickname=:nickname";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->bindParam(':nickname', $_SESSION['user'], PDO::PARAM_STR);
$query->bindParam(':last_action_time', $current_time, PDO::PARAM_STR);
$query->execute();

/* Удаляем лайк из базы */
$sql = "DELETE FROM `likes` WHERE `liker`='{$_SESSION['user']}' AND `post_id`={$post_id}";	
$query = $connection_handler->prepare($sql); 
$query->execute();

/***************************************************************************************************************/
 
/* ЕСЛИ ЛАЙКОВ БОЛЬШЕ НЕТ, ОТОБРАЖАЕМ ТОЛЬКО КОЛИЧЕСТВО */ 
    
/* ПРОВЕРЯЕМ ЕСТЬ ЛИ ЛАЙКИ ПСОЛЕ ТОГО КАК ПОЛЬЗОВАТЕЛЬ ОТМЕНИЛ ЛАЙК */    
$sql = "SELECT * FROM `likes` WHERE `post_id`={$post_id}";	
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$likes_count = $query->fetchAll(PDO::FETCH_ASSOC);      

if(count($likes_count) > 0){ //Лайки после улаоения есть

$likes_count = '[{"likes_count": "' . count($likes_count) . '"},';

//  ИЗВЛЕКАЕМ ПОСЛЕДНИХ 4-Х ЛАЙКЕРОВ 
$sql = "SELECT * FROM `likes` WHERE `post_id`={$post_id} ORDER BY `date` DESC LIMIT 4";
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$likers = $query->fetchAll(PDO::FETCH_ASSOC);      

$likers_imgs_output = $likes_count;

for($i = 0; $i < count($likers); $i++){
    
    //  ИЗВЛЕКАЕМ АВУ ЛАЙКЕРА 
$sql = "SELECT `avatar` FROM `additional_info` WHERE `nickname`='{$likers[$i]['liker']}'";
$query = $connection_handler->prepare($sql); //Подготавливаем запрос
$query->execute();
$liker_img = $query->fetchAll(PDO::FETCH_ASSOC);
$liker_img = $liker_img[0]['avatar'];
    
$likers_imgs_output .= '{"liker_img":"' . $liker_img .  '","liker_name":"' . $likers[$i]['liker'] . '"},'; 

}

// Убираем последнюю запятую 
$likers_imgs_output = substr($likers_imgs_output, 0, -1);
 
$likers_imgs_output .= "]"; 
    
echo $likers_imgs_output;    


} else { //if(count($likes_count) > 0)

echo '[{"likes_count": "0"}]';
    
        }
     }
} // if(!empty($page) && !empty($liker) && !empty($post_id))
ob_end_flush();

?>


