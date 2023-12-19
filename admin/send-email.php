
<?php
include '../mail/PHPMailerAutoload.php';

$mail = new PHPMailer;
                  

//$mail->isSMTP();                                      
$mail->Host = 'smtp.7hillsts.com';
$mail->SMTPAuth = true;                               
$mail->Username = 'meghana.prakash@7hillsts.com';           
//$mail->Password = '2022@7hillsTS';  This is the password of Godaddy Mail account 
$mail->Password = 'Luc73730'; 
$mail->CharSet    = 'UTF-8';
$mail->SMTPDebug  = 3;
$mail->SMTPSecure = "ssl";
$mail->Port       = 465;                                   

//$mail->setFrom('assesment@7hillsts.com', '7hillsTS Admin');
$mail->setFrom('meghana.prakash@7hillsts.com', '7hillsTS Admin');
$mail->addAddress('meghana.prakash@7hillsts.com', 'Meghana');              
//$mail->addReplyTo('jobs@7hillsts.com', 'Admin');
   
$mail->isHTML(true);                                 

$mail->Subject = 'Nayaudyogh Test';
$mail->Body    = "Test";
$mail->AltBody = "Test Again";

if(!$mail->send()) {
  
echo " <h1>Mail Not send Failed</h1>";
echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
  echo " <h1>Mail send successfully</h1>";
}


?>