<?php
error_reporting(0);
$total_marks = $_POST['tm'];
$total_questions= $_POST['tq'];
$starting_mark = 1;
$mytotal_marks = 0;
$exam_id = $_POST['eid'];
$record = $_POST['ri'];
 
$x=0;
while ($starting_mark <= $total_questions) {
   
$x++;
  //echo $x.": ".strtoupper(base64_decode($_POST['ran'.$starting_mark.''])) ." <-|->". strtoupper($_POST['an'.$starting_mark.''])."<br>";
         if(strtoupper(base64_decode($_POST['etyp'.$starting_mark.'']))=='ML')
              {
                  
                   $mark_count=0.0;
            $i=0;
            $split_ans = str_split(strtoupper(base64_decode($_POST['ran'.$starting_mark.''])));
                // Assuming you have checkboxes named checkbox1, checkbox2, checkbox3, and checkbox4
            $checkboxNames = ['an1'.$starting_mark.'', 'an2'.$starting_mark.'', 'an3'.$starting_mark.'', 'an4'.$starting_mark.''];
           foreach ($checkboxNames as $checkboxName) {
                // Check if the checkbox is set in the form
                if (isset($_POST[$checkboxName]) && $split_ans[$i]== 'Y') {
          // Checkbox is checked
                    $mark_count+=0.25;
                   // $checkboxStatus[$checkboxName] = 'Y';
                 } else if(!isset($_POST[$checkboxName]) &&$split_ans[$i]== 'N'){
          // Checkbox is unchecked
                              $mark_count+=0.25;
                              //$checkboxStatus[$checkboxName] = 'N';
                  }
                  else
                  {
                        $mark_count+= 0;
                  }
         $i++;
         }
         // echo strtoupper(base64_decode($_POST['ran'.$starting_mark.''])) ." outside ". $mark_count."<br>";
         if (abs($mark_count-1.0/1.0) < 0.00001)
            {
                  if(strtoupper(base64_decode($_POST['typ'.$starting_mark.'']))=="E")
                        $mytotal_marks = $mytotal_marks + 1;	
                  if(strtoupper(base64_decode($_POST['typ'.$starting_mark.'']))=="M")
                        $mytotal_marks = $mytotal_marks + 2;
                  if(strtoupper(base64_decode($_POST['typ'.$starting_mark.'']))=="H")
                        $mytotal_marks = $mytotal_marks + 3;
                        
                        // echo $x.": ".strtoupper(base64_decode($_POST['ran'.$starting_mark.''])) ." inside ". $mark_count."<br>";
            }
                 
                  
              }
         else
         {
                        if (strtoupper(base64_decode($_POST['ran'.$starting_mark.''])) === strtoupper($_POST['an'.$starting_mark.''])) {
                          if(strtoupper(base64_decode($_POST['typ'.$starting_mark.'']))=="E")
                                $mytotal_marks = $mytotal_marks + 1;	
                          if(strtoupper(base64_decode($_POST['typ'.$starting_mark.'']))=="M")
                                $mytotal_marks = $mytotal_marks + 2;
                          if(strtoupper(base64_decode($_POST['typ'.$starting_mark.'']))=="H")
                                $mytotal_marks = $mytotal_marks + 3;	
                                
                          //echo $x.": ".strtoupper(base64_decode($_POST['ran'.$starting_mark.''])) ." inside ". strtoupper($_POST['an'.$starting_mark.''])."<br>";
        
        
                    }else{
                          
                    } 
         }




      

$starting_mark++;
}
//echo "marks".$mytotal_marks;
$percent_score = ($mytotal_marks / $total_marks) * 100;
$percent_score = floor($percent_score);
$passmark = $_POST['pm'];

if ($percent_score >= $passmark) {
$status = "PASS";	
}else{
$status = "FAIL";	
}

//session_start();
// 30.11.23 Begin Check if the session variable is not set

  
  //30.11.23End
include '../../database/config.php';
$mal = isset($_POST['mal']) ? $_POST['mal'] : '';
if($mal=="mal2"){
      $sql = "UPDATE tbl_assessment_records SET score='$percent_score',status='MAL2' WHERE record_id='$record'";
      
  } else if ($mal=="mal1"){
      $sql = "UPDATE tbl_assessment_records SET score='$percent_score',status='MAL1' WHERE record_id='$record'";

  }
  else{
      $sql = "UPDATE tbl_assessment_records SET score='$percent_score', status='$status' WHERE record_id='$record'";
      
 
  }


if ($conn->query($sql) === TRUE) {

	
  header("location:../assessment-info.php");
} else {
  header("location:../assessment-info.php");
}

$conn->close();
?>
