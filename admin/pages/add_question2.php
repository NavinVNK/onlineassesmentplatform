<?php
include '../../database/config.php';
include '../../includes/uniques.php';
$examid = mysqli_real_escape_string($conn, $_POST['exam']);
$questype=mysqli_real_escape_string($conn, $_POST['questype']);
$question_id = 'QS-'.get_rand_numbers(6).'';
$question = mysqli_real_escape_string($conn, $_POST['question']);
$answer = "";

if (isset($_GET['type'])) {
$question_type = $_GET['type'];	
if ($question_type == "mc") {	
$answer = mysqli_real_escape_string($conn, $_POST['answer']);
$opt1 = mysqli_real_escape_string($conn, $_POST['opt1']);
$opt2 = mysqli_real_escape_string($conn, $_POST['opt2']);
$opt3 = mysqli_real_escape_string($conn, $_POST['opt3']);
$opt4 = mysqli_real_escape_string($conn, $_POST['opt4']);


$sql = "SELECT * FROM tbl_questions WHERE exam_id = '$examid' AND question = '$question'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
 header("location:../questions.php?rp=1185");
    }
} else {

$sql = "INSERT INTO tbl_questions (question_id, exam_id, type,ques_type, question, option1, option2, option3, option4, answer)
VALUES ('$question_id', '$examid', 'MC','$questype', '$question', '$opt1', '$opt2', '$opt3', '$opt4', '$answer')";

if ($conn->query($sql) === TRUE) {
    header("location:../questions.php?rp=0357");	
} else {
 header("location:../questions.php?rp=3903");	
}

}
}

    else if($question_type == "ml") {
          
        $opt21 = mysqli_real_escape_string($conn, $_POST['opt1']);
        $opt22 = mysqli_real_escape_string($conn, $_POST['opt2']);
        $opt23 = mysqli_real_escape_string($conn, $_POST['opt3']);
        $opt24 = mysqli_real_escape_string($conn, $_POST['opt4']);
        if(isset($_POST['answer1']) && 
        $_POST['answer1'] == 'option1') 
     {
         $answer.="y";
     }
     else
     {
     $answer.="n";
     }
     if(isset($_POST['answer2']) && 
        $_POST['answer2'] == 'option2') 
     {
         $answer.="y";
     }
     else
     {
     $answer.="n";
     }
     
     
        if(isset($_POST['answer3']) && 
        $_POST['answer3'] == 'option3') 
     {
         $answer.="y";
     }
     else
     {
     $answer.="n";
     }
     if(isset($_POST['answer4']) && 
        $_POST['answer4'] == 'option4') 
     {
         $answer.="y";
     }
     else
     {
     $answer.="n";
     }
     

        $sql = "SELECT * FROM tbl_questions WHERE exam_id = '$examid' AND question = '$question'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                header("location:../questions.php?rp=1185");
            }
        } else {
            $sql = "INSERT INTO tbl_questions (question_id, exam_id, type,ques_type, question, option1, option2, option3, option4, answer)
VALUES ('$question_id', '$examid', 'ML','$questype', '$question', '$opt21', '$opt22', '$opt23', '$opt24', '$answer')";
            if ($conn->query($sql) === TRUE) {
                echo "<h3>".$answer."inserted";
                header("location:../questions.php?rp=0357");
            } else {
                echo "<h3>".$answer."Not inserted";
                header("location:../questions.php?rp=3903");
                 
            }
        }
    }
else if($question_type == "fib") {
$answer = mysqli_real_escape_string($conn, $_POST['answer']);
$sql = "SELECT * FROM tbl_questions WHERE exam_id = '$examid' AND question = '$question'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
header("location:../add-questions.php?rp=1185&eid=$examid");
    }
} else {

$sql = "INSERT INTO tbl_questions (question_id, exam_id, type,ques_type, question, answer)
VALUES ('$question_id', '$examid', 'FB', '$questype','$question', '$answer')";

if ($conn->query($sql) === TRUE) {
  header("location:../questions.php?rp=0357");  	
} else {
 header("location:../questions.php?rp=3903");
}


}


}else{
	
}
	
}else{
	
header("location:../");	
	
}


?>