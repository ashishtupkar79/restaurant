<?php
 session_start();
?>
<!doctype html>
<html lang="en">
 <head>
  
 </head>
 <body>
<?php
  	
	$mobile_number	= $_GET['mobile_number'];
	$ses_id	= $_GET['ses_id'];

	
	$type="";
	if(isset($_GET['mobile_number']) && $_GET['mobile_number'] != '' && isset($_GET['ses_id']) && $_GET['ses_id'] != '')
	{
		session_unset();
		session_destroy();
		$mobile_number	=$_GET['mobile_number'];
		$ses_id	= $_GET['ses_id'];
		
		require_once ('smtp.php');
		require_once ('db_connect.php');
		$connection = new createConnection(); //i created a new object
		$where = " session_id = '$ses_id' and mobile_number='$mobile_number' ";
	    $results=$connection->get_data("customer_master","mobile_number,email_id,password,session_id,active",$where,null);
		$bool = false;
	   	foreach($results as $usrinfo)
		{
			if($usrinfo['session_id'] ==$ses_id)
				$bool= true;
			
			$password_dec = $connection->dec_data($usrinfo['password']);
		}
 
		
		if ($bool && $usrinfo['active'] =='') 
		{
			$rows = array('active' => 'y', 'active_date' =>$connection->get_date());
			$where = " session_id = '$ses_id' and mobile_number='$mobile_number' and active is null ";
			if($connection->update_data('customer_master',$rows,$where))
			{
				/*$body = "Dear " . $usrinfo['name'] . ",\n\n";
				$body .= "your User verified\n\nuser id : ".$email_id."\n\nlogin password : ". $password_dec;
				//echo $body;
				$smtpClient = new SMTPClient();
				$smtpClient->setServer("smtp.emergedata.in", "587", false);
				$smtpClient->setSender("naresh@emergedata.in", "naresh@emergedata.in","Naresh230777");
				$smtpClient->setMail($email_id,"Login Details",$body);
				$smtpClient->sendMail();*/
				$msg="User Activated Successfully.";
				$type="success";
			}
		}
		else
		{
			if($usrinfo['active'] =='y')
			{
				$msg=$email_id.' Already Activated';
				$type="error";
			}
			else
			{
				$msg=$email_id.' Activation Not Possible.';
				$type="error";
			}
		}
	}
	
?>
<script type="text/javascript">
	var msg = "<?php echo $msg; ?>";
	alert(msg);
	var link="index.php";
	window.location.assign(link);
	</script>
</body>
</html>