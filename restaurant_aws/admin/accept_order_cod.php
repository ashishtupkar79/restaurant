<?php
	session_start();
	if(!isset($_SESSION['user_id']))
		header("Location:logout.php");

	include ('../db_connect.php');
	$connection = new createConnection(); //i created a new object
	$order_id				=trim($_POST['order_id']);

	$order_time		=trim($_POST['order_time']);
	/*$order_time		= date("H:i", strtotime($order_time));*/

	$email_id				=$_POST['email_id'];
	$delivery_day		=$_POST['delivery_day'];
	$delivery_time	=$_POST['delivery_time'];
	

	/*$order_date_val	=explode("~",$_POST['order_date']);
	$order_date = $order_date_val[1];*/
	//$order_date		= date("Y-m-d", strtotime($order_date));

	$ofname	=$_POST['ofname'];
	$olname	=$_POST['olname'];

	$delivery_address1	=$_POST['delivery_address1'];
	$delivery_address2	=$_POST['delivery_address2'];
	$delivery_address3	=$_POST['delivery_address3'];
	$pincode	=$_POST['pincode'];


	$mobile_code			=$_POST['mobile_no'];

	//$order_accept_date_time  = date('Y-m-d H:i',strtotime('+ '.$order_time.' minutes',strtotime($_POST['delivery_time'])));
	//$order_accept_date_time  = date('Y-m-d H:i',strtotime('+ '.$order_time.' minutes',strtotime($order_date." ".$_POST['delivery_time'])));

	$order_accept_date_time  = date('Y-m-d H:i',strtotime('+ '.$order_time.' minutes',strtotime($delivery_day." ".$_POST['delivery_time'])));

	if(strlen($order_id) > 0  && strlen($order_time) > 0)
	{
		$get_date = $connection->get_date();
		//$order_accept_date_time = $order_date." ".$order_time;
		
		$rows = array('order_accept_reject_date'=>$get_date, 'order_status' => 'ORPSA','operator_id'=>$_SESSION['user_id'],'order_delivery_date'=>$order_accept_date_time);
		$where = " orderid = '$order_id' and order_status='ORPS' ";
		$connection->update_data('order_master',$rows,$where);
		if($connection)
		{
			
			require '../pdf.php';
			
			$file = '../invoice/'.$order_id.'_invoice.pdf';
			$file_size = filesize($file);
			$handle = fopen($file, "r");
			$content = fread($handle, $file_size);
			fclose($handle);
			$content = chunk_split(base64_encode($content));
			$uid = md5(uniqid(time()));
			$name = basename($file);

			$exp_date = date('d-m-Y',strtotime($order_accept_date_time));
			$exp_time = date('g:i a',strtotime($order_accept_date_time));
			/* confirmation mail */
			$image = "http://zaikart.com/img/zaikart_logo.png";
			$body="";
			if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') 
					$protocol = 'https://';
				else
					$protocol = 'http://';

			$img_src=$protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/img/zaikart_logo.png";
			$site_link=$active_link =$protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/";
			$body.='<div  style="background: #fff none repeat scroll 0 0;border: 5px solid #ededed;border-radius: 3px;margin-bottom: 10px;padding: 2px;text-align:center"><h2 style="background-color: #78cfcf;border-top-left-radius: 3px;border-top-right-radius: 3px;color: #fff;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;font-size: 22pxpx;font-weight: 600;margin: -25px -25px 25px;padding: 12px 15px;">Thank you! Your order was placed at</h2><div id="confirm"><h3></h3><p><img src="'.$img_src.'" width="252" height="218"/></p><h3 style="color: #5d5d5d;font-size: 24px;margin-bottom: 10px;margin-top: 20px;font-family: inherit;font-weight: 500;line-height: 1.1;">Order Number: <b style="color: #78CFCF;font-size: 24px;margin-bottom: 10px;margin-top: 20px;font-family: inherit;font-weight: 500;line-height: 1.1;">'.$order_id.'</b></h3><h3 style="color: #5d5d5d;font-size: 24px;margin-bottom: 10px;margin-top: 20px;font-family: inherit;font-weight: 500;line-height: 1.1;">Time requested for : <b style="color: #78CFCF;font-size: 24px;margin-bottom: 10px;margin-top: 20px;font-family: inherit;font-weight: 500;line-height: 1.1;">'.$delivery_day.' - '.$delivery_time.'</b></h3><h3 style="color: #5d5d5d;font-size: 24px;margin-bottom: 10px;margin-top: 20px;font-family: inherit;font-weight: 500;line-height: 1.1;">Order Scheduled Time : <b style="color: #78CFCF;font-size: 24px;margin-bottom: 10px;margin-top: 20px;font-family: inherit;font-weight: 500;line-height: 1.1;">'.$exp_date.' - '.$exp_time.'</b></h3><hr style=" -moz-border-bottom-colors: none;-moz-border-left-colors: none;-moz-border-right-colors: none;-moz-border-top-colors: none;border-color: #eee moz-use-text-color -moz-use-text-color;border-image: none;border-style: solid none none;border-width: 1px 0 0;margin-bottom: 10px;margin-top: 10px;"><h4 align="center">This order will be delivered directly by</h4>	<h4 align="center"><b>Zaikart</b></h4><h4 align="center"><b><br>to '.ucwords($ofname.' '.$olname).'<br>'.$delivery_address1.', <br>'.$delivery_address2.', <br>'.$delivery_address3.'<br>Pincode : '.$pincode.'<br></b></h4><h3 style="color: #78CFCF;font-size: 24px;font-family: inherit;font-weight: 500;line-height: 1.1;"><b>For any changes, please contact the restaurant directly on:</b></h3>	<h3><b>+91 7378845457, 0712 6600288</b></h3><h4 align="center"><i>Please note: if you are paying by credit card, the description on your statement will appear as Zaikart PVT LTD Nagpur.</i></h4></div></div>';
					
			$body .="Warmest Regards,<br>The Team at Zaikart<br><br>";
			$body .='<a href="https://www.zaikart.com/terms.php">Terms of Use</a> | ';
			$body .='<a href="https://www.zaikart.com/aboutus.php">About Us</a> | ';
			$body .='<a href="https://www.zaikart.com/privacy.php">Privacy Policy</a> ';
			$body .="<br> &#169; Zaikart 2016. All rights reserved";


			/**/

			$to= $email_id;
			$files[0]='../invoice/'.$order_id.'_invoice.pdf';
						$from="noreply@zaikart.com";
						$sendermail=$from;
						$subject = "Zaikart Order Confirmation";
						$message =$body;
						$headers = "From: $from";
 
						// boundary 
						$semi_rand = md5(time()); 
						$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
 
						// headers for attachment 
						$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
					 
						// multipart boundary 
						$message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"iso-8859-1\"\n" .
						"Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n"; 
					 
						// preparing attachments
						for($i=0;$i<count($files);$i++){
							if(is_file($files[$i])){
								$message .= "--{$mime_boundary}\n";
								$fp =    @fopen($files[$i],"rb");
							$data =    @fread($fp,filesize($files[$i]));
										@fclose($fp);
								$data = chunk_split(base64_encode($data));
								$message .= "Content-Type: application/octet-stream; name=\"".basename($files[$i])."\"\n" . 
								"Content-Description: ".basename($files[$i])."\n" .
								"Content-Disposition: attachment;\n" . " filename=\"".basename($files[$i])."\"; size=".filesize($files[$i]).";\n" . 
								"Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
								}
							}
						$message .= "--{$mime_boundary}--";
						$returnpath = "-f" . $sendermail;
						mail($to, $subject, $message, $headers, $returnpath); 


			/**/
					
			
			
			
			
			
			/* confirmation mail script ends here*/


			/* send sms*/

			$exp_date = date('d-m-Y',strtotime($order_accept_date_time));
			$exp_time = date('g:i a',strtotime($order_accept_date_time));
			$msg="Your order is confirmed. Expected delivery time is $exp_time. If any issues call 7387423888. Thank you for ordering with Zaikart :)";
			$connection->send_sms($mobile_code,$msg);

			/* send sms*/


			echo 'Order accept~success';
		}	
		else
			echo 'Database Connection droped. Please refresh the page~error';
	}
	else
			echo 'Database Connection droped2. Please refresh the page~error';

?>