<?php 
	session_start();
	if(!isset($_SESSION['user_id']))
		header("Location:logout.php");

	require_once ('../db_connect.php');
	$connection = new createConnection(); //i created a new object
	
	$name		="";
	$op_user_id	="";
	$status	="";
	$readonly="";
	$checked='checked';
	$button_caption="Add User";
	$record_exists = false;

	if(isset($_GET['user_id']) && $_GET['user_id'] !="")
	{
		$user_id = $_GET['user_id'];
		$where = "user_id='$user_id' and user_type='operator' ";
		$results=$connection->get_data("admin_users","*",$where,null);
		
		foreach($results as $usrinfo)
		{
			$name			=$usrinfo['name'];
			$op_user_id		=$usrinfo['user_id'];
			$status		=$usrinfo['status'];
			$readonly	='readonly';
			$button_caption="Modify User";
			$record_exists = true;
		}
	}
   

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<!-- Title here -->
		<title>Zaikart</title>
		<!-- Description, Keywords and Author -->
		<meta name="description" content="Your description">
		<meta name="keywords" content="Your,Keywords">
		<meta name="author" content="ResponsiveWebInc">
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<!-- Styles -->
		<!-- Bootstrap CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<!-- jQuery UI -->
		<link rel="stylesheet" href="css/jquery-ui.css"> 
		<!-- jQuery Gritter -->
		<link rel="stylesheet" href="css/jquery.gritter.css">
		<!-- Font awesome CSS -->
		<link href="css/font-awesome.min.css" rel="stylesheet">		
		<!-- Custom CSS -->
		<link href="css/style.css" rel="stylesheet">
		<!-- Widgets stylesheet -->
		<link href="css/widgets.css" rel="stylesheet">   
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="#">
	</head>
	
	<body>

		<?php require 'header.php'; ?>

		<!-- Main content starts -->
		<div class="content">



			
			<?php require 'sidebar.php'; ?>





			<!-- Main bar -->
			<div class="mainbar">
			  
				<!-- Page heading -->
				<!-- <div class="page-head">
					  <h2 class="pull-left">Invoice <span class="page-meta">Something Goes Here</span>	</h2>
				</div> -->
				<!-- Page heading ends -->



				<!-- Matter -->
				<div class="matter">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<div class="widget wgreen">
              						<div class="widget-head">
									  <div class="pull-left">Forms</div>
									  <div class="widget-icons pull-right">
										<a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a> 
										<a href="#" class="wclose"><i class="fa fa-times"></i></a>
									  </div>
									  <div class="clearfix"></div>
									</div>
									<div class="widget-content">
									  <div class="padd">

										<!-- <h6>Input Boxs</h6>
										<hr /> -->
										<!-- Form starts.  -->
											<form class="form-horizontal" role="form" name="user_frm" id="user_frm" action="users_form.php" method="post">

												<div class="form-group">
												  <label class="col-md-2 control-label">Name</label>
												  <div class="col-md-8">
													<input type="text" class="form-control" placeholder="Name" name="name" id="name" required="" title="Please enter  name" maxlength="10" value="<?php echo $name;  ?>">
												  </div>
												</div>

												<div class="form-group">
												  <label class="col-md-2 control-label">User name</label>
												  <div class="col-md-8">
													<input type="text" class="form-control" placeholder="User name" name="username" id="username" required="" title="Please enter user name" maxlength="10" value="<?php echo $op_user_id;  ?>" <?php echo $readonly ?>>
												  </div>
												</div>

												<?php 
													if($record_exists == false)
													{
												?>
												<div class="form-group">
												  <label class="col-md-2 control-label">Password</label>
												  <div class="col-md-8">
													<input type="password" class="form-control" placeholder="password"  name="user_pwd" id="user_pwd"  required="" title="Please enter password" <?php echo $readonly ?>>
												  </div>
												</div>
												<?php
													}
												?>


												<div class="form-group">
												  <label class="col-md-2 control-label">Status</label>
												  <div class="col-md-8">
													<div class="radio">
													  <label>
														<input type="radio" value="y" id="status_y" name="status" <?php if($status=='y') echo $checked; else if($status=="") echo $checked; ?>>
														Active
													  </label>
													</div>
													<div class="radio">
													  <label>
														<input type="radio" value="n" id="status_n" name="status" <?php if($status=='n') echo $checked; ?>>
														Inactive
													  </label>
													</div>
												  </div>
												</div>
												
												
												
												<div class="form-group">
													 <div class="col-md-8">
															<div id="register_msg"></div>
													</div>
												</div>
												
												
												<div class="form-group">
												  <div class="col-md-offset-2 col-md-8">
													<!-- <button type="button" class="btn btn-default">Default</button>
													<button type="button" class="btn btn-primary">Primary</button> -->
													<!-- <button type="button" class="btn btn-success">Success</button> -->
													<input type="submit" class="btn btn-success" name="submit_users" id="success" value="<?php echo $button_caption;  ?>">
													<!-- <button type="button" class="btn btn-info">Info</button>
													<button type="button" class="btn btn-warning">Warning</button>
													<button type="button" class="btn btn-danger">Danger</button> -->
												  </div>
												</div>
											</form>
									  </div>
									</div>
								</div>  
							</div>
						</div>
					</div>
				</div><!--/ Matter ends -->
			</div><!--/ Mainbar ends -->	    	
			<div class="clearfix"></div>
		</div><!--/ Content ends -->

		

		<!-- Scroll to top -->
		<span class="totop"><a href="#"><i class="fa fa-chevron-up"></i></a></span> 

		<!-- Javascript files -->
		<!-- jQuery -->
		<script src="js/jquery.js"></script>
		<!-- Bootstrap JS -->
		<script src="js/bootstrap.min.js"></script>
		<!-- jQuery UI -->
		<script src="js/jquery-ui.min.js"></script> 
		<!-- jQuery Gritter -->
		<script src="js/jquery.gritter.min.js"></script>
		<!-- Respond JS for IE8 -->
		<script src="js/respond.min.js"></script>
		<!-- HTML5 Support for IE -->
		<script src="js/html5shiv.js"></script>
		<!-- Custom JS -->
		<script src="js/custom.js"></script>



		
	<script src="../js/jquery.validate.js"></script>
		<script src="../js/additional-methods.js"></script>
		<script src="../js/jquery.form.js"></script>

		<script type="text/javascript">

	$(document).ready(function () {
	$('#user_frm').validate({}); // For Validation should be there

	var options = { 
        target:        '#register_msg',   // target element(s) to be updated with server response 
      	beforeSubmit:  showRequest,  // pre-submit callback 
        success:       showResponse  // post-submit callback 
    }; 
     // bind form using 'ajaxForm' 
    $('#user_frm').ajaxForm(options); 
	// pre-submit callback 
	function showRequest(formData, jqForm, options) 
		{ 
			var queryString = $.param(formData); 
			return true; 
		} 
	// post-submit callback 
	function showResponse(responseText, statusText, xhr, $form)  
	{ 
		response = responseText;
		//alert(response);
		var response_val = response.split("~")
		if(response_val[1]=='error')
			document.getElementById("register_msg").innerHTML = response_val[0];
		else
			window.location.assign("users.php");


	}	 
});

</script>

	</body>	
</html>