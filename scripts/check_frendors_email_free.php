<?php
ob_start();

if(empty($_SERVER['HTTP_REFERER'])){
header('Location: ../games/head_answers.php'); 
exit();   
}
header("Content-type: application/json; charset='utf-8'");

$email_name = strtolower(htmlspecialchars($_POST['email_name']));

if(!empty($email_name)){ 

    
    $content = file_get_contents('https://api.beget.ru/api/mail/getMailboxList?login=chedse6e&' .
                                    'passwd=yeGV3TgC&input_format=json&output_format=json&' .
                                    'input_data=' . urlencode('{"domain":"frendors.com"}'));

    if(stripos($content, '"mailbox":"' . $email_name . '"') === false){ // Не найден
        echo '{"free":"free"}';
    }else{
        
        echo '{"free":"not_free"}';
        
    }
    
}

ob_end_flush();
?>


