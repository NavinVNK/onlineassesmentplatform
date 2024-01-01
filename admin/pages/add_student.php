<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

include '../../mail2/PHPMailer.php';
include '../../mail2/Exception.php';
include '../../mail2/SMTP.php';
date_default_timezone_set('Africa/Dar_es_salaam');
include '../../database/config.php';
include '../../includes/uniques.php';
$student_id = 'S'.get_rand_numbers(3).'-'.get_rand_numbers(3).'-'.get_rand_numbers(3).'';
$fname = ucwords(mysqli_real_escape_string($conn, $_POST['fname']));
$lname = ucwords(mysqli_real_escape_string($conn, $_POST['lname']));
$email = mysqli_real_escape_string($conn, $_POST['email']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$department = mysqli_real_escape_string($conn, $_POST['department']);
$category = mysqli_real_escape_string($conn, $_POST['category']);
$subject = mysqli_real_escape_string($conn, $_POST['subject']);
$address = ucwords(mysqli_real_escape_string($conn, $_POST['address']));
$dob = mysqli_real_escape_string($conn, $_POST['dob']);
$gender = mysqli_real_escape_string($conn, $_POST['gender']);

$sql = "SELECT * FROM tbl_users WHERE email = '$email' OR phone = '$phone'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
    $sem = $row['email'];
	$sph = $row['phone'];
	if ($sem == $email) {
	 header("location:../students.php?rp=1189");	
	}else{
	
	if ($sph == $phone) {
	 header("location:../students.php?rp=2074");	
	}else{
		
	}
	
	}
	
    }
} else {

$sql = "INSERT INTO tbl_users (user_id, first_name, last_name, gender, dob, address, email, phone, department, category,subject)
VALUES ('$student_id', '$fname', '$lname', '$gender', '$dob', '$address', '$email', '$phone', '$department', '$category', '$subject')";

if ($conn->query($sql) === TRUE) {

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
		$mail->addAddress($email,$fname);               //Name is optional
	  //  $mail->addReplyTo('meghana.prakash@7hillsts.com', 'Information');
		//$mail->addCC("chamundeeswari.swamiaiah@7hillsts.com");
		//$mail->addBCC('ganeshan.vnk@gmail.com');
	
		//Attachments
	   // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
	   // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
	
		//Content
		$mail->isHTML(true);                                  //Set email format to HTML
		$mail->Subject = 'Hi'.$fname.' your registration for assesment';
		$mail->Body    = 'Hi'.$fname.'you are regidtered for assesment <b>in'.$department.'</b>';
		$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	
		$mail->send();
		echo 'Message has been sent';
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
  header("location:../students.php?rp=6310");
} else {
  header("location:../students.php?rp=9157");
}


}

$conn->close();
?>