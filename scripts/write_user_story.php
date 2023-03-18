<?php 
ob_start();
session_start(); 

require_once 'connection.php';

if(empty($_SERVER['HTTP_REFERER']) || empty($_SESSION['user'])){
header('Location: ../games/head_answers.php'); 
exit();   
}

$name = htmlspecialchars($_POST['name']);
$text = htmlspecialchars($_POST['text']);

if(!empty($name) && !empty($text)){

$sql = "INSERT INTO `user_stories`(`name`,`author`,`text`) VALUES('{$name}','{$_SESSION['user']}','{$text}')";	
$query = $connection_handler->prepare($sql);
$query->execute();

$user_story_id = $connection_handler->lastInsertId();

$msg_txt = 'Я написал историю <a href=/user_story.php?id=' . $user_story_id . ' target = _blank>' . $name . '</a>';

//$msg_txt = htmlspecialchars($msg_txt, ENT_QUOTES);

 $data_array = array($_SESSION['user'], $msg_txt, $_SESSION['user']);
                        $sql = "INSERT INTO wall_user_posts(nickname,message,page_id) VALUES(?,?,?) "; 
                        $query = $connection_handler->prepare($sql);
                        $query->execute($data_array);
  
}

?>

<?php ob_end_flush(); ?>