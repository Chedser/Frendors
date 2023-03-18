<?php
ob_start();

$email_name = "frendors";

$content = file_get_contents('https://api.beget.ru/api/mail/getMailboxList?login=chedse6e&' .
                                    'passwd=yeGV3TgC&input_format=json&output_format=json&' .
                                    'input_data=' . urlencode('{"domain":"frendors.com"}'));


    if(stripos($content, '"mailbox":"' . $email_name . '"') === false){ // Не найден
        echo "free";
    }else{
        
        echo "not_free";
        
    }

ob_end_flush();
?>


