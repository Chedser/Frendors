<?php ob_start(); ?>

<?php

require_once 'scripts/connection.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

$asshole = trim(addslashes(htmlspecialchars($_POST['ASSHOLE'])));

if(!empty($asshole)){

       if(strlen($asshole) <= 100){

 $response = '';
    $asshole =  preg_replace("/  +/is"," ",$asshole);
        
        $sql = "SELECT *  FROM `fuck_you` WHERE `text`='{$asshole}'";	
        $query = $connection_handler->prepare($sql);
        $query->execute();
        $asshole_qr = $query->fetchAll(PDO::FETCH_ASSOC);
        
                if(!empty($asshole_qr)){
                    
                    $response = json_encode(array("reserved"));
                }else{

              
                   
                    $sql = "INSERT INTO `fuck_you`(`text`) VALUE ('{$asshole}')";
                    $query = $connection_handler->prepare($sql);
                    $query->execute(); 
       
   
       
       $response = json_encode(array($connection_handler->lastInsertId()));
       
                }

     echo $response;
     
       } 

}


?>

<?php ob_end_flush(); ?>
