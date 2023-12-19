<?php
date_default_timezone_set('Asia/Calcutta');
include 'includes/check_user.php';
include 'includes/check_reply.php';
include '../includes/uniques.php';
session_start();

if (isset($_SESSION['current_examid']))
{
    include '../database/config.php';
    $exam_id = $_SESSION['current_examid'];
    $retake_status = $_SESSION['student_retake'];

    if ($retake_status == "1")
    {
        $sql = "DELETE FROM tbl_assessment_records WHERE student_id = '$myid' AND exam_id = '$exam_id'";

        if ($conn->query($sql) === true)
        {

        }
        else
        {

        }
    }

    $sql = "SELECT * FROM tbl_examinations WHERE exam_id = '$exam_id' AND category = '$mycategory' AND status = 'Active'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0)
    {

        while ($row = $result->fetch_assoc())
        {
            $exam_name = $row['exam_name'];
            $subject = $row['subject'];
            $deadline = $row['date'];
            $duration = $row['duration'];
            $tot_ques=$row['tot_ques'];
            $ques_easy_per = $row['ques_easy'];
            $ques_medium_per = $row['ques_medium'];
            $ques_hard_per = $row['ques_hard'];
            $passmark = $row['passmark'];
            $reexam = $row['re_exam'];
            $terms = $row['terms'];
            $status = $row['status'];
            //$today_date = date('Y/m/d');
            $next_retake = date('m/d/Y', strtotime($today_date . ' + ' . $reexam . ' days'));

            $today_date = date('d F Y, h:i:s A');//date('m/d/Y');
        }
    }
    else
    {
        header("location:./");
    }
}
else
{
    header("location:./");
}

$sql = "SELECT * FROM tbl_assessment_records WHERE student_id = '$myid'";
$result = $conn->query($sql);

if ($result->num_rows > 0)
{

    while ($row = $result->fetch_assoc())
    {
        header("location:./take-assessment.php?id=$exam_id");
    }
}
else
{
    $myname = "$myfname $mylname";
    $recid = 'RS' . get_rand_numbers(14) . '';
    $_SESSION['record_id'] = $recid;//3.12.23
    $sql = "INSERT INTO tbl_assessment_records (record_id, student_id, student_name, exam_name, exam_id, score, status, next_retake, date)
VALUES ('$recid', '$myid', '$myname', '$exam_name', '$exam_id', '0', 'FAIL', '$next_retake', '$today_date')";

    if ($conn->query($sql) === true)
    {

    }
    else
    {

    }

}

/*30.11.23 Begin Check if the session variable is not set
if (!isset($_SESSION['page_loaded'])) {
    // Set the session variable
    $_SESSION['page_loaded'] = true;
} else {
    
   if($_SESSION['page_loaded'] == true)
   {
        unset($_SESSION['page_loaded']);
        header("location:assessment-info.php");

       
   }   
}

*///30.11.23End

?>
<!DOCTYPE html>
<html>
    
<head>
        
    
        <title>OES | Examination</title>
        
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
        <link href="../assets/images/icon.png" rel="icon">
        <link href="../assets/css/modern.min.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/css/themes/green.css" class="theme-color" rel="stylesheet" type="text/css"/>
        <link href="../assets/css/custom.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/css/snack.css" rel="stylesheet" type="text/css"/>
        <script src="../assets/plugins/3d-bold-navigation/js/modernizr.js"></script>
        <script src="../assets/plugins/offcanvasmenueffects/js/snap.svg-min.js"></script>
        <style>
          .strip {
         
         padding-top: 5px;
          display: inline_block;
       
          height: 25px;
          width: 25px;
          vertical-align: middle;

          border: 1px solid black;
          margin-left:8px;
          }
          .strip::after {
          content: ' ';
          }
            </style>       
    </head>
	<body <?php if ($ms == "1")
{
    print 'onload="myFunction()"';
} ?>   class="page-header-fixed page-horizontal-bar" >
        <div class="overlay"></div>
        <div class="menu-wrap">
            <nav class="profile-menu">
                <div class="profile">
				<?php
if ($myavatar == NULL)
{
    print ' <img width="60" src="../assets/images/' . $mygender . '.png" alt="' . $myfname . '">';
}
else
{
    echo '<img src="data:image/jpeg;base64,' . base64_encode($myavatar) . '" width="60" alt="' . $myfname . '"/>';
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

        <main class="page-content content-wrap container">
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="sidebar-pusher">
                        <a href="javascript:void(0);" class="waves-effect waves-button waves-classic push-sidebar">
                            <i class="fa fa-bars"></i>
                        </a>
                    </div>
                    <div class="logo-box">
                        <a class="logo-text"><span><div id="quiz-time-left"></div></span></a>
                    </div>
                    <div class="logo-box">
                       <a class="logo-text"><span><div id="quiz-ques-left">0/<?php echo $tot_ques." ";?>Ans</div></span></a>
                    </div>

                    <div class="topmenu-outer">
                        <div class="top-menu">
						 <ul class="nav navbar-nav navbar-left">


                            </ul>
                            <ul class="nav navbar-nav navbar-right">


                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown">
                                        <span class="user-name"><?php echo "$myfname"; ?> <?php echo "$mylname"; ?><i class="fa fa-angle-down"></i></span>
										<?php
if ($myavatar == NULL)
{
    print ' <img class="img-circle avatar"  width="40" height="40" src="../assets/images/' . $mygender . '.png" alt="' . $myfname . '">';
}
else
{
    echo '<img width="40" height="40" src="data:image/jpeg;base64,' . base64_encode($myavatar) . '" class="img-circle avatar"  alt="' . $myfname . '"/>';
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
            <div class="horizontal-bar sidebar">
                <div class="page-sidebar-inner slimscroll">
                    <div class="sidebar-header">
                        <div class="sidebar-profile">
                            <a href="javascript:void(0);" id="profile-menu-link">
                                <div class="sidebar-profile-image">
								<?php
if ($myavatar == NULL)
{
    print ' <img class="img-circle img-responsive" src="../assets/images/' . $mygender . '.png" alt="' . $myfname . '">';
}
else
{
    echo '<img src="data:image/jpeg;base64,' . base64_encode($myavatar) . '" class="img-circle img-responsive"  alt="' . $myfname . '"/>';
}

?>
                       
                                </div>
                                <div class="sidebar-profile-details">
                                    <span><?php echo "$myfname"; ?> <?php echo "$mylname"; ?><br><small>OES Student</small></span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <ul class="menu accordion-menu">
                        <li><a href="./" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-home"></span><p>Dashboard</p></a></li>
                        <li><a href="subject.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon glyphicon-file"></span><p>Skills</p></a></li>
                        <li><a href="students.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon glyphicon-user"></span><p>Candidates</p></a></li>
                        <li><a href="examinations.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-book"></span><p>Assessments</p></a></li>
                        <li><a href="results.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-certificate"></span><p>Assessment Results</p></a></li>

                    </ul>
                </div>
            </div>
            <div class="page-inner">
                <div class="page-title">
                    <h3>Assessment</h3>
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li><a href="./">Home</a></li>
                            <li><a href="examinations.php">Assessments</a></li>
                            <li class="active"><?php echo "$exam_name"; ?></li>
                        </ol>
                    </div>
                </div>
                <div id="main-wrapper">
                    <div class="row">
                                <div class="panel panel-white">
                                    <div class="panel-body">
                                        <div class="tabs-below" role="tabpanel">
                                       <form action="pages/submit_assessment.php" method="POST" name="quiz" id="quiz_form"  >
                                            <div class="tab-content">
											<?php
include '../database/config.php';
$imagePath = "";
$ques_easy=floor($tot_ques*($ques_easy_per/100));

$sql = "SELECT * FROM tbl_questions WHERE exam_id = '$exam_id' and ques_type Like 'E%' ORDER BY rand() LIMIT 0,$ques_easy ";
$result = $conn->query($sql);

$ques_easy_list=array();
while ($row = $result->fetch_assoc())
{
    $ques_easy_list[]=  $row;
}
shuffle($ques_easy_list);


//echo "easy question".$ques_easy_rand[0]['question'];
$ques_medium=ceil($tot_ques*($ques_medium_per/100));
$sql = "SELECT * FROM tbl_questions WHERE exam_id = '$exam_id' and ques_type Like 'M%' ORDER BY rand() LIMIT 0,$ques_medium";
$result = $conn->query($sql);
$ques_medium_list=array();
while ($row = $result->fetch_assoc())
{
    $ques_medium_list[]=  $row;
}
shuffle($ques_medium_list);

$ques_hard=$tot_ques-($ques_easy+$ques_medium);
$sql = "SELECT * FROM tbl_questions WHERE exam_id = '$exam_id' and ques_type Like 'H%'ORDER BY rand() LIMIT 0 ,$ques_hard";
$result = $conn->query($sql);
$ques_hard_list=array();
while ($row = $result->fetch_assoc())
{
    $ques_hard_list[]=  $row;
}
shuffle($ques_hard_list);

$queslist=array();
$queslist=array_merge($ques_easy_list,$ques_medium_list,$ques_hard_list);
shuffle($queslist);
if (sizeof($queslist) > 0)
{
   /* $queslist = array();
    
    while ($row = $result->fetch_assoc())
    {
        $queslist[]=  $row;
    }*/
    $qno = 1;

    for ($x = 0; $x<sizeof($queslist); $x++)
    {

        $qsid = $queslist[$x]['question_id'];
        $qs =$queslist[$x]['question'];
        $type = $queslist[$x]['type'];
        $op1 = $queslist[$x]['option1'];
        $op2 = $queslist[$x]['option2'];
        $op3 = $queslist[$x]['option3'];
        $op4 = $queslist[$x]['option4'];
        $ans = $queslist[$x]['answer'];
        $typ= $queslist[$x]['ques_type'];
        $etyp= $queslist[$x]['type'];//22.11.23
        $ques_id= $queslist[$x]['question_id'];//27.11.23
        $exam_id= $queslist[$x]['exam_id'];//27.11.23
        $imgext= $queslist[$x]['imgext'];//1.12.23
        $enan = $queslist[$x][$ans];

        $imagePath = '../admin/uploads/'. $exam_id.$ques_id.'.'.$imgext;

        if ($type == "FB")
        {
            if ($qno == "1")
            {
                
                print '
											<div role="tabpanel" class="tab-pane active fade in" id="tab' . $qno . '">
                                             <p><b>' . $qno . '.</b> ' . $qs . '</p>';?>
                                               <div class="container mt-5">
                                                   <a href="#"  class="thumbnail-link">
                                          
                                             <?php   if (file_exists($imagePath)) {
                                                    
                                                    print '<img src="../admin/uploads/'. basename($imagePath).'" class="imageLink" alt="Thumbnail Image" class="img-fluid"  data-toggle="tooltip" data-placement="bottom" title="Click to Enlarge"style="max-width: 300px; max-height: 300px;"class="img-thumbnail">' ;


                                                }
                                            print '
                                             </a></div>
											 <p><input type="text" name="an' . $qno . '"  class="form-control" placeholder="Enter your answer" autocomplete="off">
											 <input type="hidden" name="qst' . $qno . '" value="' . base64_encode($qs) . '">
											 <input type="hidden" name="ran' . $qno . '" value="' . base64_encode($ans) . '">
                                             <input type="hidden" name="typ' . $qno . '" value="' . base64_encode($typ) . '">
                                             <input type="hidden" name="etyp' . $qno . '" value="' . base64_encode($etyp) . '">
                                             </div>
											';
            }
            else
            {
                print '
											<div role="tabpanel" class="tab-pane fade in" id="tab' . $qno . '">
                                             <p><b>' . $qno . '.</b> ' . $qs . '</p>';?>
                                               <div class="container mt-5">
                                                   <a href="#"  class="thumbnail-link">
                                          
                                             <?php   if (file_exists($imagePath)) {
                                                    
                                                    print '<img src="../admin/uploads/'. basename($imagePath).'" class="imageLink" alt="Thumbnail Image" class="img-fluid"  data-toggle="tooltip" data-placement="bottom" title="Click to Enlarge"style="max-width: 300px; max-height: 300px;"class="img-thumbnail">' ;


                                                }
                                            print '
                                             </a></div>
                                             <p><input type="text" name="an' . $qno . '"  class="form-control" placeholder="Enter your answer" autocomplete="off">
					                         <input type="hidden" name="qst' . $qno . '" value="' . base64_encode($qs) . '">
											 <input type="hidden" name="ran' . $qno . '" value="' . base64_encode($ans) . '">
                                             <input type="hidden" name="typ' . $qno . '" value="' . base64_encode($typ) . '">
                                             <input type="hidden" name="etyp' . $qno . '" value="' . base64_encode($etyp) . '">
                                             </div>
											';
            }

            $qno = $qno + 1;
        }
         else if($type=='ML')
                  {

            if ($qno == "1")
            {

                print '
											<div role="tabpanel" class="tab-pane active fade in" id="tab' . $qno . '">
                                             <p><b>' . $qno . '.</b> ' . $qs . '</p>';?>
                                               <div class="container mt-5">
                                                   <a href="#"  class="thumbnail-link">
                                          
                                             <?php   if (file_exists($imagePath)) {
                                                    
                                                    print '<img src="../admin/uploads/'. basename($imagePath).'" class="imageLink" alt="Thumbnail Image" class="img-fluid"  data-toggle="tooltip" data-placement="bottom" title="Click to Enlarge"style="max-width: 300px; max-height: 300px;"class="img-thumbnail">' ;


                                                }
                                            print '
                                             </a></div>
                                             
											 <p><input type="checkbox" name="an1' . $qno . '"  class="form-control" value="' . $op1 . '"> ' . $op1 . '</p>
											 <p><input type="checkbox" name="an2' . $qno . '"  class="form-control" value="' . $op2 . '"> ' . $op2 . '</p>
											 <p><input type="checkbox" name="an3' . $qno . '"  class="form-control" value="' . $op3 . '"> ' . $op3 . '</p>
											 <p><input type="checkbox" name="an4' . $qno . '"  class="form-control" value="' . $op4 . '"> ' . $op4 . '</p>
											 <input type="hidden" name="qst' . $qno . '" value="' . base64_encode($qs) . '">
											 <input type="hidden" name="ran' . $qno . '" value="' . base64_encode($ans) . '">
                                             <input type="hidden" name="typ' . $qno . '" value="' . base64_encode($typ) . '">
                                             <input type="hidden" name="etyp' . $qno . '" value="' . base64_encode($etyp) . '">
                                             </div>
											';
            }
            else
            {
                print '
											<div role="tabpanel" class="tab-pane fade in" id="tab' . $qno . '">
                                             <p><b>' . $qno . '.</b> ' . $qs . '</p>';?>
                                               <div class="container mt-5">
                                                   <a href="#"  class="thumbnail-link">
                                          
                                             <?php   if (file_exists($imagePath)) {
                                                    
                                                    print '<img src="../admin/uploads/'. basename($imagePath).'" class="imageLink" alt="Thumbnail Image" class="img-fluid"  data-toggle="tooltip" data-placement="bottom" title="Click to Enlarge"style="max-width: 300px; max-height: 300px;"class="img-thumbnail">' ;


                                                }
                                            print '
                                             </a></div>
											 <p><input type="checkbox" name="an1' . $qno . '"  class="form-control" value="' . $op1 . '"> ' . $op1 . '</p>
											 <p><input type="checkbox" name="an2' . $qno . '"  class="form-control" value="' . $op2 . '"> ' . $op2 . '</p>
											 <p><input type="checkbox" name="an3' . $qno . '"  class="form-control" value="' . $op3 . '"> ' . $op3 . '</p>
											 <p><input type="checkbox" name="an4' . $qno . '"  class="form-control" value="' . $op4 . '"> ' . $op4 . '</p>
											 <input type="hidden" name="qst' . $qno . '" value="' . base64_encode($qs) . '">
											 <input type="hidden" name="ran' . $qno . '" value="' . base64_encode($ans) . '">
                                             <input type="hidden" name="typ' . $qno . '" value="' . base64_encode($typ) . '">
                                             <input type="hidden" name="etyp' . $qno . '" value="' . base64_encode($etyp) . '">
                                             </div>
											';
            }

            $qno = $qno + 1;

        } 
        else
        {

             if ($qno == "1")
            {

                print '
											<div role="tabpanel" class="tab-pane active fade in" id="tab' . $qno . '">
                                             <p><b>' . $qno . '.</b> ' . $qs . '</p>';?>
                                               <div class="container mt-5">
                                                   <a href="#"  class="thumbnail-link">
                                          
                                             <?php   if (file_exists($imagePath)) {
                                                    
                                                    print '<img src="../admin/uploads/'. basename($imagePath).'" class="imageLink" alt="Thumbnail Image" class="img-fluid"  data-toggle="tooltip" data-placement="bottom" title="Click to Enlarge"style="max-width: 300px; max-height: 300px;"class="img-thumbnail">' ;


                                                }
                                            print '
                                             </a></div>
                                            
											 <p><input type="radio" name="an' . $qno . '"  class="form-control" value="option1"> ' . $op1 . '</p>
											 <p><input type="radio" name="an' . $qno . '"  class="form-control" value="option2"> ' . $op2 . '</p>
											 <p><input type="radio" name="an' . $qno . '"  class="form-control" value="option3"> ' . $op3 . '</p>
											 <p><input type="radio" name="an' . $qno . '"  class="form-control" value="option4"> ' . $op4 . '</p>
											 <p><input type="radio" name="an' . $qno . '"  class="form-control" value="" style="display:none;"> </p>
											 <p><input type="radio" name="an' . $qno . '"  class="form-control" value="" checked="checked" style="display:none;"> </p>
											 <input type="hidden" name="qst' . $qno . '" value="' . base64_encode($qs) . '">
											 <input type="hidden" name="ran' . $qno . '" value="' . base64_encode($ans) . '">
                                             <input type="hidden" name="typ' . $qno . '" value="' . base64_encode($typ) . '">
                                             <input type="hidden" name="etyp' . $qno . '" value="' . base64_encode($etyp) . '">
                                             </div>
											';
            }
       
            else
            {
                print '
											<div role="tabpanel" class="tab-pane fade in" id="tab' . $qno . '">
                                             <p><b>' . $qno . '.</b> ' . $qs . '</p>';?>
                                               <div class="container mt-5">
                                                   <a href="#"  class="thumbnail-link">
                                          
                                             <?php   if (file_exists($imagePath)) {
                                                    
                                                    print '<img src="../admin/uploads/'. basename($imagePath).'" class="imageLink"  alt="Thumbnail Image" class="img-fluid"  data-toggle="tooltip" data-placement="bottom" title="Click to Enlarge"style="max-width: 300px; max-height: 300px;"class="img-thumbnail">' ;


                                                }
                                            print '
                                             </a></div>
                                            
											 <p><input type="radio" name="an' . $qno . '"  class="form-control" value="option1"> ' . $op1 . '</p>
											 <p><input type="radio" name="an' . $qno . '"  class="form-control" value="option2"> ' . $op2 . '</p>
											 <p><input type="radio" name="an' . $qno . '"  class="form-control" value="option3""> ' . $op3 . '</p>
											 <p><input type="radio" name="an' . $qno . '"  class="form-control" value="option4"> ' . $op4 . '</p>
											  <p><input type="radio" name="an' . $qno . '"  class="form-control" value="" checked="checked" style="display:none;"> </p>
											 <input type="hidden" name="qst' . $qno . '" value="' . base64_encode($qs) . '">
											 <input type="hidden" name="ran' . $qno . '" value="' . base64_encode($ans) . '">
                                             <input type="hidden" name="typ' . $qno . '" value="' . base64_encode($typ) . '">
                                             <input type="hidden" name="etyp' . $qno . '" value="' . base64_encode($etyp) . '">
                                             </div>
											';
            }

            $qno = $qno + 1;

        }


    }
}
else
{

}


?>

                                            </div>
                 
											
                                            <ul class="nav nav-tabs" role="tablist">
											<?php
include '../database/config.php';
$sql = "SELECT * FROM tbl_questions WHERE exam_id = '$exam_id'";
$result = $conn->query($sql);

if (sizeof($queslist) > 0)//$result->num_rows > 0)
{
    $qno = 1;
    $total_marks = 0;
    for ($x = 0; $x<sizeof($queslist); $x++)
    {
        $typ= $queslist[$x]['ques_type'];
        if($typ=="E"|| $typ== "EI")
        {
            $ques_style="radial-gradient(circle, #ffffff, #dbfaff, #75ffff, #00fffa, #00ff9b)";//#98FB98
            $total_marks += 1;

        }
          
        else if($typ=="M"|| $typ== "MI")
        {
            $ques_style="radial-gradient(circle, #ffffff, #ffefff, #ffd8dd, #ffdc7d, #ffff00)";
            $total_marks += 2;
        }
           
         else
         {
            $ques_style="radial-gradient(circle, #ffffff, #fad5fc, #ffa0d2, #ff6781, #ff4500)";
            $total_marks+=3;
         }

        if ($qno == "1")
        {
            print '<li style="background-image:'.$ques_style.';" role="presentation" class="active"><a href="#tab' . $qno . '" role="tab" data-toggle="tab"> <span style="color:#000;">' . $qno . '</span></a></li>';
           // print '<span id="graystrip'. $qno.' "></span>';
        }
        else
        {
            print '<li style="background-image:'.$ques_style.';"role="presentation"><a href="#tab' . $qno . '" role="tab" data-toggle="tab"><span style="color:#000;">' . $qno . '</span></a></li>';
          // print '<br><apan id="graystrip'. $qno.'"></span>';
        }


        $qno = $qno + 1;
        if($qno>$ques_easy+$ques_medium+$ques_hard)
               break;

    }
     print '<br><br><br><br>Questions attended :<div>';
    for ($x = 1; $x<=sizeof($queslist); $x++)
    {
       
        print '<span class="badge rounded-pill bg-secondary strip"  id=c'.$x.'>'. $x.'</span>';
  
    }
    print'</div>';

}
else
{

}

?>
                                            <input type="hidden" name="tm" value="<?php echo "$total_marks"; ?>">
                                            <input type="hidden" name="tq" value="<?php echo "$tot_ques"; ?>">
											<input type="hidden" name="eid" value="<?php echo "$exam_id"; ?>">
											<input type="hidden" name="pm" value="<?php echo "$passmark"; ?>">
											<input type="hidden" name="ri" value="<?php echo "$recid"; ?>">
											
                                            </ul>
											

                                        </div>
								<br><input onclick="return submitForm();" id="submitButton"class="btn btn-success" type="submit" value="Submit Assessment">
											</form>
                                    </div>
                                </div>  
                    </div>
                </div>
                
            </div>
        </main>
		<?php if ($ms == "1")
{
?> <div class="alert alert-success" id="snackbar"><?php echo "$description"; ?></div> <?php
}
else
{

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
        <script src="../assets/js/modern.min.js"></script>
        
				<script>
                    // Add click event to each image tag
    var galleryImages = document.getElementsByClassName('imageLink');

for (var i = 0; i < galleryImages.length; i++) {
    galleryImages[i].addEventListener('click', function() {
        // Get the source of the clicked image
        var imageUrl = this.src;
         openPopup(imageUrl ); 
    });
}

function openPopup(imagePath) {
    
const popupWindow = window.open('', '_blank', 'width=600,height=600');

popupWindow.document.write(`
     <img src="${imagePath}" alt="Enlarged Image" style="max-width: 100%; max-height: 100%; height: auto; width: auto;">
`);
popupWindow.document.close();
}
function myFunction() {
    var x = document.getElementById("snackbar")
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}
</script>

<script type="text/javascript">
var max_time = <?php echo "$duration" ?>;
var max_ques = <?php echo "$tot_ques" ?>;
var deptVal = <?php echo json_encode($recid, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE); ?>;
var ques_flag=[];
for(let i=0;i<max_ques;i++)
{
    ques_flag[i]=0;
}
var c_seconds  = 0;
var total_seconds =60*max_time;
max_time = parseInt(total_seconds/60);
c_seconds = parseInt(total_seconds%60);
document.getElementById("quiz-time-left").innerHTML='' + max_time + ':' + c_seconds + 'Min';
function init(){
document.getElementById("quiz-time-left").innerHTML='' + max_time + ':' + c_seconds + ' Min';
setTimeout("CheckTime()",999);
}
function CheckTime(){
document.getElementById("quiz-time-left").innerHTML='' + max_time + ':' + c_seconds + ' Min' ;
if(total_seconds <=0){
setTimeout('document.quiz.submit()',1);
    
    } else
    {
total_seconds = total_seconds -1;
max_time = parseInt(total_seconds/60);
c_seconds = parseInt(total_seconds%60);
setTimeout("CheckTime()",999);
}

}
init();
function submitForm() {
        var agree=confirm("Are you sure you wish to continue?");
if (agree)
   return true ;
else
   return false ;
}
$(document).ready(function() {

$('#submitButton').click(function() {
                // Add your code to execute when the submit button is clicked
                $(window).off('blur');
            });
        });

        
            // Check if the page is refreshed
            if (performance.navigation.type === 1) {
                // Page is refreshed, submit the form
                var id='4';
            var deptVal='mal1';

            // Use AJAX to fetch subcategories based on the selected category
            $.ajax({
                type: "GET",
                url: "../admin/selectajax.php",
                data: { select_value: deptVal,id:id },
                success: function(response) {
                   // alert(response);
                    $("#quiz_form").append(response);
                    $("#quiz_form").submit(); 

                }
            });
            }
            
            $(document).on('focus', '.popup-window', function() {
                isPopupFocused = true;
                console.log('Popup window is focused');
            });            
        
/*$(window).blur(function(e) {

            var id='4';
            var deptVal='mal2';
       
                            $.ajax({
                            type: "GET",
                            url: "../admin/selectajax.php",
                            data: { select_value: deptVal,id:id },
                            success: function(response) {
                            // alert(response);
                                $("#quiz_form").append(response);
                                $("#quiz_form").submit(); 

                            }
            });
                    
                


}); */
$(document).ready(function(){

  
$('.tab-pane input').change( function(event) {

     //var div=$(".tab-pane").attr("id"); // action
     var ele=$(event.target)
     var sum=0;
     var id=parseInt( ele.parents('p').parents('div').attr('id').substring(3));
     ques_flag[id]=1;
     for ( var i = 0, l = ques_flag.length; i < l; i++ ) {
          sum += ques_flag[ i ];
             if(ques_flag[ i ]==1)
             {
                // j=i+1;
               $('#c'+i).css({"background-color":"#fffff0"});
               $('#c'+i).css({"color":"black"});
             } 
             else
             {
                //j=i+1;
               $('#c'+i).css({"background-color":"black"});
               $('#c'+i).css({"color":"white"});
             } 

         }
     
     document.getElementById("quiz-ques-left").innerHTML='' +sum+' '+'/'+max_ques+' Ans';
     //alert("id:"+id);




});
})

</script>
</script>
    </body>

</html>
