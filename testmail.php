
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

include 'mail2/PHPMailer.php';
include 'mail2/Exception.php';
include 'mail2/SMTP.php';
//$mail = new PHPMailer;

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
  //  $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
   // $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'mail.7hillsts.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'assesment@7hillsts.com';                     //SMTP username
    $mail->Password   = '2021@7hillsTS';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('assesment@7hillsts.com', '7hillsTS Admin');
 //   $mail->addAddress('meghanap63@gmail.com', 'Joe User');     //Add a recipient
    $mail->addAddress('meghanap24@yahoo.co.in','Joe');               //Name is optional
  //  $mail->addReplyTo('meghana.prakash@7hillsts.com', 'Information');
   // $mail->addCC("meghanap63@gmail.com");
    //$mail->addBCC('ganeshan.vnk@gmail.com');

    //Attachments
   // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
   // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Here is the subject using test mai l';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

                  
/*
//$mail->isSMTP();                                      
$mail->Host = 'smtp.7hillsts.com';
$mail->SMTPAuth = true; 
//$mail->Username = 'assesment@7hillsts.com'; 
$mail->Username = 'meghana.prakash@7hillsts.com';           
//$mail->Password = '2022@7hillsTS';   
$mail->Password = 'Luc73730'; 
$mail->CharSet    = 'UTF-8';
$mail->SMTPDebug  = 3;
$mail->SMTPSecure = "ssl";
$mail->Port       = 465;                                   

//$mail->setFrom('assesment@7hillsts.com', '7hillsTS Admin');
$mail->setFrom('meghana.prakash@7hillsts.com', '7hillsTS Admin');
$mail->addAddress("meghanap63@gmail.com" , "Megna");   
//$mail->addAddress("nav_wins@yahoo.co.in" , "Nav");  
//$mail->addReplyTo('jobs@7hillsts.com', 'Admin');
   
$mail->isHTML(true);                                 

$mail->Subject = 'Nayaudyogh Test';
$mail->Body    = "Test with ASSESMENT ID- .com";
$mail->AltBody = "Test Again";

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
*/



?>