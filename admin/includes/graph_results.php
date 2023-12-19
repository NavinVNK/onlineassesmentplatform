<?php
extract($_POST);
include '../../database/config.php';
$std_pass=0;
$std_fails=0;
$std_25=0;
$std_50=0;
$std_75=0;
$std_100=0;

//if(isset($passresult))
//{

$sql = "SELECT * FROM tbl_assessment_records where exam_id ='".$exam."'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
   
    while($row = $result->fetch_assoc()) {
     $status = $row['status'];
	 if ($status == "PASS"){
		 $std_pass++;
	 }else{
		$std_fails++; 
		 
	 }

	 
    }

}

$sql = "SELECT * FROM tbl_assessment_records where exam_id ='".$exam."'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $score= $row['score'];
        if($score<25) 
        {
            $std_25++;
            //$return_arr[] = array("one"=>$row25
        }
        else if($score>=25&& $score <=50) 
        {
            $std_50++;
            //$return_arr[] = array("one"=>$row25
        }
        else if($score>=50&& $score <75) 
        {
            $std_50++;
            //$return_arr[] = array("one"=>$row25
        }
        else{
            $std_100++;
        }
   
        
       }

}
$return_arr[] = array("pass" => $std_pass,
"fail" => $std_fails,"score25" => $std_25,
"score50" => $std_50,"score75" => $std_75,"score100" => $std_100);
$conn->close();
//` }

    // Encoding array in JSON format
    echo json_encode($return_arr);



?>