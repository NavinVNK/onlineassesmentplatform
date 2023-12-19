<?php
include '../includes/uniques.php';
include '../database/config.php';
$myid = mysqli_real_escape_string($conn, $_POST['user']);
$new_password = mysqli_real_escape_string($conn, $_POST['newpass']);
$encrypt_pass=md5($new_password);

$sql = "SELECT * FROM tbl_users WHERE user_id = '$myid' OR email = '$myid'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
$myuserid = $row['user_id'];
$myemail = $row['email'];
$myfname = $row['first_name'];
$mylname = $row['last_name'];
$myfullname = "$myfname $mylname";
$activationcode=md5($myid.time());
//$new_password = get_rand_alphanumeric(10);
$status=0;
//$encpass = md5($new_password);
$sql = "UPDATE tbl_users SET activationcode='$activationcode',newpass='$encrypt_pass',status='$status' WHERE user_id='$myuserid'";

if ($conn->query($sql) === TRUE) {

$message.="<html></body><div><div>Dear $myfullname,</div></br></br>";
$message.="<div style='padding-top:8px;'>Please click The following link For verifying and activation of your password <br><b style='font-size:20px;color:red;background-color:lightgrey;'>$new_password</b></div>
<div style='padding-top:10px;'><a href='http://www.nayaudyogh.com/pages/email_verification.php?code=$activationcode'>Click Here</a></div>
<div style='padding-top:4px;'>Powered by <a href='7hillsts.com'>7hillsts</a></div></div>
</body></html>";

 //$message.= "Hellow $myfullname, we received a request for your new password for the <b>Online Examination System</b> account, therefore your password have been changed to <br><b style='font-size:20px;color:red;background-color:lightgrey;'>$new_password</b>";   
require '../mail/PHPMailerAutoload.php';

$mail = new PHPMailer;
                          

//$mail->isSMTP();                                      
$mail->Host = 'smtp.7hillsts.com';
$mail->SMTPAuth = true;                               
$mail->Username = 'assesment@7hillsts.com';           
$mail->Password = '2022@7hillsTS';                         
$mail->CharSet    = 'UTF-8';
$mail->SMTPDebug  = 3;
$mail->SMTPSecure = "ssl";
$mail->Port       = 465;                                   

$mail->setFrom('assesment@7hillsts.com', '7hillsTS Admin');
$mail->addAddress($myemail , $myfullname);              
//$mail->addReplyTo('jobs@7hillsts.com', 'Admin');
   
$mail->isHTML(true);                                 

$mail->Subject = 'Nayaudyogh Password Reset';
$mail->Body    = $message;
$mail->AltBody = $message;

if(!$mail->send()) {

} else {
header("location:../index.php?rp=1804");
}


} else {
header("location:../index.php?rp=1100");
}

	
    }
} else {
header("location:../index.php?rp=8924");
}
$conn->close();






