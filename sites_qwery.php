<?php
ob_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
header("Content-type: text/plain; charset='utf-8'");

if(empty($_SERVER['HTTP_REFERER'])){
header('Location: head_answers.php'); 
exit();   
}

header("Content-type: application/json; charset='utf-8'");

$query_site = trim(htmlspecialchars($_POST['sites_qwery'])); 

if(!empty($query_site)){

// ПРОВЕРЯЕМ ЕСТЬ ЛИ В ЗАПРОСЕ НАЗВАНИЕ САЙТА 
if(preg_match("/(^|[\n ])([\w]*?)(https?:\/\/)(www\.)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;%=+])*)*)/is",$query_site,$sitename) |
     preg_match("/(^|[\n ])([\w]*?)(https?:\/\/)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;%=+])*)*)/is",$query_site,$sitename) |
     preg_match("/(^|[\n ])([\w]*?)(www\.)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;%=+])*)*)/is",$query_site,$sitename) |
     preg_match("/(^|[\n ])([\w]*?)(([a-zA-Z0-9_\-.]{2,256})+\.([a-zA-Z]{2,6})+([\/]([a-zA-Z0-9_\/\-.?&;%=+])*)*)/is",$query_site,$sitename)){

    $sitename = mb_strtolower($sitename[0]);
    $patterns = array(
                        '/(^|[\n ])([\w]*?)(https?:\/\/)(www\.)/is',
                        '/(^|[\n ])([\w]*?)(https?:\/\/)/is',
                        '/(^|[\n ])([\w]*?)(www\.)/is');
    
    $sitename = preg_replace($patterns,"",$sitename);
    $sitename = str_replace(" ","",$sitename);

                 /* ПРОВЕРЯЕМ ЕСТЬ ЛИ ТАКОЙ САЙТ В БАЗЕ. ЕСЛИ ЕСТЬ ТО, ОТДАЕМ РЕЗУЛЬТАТ И ОБНОВЛЯЕМ КОЛИЧЕСТВО ЗАПРОСОВ ИНАЧЕ СМОТРИМ В ДРУГИХ САЙТАХ */
                $sql = "SELECT * FROM `sites` WHERE UPPER(`sitename`) LIKE UPPER('%{$sitename}%') OR UPPER(`title`) LIKE UPPER('%{$query_site}%') OR UPPER(`description`) LIKE ('%{$query_site}%') ORDER BY `queries_count` DESC";
                $query = $connection_handler->prepare($sql);
                $query->execute();
                $sites = $query->fetchAll(PDO::FETCH_ASSOC);
                     
                    if(!empty($sites)){// Такой сайт в базе есть
                        // УЗНАЕМ КОЛИЧЕСТВО ЗАПРОСОВ 
                        $sql = "SELECT `queries_count` FROM `sites` WHERE `sitename`='{$sitename}'";
                        $query = $connection_handler->prepare($sql);
                        $query->execute();
                        $queries_count = $query->fetchAll(PDO::FETCH_ASSOC);
                        $queries_count = $queries_count[0]['queries_count'];
                       
                        $queries_count++;
                        
                           // ОБНОВЛЯЕМ КОЛИЧЕСТВО ЗАПРОСОВ 
                        $sql = "UPDATE `sites` SET `queries_count`={$queries_count} WHERE `sitename`='{$sitename}'";
                        $query = $connection_handler->prepare($sql);
                        $query->execute();
                     
                         //ВЫДАЕМ РЕЗУЛЬТАТ
                       
                       $result = '{"sites":[';
                       
                             for($i = 0; $i < count($sites); $i++){
                                 
                                 $sitename = $sites[$i]['sitename'];
                                 $title = $sites[$i]['title'];
                                 $description = $sites[$i]['description'];
                                 $id = $sites[$i]['this_id'];
                                  $img_src = "";
                              
                               $result .= '{"sitename":"' . $sitename . '","title":"' . $title . '","description":"' . $description . '","id":"' . $id . '"},';
                         }
                        
              $result .= '{"count":"' . count($sites) . '"}]}';
              echo $result; 
                } // Такой сайт в базе есть 
                   else{// Сайта нет. Проверяем фразы в заголовке и описании
                        /* ПРОВЕРЯЕМ ЗАПРОС В ЗАГОЛОВКЕ И ОПИСАНИИ. ЕСЛИ ЕСТЬ ТО, ОТДАЕМ РЕЗУЛЬТАТ ИНАЧЕ ГОВОРИМ, ЧТО ЗАПРОС НЕ ДАЛ РЕЗУЛЬТАТОВ */
                            $sql = "SELECT * FROM `sites` WHERE UPPER(`title`) LIKE UPPER('%{$query_site}%') OR UPPER(`description`) LIKE ('%{$query_site}%') ORDER BY `queries_count` DESC";
                            $query = $connection_handler->prepare($sql);
                            $query->execute();
                            $sites = $query->fetchAll(PDO::FETCH_ASSOC);
                            
                                if(!empty($sites)){ // Сайты в базе есть
                                     //ВЫДАЕМ РЕЗУЛЬТАТ
                       
                               $result = '{"sites":[';
                               
                                     for($i = 0; $i < count($sites); $i++){
                                         
                                         $sitename = $sites[$i]['sitename'];
                                         $title = $sites[$i]['title'];
                                         $description = $sites[$i]['description'];
                                         $id = $sites[$i]['this_id'];
                                          $img_src = "";
                                      
                                       $result .= '{"sitename":"' . $sitename . '","title":"' . $title . '","description":"' . $description . '","id":"' . $id . '"},';
                                 }
                        
                                  $result .= '{"count":"' . count($sites) . '"}]}';
                                      echo $result; 
                            }else { // Сайта нет
                                echo '{"sites":[]}';
                        }
                   
                       
                   } // САЙТА НЕТ
         
            }// Проверяем есть ли в запросе название сайта
               
               /*************************************************************************************************************************************************************/
               
                else{//Названия сайта в запросе нет. Ищем запрос в заголовке и описании 
                    
                     /* ПРОВЕРЯЕМ ЗАПРОС В ЗАГОЛОВКЕ И ОПИСАНИИ. ЕСЛИ ЕСТЬ ТО, ОТДАЕМ РЕЗУЛЬТАТ ИНАЧЕ ГОВОРИМ, ЧТО ЗАПРОС НЕ ДАЛ РЕЗУЛЬТАТОВ */
                            $sql = "SELECT * FROM `sites` WHERE UPPER(`title`) LIKE UPPER('%{$query_site}%') OR UPPER(`description`) LIKE UPPER('%{$query_site}%') ORDER BY `queries_count` DESC;";
                            $query = $connection_handler->prepare($sql);
                            $query->execute();
                            $sites = $query->fetchAll(PDO::FETCH_ASSOC);
                            
                                if(!empty($sites)){ // Сайты в базе есть
                                     //ВЫДАЕМ РЕЗУЛЬТАТ
                       
                               $result = '{"sites":[';
                               
                                     for($i = 0; $i < count($sites); $i++){
                                         
                                         $sitename = $sites[$i]['sitename'];
                                         $title = $sites[$i]['title'];
                                         $description = $sites[$i]['description'];
                                         $id = $sites[$i]['this_id'];
                                          $img_src = "";
                                      
                                       $result .= '{"sitename":"' . $sitename . '","title":"' . $title . '","description":"' . $description . '","id":"' . $id . '"},';
                                 }
                        
                                  $result .= '{"count":"' . count($sites) . '"}]}';
                                      echo $result; 
                            }  else { // Сайта нет
                                echo '{"sites":[]}';
                        } 
              
        }// Названия сайта в запросе нет

         

}
ob_end_flush(); 
?>

