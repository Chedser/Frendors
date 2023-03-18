<?php 

if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

$rand_conv = mt_rand(0,1);

if($rand_conv == 1) echo 'bigger';
else echo 'less';
?>

