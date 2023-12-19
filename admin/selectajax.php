<?php
// Assume $db is your database connection
include '../database/config.php';

// Get the selected category ID from the AJAX request

$selectVal = $_GET['select_value'];
$queryId= $_GET['id'];
//$selected= $_GET['selected'];



$sql1 = "SELECT * FROM tbl_categories WHERE department='$selectVal' and status='Active' ORDER BY name";
$sql2 = "SELECT * FROM tbl_subjects WHERE category='$selectVal' and status='Active' ORDER BY name";
$sql3 = "SELECT * FROM tbl_examinations  WHERE subject='$selectVal' and  status='Active'ORDER BY exam_name";
$sql4 = "UPDATE tbl_assessment_records SET score='0', status='MAL2' WHERE record_id='$selectVal'";

                                     if($queryId=='1'){
                                            $result = $conn->query($sql1);
                                            $options = "<option value=' ' selected disabled>-Select Service-</option>";
                                            if ($result->num_rows > 0) {
                                               
    
                                            while($row = $result->fetch_assoc()) {
                                                $options .= "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                                            }
                                           } else {
                          
                                            }
                                            echo $options;
                                        } else  if($queryId=='2'){                                       
                                            $result = $conn->query($sql2);
                                            $options = "<option value=' ' selected disabled>-Select Service-</option>";
                                            if ($result->num_rows > 0) {
                                               
    
                                            while($row = $result->fetch_assoc()) {
                                                $options .= "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                                            }
                                           } else {
                          
                                            }
                                            echo $options;

                                        }
                                        else if($queryId=='3'){
                                            $result = $conn->query($sql3);

                                            if ($result->num_rows > 0) {
                                                $list .= "<h3>List of Examinations set</h3>";
                                                $list .= "<ul style='list-style-type:decimal;'>";  
    
                                            while($row = $result->fetch_assoc()) {
                                                
                                                $list .= "<li>" . $row['exam_name'] . "</li>";
                                              
                                            }
                                            $list .= "</ul>";
                                           } else {
                                            echo " <p >No examinations set </p>";
                          
                                            }
                                            echo $list;
                                            

                                        }
                                       else  if($queryId=='5'){                                       
                                            $result = $conn->query($sql2);

                                            if ($result->num_rows > 0) {
                                               
    
                                            while($row = $result->fetch_assoc()) {
                                                if ($selected == $row['name']) {
                                                    $options .=   "<option selected value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                                                    }else{
                                                $options .= "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                                                    }
                                            }
                                           } else {
                          
                                            }
                                            echo $options;

                                        }
                                        else  if($queryId=='6'){                                       
                                            $result = $conn->query($sql3);

                                            if ($result->num_rows > 0) {
                                               
    
                                            while($row = $result->fetch_assoc()) {
                                                if ($selected == $row['name']) {
                                                    print '<option selected value="'.$row['name'].'">'.$row['name'].'</option>';	
                                                    }else{
                                                $options .= "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                                                    }
                                            }
                                           } else {
                          
                                            }
                                            echo $options;

                                        }
                                        else{

                                           //if ($conn->query($sql4) === TRUE) {
                                            
                                                echo "<input type='hidden' name='mal' value='" . $selectVal . "'>" ;

                                           /* } else {
                                                echo"failure";

                                            }*/
                                            //$options= $selectVal;
                                            //echo $options;
                                        }
                                             $conn->close();
                                             // Close the database connection
                                             mysqli_close($db);



?>
