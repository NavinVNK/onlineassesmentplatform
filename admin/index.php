<?php include 'includes/check_user.php'; 
include 'includes/fetch_records.php';
?>
<!DOCTYPE html>
<html>
    
<head>
        
        <title>OES | Admin Dashboard</title>
        
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
        <link href="../assets/plugins/weather-icons-master/css/weather-icons.min.css" rel="stylesheet" type="text/css"/>	
        <link href="../assets/plugins/metrojs/MetroJs.min.css" rel="stylesheet" type="text/css"/>	
        <link href="../assets/plugins/toastr/toastr.min.css" rel="stylesheet" type="text/css"/>	
        <link href="../assets/images/icon.png" rel="icon">
        <link href="../assets/css/modern.min.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/css/themes/green.css" class="theme-color" rel="stylesheet" type="text/css"/>
        <link href="../assets/css/custom.css" rel="stylesheet" type="text/css"/>
        
        <script src="../assets/plugins/3d-bold-navigation/js/modernizr.js"></script>
        <script src="../assets/plugins/offcanvasmenueffects/js/snap.svg-min.js"></script>
        
    </head>
    <body class="page-header-fixed">
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
                        <a href="./" class="logo-text"><img src="../assets/images/7hillsTS.png" alt="" height="50" width=""></span></a>
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
                    <li class="active"><a href="./" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-home"></span><p>Dashboard</p></a></li>
						<li><a href="departments.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-folder-open"></span><p>Domain</p></a></li>
						<li><a href="categories.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon glyphicon-tags"></span><p>Categories</p></a></li>
						<li><a href="subject.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon glyphicon-file"></span><p>Skills</p></a></li>
						<li><a href="students.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon glyphicon-user"></span><p>Candidates</p></a></li>
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
                    <h3>Admin Dashboard</h3>
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li><a href="./">Home</a></li>
                            <li class="active">Admin Dashboard</li>
                        </ol>
                    </div>
                </div>
                <div id="main-wrapper">
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="panel info-box panel-white">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p class="counter"><?php echo number_format($departments); ?></p>
                                        <span class="info-box-title">DOMAIN</span>
                                    </div>
                                    <div class="info-box-icon">
                                        <i class="icon-folder"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="panel info-box panel-white">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p class="counter"><?php echo number_format($students); ?></p>
                                        <span class="info-box-title">CANDIDATES</span>
                                    </div>
                                    <div class="info-box-icon">
                                        <i class="icon-user"></i>
                                    </div>
     
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="panel info-box panel-white">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p><span class="counter"><?php echo number_format($examination); ?></span></p>
                                        <span class="info-box-title">ASSESSMENTS</span>
                                    </div>
                                    <div class="info-box-icon">
                                        <i class="icon-book-open"></i>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="panel info-box panel-white">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p class="counter"><?php echo number_format($subjects); ?></p>
                                        <span class="info-box-title">SKILLS</span>
                                    </div>
                                    <div class="info-box-icon">
                                        <i class="icon-docs"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
						
						                        <div class="col-lg-3 col-md-6">
                            <div class="panel info-box panel-white">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p class="counter"><?php echo number_format($categories); ?></p>
                                        <span class="info-box-title">SERVICES <?php echo "$fp $pp"; ?></span>
                                    </div>
                                    <div class="info-box-icon">
                                        <i class="icon-tag"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="panel info-box panel-white">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p class="counter"><?php echo number_format($notice); ?></p>
                                        <span class="info-box-title">BULLETIN BOARD</span>
                                    </div>
                                    <div class="info-box-icon">
                                        <i class="icon-list"></i>
                                    </div>
     
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="panel info-box panel-white">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p><span class="counter"><?php echo number_format($questions); ?></span></p>
                                        <span class="info-box-title">QUESTIONS</span>
                                    </div>
                                    <div class="info-box-icon">
                                        <i class="icon-question"></i>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="panel info-box panel-white">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p class="counter"><?php echo number_format($banned_students); ?></p>
                                        <span class="info-box-title">BANNED CANDIDATES</span>
                                    </div>
                                    <div class="info-box-icon">
                                        <i class="icon-lock"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   <div class="container">
                    <form class="form form-inline" role="form"action="includes/graph_results.php"  method="POST" name="result_exam" id="result_form">
                        <legend>Assesment Analysis</legend>
    
                            <div class="form-group col-xs-12 col-sm-6 col-lg-3">
                                <label for="InputFieldA" class="col-xs-4">Select Assesment</label>
                                   <div class="col-xs-8">
                                            
                                            <select class="form-control" name="exam" id="exam" required>
											<option value="" selected disabled>-Select Assesment-</option>
											<?php
											include '../database/config.php';
											$sql = "SELECT * FROM tbl_examinations WHERE status = 'Active' ORDER BY exam_name";
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
                            </div>  
                                <div class="form-group col-xs-12 col-sm-6 col-lg-3">
      
                                     <div class="col-xs-8">
                                        <input style ="text-align: center; "  class="btn btn-success" type="submit" name="passresult"id="myBtn" value="Submit">
                                     </div>
                                </div>   
                                      </div>
                     </form>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="panel panel-white">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 col-lg-6">

                                        <div class="visitors-chart">
                                            <div class="panel-body">
                                            <div id="chartContainer"  style="height: 370px; max-width: 920px; margin: 0px auto;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="visitors-chart">
                                            <div class="panel-body">
                                            <div id="chartContainer1"  style="height: 370px; max-width: 920px; margin: 0px auto;"></div>
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
        <script src="../assets/plugins/waypoints/jquery.waypoints.min.js"></script>
        <script src="../assets/plugins/jquery-counterup/jquery.counterup.min.js"></script>
        <script src="../assets/plugins/toastr/toastr.min.js"></script>
        <script src="../assets/plugins/flot/jquery.flot.min.js"></script>
        <script src="../assets/plugins/flot/jquery.flot.time.min.js"></script>
        <script src="../assets/plugins/flot/jquery.flot.symbol.min.js"></script>
        <script src="../assets/plugins/flot/jquery.flot.resize.min.js"></script>
        <script src="../assets/plugins/flot/jquery.flot.tooltip.min.js"></script>
        <script src="../assets/plugins/curvedlines/curvedLines.js"></script>
        <script src="../assets/plugins/metrojs/MetroJs.min.js"></script>
        <script src="../assets/js/modern.js"></script>
		<script src="../assets/js/canvasjs.min.js"></script>
		 
		 <script>
window.onload = function() {


    $("#result_form").submit(function(e) {

                e.preventDefault(); // avoid to execute the actual submit of the form.

                var form = $(this);
                var url = form.attr('action');

                    $.ajax({
                        type: "POST",
                        url: url,
                        data: form.serialize(), // serializes the form's elements.
                        dataType:"json",
                        success: function(response)
                        {
                         //var jsondata = JSON.parse(response);
                          // alert(response);$("#exam option").filter(":selected").text();
                           var pass = response[0].pass;
                          var fail = response[0].fail;

                            var chart = new CanvasJS.Chart("chartContainer", {
                            theme: "light1", 
                            exportEnabled: true,
                            animationEnabled: true,
                            title: {
                                text: "Csndiate assessments  FAIL and PASS in "+$("#exam option").filter(":selected").text()
                            },
                            data: [{
                                type: "pie",
                                startAngle: 25,
                                toolTipContent: "<b>{label}</b>: {y}",
                                showInLegend: "true",
                                legendText: "{label}",
                                indexLabelFontSize: 14,
                                indexLabel: "{label} - {y}",
                                dataPoints: [
                                    { y:pass, label: "Candidate Passing Exams" },
                                    { y: fail, label: "Candidate Failing Exams" }
                                ]
                            }]
                        });
                        chart.render();


                        var chart = new CanvasJS.Chart("chartContainer1", {
            title: {
                text: "Assesment Marks Range"
            },
            subtitles: [
                {
                    text: "Click on Legends to Enable/Disable Data Series"
                }
            ],
            animationEnabled: true,
            legend: {
                cursor: "pointer",
                itemclick: function (e) {
                    if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                        e.dataSeries.visible = false;
                    }
                    else {
                        e.dataSeries.visible = true;
                    }
                    chart.render();
                }
            },
            axisY: {
                title: "Mark assesment in "+$("#exam option").filter(":selected").text()
            },
            toolTip: {
                shared: true,
                content: function (e) {
                    var str = '';
                    var total = 0;
                    var str3;
                    var str2;
                    for (var i = 0; i < e.entries.length; i++) {
                        var str1 = "<span style= 'color:" + e.entries[i].dataSeries.color + "'> " + e.entries[i].dataSeries.name + "</span>: <strong>" + e.entries[i].dataPoint.y + "</strong> <br/>";
                        total = e.entries[i].dataPoint.y + total;
                        str = str.concat(str1);
                    }
                    str2 = "<span style = 'color:DodgerBlue; '><strong>" + e.entries[0].dataPoint.label + "</strong></span><br/>";
                    str3 = "<span style = 'color:Tomato '>Total: </span><strong>" + total + "</strong><br/>";

                    return (str2.concat(str)).concat(str3);
                }

            },
            data: [
            {
                type: "bar",
                showInLegend: true,
                name: "count of candidates",
                color: "gold",
                dataPoints: [{'y':response[0].score25,'label':"0-25"},{'y':response[0].score50,'label':"25-50"},{'y':response[0].score75,'label':"50-75"},{'y':response[0].score100,'label':"75-100"}]
            }

            ]
        });

        chart.render();

                        }
                                        });


                                    });



}
</script>
        
    </body>


</html>                                                                      