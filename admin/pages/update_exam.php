<?php
date_default_timezone_set('Africa/Dar_es_salaam');
include '../../database/config.php';
include '../../includes/uniques.php';
$exam_id = $_POST['examid'];
$exam = ucwords(mysqli_real_escape_string($conn, $_POST['exam']));
$duration = mysqli_real_escape_string($conn, $_POST['duration']);
$tot_ques = mysqli_real_escape_string($conn, $_POST['tot_ques']);
$ques_easy = mysqli_real_escape_string($conn, $_POST['ques_easy']);
$ques_medium = mysqli_real_escape_string($conn, $_POST['ques_medium']);
$ques_hard = mysqli_real_escape_string($conn, $_POST['ques_hard']);
$passmark = mysqli_real_escape_string($conn, $_POST['passmark']);
$attempts = mysqli_real_escape_string($conn, $_POST['attempts']);
$date = mysqli_real_escape_string($conn, $_POST['date']);
$subject = mysqli_real_escape_string($conn, $_POST['subject']);
$category = mysqli_real_escape_string($conn, $_POST['category']);
$terms = ucfirst(mysqli_real_escape_string($conn, $_POST['instructions']));

$sql = "SELECT * FROM tbl_examinations WHERE exam_name = '$exam' AND subject = '$subject' AND category = '$category' AND exam_id != '$exam_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
header("location:../examinations.php?rp=1185");
    }
} else {

$sql = "UPDATE tbl_examinations SET category = '$category', subject = '$subject', exam_name = '$exam', date = '$date', duration = '$duration',tot_ques='$tot_ques',ques_easy='$ques_easy',ques_medium='$ques_medium',ques_hard='$ques_hard', passmark = '$passmark', re_exam = '$attempts', terms = '$terms' WHERE exam_id='$exam_id'";

if ($conn->query($sql) === TRUE) {
header("location:../edit-exam.php?rp=7823&eid=$exam_id");
} else {
header("location:../edit-exam.php?rp=1298&eid=$exam_id");
}


}
$conn->close();
?>
