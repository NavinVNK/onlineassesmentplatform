<?php
include './includes/uniques.php';
include './database/config.php';

require './mail/PHPMailerAutoload.php';

$mail = new PHPMailer;
                          

//$mail->isSMTP();                                      
$mail->Host = 'smtp.7hillsts.com';
$mail->SMTPAuth = true;                               
$mail->Username = 'Admin';           
$mail->Password = '2021@7hillsTS';                         
$mail->CharSet    = 'UTF-8';
$mail->SMTPDebug  = 3;
$mail->SMTPSecure = "ssl";
$mail->Port       = 465;                                   

$mail->setFrom('assesment@7hillsts.com', 'Admin');
$mail->addAddress('meghanap24@yahoo.com' , 'Meghana');              
//$mail->addReplyTo('meghanap24@yahoo.com', 'Admin');
   
$mail->isHTML(true);                                 

$mail->Subject = 'Nayaudyogh Password Reset';
$mail->Body    = 'Sending via luck using 465';
$mail->AltBody = 'Sending via luck';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
