<?php
ob_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
header("Content-type: text/plain; charset='utf-8'");


 
 
 /***********************************************************************************************************/
                                     function get_site_info($arg){
                                         
                                                         function _utf8_decode($string)
                                                    {
                                                      $tmp = $string;
                                                      $count = 0;
                                                      while (mb_detect_encoding($tmp)=="UTF-8")
                                                      {
                                                        $tmp = utf8_decode($tmp);
                                                        $count++;
                                                      }
                                                      
                                                      for ($i = 0; $i < $count-1 ; $i++)
                                                      {
                                                        $string = utf8_decode($string);
                                                        
                                                      }
                                                      
                                                      $string = str_replace('?',"",$string);
                                                      
                                                      return $string;
                                                      
                                                    }
                                       
                                       
                                       /*************************************************************/
                                       
                                    
                                        
                                        $sitename = 'http://' . $arg;
                                        $siteinfo_arr = array();
                                     
                                    $content = file_get_contents($sitename);
                                       
                                        //domelement
                                    		$dom = new DOMDocument;	//создаем объект
                                    		
                                    		$dom->loadHTML($content);	//загружаем контент
                                    		$metas = $dom->getElementsByTagName('meta');   //берем все теги a
                                    	    $title = $dom->getElementsByTagName('title')->item(0)->nodeValue;   //берем тэг title
                                    
                                    	   if(empty($title)){
                                    	       /* Берем первый h1 */
                                    	       $h1 = $dom->getElementsByTagName('h1')->item(0)->nodeValue;   //берем тэг title
                                    
                                    	       if(empty($h1)){
                                    	   	       $title = "Нет заголовка нахуй!";
                                    	   }else{
                                    	       $title = $h1;
                                    	   }
                                    } 
                                    
                                    /************************************************************/
                                    
                                    		$description = "";
                                    		
                                    		for ($j = 0; $j < $metas->length; $j++) {
                                    		$name =	$metas->item($j)->getAttribute('name');	//вытаскиваем из тега атрибут name
                                    		
                                        		 if($name === 'description'){
                                        		   $description = $metas->item($j)->getAttribute('content');	//вытаскиваем из тега атрибут name
                                           		  break;
                                        		 }   
                                    	
                                    		}
                                    
                                                 if(empty($description)){
                                    
                                    	   	       $description = "Нет  описания нахуй!";
                                    }
                                    
                                            $description = _utf8_decode($description);
                                            $title = _utf8_decode($title);
                                            
                                            /***************************************************************/
                                            $img = "";
                                            $img_src = "";
                                    		
                                    				for ($k = 0; $k < $metas->length; $k++) {
                                    		$name =	$metas->item($k)->getAttribute('property');	//вытаскиваем из тега атрибут name
                                    		
                                        		 if($name === 'og:image'){
                                        		   $img_src = $metas->item($k)->getAttribute('content');	//вытаскиваем из тега атрибут name
                                           		  $img = "<img src = " . $img_src . " height = '50' width = '50' style = 'margin:5px' />";
                                           		  break;
                                        		 }   
                                    	
                                    		}
                                    	array_push($siteinfo_arr,$title);
                                    	array_push($siteinfo_arr,$description);
                                    	return $siteinfo_arr;
                                         
                                     }
  
 
 /* ПРОВЕРЯЕМ ЕСТЬ ЛИ ТАКОЙ САЙТ В БАЗЕ */
                $sql = "SELECT * FROM `sites`";
                $query = $connection_handler->prepare($sql);
                $query->execute();
                $sites = $query->fetchAll(PDO::FETCH_ASSOC);
   
   for($i = 0; $i < count($sites); $i++){
     
     $sitename = $sites[$i]['sitename'];
        
          if(checkdnsrr($sitename) != false){ // Проверяем существует ли такой сайт
 
            $site_info_for_db = get_site_info($sitename);        
                                        /* ВСТАВЛЯЕМ САЙТ В ТАБЛИЦУ */
                    $sql = "UPDATE `sites` SET `title`='" . $site_info_for_db[0] . "',`description`='" . $site_info_for_db[1] . "' WHERE `sitename`='" . $sitename . "'";
                    $query = $connection_handler->prepare($sql);
                    $query->execute();
                                        

                    }else{
                            
                                        $sql = "DELETE FROM `sites` WHERE `sitename`='{$sitename}'";
                                        $query = $connection_handler->prepare($sql);
                                        $query->execute();
    
                }
}

ob_end_flush(); 
?>

