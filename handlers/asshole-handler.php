<?php ob_start(); ?>

<?php

require_once '../scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

$target = trim(addslashes(htmlspecialchars($_POST['target'])));
$definition = trim(addslashes(htmlspecialchars($_POST['definition'])));
$extra = trim(addslashes(htmlspecialchars($_POST['extra'])));

if(!empty($extra)){
    
    $extra = preg_replace("/  +/is"," ",$extra);
    
    if(strlen($extra) > 512){
        
        $extra = substr($extra, 0, 512);
        
    }
    
}

if(!empty($target) && !empty($definition)){


 $response = '';
    $target =  preg_replace("/  +/is"," ",$target);
    $definition =  preg_replace("/  +/is"," ",$definition);
        
        $sql = "SELECT *  FROM `asshole` WHERE `target`='{$target}' AND `definition`='{$definition}'";	
        $query = $connection_handler->prepare($sql);
        $query->execute();
        $asshole_qr = $query->fetchAll(PDO::FETCH_ASSOC);
        
                if(!empty($asshole_qr)){
                    
                    $response = json_encode(array("reserved"));
                }else{

                    $sql = "INSERT INTO `asshole`(`target`,`definition`,`extra`) VALUE ('{$target}','{$definition}','{$extra}')";
                    $query = $connection_handler->prepare($sql);
                    $query->execute(); 
       
   
       
       $response = json_encode(array($connection_handler->lastInsertId()));
       
                }

     echo $response;
     
        

}


?>

<?php ob_end_flush(); ?>
