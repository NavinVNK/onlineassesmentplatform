<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

include '../mail2/PHPMailer.php';
include '../mail2/Exception.php';
include '../mail2/SMTP.php';
include '../includes/uniques.php';
include '../database/config.php';
$myid         = mysqli_real_escape_string($conn, $_POST['user']);
$new_password = mysqli_real_escape_string($conn, $_POST['newpass']);
$encrypt_pass = md5($new_password);

$sql    = "SELECT * FROM tbl_users WHERE user_id = '$myid' OR email = '$myid'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    
    while ($row = $result->fetch_assoc()) {
        $myuserid       = $row['user_id'];
        $myemail        = $row['email'];
        $myfname        = $row['first_name'];
        $mylname        = $row['last_name'];
        $myfullname     = "$myfname $mylname";
        $activationcode = md5($myid . time());
        //$new_password = get_rand_alphanumeric(10);
        $status         = 0;
        //$encpass = md5($new_password);
        $sql            = "UPDATE tbl_users SET activationcode='$activationcode',newpass='$encrypt_pass',status='$status' WHERE user_id='$myuserid'";
        
        if ($conn->query($sql) === TRUE) {
            
            $message .= "<html></body><div><div>Dear $myfullname,</div></br></br>";
            $message .= "<div style='padding-top:8px;'>Please click The following link For verifying and activation of your password <br><b style='font-size:20px;color:red;background-color:lightgrey;'>$new_password</b></div>
<div style='padding-top:10px;'><a href='http://www.nayaudyogh.com/pages/email_verification.php?code=$activationcode'>Click Here</a></div>
<div style='padding-top:4px;'>Powered by <a href='7hillsts.com'>7hillsts</a></div></div>
</body></html>";
            
            //$message.= "Hellow $myfullname, we received a request for your new password for the <b>Online Examination System</b> account, therefore your password have been changed to <br><b style='font-size:20px;color:red;background-color:lightgrey;'>$new_password</b>";  
         //   require '../mail/PHPMailerAutoload.php';
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

            $mail->setFrom('admin@7hillslab.com', '7hillLab Admin');
            $mail->addAddress($myemail, $myfullname);
            //$mail->addReplyTo('jobs@7hillsts.com', 'Admin');
            
            $mail->isHTML(true);
            
            $mail->Subject = 'Nayaudyogh Password Reset';
            $mail->Body    = $message;
            $mail->AltBody = $message;
            if (!$mail->send()) {
                
            } else {
                header("location:../index.php?rp=1804");
            }
           echo 'Message has been sent';
         } catch (Exception $e) {
                   echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
          }
            

            
            
        } else {
            header("location:../index.php?rp=1100");
        }
        
        
    }
} else {
    header("location:../index.php?rp=8924");
}
$conn->close();