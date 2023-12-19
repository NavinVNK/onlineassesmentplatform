<!DOCTYPE html>
<?php include 'includes/check_reply.php'; ?>
<html>
	<head>
		<meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta charset="UTF-8">
        <meta name="description" content="Online Examination System" />
        <meta name="keywords" content="Online Examination System" />
        <meta name="author" content="navin K" />
		

        <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>

       
        
         <link href="assets/css/snack.css" rel="stylesheet" type="text/css"/>



		<!-- LINEARICONS -->
		<link rel="stylesheet" href="assets/fonts/linearicons/style.css">

		<!-- MATERIAL DESIGN ICONIC FONT -->
		<link rel="stylesheet" href="assets/fonts/material-design-iconic-font/css/material-design-iconic-font.css">

		<!-- STYLE CSS -->
		<link rel="stylesheet" href="assets/css/style.css">
	</head>
	<body <?php if ($ms == "1") { print 'onload="myFunction()"'; } ?>>
<div class="se-pre-con"></div>
		<nav>
				<img src="assets/images/7hillsTS.png" alt="" width="10" height='50'  style="vertical-align: middle;margin:2px 20px;width:200px">
		</nav>
		<div class="wrapper">
			<div class=" image-holder">
				<div class="row online-img" >
				<div class="col-md-9 col-xs-12" >
					<div class="team-member text-center">
<div class="picture">
  
    <div class="mask">
        <div class="team-member-icons">
            <a target="_blank" href="#">
                <i class="fa fa-facebook"></i>
            </a>
            <a target="_blank" href="#">
                <i class="fa fa-twitter"></i>
            </a>
        </div>
    </div>
</div>
</div> 

					
				</div>
				<div class="col-md-3 col-xs-12">
				  <h2> Online Assessment Platform </h2>
				</div>
			</div>

				
			</div>
            <div class="form-content">
            	
            		<div id="wizard">
	            		<!-- SECTION 1 -->
		                <h4></h4>
		                <section>
							<form action="pages/authentication.php" method="POST">
	                		<!-- <img src="assets/images/7hillsTS.png" alt="" width="" height='50'  class="center pt-4"> -->
							
							<div class="form-wrapper">
								<label for="" class="label-input">E-Mail/ID:</label>
								<input type="text" class="form-control" placeholder="Enter E-mail or ID" name="user" required>
							</div>
								<div class="form-wrapper">
									<label for="" class="label-input">Password:</label>
									<input type="password"  class="form-control" placeholder="Your strong password" name="login" required>
								</div>
								<div class="form-wrapper">
									<label for="" class="label-input"></label>
									<button type="submit" class="button login__submit ">Login</button>
								</div>	    
								
								
								
							
						</form>
		                </section>
					

						<!-- SECTION 2 -->
						
		                <h4></h4>
		                <section>
							<form action="pages/reset_account.php" method="POST">

							<img src="assets/images/7hillsTS.png" alt="" width=""  height="50" class="center pt-4">
								
								<div class="form-wrapper">
									<label for="" class="label-input">E-mail ID:</label>
									<input type="text" class="form-control" placeholder="Enter E-mail or ID" name="user" required>
								</div>
									<div class="form-wrapper">
										<label for="" class="label-input">New Password:</label>
										<input type="password" class="form-control" placeholder="Enter new passWord"  name="newpass" required>
									</div>
									<div class="form-wrapper">
										<label for="" class="label-input"></label>
										<button type="submit" class="button login__submit ">Send me new password</button>
									</div>	    
																					
						</form>
		                </section>
					

		                <!-- SECTION 3 -->
						

            	
            	
				
            </div>
		</div>
		<?php if ($ms == "1") {
?> <div class="alert alert-success" id="snackbar"><?php echo "$description"; ?></div> <?php	
}else{
	
}
?>
        <script src="assets/js/jquery-3.3.1.min.js"></script>
		<script src="assets/plugins/3d-bold-navigation/js/modernizr.js"></script>
        <script src="assets/plugins/offcanvasmenueffects/js/snap.svg-min.js"></script>
		<!-- JQUERY STEP -->
		<script src="assets/js/jquery.steps.js"></script>

		<script src="assets/js/main.js"></script>

        <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>


        		<script>
					
function myFunction() {
    var x = document.getElementById("snackbar")
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}
</script>
</body>
</html>