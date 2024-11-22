<?php 
	session_start();
	if(!isset($_SESSION['user_id']))
		header("Location:logout.php");

	require_once ('../db_connect.php');
	$connection = new createConnection(); //i created a new object

	if(isset($_GET['client_data']) && $_GET['client_data'] =='Export Client Data')
	{
		ob_clean();
		header("Content-Type: application/xls");
		header("Content-Disposition: attachment; filename=customers_".date("d_m_Y").".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		$where="";
		$results=$connection->get_data("customer_master","concat(fname, ' ',lname)  as name,email_id,mobile_number",$where," concat(fname, ' ',lname)");
		$i=1;
		echo "Name \t Email \t Mobile Number";
		echo "\r\n";	
		foreach($results as $usrinfo)
		{
			echo ucfirst($usrinfo['name'])."\t";
			echo strtolower($usrinfo['email_id'])."\t";
			echo '="'.$usrinfo['mobile_number'].'"';
			echo "\r\n";	
		}
		
		exit;
	}

	if(isset($_GET['client_data']) && $_GET['client_data'] =='Export Email Data')
	{
		ob_clean();
		header("Content-Type: application/txt");
		header("Content-Disposition: attachment; filename=customer_emails.txt");
		header("Pragma: no-cache");
		header("Expires: 0");
		$where="";
		$results=$connection->get_data("customer_master","email_id",$where,null);
		$i=1;
		foreach($results as $usrinfo)
		{
			echo strtolower($usrinfo['email_id']).";";
		}
		
		exit;
	}

	
	if(isset($_POST['search']) && $_POST['search'] =='Search' && isset($_POST['date1']) && $_POST['date1'] !='' && isset($_POST['date2']) && $_POST['date2'] !='')
	{
		

		 $order_date_from = $_POST['date1'];
		 $order_date_to= $_POST['date2'];

		 $order_date_val = explode("-",$order_date_from);
		$day			= $order_date_val[0];
		$month		= $order_date_val[1];
		$year			= $order_date_val[2];
		$order_date_from = $year.'-'.$month.'-'.$day;


		$order_date_to_val	= explode("-",$order_date_to);
		$day							= $order_date_to_val[0];
		$month						= $order_date_to_val[1];
		$year							= $order_date_to_val[2];
		$order_date_to			= $year.'-'.$month.'-'.$day;

		//$date_range = " date(order_entry_date) >= '$from_date'  and date(order_entry_date) <= '$to_date' and order_status='ORPS' ";
		//$where="mobile_number in (select mobileno from order_master where date(order_entry_date) >= '$order_date_from'  and date(order_entry_date) <= '$order_date_to' and order_status='ORPSC')";
		$where="mobile_number in (select mobileno from order_master where mobileno in('8446448668','9823019243') )";
		$customer_results=$connection->get_data("customer_master","concat(fname, ' ',lname)  as name,email_id,mobile_number",$where,"concat(fname, ' ',lname)");
	}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<!-- Title here -->
		<title>Customer Zaikart</title>
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



		<!-- ckeditor -->
		<script src="ckeditor/ckeditor.js"></script>
		<script src="ckeditor/config.js"></script>
		
		<!-- ckeditor  ends here-->


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
					  <h2 class="pull-left">Users </h2>
				</div> -->
				<!-- Page heading ends -->



				
	<!-- Modal -->
								<a href="0" data-toggle="modal" data-target="#emailModal"  id="trigger_email_model"></a>
								<div id="emailModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog" style="width:700px;">
								  <div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									<h4 class="modal-title">Send Email</h4>
								  </div>
								  <div class="modal-body">
									<form class="form-horizontal" role="form" name="frm_mail" id="frm_mail" method="POST" action="attachment.php" enctype="multipart/form-data">

									<script src="js/nicEdit.js" type="text/javascript"></script>

											<div class="form-group">
											  <label class="col-md-2 control-label">To</label>
											  <div class="col-md-8">
												<input class="form-control" placeholder="Email" type="text" name="email" id="email" readonly>
											  </div>
											</div>
											<div class="form-group">
											  <label class="col-md-2 control-label">Subject</label>
											  <div class="col-md-8">
												<input class="form-control" placeholder="Subject" type="text" name="subject" id="subject"  required="" title="Please enter subject">
											  </div>
											</div>
											<div class="form-group">
											  <label class="col-md-2 control-label">Message</label>
											  <div class="col-md-8">
											<textarea class="form-control" rows="3" cols="40"  placeholder="Message" required="" title="Please enter message" name="message" id="message"></textarea> 
											
												
											  </div>
											</div>    
											
											<div class="form-group">
											  <label class="col-md-2 control-label">Select File</label>
											  <div class="col-md-8"><input type="file" name="uploaded_file"></div>
											</div>

										
											
											
									
											
								
								  </div>
								  	<div class="form-group">
										 <div class="col-md-12"><div id="mail_success" style="color:red;font-weight:bold;display:none"></div></div>
									</div>
								  <div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
									<!-- <button type="button" class="btn btn-primary">Send Mail</button> -->
									<input type="submit" class="btn btn-primary" value="Send Mail" id="btn_sendmail">
								  </div>	</form>
								</div>
								</div>
								</div>



<!-- Matter -->
			<div class="matter">
				<div class="container">
						<form name="customers" id="customers" action="customers.php" method="POST">
							<div class="row">
								<div class="col-md-12">
									<div class="col-md-3">
										<input data-format="dd-MM-yyyy" class="picker" type="text" placeholder="Select order date from" id="picker" name="date1">&nbsp;
									</div>
									<div class="col-md-3">
										<input data-format="dd-MM-yyyy" class="picker" type="text" placeholder="Select order date to" id="picker2"  name="date2" required="">
									</div>
									
									<div class="col-md-3">	<input type="submit" class="btn btn-info"  name="search" value="Search"></div>
								</div>
							</div>
						</form>
						<div class="row">
							<div class="col-md-12">
								<div class="widget wviolet">
									<div class="widget-head">

										<div class="pull-left">
											Customers
											<?php
												if(count($customer_results) > 0)
												{
													echo 'From&nbsp;'.$_POST['date1'].'&nbsp;To&nbsp;'. $_POST['date2'];
												}
											?>
										</div>

										<div class="widget-icons pull-right">
											<a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a> 
											<a href="#" class="wclose"><i class="fa fa-times"></i></a>
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="widget-content">
										<div class="error-log" style="height:300px;">
											<div class="table-responsive">
												<table class="table table-bordered ">
													<thead>
														<tr>
														 <th><div class="checkbox"><label><input type="checkbox" name="customers[]" id="select_all" onClick="checkAll(this)"> Select All</label></div></th>	
														  <th>#</th>
														  <th>Name</th>
														  <th>Email</th>
														  <th>Mobile Number</th>
														</tr>
													</thead>
													<tbody>
														<?php
																/*$where="";
																$results=$connection->get_data("customer_master","concat(fname, ' ',lname)  as name,email_id,mobile_number",$where,"concat(fname, ' ',lname)");*/
																$i=1;
																
																if(count($customer_results) > 0)
																{
																	foreach($customer_results as $usrinfo)
																	{
																		echo '<tr>';
																		echo '<td><input type="checkbox" name="customers[]" id="customers'.$i.'" value="'.$usrinfo['email_id'].'" class="source"></td>';
																		echo '<td>'.$i.'</td>';
																		echo '<td>'.ucfirst($usrinfo['name']).'</td>';
																		echo '<td>'.$usrinfo['email_id'].'</td>';
																		echo '<td>'.ucfirst($usrinfo['mobile_number']).'</td>';
																		echo '</tr>';
																		$i++;
																	}
																}
																
														   ?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div class="widget-foot">
										<!-- <ul class="pagination pull-right">
										  <li><a href="#">Prev</a></li>
										  <li><a href="#">1</a></li>
										  <li><a href="#">2</a></li>
										  <li><a href="#">3</a></li>
										  <li><a href="#">4</a></li>
										  <li><a href="#">Next</a></li>
										</ul> -->
										<div class="clearfix"></div> 
									</div>

									<div class="row">
										<div class="col-md-12">
												<div class="col-md-2"><form action="customers.php"><input type="submit" name="client_data" value="Export Client Data" class="btn btn-info"></form></div>
												<div class="col-md-2"><form action="customers.php"><input type="submit" name="client_data" value="Export Email Data" class="btn btn-info"></form></div>
												<div class="col-md-2"><form><a class="btn btn-info" onClick="send_email();">Send Email</a></form></div>
										</div>
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

		<!-- Date picker -->
		<script src="js/bootstrap-datetimepicker.min.js"></script> 
		<!-- Bootstrap Toggle -->
		<script src="js/bootstrap-switch.min.js"></script> 

		<!-- Respond JS for IE8 -->
		<script src="js/respond.min.js"></script>
		<!-- HTML5 Support for IE -->
		<script src="js/html5shiv.js"></script>
		<!-- Custom JS -->
		<script src="js/custom.js"></script>

		<script>
			/* Bootstrap Switch */
			//$(".make-switch input").bootstrapSwitch();
			
			/* *************************************** */
			
			/* Date picker */

			
		
			$(document).ready(function(){ 
				
				var today = new Date(); 
				$('#picker').datepicker({ 
					dateFormat: 'dd-mm-yy', 
					autoclose: true, 
						startDate: today 
						}); 

				$('#picker2').datepicker({ 
					dateFormat: 'dd-mm-yy', 
					autoclose: true, 
						startDate: today 
						}); 


					});
			
			/* *************************************** */
</script>
<script>
			/* Bootstrap Switch */
			$(".make-switch input").bootstrapSwitch();
			
			/* *************************************** */
			
			/* Date picker */
			$(function() {
				$('#datetimepicker1').datetimepicker({
				  pickTime: false
				});
			});
			$(function() {
				$('#datetimepicker2').datetimepicker({
				  pickDate: false
				});
			});
</script>
<script>
function checkAll(ele) {
     var checkboxes = document.getElementsByTagName('input');
     if (ele.checked) {
         for (var i = 0; i < checkboxes.length; i++) {
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = true;
             }
         }
     } else {
         for (var i = 0; i < checkboxes.length; i++) {
             console.log(i)
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = false;
             }
         }
     }
 }
</script>

<script>
function send_email()
{
	$(document).ready(function() {
	document.getElementById("email").value="";
	document.getElementById('subject').value="";
	document.getElementById('message').value=""; 
	
	
    $(".source:checked").each(function(){
		document.getElementById("email").value+=$(this).val()+';';
	});
	
	

	/*if(checked==false)
		alert("Select atleast one checkbox");*/

	if($('[name="customers[]"]:checked').length > 0)
		$( "#trigger_email_model" ).trigger( "click" );
	else
		{
			alert("please selct atleast one checkbox");
		}

	


   	


	});
}
</script>


<script src="../js/jquery.validate.js"></script>
<script src="../js/additional-methods.js"></script>
<script src="../js/jquery.form.js"></script>
<script src="../js/jquery.blockUI.js"></script>

<script type="text/javascript">
$(document).ready(function () {
	$('#customers').validate({}); // For Validation should be there
});
</script>


<script type="text/javascript">

	$(document).ready(function () {
	
	$('#btn_sendmail').on("click", function(event) {
	$(document).ajaxComplete(function(){
								$.unblockUI();
			});

		$('#frm_mail').validate({}); // For Validation should be there

	var options = { 
        target:        '#mail_success',   // target element(s) to be updated with server response 
      	beforeSubmit:  showRequest,  // pre-submit callback 
        success:       showResponse  // post-submit callback 
    }; 
     // bind form using 'ajaxForm' 
    $('#frm_mail').ajaxForm(options); 
	// pre-submit callback 
	function showRequest(formData, jqForm, options) 
		{ 
			var queryString = $.param(formData); 
			$.blockUI({ 
					message: '<h4 style="width:auto">Please Wait email sending in progress...<br><br> </h4><div id="msg_count"></div>',
					css: { 
				border: 'none', 
				padding: '05px', 
				backgroundColor: '#000', 
				'-webkit-border-radius': '10px', 
				'-moz-border-radius': '10px', 
				opacity: .5, 
				zIndex: 20000,
				color: '#fff' 
				} }); 
			return true; 
		} 
	// post-submit callback 
	function showResponse(responseText, statusText, xhr, $form)  
	{ 
		response = responseText;
		var response_val = response.split("~");
		if(response_val[0] == 'success')
		
		
		try
		{
			if(response_val[0] == 'success')
			{
				if(response_val[1]=="")
					var file_name="";
				else
					var file_name=response_val[1];

				/*********************/
					
			
				/*********************/
				 var emails = document.getElementById('email').value;
				 var emails = emails.substring(0, emails.length - 1);
				 var subject = document.getElementById('subject').value;
				 var message = document.getElementById('message').value; 
				 var emails_val = emails.split(";");
				 var success_mail = 0;
				 var error_mail=0;
				 var error_mails = "";
				 var mail_send="";
				 var email_id=emails_val[0];
				
				// for(var i=0;i<emails_val.length;i++)
				
					var f = (function() {

					
						 for(var i=0;i<emails_val.length;i++)
						{
							
							 if(emails_val[i].length >0)
							{
								 //alert("Email Sendings "+ (i+1) + " of "+ emails_val.length);
								document.getElementById("msg_count").innerHTML= "Sending "+ (i+1) + " of " + emails_val.length;
								
								 
								(function(i){
									var xhr = new XMLHttpRequest();
									var url = "send_mail.php?subject="+subject+"&file_name="+file_name+"&message="+encodeURIComponent(message)+"&email="+emails_val[i];
									xhr.open("GET", url, false);
									xhr.onreadystatechange = function () {
										if (xhr.readyState == 4 && xhr.status == 200) 
										{
											//alert(xhr.responseText);
											//alert(xhr.responseText+" "+emails_val[i]);
											mail_send = xhr.responseText;
											var mail_send_val = mail_send.split("~");
											 if(mail_send_val[0] == 'error')
											{
												alert("Error \n email cannot sent for --> "+emails_val[i]+"\n\nReason: "+mail_send_val[1]);
												error_mail++;
												error_mails = error_mails+";"+emails_val[i];
											}
											else if(mail_send_val[0] == 'success')
											{
											 success_mail++;
											}

										}
									};
									xhr.send();
								})(i);

								
							}
							
							
						}
						//$.unblockUI();
						//alert("Hello World");

					
					})();

			
		


	
					var msg="";
					if(success_mail > 0)
						msg=success_mail+ " mails sent successfully \n" ;

					if(error_mail > 0)
						msg=msg+error_mail+ " mails will not sent \n" ;

					if(error_mails > 0)
						msg=msg+error_mails;

					alert(msg);
					///$.unblockUI();
				


			}
		}
		catch (ex)
		{
			alert(ex);
		}

		
	
		
	}	 

	/*function send_mail(email_id,subject,message,file_name)
		{
			
			if(email_id=="" || subject=="" || message=="")
			{
				alert("All Fields are cumpolsory");
				return false;
			}
			var xmlhttp;
			if (window.XMLHttpRequest)
			{// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			}
			else
			{// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					 alert(xmlhttp.responseText);
					 return xmlhttp.responseText;
				}
			}
			xmlhttp.open("GET", "send_mail.php?subject="+subject+"&file_name="+file_name+"&message="+message+"&email="+email_id,true);
			xmlhttp.send();
		}*/
	});	
});


</script>


<script src="js/nicEdit.js"></script>
<script type="text/javascript">
$(document).ready(function () {

});
</script>


<script type="text/javascript">
var editor = CKEDITOR.replace( 'message');

</script>








</body>	

</html>