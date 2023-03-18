<?php ob_start(); ?>

<?php 

if(empty($_SERVER['HTTP_REFERER'])){
    header('Location: index.php'); 
    exit();   
}

$fb_name = str_replace(" ","_",htmlspecialchars($_GET['name'],ENT_QUOTES));
$fb_id = (int)$_GET['id'];
$hash = $_GET['a_cho_tam'];

if (!empty($fb_name) && !empty($fb_id) && !empty($hash)) {

$client_id = '105917036567372';
$client_secret = '9aabc3fc9c30da1a922f615a1dbf2687';

$hashed_string = $client_id . $client_secret;

$frendors_hash = crypt($hashed_string,'babushka_Misha');

        if(hash_equals($frendors_hash, $hash)){
                
            require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
            $connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

            // ПРОВЕРЯЕМ ЗАРЕГАН ЛИ ТАКОЙ ПОЛЬЗОВАТЕЛЬ ЧЕРЕЗ ВК
            $sql = "SELECT * FROM `main_info` WHERE `nickname` = '{$fb_name}' AND `fb_id`={$fb_id}"; 	
            $query = $connection_handler->prepare($sql); 
            $query->execute();
            $fb_user_info = $query->fetchAll(PDO::FETCH_ASSOC);
            
                if(empty($fb_user_info)){ // Пользователь не зареган. Регаем и авторизуем
                 
                    /* Вставляем главные данные в таблицу */
                    $sql = "INSERT INTO `main_info`(`nickname`,`fb_id`,`reg_type`,`is_new_user`) VALUES ('" . $fb_name . "'," . $fb_id . ",'fb',1)";	
                    $query = $connection_handler->prepare($sql); 
                    $query->execute();
                    
                    $last_insert_id = $connection_handler->lastInsertId(); // Последнее вставленное айди
                    
                    /* ВСТАВЛЯЕМ ДОПОЛНИТЕЛЬНЫЕ ДАННЫЕ В ТАБЛИЦУ */
                    $data_additional = array($last_insert_id,$fb_name);
                    $sql_additional = "INSERT INTO `additional_info`(`user_id`, `nickname`) VALUES (?, ?)";	
                    $query_additional = $connection_handler->prepare($sql_additional);
                    $query_additional->execute($data_additional);
                    
                        /* СОЗДАЕМ ПАПКУ ДЛЯ ПОЛЬЗОВАТЕЛЯ*/
                        chdir('users/');//Переходим в папку users    
                        $dir = 'zs' . $last_insert_id . '/'; // Папка пользователя 

                        if(!file_exists($dir)){ // Создаем папку пользователя
                            mkdir($dir, 0777,true); //.. создаём эту папку
                        }
                            
                            session_start(); // Авторизуем пользователя
                            $_SESSION['user'] = $fb_name; // Создаем переменную сессии
                            header('Location: user.php?zs=' . $fb_name); // Редиректим на страницу пользователя.
                    
                } else { // Пользователь зареган и авторизуем
                     session_start(); // Авторизуем пользователя
                     $_SESSION['user'] = $fb_name; // Создаем переменную сессии
                     header('Location: user.php?zs=' . $fb_name); // Редиректим на страницу пользователя.
                }
        }
}

?>


<?php ob_end_flush(); ?>