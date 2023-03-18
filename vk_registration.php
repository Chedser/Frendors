<?php ob_start(); ?>

<?php 

if(empty($_SERVER['HTTP_REFERER'])){
    header('Location: index.php'); 
    exit();   
}

    $vk_name = str_replace(" ","_",htmlspecialchars($_GET['vk_name'],ENT_QUOTES));
    $user_id = (int)$_GET['user_id'];
    $hash = $_GET['a_cho_tam'];
     
if(!empty($vk_name) && !empty($user_id) && !empty($hash)){ 
        
        $app_id_vk = "5757931";
        $secret_key_vk = "DMTvuElXhDwuUsBuAzhZ";
        
        $md5arg = $app_id_vk . $user_id . $secret_key_vk;
        
        if(md5($md5arg) === $hash){

            require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
            $connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

            // ПРОВЕРЯЕМ ЗАРЕГАН ЛИ ТАКОЙ ПОЛЬЗОВАТЕЛЬ ЧЕРЕЗ ВК
            $sql = "SELECT * FROM `main_info` WHERE `nickname` = '{$vk_name}' AND `vk_id`={$user_id}"; 	
            $query = $connection_handler->prepare($sql); 
            $query->execute();
            $vk_user_info = $query->fetchAll(PDO::FETCH_ASSOC);
            
            
                if(empty($vk_user_info)){ // Пользователь не зареган. Регаем и авторизуем
                    /* Вставляем главные данные в таблицу */
                    $data = array($vk_name, $user_id,'vk',1);
                    $sql = "INSERT INTO main_info(nickname,vk_id,reg_type,is_new_user) VALUES (?, ?, ?, ?)";	
                    $query = $connection_handler->prepare($sql); 
                    $query_execution = $query->execute($data);
                    
                    $last_insert_id = $connection_handler->lastInsertId(); // Последнее вставленное айди
                    
                    /* ВСТАВЛЯЕМ ДОПОЛНИТЕЛЬНЫЕ ДАННЫЕ В ТАБЛИЦУ */
                    $data_additional = array($last_insert_id,$vk_name);
                    $sql_additional = "INSERT INTO additional_info(user_id, nickname) VALUES (?, ?)";	
                    $query_additional = $connection_handler->prepare($sql_additional);
                    $query_additional->execute($data_additional);
                    
                        $data_array = array($vk_name, 'Я теперь долбоеб!', $vk_name);
                        $sql = "INSERT INTO wall_user_posts(nickname,message,page_id) VALUES(?,?,?) "; 
                        $query = $connection_handler->prepare($sql);
                        $query->execute($data_array);
                    
                        /* СОЗДАЕМ ПАПКУ ДЛЯ ПОЛЬЗОВАТЕЛЯ*/
                        chdir('users/');//Переходим в папку users    
                        $dir = 'zs' . $last_insert_id . '/'; // Папка пользователя 

                        if(!file_exists($dir)){ // Создаем папку пользователя
                            mkdir($dir, 0777,true); //.. создаём эту папку
                        }
                            
                    
                }  // Пользователь зареган, авторизуем
                     session_start(); // Авторизуем пользователя
                    setcookie("user", $vk_name, time()+60*60*24*30);   
                     $_SESSION['user'] = $vk_name; // Создаем переменную сессии
                   /*   $oauth = 'https://oauth.vk.com/authorize?client_id=' . $app_id_vk . '&display=page&redirect_uri=http://frendors.com/vk_redirect_uri.php&response_type=token&v=5.62';
                  
                  header('Location: ' . $oauth); */
                  
              header('Location: user.php?zs=' . $vk_name); // Редиректим на страницу пользователя. 
             
        }else{
            header('Location: index.php');
            exit();
        }

}else{
   
    header('Location: index.php');
    exit();

}    

?>

<?php ob_end_flush(); ?>