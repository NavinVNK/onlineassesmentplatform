<?php 
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
//require_once 'DataSource.php';
include '../database/config.php';
include '../includes/uniques.php';
include 'includes/check_user.php'; 
include 'includes/check_reply.php';
require_once ('./vendor/autoload.php');
//$db = new DataSource();
//$dbconn = $db->getConnection();
if (isset($_POST["import"])) {

    $allowedFileType = [
        'application/vnd.ms-excel',
        'text/xls',
        'text/xlsx',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    ];

    if (in_array($_FILES["file"]["type"], $allowedFileType)) {

        $targetPath = 'uploads/' . $_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);

        $Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

        $spreadSheet = $Reader->load($targetPath);
        $excelSheet = $spreadSheet->getActiveSheet();
        $spreadSheetAry = $excelSheet->toArray();
        $sheetCount = count($spreadSheetAry);

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($targetPath );
        $worksheet = $spreadsheet->getActiveSheet();
       $worksheetArray = $worksheet->toArray();
       array_shift($worksheetArray);
       //$sheetCount = count($worksheetArray);
		$status=array();
		
		// validations
		$exam_idvalidate = array();
		$type_validate= array();
		$ques_typevalidate= array();
		$question_validate= array();
		$option1_validate= array();
		$option2_validate= array();
		$option3_validate= array();
		$option4_validate= array();
		$answer_validate= array();
      //  for ($i = 1; $i <= $sheetCount; $i ++) {
        $i = 1;
        foreach ($worksheetArray as $key => $value) {
            $exam_idstatus=0;
            $question_id = 'QS-'.get_rand_numbers(6).'';

            $exam_id = "";
            if (isset($value[0])) {
                $exam_id = mysqli_real_escape_string($conn , $value[0]);
                $exam_id = trim($exam_id);
                $sql = "SELECT exam_id FROM tbl_examinations WHERE exam_id = '$exam_id'";
				$result = $conn->query($sql);
				
				if ($result->num_rows > 0) {
					
					$exam_idvalidate[]=1;
						
					}
                else 
				{
					$exam_idvalidate[]=0;
				}
            }
            $type = "";
            if (isset($value[1])) {
                $type = mysqli_real_escape_string($conn , $value[1]);
                if(strlen($type) ==2 && ($type =="MC"||$type =="ML"||$type =="FB"))
					$type_validate[]=1;
				else
					$type_validate[]=0;
	
            }
            $ques_type = "";
            if (isset($value[2])||empty($value[2])) {
                $ques_type = mysqli_real_escape_string($conn , $value[2]);
                if(preg_match('/^(H|M|E|HI|MI|EI)$/',$ques_type))
					$ques_typevalidate[]=1;
				else
					$ques_typevalidate[]=0;
            }
            $question = "";
            if (isset($value[3])||empty($value[3])) {
                $question = mysqli_real_escape_string($conn , $value[3]);
				if(strlen($question)> 8)
				   $question_validate[]=1;
				  else
				  $question_validate[] =0; 

				//$question = preg_replace( "\n", "", $question );
               
            }
            $option1 ="";
            if (isset($value[4])) {
                $option1 = mysqli_real_escape_string($conn , $value[4]);
				if(trim($option1) ==='')
				$option1_validate[]=1;

				else
				$option1_validate[]=0;
            }
            $option2 ="";
            if (isset($value[5])) {
                $option2 = mysqli_real_escape_string($conn , $value[5]);
				if(trim($option2) ==='')
				     $option2_validate[]=1;

				else
				     $option2_validate[]=0;
            }
            $option3 ="";
            if (isset($value[6])) {
                $option3 = mysqli_real_escape_string($conn , $value[6]);
				if(trim($option3) ==='')
				    $option3_validate[]=1;
				  else
				$option3_validate[]=0;
            }
            $option4="";
            if (isset($value[7])) {
                $option4 = mysqli_real_escape_string($conn, $value[7]);
				if(trim($option4) ==='')
				$option4_validate[]=1;
				  else
				$option4_validate[]=0;
            }
            $answer="";
            if (isset($value[8])) {
                $answer = mysqli_real_escape_string($conn, $value[8]);
                
             if($type=="ML") 
             {
				if(strlen($answer)==4 &&preg_match("/^[yn]+$/i",$answer))
					$answer_validate[]=1;
				else
					$answer_validate[]=0;
             }
             else if($type=="MC")
             {
				if(preg_match('/^option[1-4]/',$answer))
				$answer_validate[]=1;
			else
			    $answer_validate[]=0;
             }
             else
             {
                 if(strlen($answer) >= 1)
				$answer_validate[]=1;
			else
			    $answer_validate[]=0;
                 
             }
                 
            }
        try
          {
            $drawing = $worksheet->getDrawingCollection()[$key];

            $zipReader = fopen($drawing->getPath(), 'r');
            $imageContents = '';
            while (!feof($zipReader)) {
                $imageContents .= fread($zipReader, 1024);
            // Save the image to a file (e.g., a JPEG)
            }
            fclose($zipReader);
            
            $extension = $drawing->getExtension();
			
            if (($exam_idvalidate[$i-1] ==1) && ($type_validate[$i-1]==1) && ($ques_typevalidate[$i-1]==1)&& (strlen($question) > 8) && ((strlen($option1) > 0)) && ((strlen($option2) > 0)) && ((strlen($option3) > 0)) && ((strlen($option4) > 0))&& ( $answer_validate[$i-1]) )
			{
               
				$sql = "SELECT * FROM tbl_questions WHERE exam_id = '$exam_id' AND question = '$question'";
				$result = $conn->query($sql);
				
				if ($result->num_rows > 0) {

				      $status[]=0;
					
				} else {

                    if($ques_type!="H" && $ques_type!="M" && $ques_type!="E")
                       {
                         $myFileName = 'uploads/' .$exam_id. $question_id.'.'.$extension;
                         file_put_contents($myFileName,$imageContents);
                         $sql = "INSERT INTO tbl_questions (question_id, exam_id, type,ques_type, question, option1, option2, option3, option4, answer,imgext)
				        VALUES ('$question_id', '$exam_id', '$type','$ques_type', '$question', '$option1', '$option2', '$option3', '$option4', '$answer','$extension')";
				
				       if ($conn->query($sql) === TRUE) {
         					$status[]=1;	
				     } else {
	
				           $status[]=2;
				           }
                       }
                       else
                       {
                        $sql = "INSERT INTO tbl_questions (question_id, exam_id, type,ques_type, question, option1, option2, option3, option4, answer)
				        VALUES ('$question_id', '$exam_id', '$type','$ques_type', '$question', '$option1', '$option2', '$option3', '$option4', '$answer')";
				
				       if ($conn->query($sql) === TRUE) {
         					$status[]=1;	
				     } else {
	
				           $status[]=2;
				           }

                       } 
				
				
				
				}

			                
            }
			else{
				$status[]=3;
			}
        }
        catch (Error $e) {
            // Handle the error
            //echo '<td><img  height="150px" width="150px"   src="data:image/jpeg;base64,' . base64_encode($imageContents) . '"/></td>';
            echo "An error occurred: " . $e->getMessage();
            echo '<td>No image</td>';
            continue;
        } 

			$i++;
        }//for
    } else {
        header("location:questions.php?rp=1992");	
        
    }
}
?>


	<!DOCTYPE html>
	<html>

	<head>
		<title>OES | Add Questions</title>
		<meta content="width=device-width, initial-scale=1" name="viewport" />
		<meta charset="UTF-8">
		<meta name="description" content="Online Examination System" />
		<meta name="keywords" content="Online Examination System" />
		<meta name="author" content="Bwire Charles Mashauri" />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
		<link href="../assets/plugins/pace-master/themes/blue/pace-theme-flash.css" rel="stylesheet" />
		<link href="../assets/plugins/uniform/css/uniform.default.min.css" rel="stylesheet" />
		<link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="../assets/plugins/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
		<link href="../assets/plugins/line-icons/simple-line-icons.css" rel="stylesheet" type="text/css" />
		<link href="../assets/plugins/offcanvasmenueffects/css/menu_cornerbox.css" rel="stylesheet" type="text/css" />
		<link href="../assets/plugins/waves/waves.min.css" rel="stylesheet" type="text/css" />
		<link href="../assets/plugins/switchery/switchery.min.css" rel="stylesheet" type="text/css" />
		<link href="../assets/plugins/3d-bold-navigation/css/style.css" rel="stylesheet" type="text/css" />
		<link href="../assets/plugins/slidepushmenus/css/component.css" rel="stylesheet" type="text/css" />
		<link href="../assets/plugins/datatables/css/jquery.datatables.min.css" rel="stylesheet" type="text/css" />
		<link href="../assets/plugins/datatables/css/jquery.datatables_themeroller.css" rel="stylesheet" type="text/css" />
		<link href="../assets/plugins/x-editable/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet" type="text/css">
		<link href="../assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" type="text/css" />
		<link href="../assets/images/icon.png" rel="icon">
		<link href="../assets/css/modern.min.css" rel="stylesheet" type="text/css" />
		<link href="../assets/css/themes/green.css" class="theme-color" rel="stylesheet" type="text/css" />
		<link href="../assets/css/custom.css" rel="stylesheet" type="text/css" />
		<link href="../assets/css/snack.css" rel="stylesheet" type="text/css" />
		<script src="../assets/plugins/3d-bold-navigation/js/modernizr.js"></script>
		<script src="../assets/plugins/offcanvasmenueffects/js/snap.svg-min.js"></script>
	</head>

	<body <?php if ($ms=="1" ) { print 'onload="myFunction()"'; } ?> class="page-header-fixed">
		<div class="overlay"></div>
		<div class="menu-wrap">
			<nav class="profile-menu">
				<div class="profile">
					<?php 
				if ($myavatar == NULL) {
				print' <img width="60" src="../assets/images/'.$mygender.'.png" alt="'.$myfname.'">';
				}else{
				echo '<img src="data:image/jpeg;base64,'.base64_encode($myavatar).'" width="60" alt="'.$myfname.'"/>';	
				}
						
				?> <span><?php echo "$myfname"; ?> <?php echo "$mylname"; ?></span></div>
				<div class="profile-menu-list"> <a href="profile.php"><i class="fa fa-user"></i><span>Profile</span></a> <a href="logout.php"><i class="fa fa-sign-out"></i><span>Logout</span></a> </div>
			</nav>
			<button class="close-button" id="close-button">Close Menu</button>
		</div>
		<form class="search-form" action="search.php" method="GET">
			<div class="input-group">
				<input type="text" name="keyword" class="form-control search-input" placeholder="Search student..." required> <span class="input-group-btn">
                    <button class="btn btn-default close-search waves-effect waves-button waves-classic" type="button"><i class="fa fa-times"></i></button>
                </span> </div>
		</form>
		<main class="page-content content-wrap">
			<div class="navbar">
				<div class="navbar-inner">
					<div class="sidebar-pusher">
						<a href="javascript:void(0);" class="waves-effect waves-button waves-classic push-sidebar"> <i class="fa fa-bars"></i> </a>
					</div>
					<div class="logo-box"> <a href="./" class="logo-text"><span><img src="../assets/images/7hillsTS.png" alt="" height="76" width="130"></span></a> </div>
					<div class="search-button"> <a href="javascript:void(0);" class="waves-effect waves-button waves-classic show-search"><i class="fa fa-search"></i></a> </div>
					<div class="topmenu-outer">
						<div class="top-menu">
							<ul class="nav navbar-nav navbar-right">
								<li> <a href="javascript:void(0);" class="waves-effect waves-button waves-classic show-search"><i class="fa fa-search"></i></a> </li>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown"> <span class="user-name"><?php echo "$myfname"; ?> <?php echo "$mylname"; ?><i class="fa fa-angle-down"></i></span>
										<?php 
						                if ($myavatar == NULL) {
						                print' <img class="img-circle avatar"  width="40" height="40" src="../assets/images/'.$mygender.'.png" alt="'.$myfname.'">';
						                }else{
						                echo '<img width="40" height="40" src="data:image/jpeg;base64,'.base64_encode($myavatar).'" class="img-circle avatar"  alt="'.$myfname.'"/>';	
						                }
						
						                ?> </a>
									<ul class="dropdown-menu dropdown-list" role="menu">
										<li role="presentation"><a href="profile.php"><i class="fa fa-user"></i>Profile</a></li>
										<li role="presentation"><a href="logout.php"><i class="fa fa-sign-out m-r-xs"></i>Log out</a></li>
									</ul>
								</li>
								<li>
									<a href="logout.php" class="log-out waves-effect waves-button waves-classic"> <span><i class="fa fa-sign-out m-r-xs"></i>Log out</span> </a>
								</li>
								<li> </li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="page-sidebar sidebar">
				<div class="page-sidebar-inner slimscroll">
					<div class="sidebar-header">
						<div class="sidebar-profile">
							<a href="javascript:void(0);" id="profile-menu-link">
								<div class="sidebar-profile-image">
									<?php 
						        if ($myavatar == NULL) {
						        print' <img class="img-circle img-responsive" src="../assets/images/'.$mygender.'.png" alt="'.$myfname.'">';
						        }else{
						        echo '<img src="data:image/jpeg;base64,'.base64_encode($myavatar).'" class="img-circle img-responsive"  alt="'.$myfname.'"/>';	
						        }
						
						        ?> </div>
								<div class="sidebar-profile-details"> <span><?php echo "$myfname"; ?> <?php echo "$mylname"; ?><br><small>OES Administrator</small></span> </div>
							</a>
						</div>
					</div>
					<ul class="menu accordion-menu">
						<li><a href="./" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-home"></span><p>Dashboard</p></a></li>
						<li><a href="departments.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-folder-open"></span><p>Departments</p></a></li>
						<li><a href="categories.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon glyphicon-tags"></span><p>Categories</p></a></li>
						<li><a href="subject.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon glyphicon-file"></span><p>Subjects</p></a></li>
						<li><a href="students.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon glyphicon-user"></span><p>Students</p></a></li>
						<li><a href="examinations.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-book"></span><p>Assesments</p></a></li>
						<li class="active"><a href="questions.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-question-sign"></span><p>Questions</p></a></li>
						<li><a href="notice.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-th-list"></span><p>Notice</p></a></li>
						<li><a href="results.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-certificate"></span><p>Exam Results</p></a></li>
					</ul>
				</div>
			</div>
			<div class="page-inner">
				<div class="page-title">
					<h3>Add Questions</h3> </div>
				<div id="main-wrapper">
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-12">
									<div class="panel panel-white">
										<div class="panel-body">
											<div role="tabpanel">
												<ul class="nav nav-tabs" role="tablist">
													<li role="presentation" class="active"><a href="#tab5" role="tab" data-toggle="tab">Multiple Choice</a></li>
													<li role="presentation"><a href="#tab51" role="tab" data-toggle="tab">Multiple Choice2</a></li> 
													<li role="presentation"><a href="#tab6" role="tab" data-toggle="tab">Filling Blanks</a></li>
													<li role="presentation"><a href="#tab7" role="tab" data-toggle="tab">Upload Questions</a></li>
												</ul>
												<div class="tab-content">

																
																<div role="tabpanel" class="tab-pane active fade in" id="tab5">
														<form action="pages/add_question2.php?type=mc" method="POST">
															<div class="form-group">
																<label for="exampleInputEmail1">Exam Name</label>
																<select class="form-control" name="exam" required>
																	<option value="" selected disabled>-Select exam</option>
																	<?php
											include '../database/config.php';
											$sql = "SELECT * FROM tbl_examinations ORDER BY exam_name";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
    
                                            while($row = $result->fetch_assoc()) {
                                            print '<option value="'.$row['exam_id'].'">'.$row['exam_name'].'</option>';
                                            }
                                           } else {
                          
                                            }
                                             $conn->close();
											 ?>
																</select>
                                                        <div class="form-group">
															<label for="exampleInputEmail1">Question Type</label>
															<select class="form-control" name="questype" required>
																	<option value="" selected disabled>-Select Type</option>
                                                                    <option value="E">Easy</option>
                                                                    <option value="M">Medium</option>
                                                                    <option value="H">Hard</option>
                                                                 
                                                            </select>
														</div>
															</div>
															<div class="form-group">
																<label for="exampleInputEmail1">Question</label>
																<input type="text" class="form-control" placeholder="Enter question" name="question" required autocomplete="off"> </div>
															<table class="table table-bordered">
																<thead>
																	<tr>
																		<th width="100">Option No.</th>
																		<th>Option</th>
																		<th width="100">Answer</th>
																	</tr>
																</thead>
																<tbody>
																	<tr>
																		<th scope="row">1</th>
																		<td>
																			<div class="form-group">
																				<label for="exampleInputEmail1">Option 1</label>
																				<input type="text" class="form-control" placeholder="Enter option 1" name="opt1" required autocomplete="off"> </div>
																		</td>
																		<td>
																			<input type="radio" name="answer" value="option1" required>
																		</td>
																	</tr>
																	<tr>
																		<th scope="row">2</th>
																		<td>
																			<div class="form-group">
																				<label for="exampleInputEmail1">Option 2</label>
																				<input type="text" class="form-control" placeholder="Enter option 2" name="opt2" required autocomplete="off"> </div>
																		</td>
																		<td>
																			<input type="radio" name="answer" value="option2" required>
																		</td>
																	</tr>
																	<tr>
																		<th scope="row">3</th>
																		<td>
																			<div class="form-group">
																				<label for="exampleInputEmail1">Option 3</label>
																				<input type="text" class="form-control" placeholder="Enter option 3" name="opt3" required autocomplete="off"> </div>
																		</td>
																		<td>
																			<input type="radio" name="answer" value="option3" required>
																		</td>
																	</tr>
																	<tr>
																		<th scope="row">3</th>
																		<td>
																			<div class="form-group">
																				<label for="exampleInputEmail1">Option 4</label>
																				<input type="text" class="form-control" placeholder="Enter option 4" name="opt4" required autocomplete="off"> </div>
																		</td>
																		<td>
																			<input type="radio" name="answer" value="option4" required>
																		</td>
																	</tr>
																</tbody>
															</table>
															<button type="submit" class="btn btn-primary">Submit</button>
														</form>
													</div>
														<!-- Write 7.4.23 -->									
				<div role="tabpanel" class="tab-pane  fade " id="tab51">
														<form action="pages/add_question2.php?type=ml" method="POST">
															<div class="form-group">
																<label for="exampleInputEmail1">Exam Name</label>
																<select class="form-control" name="exam" required>
																	<option value="" selected disabled>-Select exam</option>
																	<?php
include '../database/config.php';
$sql = "SELECT * FROM tbl_examinations ORDER BY exam_name";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        print '<option value="' . $row['exam_id'] . '">' . $row['exam_name'] . '</option>';
    }
} else {
}
$conn->close();
?>
																</select>
                                                        <div class="form-group">
															<label for="exampleInputEmail1">Question Type</label>
															<select class="form-control" name="questype" required>
																	<option value="" selected disabled>-Select Type</option>
                                                                    <option value="E">Easy</option>
                                                                    <option value="M">Medium</option>
                                                                    <option value="H">Hard</option>
                                                                 
                                                            </select>
														</div>
															</div>
															<div class="form-group">
																<label for="exampleInputEmail1">Question</label>
																<input type="text" class="form-control" placeholder="Enter question" name="question" required autocomplete="off"> </div>
															<table class="table table-bordered">
																<thead>
																	<tr>
																		<th width="100">Option No.</th>
																		<th>Option</th>
																		<th width="100">Answer</th>
																	</tr>
																</thead>
																<tbody>
																	<tr>
																		<th scope="row">1</th>
																		<td>
																			<div class="form-group">
																				<label for="exampleInputEmail1">Option 1</label>
																				<input type="text" class="form-control" placeholder="Enter option 1" name="opt1" required autocomplete="off"> </div>
																		</td>
																		<td>
																			<input type="checkbox" name="answer1" value="option1">
																		</td>
																	</tr>
																	<tr>
																		<th scope="row">2</th>
																		<td>
																			<div class="form-group">
																				<label for="exampleInputEmail1">Option 2</label>
																				<input type="text" class="form-control" placeholder="Enter option 2" name="opt2" required autocomplete="off"> </div>
																		</td>
																		<td>
																			<input type="checkbox" name="answer2" value="option2" >
																		</td>
																	</tr>
																	<tr>
																		<th scope="row">3</th>
																		<td>
																			<div class="form-group">
																				<label for="exampleInputEmail1">Option 3</label>
																				<input type="text" class="form-control" placeholder="Enter option 3" name="opt3" required autocomplete="off"> </div>
																		</td>
																		<td>
																			<input type="checkbox" name="answer3" value="option3" >
																		</td>
																	</tr>
																	<tr>
																		<th scope="row">3</th>
																		<td>
																			<div class="form-group">
																				<label for="exampleInputEmail1">Option 4</label>
																				<input type="text" class="form-control" placeholder="Enter option 4" name="opt4" required autocomplete="off"> </div>
																		</td>
																		<td>
																			<input type="checkbox" name="answer4" value="option4" >
																		</td>
																	</tr>
																</tbody>
															</table>
															<button type="submit" class="btn btn-primary">Submit</button>
														</form>
													</div>
			<!-- Write 7.4.23 -->	
													<div role="tabpanel" class="tab-pane fade" id="tab6">
														<form action="pages/add_question2.php?type=fib" method="POST">
															<div class="form-group">
																<label for="exampleInputEmail1">Exam Name</label>
																<select class="form-control" name="exam" required>
																	<option value="" selected disabled>-Select exam</option>
																	<?php
																		include '../database/config.php';
																		$sql = "SELECT * FROM tbl_examinations ORDER BY exam_name";
																		$result = $conn->query($sql);

																		if ($result->num_rows > 0) {
								
																		while($row = $result->fetch_assoc()) {
																		print '<option value="'.$row['exam_id'].'">'.$row['exam_name'].'</option>';
																		}
																	} else {
													
																		   }
																			$conn->close();
																			?>
																</select>
															</div>
															<div class="form-group">
																<label for="exampleInputEmail1">Question</label>
																<input type="text" class="form-control" placeholder="Enter question" name="question" required autocomplete="off"> </div>
															<div class="form-group">
															    <label for="exampleInputEmail1">Question Type</label>
															    <select class="form-control" name="questype" required>
																	<option value="" selected disabled>-Select Type</option>
                                                                    <option value="E">Easy</option>
                                                                    <option value="M">Medium</option>
                                                                    <option value="H">Hard</option>
                                                                 
                                                                </select>
														    </div>
															<div class="form-group">
																<label for="exampleInputEmail1">Answer</label>
																<input type="text" class="form-control" placeholder="Enter answer" name="answer" required autocomplete="off"> </div>
															<button type="submit" class="btn btn-primary">Submit</button>
														</form>
													</div>
													<div role="tabpanel" class="tab-pane fade" id="tab7">
                                                 <div class="outer-container">
                                                    <form action="questions.php" method="post" name="frmExcelImport"
                                                        id="frmExcelImport" enctype="multipart/form-data">
														  <div class="input-group">
                                                            <label class="input-group-btn">Choose Excel File</label>
															<span class="btn btn-primary">
															 <input type="file"
                                                                name="file" id="file" accept=".xls,.xlsx">
                                                            <button type="submit" id="submit" name="import"
                                                                class="btn-submit"  onMouseOver="this.style.backgroundColor='#fc7f01'"   onMouseOut="this.style.backgroundColor='#00C0FF'" style=" font-size: larger; color: black; background-color: #00C0FF; border: 3pt ridge lightgrey">Import</button>
															</span>
														   </div>

                                                    </form>

                                                  </div>
                                                  <?php
                                                       /* $sqlSelect = "SELECT * FROM tbl_questions";
                                                        $result = $db->select($sqlSelect);
                                                        if (! empty($result)) {*/
                                                            ?>
                                                        <div class="table-responsive">
                                                            <table class="table table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">Question ID</th>
                                                                        <th scope="col">Exam ID</th>
                                                                        <th scope="col">Type</th>
                                                                        <th scope="col">Question Type</th>
                                                                        <th scope="col">Question</th>
                                                                        <th scope="col">Option1</th>
                                                                        <th scope="col">option2</th>
                                                                        <th scope="col">Option3</th>
                                                                        <th scope="col">Option4</th>
                                                                        <th scope="col">Answer</th>
                                                                        

                                                                    </tr>
                                                                </thead>
                                                             <?php
                                                            //foreach ($result as $row) { // ($row = mysqli_fetch_array($result))
																for ($i = 1; $i < $sheetCount; $i ++) {
																	$statuscolor;
																	$statusmessg;
																	switch($status[$i-1])
																	 {
																		 case 0:
																			$statuscolor= "class='bg-danger'";
																			$statusmessg ="Record Exist";
																			break;
																		 case 1:
																			$statuscolor= "class='bg-success'";
																			$statusmessg ="Record Inserted";
																			break;
																		 case 2:
																			$statuscolor= "class='bg-danger'";
																			$statusmessg ="Could not insert data";
																			break;
																		 case 3:
																			$statuscolor= "class='bg-warning'";
																			$statusmessg ="Record in Excel not proper";
																			break;
																	 }
                                                                ?>
                                                                <tbody>
                                                                    <tr>
																	<tr style="background-color:#ffffcf">
																	<td <?php  echo $statuscolor;?>><?php echo $i." ". $statusmessg;?></td>
																	<td <?php if($exam_idvalidate[$i-1] == 0)echo " style=' border-color:red;border-width:5px;'";else echo " style=' border-color: green;'"; ?>><?php  echo $spreadSheetAry[$i][0]; ?></td>
																    <td <?php if($type_validate[$i-1] == 0)echo " style=' border-color:red;border-width:5px;'";else echo " style=' border-color: green;'"; ?>><?php  echo $spreadSheetAry[$i][1]?></td>
																	<td <?php if($ques_typevalidate[$i-1]== 0)echo " style=' border-color:red;border-width:5px;'";else echo " style=' border-color: green;'"; ?>><?php  echo $spreadSheetAry[$i][2] ?></td>
																	<td <?php if($question_validate[$i-1] == 0)echo " style=' border-color:red;border-width:5px;'";else echo " style=' border-color: green;'"; ?>><?php  echo $spreadSheetAry[$i][3] ?></td>
																	<td <?php if($option1_validate[$i-1]== 1)echo " style=' border-color:red;border-width:5px;'";else echo " style=' border-color: green;'"; ?>><?php  echo $spreadSheetAry[$i][4] ?></td>
																	<td <?php if($option2_validate[$i-1]== 1)echo " style=' border-color:red;border-width:5px;'";else echo " style=' border-color: green;'"; ?>><?php  echo $spreadSheetAry[$i][5] ?></td>
																	<td <?php if($option3_validate[$i-1]== 1)echo " style=' border-color:red;border-width:5px;'";else echo " style=' border-color: green;'"; ?>><?php  echo $spreadSheetAry[$i][6] ?></td>
																	<td <?php if($option4_validate[$i-1]== 1)echo " style=' border-color:red;border-width:5px;'";else echo " style=' border-color: green;'"; ?>><?php  echo $spreadSheetAry[$i][7] ?></td>
																	<td <?php if($answer_validate[$i-1] == 0)echo " style=' border-color:red;border-width:5px;'";else echo " style=' border-color: green;'"; ?>><?php  echo  $spreadSheetAry[$i][8] ?></td> 
                                                                    </tr>
                                                         <?php
                                                            }
                                                            ?>
                                                                </tbody>
                                                            </table>
														</div>
                                                        <?php
                                                      //  }
                                                      ?>
                                                </div>
                                                </div>
													
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
		<?php if ($ms == "1") {
?>
			<div class="alert alert-success" id="snackbar">
				<?php echo "$description"; ?>
			</div>
			<?php	
}else{
	
}
?>
				<div class="cd-overlay"></div>
				<script src="../assets/plugins/jquery/jquery-2.1.4.min.js"></script>
				<script src="../assets/plugins/jquery-ui/jquery-ui.min.js"></script>
				<script src="../assets/plugins/pace-master/pace.min.js"></script>
				<script src="../assets/plugins/jquery-blockui/jquery.blockui.js"></script>
				<script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
				<script src="../assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
				<script src="../assets/plugins/switchery/switchery.min.js"></script>
				<script src="../assets/plugins/uniform/jquery.uniform.min.js"></script>
				<script src="../assets/plugins/offcanvasmenueffects/js/classie.js"></script>
				<script src="../assets/plugins/offcanvasmenueffects/js/main.js"></script>
				<script src="../assets/plugins/waves/waves.min.js"></script>
				<script src="../assets/plugins/3d-bold-navigation/js/main.js"></script>
				<script src="../assets/plugins/jquery-mockjax-master/jquery.mockjax.js"></script>
				<script src="../assets/plugins/moment/moment.js"></script>
				<script src="../assets/plugins/datatables/js/jquery.datatables.min.js"></script>
				<script src="../assets/plugins/x-editable/bootstrap3-editable/js/bootstrap-editable.js"></script>
				<script src="../assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
				<script src="../assets/js/modern.min.js"></script>
				<script src="../assets/js/pages/table-data.js"></script>
				<script>
				function myFunction() {
					var x = document.getElementById("snackbar")
					x.className = "show";
					setTimeout(function() {
						x.className = x.className.replace("show", "");
					}, 3000);
				}
				</script>
	</body>

	</html>