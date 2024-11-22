<?php
	
		session_start();
		error_reporting(E_ALL);
		// Same as error_reporting(E_ALL);
		ini_set("error_reporting", E_ALL);
		date_default_timezone_set('Asia/Kolkata');
		$body="";
		if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') 
			$protocol = 'https://';
		else
			$protocol = 'http://';

		$img_src=$protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/img/zaikart_logo.png";
		$site_link=$active_link =$protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/";


/*$body .='<html>';
$body .='<head>';
$body .='<meta http-equiv="content-type" content="text/html; charset=utf-8" />';
$body .='</head>';
$body .='<body>';*/
 

		$body.= ($_GET['message']).'<br><br>';
		$body .="Warmest Regards,<br>The Team at Zaikart<br><br>";
		$body .='<a href="'.$site_link.'terms.php">Terms of Use</a> | ';
		$body .='<a href="'.$site_link.'aboutus.php">About Us</a> | ';
		$body .='<a href="'.$site_link.'privacy.php">Privacy Policy</a> ';
		$body .="<br> &#169; Zaikart 2016. All rights reserved<br><br>";
		$body .='<p><img src="'.$img_src.'" width="252" height="218"/></p>';
		/*$body .='</body>';
$body .='</html>';*/

		$to=$_GET['email'];
		$from="noreply@zaikart.com";
		$sendermail=$from;
		$subject = $_GET['subject'];
		$message =$body;
		



		if(isset($_GET['file_name']) && $_GET['file_name'] !="")
		{
			// boundary 
				$semi_rand = md5(time()); 
				$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
				$headers = "From: $from";
				$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
				$message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"iso-8859-1\"\n" .
					"Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n"; 
					$file_name = $_GET['file_name'] ; 
					$files[0] = 'mail_attachment/'.$file_name;
					if(count($files) > 0)
					{
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
					}
					$message .= "--{$mime_boundary}--";
					$returnpath = "-f" . $sendermail;
					$mail_send = mail($to, $subject, $message, $headers, $returnpath);
		}
		else if($_GET['file_name'] =="")
		{
			//$message='zzz';
			$message=$body;
			
			/*$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: '.$from."\r\n".'Reply-To: '.$from."\r\n" .'X-Mailer: PHP/' . phpversion();*/
			$headers = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$headers  .= "From: $from\r\n"; 
			$mail_send = mail($to,$subject,$message,$headers);
		}
	
	//echo "success~success";

		if($mail_send)
			echo "success~success";
		else
		{
			$err = error_get_last();
			//var_export($err);
			//echo "error~error message-->".$err['message'].' line-->'.$err['line'].$to.'***'.$_GET['email'].'***'.$message;
			echo "error~error message-->".$err['message'];
		}
		
		/*try
		{
			$mail_send = mail($to, $subject, $message, $headers, $returnpath);
			echo "success~success";
		}
		catch(Exception $e) 
		{
			echo 'error~Message: ' .$e->getMessage();
		}*/

	



			//echo "success~success";
?>