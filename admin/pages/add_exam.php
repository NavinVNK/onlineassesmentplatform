<?php
date_default_timezone_set('Africa/Dar_es_salaam');
include '../../database/config.php';
include '../../includes/uniques.php';
$exam_id = 'EX_'.get_rand_numbers(6).'';
$exam = ucwords(mysqli_real_escape_string($conn, $_POST['exam']));
$duration = mysqli_real_escape_string($conn, $_POST['duration']);
$tot_ques = mysqli_real_escape_string($conn, $_POST['tot_ques']);
$ques_easy = mysqli_real_escape_string($conn, $_POST['ques_easy']);
$ques_medium = mysqli_real_escape_string($conn, $_POST['ques_medium']);
$ques_hard = mysqli_real_escape_string($conn, $_POST['ques_hard']);
$passmark = mysqli_real_escape_string($conn, $_POST['passmark']);
$attempts = mysqli_real_escape_string($conn, $_POST['attempts']);
$date = mysqli_real_escape_string($conn, $_POST['date']);
$department = mysqli_real_escape_string($conn, $_POST['deptartment']);
$subject = mysqli_real_escape_string($conn, $_POST['subject']);
$category = mysqli_real_escape_string($conn, $_POST['category']);
$terms = ucfirst(mysqli_real_escape_string($conn, $_POST['instructions']));

$sql = "SELECT * FROM tbl_examinations WHERE exam_name = '$exam' AND subject = '$subject' AND category = '$category'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
header("location:../examinations.php?rp=1185");
    }
} else {

$sql = "INSERT INTO tbl_examinations (exam_id, department,category, subject, exam_name, date, duration,tot_ques,ques_easy,ques_medium,ques_hard,passmark, re_exam, terms)
VALUES ('$exam_id', '$department','$category', '$subject', '$exam', '$date','$duration','$tot_ques','$ques_easy','$ques_medium','$ques_hard', '$passmark', '$attempts', '$terms')";

if ($conn->query($sql) === TRUE) {
header("location:../examinations.php?rp=2932");
} else {
header("location:../examinations.php?rp=7788");
}


}
$conn->close();
?>
