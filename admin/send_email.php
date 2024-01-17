
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
include '../includes/moverecords.php';
include '../database/config.php';
include '../mail2/PHPMailer.php';
include '../mail2/Exception.php';
include '../mail2/SMTP.php';

if (isset($_GET['studid'])&& isset($_GET['examid'])) {
    $ms =1;
	$student_id = mysqli_real_escape_string($conn, $_GET['studid']);
	$sql = "SELECT * FROM tbl_users WHERE user_id = '$student_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
	$sdfname = $row['first_name'];
	$sdlname = $row['last_name'];
	$sdemail = $row['email'];
    $sdexam = $row['exam'];
    }
} else {
   // header("location:./");
}

	$exam_id = mysqli_real_escape_string($conn, $_GET['examid']);
	$sql = "SELECT * FROM tbl_examinations WHERE exam_id = '$exam_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
	$exam_name = $row['exam_name'];
	$exam_date = $row['date'];
	
    }
} else {
   // header("location:./");
}
if($sdexam===$exam_name)
{

}
else{
        $sql = "UPDATE tbl_users SET exam='$exam_name' WHERE user_id = '$student_id'";

        if ($conn->query($sql) === TRUE) {
          /*  $sql = "DELETE FROM tbl_assessment_records WHERE student_id = '$student_id'";

            if ($conn->query($sql) === true)
            {

            }
            else
            {

            }*/
            moveAssessmentToHistory($student_id, $conn);
            echo "updated";
        } else {
            echo "Not updated";
        }
    }   
	
}else{
	//header("location:./");
}
echo $exam_name.$exam_date.$sdfname;

//Create an instance; passing `true` enables exceptions
/*$mail = new PHPMailer(true);

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
    $mail->addAddress($sdemail,$sdfname." ".$sdlname);               //Name is optional
  //  $mail->addReplyTo('meghana.prakash@7hillsts.com', 'Information');
    $mail->addCC("nawin.vnk@gmail.com");
    //$mail->addBCC('ganeshan.vnk@gmail.com');

    //Attachments
   // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
   // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'You have an assesment to take on';
    $mail->Body    = 'Dear'.$sdlname.'<br>We have set up assesment on  <b>'.$exam_name.'</b> you need to login and complete the assesment on or before<b>'.$exam_date.'</b>';
    $mail->AltBody = 'Dear candidate<br>We have set up assesment on  <b>'.$exam_name.'</b> you need to login and complete the assesment on or before<b>'.$exam_date.'</b>';

    $mail->send();
    echo 'Message has been sent';
    header("location:./view-student.php?id='.$student_id.'&rp=4000");
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    header("location:./view-student.php?id='.$student_id.'&rp=4001");
    
}*/

?>