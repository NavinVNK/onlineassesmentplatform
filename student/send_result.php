<?php
if (isset($_GET['myfullname'])&& isset($_GET['myemail'])&& 
isset($_GET['exam_name'])&& isset($_GET['score'])&& isset($_GET['next_retake'])&& isset($_GET['taking_date'])) {
    $myfname =$_GET['myfname'];
    $mylname=$_GET['mylname'];
    $myfullname= $_GET['myfullname'];
     $exam_name=$_GET['exam_name'];
     $score=$_GET['score'];
   $next_retake=$_GET['next_retake'];
   $taking_date=$_GET['taking_date'];
   $myemail=$_GET['myemail'];

   
 //echo $myfullname.$exam_name,$score.$next_retake.$taking_date.$myemail. $myfname. $mylname;
 $message =" <table class='table' rules='all' style='border-color: #666;' cellpadding='10'>
                                           </thead>
                                           <tbody>
                                               <tr style='background: #eee;'>
                                                   <th scope='row'>1</th>
                                                   <td><strong>Assessment Name</td>
                                                   <td> $exam_name</td>
                                               </tr>
											     <tr style='background: #eee;'>
                                                   <th scope='row'>2</th>
                                                   <td><strong>Candidate_name</td>
                                                   <td>$myfname $mylname</td>
                                               </tr>
											    <tr style='background: #eee;'>
                                                   <th scope='row'>3</th>
                                                   <td><strong>Score</td>
                                                   <td> $score %</td>
                                               </tr>

											   
											  <tr style='background: #eee;'>
                                                   <th scope='row'>4</th>
                                                   <td><strong>Next Re-take</td>
                                                   <td>$next_retake</td>
                                               </tr>

                                              
                                           </tbody>
                                        </table>";

 $mail = new PHPMailer(true);

try {
    //Server settings
  //  $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
   // $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'mail.7hillslab.in';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'admin@7hillslab.in';                     //SMTP username
    $mail->Password   = '7hills@2023';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('admin@7hillslab.in', '7hillsLab Admin');
 //   $mail->addAddress('meghanap63@gmail.com', 'Joe User');     //Add a recipient
    $mail->addAddress($myemail , $myfullname);                //Name is optional
  //  $mail->addReplyTo('meghana.prakash@7hillsts.com', 'Information');
   // $mail->addCC("chamundeeswari.swamiaiah@7hillsts.com");
    //$mail->addBCC('ganeshan.vnk@gmail.com');

    //Attachments
   // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
   // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Assesment Result';
    $mail->Body    = $message;
    $mail->AltBody = $message;
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}



}

?>