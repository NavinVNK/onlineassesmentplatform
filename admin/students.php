<?php 
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;//added by Megh
include '../database/config.php';//added by Megh
include '../includes/uniques.php';//added by Megh
include 'includes/check_user.php'; 
include 'includes/check_reply.php';
require_once ('./vendor/autoload.php');//added by Megh

//added by Megh
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
        for ($i = 1; $i <= $sheetCount; $i ++) {
            $exam_idstatus=0;
            $question_id = 'QS-'.get_rand_numbers(6).'';

            $exam_id = "";
            if (isset($spreadSheetAry[$i][0])) {
                $exam_id = mysqli_real_escape_string($conn , $spreadSheetAry[$i][0]);
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
          /* $type = "";
            if (isset($spreadSheetAry[$i][1])) {
                $type = mysqli_real_escape_string($conn , $spreadSheetAry[$i][1]);
                if(strlen($type) ==2 && ($type =="MC"||$type =="FB"))
					$type_validate[]=1;
				else
					$type_validate[]=0;
            }
            $ques_type = "";
            if (isset($spreadSheetAry[$i][2])||empty($spreadSheetAry[$i][2])) {
                $ques_type = mysqli_real_escape_string($conn , $spreadSheetAry[$i][2]);
                if(strlen($ques_type)==1 &&(preg_match('/H|M|E/',$ques_type)))
					$ques_typevalidate[]=1;
				else
					$ques_typevalidate[]=0;
            }
            $question = "";
            if (isset($spreadSheetAry[$i][3])||empty($spreadSheetAry[$i][3])) {
                $question = mysqli_real_escape_string($conn , $spreadSheetAry[$i][3]);
				if(strlen($question)> 8)
				   $question_validate[]=1;
				  else
				  $question_validate[] =0; 

				//$question = preg_replace( "\n", "", $question );
               
            }
            $option1 ="";
            if (isset($spreadSheetAry[$i][4])) {
                $option1 = mysqli_real_escape_string($conn , $spreadSheetAry[$i][4]);
				if(trim($option1) ==='')
				$option1_validate[]=1;

				else
				$option1_validate[]=0;
            }
            $option2 ="";
            if (isset($spreadSheetAry[$i][5])) {
                $option2 = mysqli_real_escape_string($conn , $spreadSheetAry[$i][5]);
				if(trim($option2) ==='')
				     $option2_validate[]=1;

				else
				     $option2_validate[]=0;
            }
            $option3 ="";
            if (isset($spreadSheetAry[$i][6])) {
                $option3 = mysqli_real_escape_string($conn , $spreadSheetAry[$i][6]);
				if(trim($option3) ==='')
				    $option3_validate[]=1;
				  else
				$option3_validate[]=0;
            }
            $option4="";
            if (isset($spreadSheetAry[$i][7])) {
                $option4 = mysqli_real_escape_string($conn, $spreadSheetAry[$i][7]);
				if(trim($option4) ==='')
				$option4_validate[]=1;
				  else
				$option4_validate[]=0;
            }
            $answer="";
            if (isset($spreadSheetAry[$i][8])) {
                $answer = mysqli_real_escape_string($conn, $spreadSheetAry[$i][8]);
				if(preg_match('/^option[1-4]/',$answer))
				$answer_validate[]=1;
			else
			    $answer_validate[]=0;
                 
            }*/
			
			//"EX_120895";

			
            /* if (($exam_idvalidate[$i-1] ==1) && ($type_validate[$i-1]==1) && ($ques_typevalidate[$i-1]==1)&& (strlen($question) > 8) && ((strlen($option1) > 0)) && ((strlen($option2) > 0)) && ((strlen($option3) > 0)) && ((strlen($option4) > 0))&& ( $answer_validate[$i-1]) )
			{ */
               //echo "Exam Id '.strlen($exam_id)'";
				$sql = "SELECT * FROM tbl_users WHERE exam_id = '$exam_id' AND question = '$question'";
				$result = $conn->query($sql);
				
				if ($result->num_rows > 0) {

				      $status[]=0;
					
				} else {
				
				$sql = "INSERT INTO tbl_users (question_id, exam_id, first_name,last_name, gender)
				VALUES ('$question_id', '$exam_id', '$first_name','$last_name', '$gender')";
				
				if ($conn->query($sql) === TRUE) {
					//header("location:../questions.php?rp=0357");
					$status[]=1;	
				} else {
				 //header("location:../questions.php?rp=3903");	
				 $status[]=2;
				}
				
				}
				/*$insertId = $db->insert($query, $paramType, $paramArray);
                // $query = "insert into tbl_info(name,description) values('" . $name . "','" . $description . "')";
                // $result = mysqli_query($conn, $query);

                if (! empty($insertId)) {
                   // header("location:questions.php?rp=1990");	
                    
                } else {
                   // header("location:questions.php?rp=1991");	
                   
                }*/

			                
           /* }
			else{
				$status[]=3;
			}*/

			
        }//for
    } else {
        header("location:students.php?rp=1990");	
        
    }
}
?>








<!DOCTYPE html>
<html>
   
<head>
        
        <title>OES | Manage Students</title>
        
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta charset="UTF-8">
        <meta name="description" content="Online Examination System" />
        <meta name="keywords" content="Online Examination System" />
        <meta name="author" content="Bwire Charles Mashauri" />

        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
        <link href="../assets/plugins/pace-master/themes/blue/pace-theme-flash.css" rel="stylesheet"/>
        <link href="../assets/plugins/uniform/css/uniform.default.min.css" rel="stylesheet"/>
        <link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/plugins/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/plugins/line-icons/simple-line-icons.css" rel="stylesheet" type="text/css"/>	
        <link href="../assets/plugins/offcanvasmenueffects/css/menu_cornerbox.css" rel="stylesheet" type="text/css"/>	
        <link href="../assets/plugins/waves/waves.min.css" rel="stylesheet" type="text/css"/>	
        <link href="../assets/plugins/switchery/switchery.min.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/plugins/3d-bold-navigation/css/style.css" rel="stylesheet" type="text/css"/>	
        <link href="../assets/plugins/slidepushmenus/css/component.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/plugins/datatables/css/jquery.datatables.min.css" rel="stylesheet" type="text/css"/>	
        <link href="../assets/plugins/datatables/css/jquery.datatables_themeroller.css" rel="stylesheet" type="text/css"/>	
        <link href="../assets/plugins/x-editable/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet" type="text/css">
        <link href="../assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" type="text/css"/>
		<link href="../assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/images/icon.png" rel="icon">
        <link href="../assets/css/modern.min.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/css/themes/green.css" class="theme-color" rel="stylesheet" type="text/css"/>
        <link href="../assets/css/custom.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/css/snack.css" rel="stylesheet" type="text/css"/>
        <script src="../assets/plugins/3d-bold-navigation/js/modernizr.js"></script>
        <script src="../assets/plugins/offcanvasmenueffects/js/snap.svg-min.js"></script>
		

        <link href="../assets/plugins/summernote-master/summernote.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/plugins/bootstrap-colorpicker/css/colorpicker.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css"/>
        
		

        
    </head>
    <body <?php if ($ms == "1") { print 'onload="myFunction()"'; } ?>  class="page-header-fixed">
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
						
				?>
				<span><?php echo "$myfname"; ?> <?php echo "$mylname"; ?></span></div>
                <div class="profile-menu-list">
                    <a href="profile.php"><i class="fa fa-user"></i><span>Profile</span></a>
                    <a href="logout.php"><i class="fa fa-sign-out"></i><span>Logout</span></a>
                </div>
            </nav>
            <button class="close-button" id="close-button">Close Menu</button>
        </div>
        <form class="search-form" action="search.php" method="GET">
            <div class="input-group">
                <input type="text" name="keyword" class="form-control search-input" placeholder="Search student..." required>
                <span class="input-group-btn">
                    <button class="btn btn-default close-search waves-effect waves-button waves-classic" type="button"><i class="fa fa-times"></i></button>
                </span>
            </div>
        </form>
        <main class="page-content content-wrap">
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="sidebar-pusher">
                        <a href="javascript:void(0);" class="waves-effect waves-button waves-classic push-sidebar">
                            <i class="fa fa-bars"></i>
                        </a>
                    </div>
                    <div class="logo-box">
                        <a href="./" class="logo-text"><span><img src="../assets/images/7hillsTS.png" alt="" height="50" width=""></span></a>
                    </div>
                    <div class="search-button">
                        <a href="javascript:void(0);" class="waves-effect waves-button waves-classic show-search"><i class="fa fa-search"></i></a>
                    </div>
                    <div class="topmenu-outer">
                        <div class="top-menu">
                            <ul class="nav navbar-nav navbar-right">
                                <li>	
                                    <a href="javascript:void(0);" class="waves-effect waves-button waves-classic show-search"><i class="fa fa-search"></i></a>
                                </li>

                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown">
                                        <span class="user-name"><?php echo "$myfname"; ?> <?php echo "$mylname"; ?><i class="fa fa-angle-down"></i></span>
										<?php 
						                if ($myavatar == NULL) {
						                print' <img class="img-circle avatar"  width="40" height="40" src="../assets/images/'.$mygender.'.png" alt="'.$myfname.'">';
						                }else{
						                echo '<img width="40" height="40" src="data:image/jpeg;base64,'.base64_encode($myavatar).'" class="img-circle avatar"  alt="'.$myfname.'"/>';	
						                }
						
						                ?>
                                    </a>
                                    <ul class="dropdown-menu dropdown-list" role="menu">
                                        <li role="presentation"><a href="profile.php"><i class="fa fa-user"></i>Profile</a></li>
                                        <li role="presentation"><a href="logout.php"><i class="fa fa-sign-out m-r-xs"></i>Log out</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="logout.php" class="log-out waves-effect waves-button waves-classic">
                                        <span><i class="fa fa-sign-out m-r-xs"></i>Log out</span>
                                    </a>
                                </li>
                                <li>

                                </li>
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
						
						        ?>
                       
                                </div>
                                <div class="sidebar-profile-details">
                                    <span><?php echo "$myfname"; ?> <?php echo "$mylname"; ?><br><small>OES Administrator</small></span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <ul class="menu accordion-menu">
                    <li><a href="./" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-home"></span><p>Dashboard</p></a></li>
						<li><a href="departments.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-folder-open"></span><p>Domain</p></a></li>
						<li><a href="categories.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon glyphicon-tags"></span><p>Categories</p></a></li>
						<li><a href="subject.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon glyphicon-file"></span><p>Skills</p></a></li>
						<li class="active"><a href="students.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon glyphicon-user"></span><p>Candidates</p></a></li>
						<li><a href="examinations.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-book"></span><p>Assessment</p></a></li>
						<li><a href="questions.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-question-sign"></span><p>Questions</p></a></li>
						<li><a href="notice.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-th-list"></span><p>bulletin Board</p></a></li>
						 <li class=""><a href="results.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-certificate"></span><p>Assessment Results</p></a></li>
                       <li  class=" show-mobile"><a href="logout.php" class="waves-effect waves-button"><span class="menu-icon fa fa-sign-out"></span><p>Logout</p></a></li>

                    </ul>
                </div>
            </div>
            <div class="page-inner">
                <div class="page-title">
                    <h3>Manage Candidates</h3>



                </div>
                <div id="main-wrapper">
                    <div class="row">
                        <div class="col-md-12">
						<div class="row">
                            <div class="col-md-12">

                                <div class="panel panel-white">
                                    <div class="panel-body">
                                        <div role="tabpanel">
                                   
                                            <ul class="nav nav-tabs" role="tablist">
			
                                                <li role="presentation" class="active"><a href="#tab5" role="tab" data-toggle="tab">Candidates</a></li>
                                                <li role="presentation"><a href="#tab6" role="tab" data-toggle="tab">Add Candidates</a></li>										
												<li role="presentation"><a href="#tab7" role="tab" data-toggle="tab">Upload Candidates</a></li>
						

                                            </ul>
                                    
                                            <div class="tab-content">
                                                <div role="tabpanel" class="tab-pane active fade in" id="tab5">
                                           <div class="table-responsive">
										   <?php
										   include '../database/config.php';
										   $sql = "SELECT * FROM tbl_users WHERE role = 'student'";
                                           $result = $conn->query($sql);

                                           if ($result->num_rows > 0) {
										print '
										<table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
												<th>Gender</th>
												<th>Category</th>
                                                <th>Status</th>
                                                <th>Date of Birth</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Name</th>
												<th>Gender</th>
												<th>Category</th>
                                                <th>Status</th>
                                                <th>Date of Birth</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>';
     
                                           while($row = $result->fetch_assoc()) {
											   
											   $status = $row['acc_stat'];
											   if ($status == "1") {
											   $st = '<p class="text-success">ACTIVE</p>';
											   $stl = '<a href="pages/make_sd_in.php?id='.$row['user_id'].'">Make Inactive</a>';
											   }else{
											   $st = '<p class="text-danger">INACTIVE</p>'; 
                                               $stl = '<a href="pages/make_sd_ac.php?id='.$row['user_id'].'">Make Active</a>';											   
											   }
                                          print '
										       <tr>
                                                <td>'.$row['first_name'].' '.$row['last_name'].'</td>
												<td>'.$row['gender'].'</td>
                                                <td>'.$row['category'].'</td>
                                                <td>'.$st.'</td>
												<td>'.$row['dob'].'</td>
                                                <td><div class="btn-group" role="group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    Select Action
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li>'.$stl.'</li>
													<li><a href="edit-student.php?sid='.$row['user_id'].'">Edit Candidate</a></li>
													<li><a href="send-email.php?sid='.$row['user_id'].'">Send Email</a></li>
													<li><a href ="view-student.php?sid='.$row['user_id'].'">View Candidate</a></li>
                                                    <li><a'; ?> onclick = "return confirm('Drop <?php echo $row['first_name']; ?> ?')" <?php print ' href="pages/drop_sd.php?id='.$row['user_id'].'">Drop Student</a></li>
                                                </ul>
                                            </div></td>
          
                                            </tr>';
                                           }
										   
										   print '
									   </tbody>
                                       </table>  ';
                                            } else {
											print '
												<div class="alert alert-info" role="alert">
                                        Nothing was found in database.
                                    </div>';
    
                                           }
                                           $conn->close();
										   
										   ?>


                 

                                    </div>
                                                       
                                                </div>
                                                <div role="tabpanel" class="tab-pane fade" id="tab6">
                                         <form action="pages/add_student.php" method="POST">
										<div class="form-group">
                                            <label for="exampleInputEmail1">First Name</label>
                                            <input type="text" class="form-control" placeholder="Enter first name" name="fname" required autocomplete="off">
                                        </div>
										<div class="form-group">
                                            <label for="exampleInputEmail1">Last Name</label>
                                            <input type="text" class="form-control" placeholder="Enter last name" name="lname" required autocomplete="off">
                                        </div>
										<div class="form-group">
										  <label for="exampleInputEmail1">Male</label>
                                            <input type="radio"  name="gender" value="Male" required>
                                            <label for="exampleInputEmail1">Female</label>
                                            <input type="radio" name="gender" value="Female" required>
                                        </div>
										<div class="form-group">
                                            <label for="exampleInputEmail1">Email Address</label>
                                            <input type="email" class="form-control" placeholder="Enter email address" name="email" pattern= "/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/"required autocomplete="off">
                                        </div>
										<div class="form-group">
                                            <label for="exampleInputEmail1">Phone</label>
                                            <input type="text" class="form-control" placeholder="Enter phone" name="phone" pattern="[0-9]{10}" required autocomplete="off">
                                        </div>
										<div class="form-group">
                                            <label for="exampleInputEmail1">Select Domain</label>
                                            <select id="dept"class="form-control" name="department" required>
											<option value="" selected disabled>-Select domain-</option>
											<?php
											include '../database/config.php';
											$sql = "SELECT * FROM tbl_departments WHERE status = 'Active' ORDER BY name";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
    
                                            while($row = $result->fetch_assoc()) {
                                            print '<option value="'.$row['name'].'">'.$row['name'].'</option>';
                                            }
                                           } else {
                          
                                            }
                                             $conn->close();
											 ?>
											
											</select>
                                        </div>
										
										<div class="form-group">
                                            <label for="exampleInputEmail1">Select Service</label>
                                            <select id="category"class="form-control" name="category" required>

											
											</select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Select Subject</label>
                                            <select id="subject"class="form-control" name="subject" required>

											
											</select>
                                        </div>
										
									<div class="form-group">
                                    <label >Date of Birth</label>
                                    <input type="text" class="form-control date-picker" name="dob" required autocomplete="off" placeholder="Select date of birth">
                                    </div>
									
									<div class="form-group">
                                            <label for="exampleInputEmail1">Address</label>
                                            <textarea style="resize: none;" rows="4" class="form-control" placeholder="Enter address" name="address" required autocomplete="off"></textarea>
                                     </div>


                                        <button type="submit" class="btn btn-primary">Submit</button>
                                       </form>
                                                </div>

	                                    	<div role="tabpanel" class="tab-pane fade" id="tab7">
                                                 <div class="outer-container">
                                                    <form action="students.php" method="post" name="frmExcelImport"
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
                                                       /* $sqlSelect = "SELECT * FROM tbl_users";
                                                        $result = $db->select($sqlSelect);
                                                        if (! empty($result)) {*/
                                                            ?>
                                                        <div class="table-responsive">
                                                            <table class="table table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">Question ID</th>
                                                                        <th scope="col">Exam ID</th>
                                                                        <th scope="col">First Name</th>
                                                                        <th scope="col">Last Name</th>
                                                                        <th scope="col">Gender</th>
                                                                        <th scope="col">Email Address</th>
                                                                        <th scope="col">Phone</th>
                                                                        <th scope="col">Domain</th>
                                                                        <th scope="col">Service</th>
                                                                        <th scope="col">DOB</th>
                                                                        <th scope="col">Address</th>
                                                                        
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
        </main>
		<?php if ($ms == "1") {
?> <div class="alert alert-success" id="snackbar"><?php echo "$description"; ?></div> <?php	
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
		<script src="../assets/plugins/select2/js/select2.min.js"></script>
        <script src="../assets/plugins/summernote-master/summernote.min.js"></script>
        <script src="../assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
        <script src="../assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
        <script src="../assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
        <script src="../assets/js/pages/form-elements.js"></script>
		

		<script>
function myFunction() {
    var x = document.getElementById("snackbar")
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}
</script>
<script>
        $(document).ready(function() {
            // Attach the change event using jQuery
			$("#dept").change(function() {
                getSubcategories('1');
            });
            $("#category").change(function() {
                getSubcategories('2');
            });
            $("#subject").change(function() {
                getSubcategories('3');
            });
        });

        function getSubcategories(id) {
            // Get the selected category value
            // Get the selected category value
            if(id=='1')
			var deptVal = $("#dept").val();
            else if(id=='2')
            var deptVal = $("#category").val();
			else
            var deptVal = $("#subject").val();


            // Use AJAX to fetch subcategories based on the selected category
            $.ajax({
                type: "GET",
                url: "selectajax.php",
                data: { select_value: deptVal,id:id },
                success: function(response) {
                   // Update the subcategory select element with the new options
					if(id=='1')
					$("#category").html(response);
					else if(id=='2')
                    $("#subject").html(response);
					else
					$("#examlist").html(response);
                }
            });
        }
    </script>
    </body>

</html>