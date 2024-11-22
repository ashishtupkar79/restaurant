<?php
		$img_src = "img/zaikart_logo.png";
		$imgbinary = fread(fopen($img_src, "r"), filesize($img_src));
		$img_str = base64_encode($imgbinary);
		//echo '<img src="data:image/jpg;base64,'.$img_str.'" />';

		if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') 
						$protocol = 'https://';
					else
						$protocol = 'http://';

					$site_link=$active_link =$protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/";
	
					$body.='<div  style="background: #fff none repeat scroll 0 0;border: 5px solid #ededed;border-radius: 3px;margin-bottom: 10px;padding: 2px;text-align:center"><h2 style="background-color: #78cfcf;border-top-left-radius: 3px;border-top-right-radius: 3px;color: #fff;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;font-size: 22pxpx;font-weight: 600;margin: -25px -25px 25px;padding: 12px 15px;">Thank you! Your order was placed at</h2><div id="confirm"><h3></h3>	<p><img src="data:image/jpg;base64,'.$img_str.'" /></p>	<h3 style="color: #5d5d5d;font-size: 24px;margin-bottom: 10px;margin-top: 20px;font-family: inherit;font-weight: 500;line-height: 1.1;">Order Number: <b style="color: #78CFCF;font-size: 24px;margin-bottom: 10px;margin-top: 20px;font-family: inherit;font-weight: 500;line-height: 1.1;">'.$_POST['ORDERID'].'</b></h3><h3 style="color: #333;font-size: 24px;margin-bottom: 10px;margin-top: 20px;font-family: inherit;font-weight: 500;line-height: 1.1;">Time requested for : NOW</h3><hr style=" -moz-border-bottom-colors: none;-moz-border-left-colors: none;-moz-border-right-colors: none;-moz-border-top-colors: none;border-color: #eee moz-use-text-color -moz-use-text-color;border-image: none;border-style: solid none none;border-width: 1px 0 0;margin-bottom: 10px;margin-top: 10px;"><h4 align="center">This order will be delivered directly by</h4>	<h4 align="center"><b>Zaikart</b></h4><h4 align="center"><b>to Plot no 30 , Bajaj Nagar 440013</b></h4><h3 style="color: #78CFCF;font-size: 24px;font-family: inherit;font-weight: 500;line-height: 1.1;"><b>For any changes, please contact the restaurant directly on:</b></h3>	<h3><b>0712 23334444</b></h3><h4 align="center"><i>Please note: if you are paying by credit card, the description on your statement will appear as Zaikart PVT LTD Nagpur.</i></h4></div></div>';
					
					$body .="Warmest Regards,<br>The Team at Zaikart<br><br>";
					$body .='<a href="'.$site_link.'terms.php">Terms of Use</a> | ';
					$body .='<a href="'.$site_link.'aboutus.php">About Us</a> | ';
					$body .='<a href="'.$site_link.'privacy.php">Privacy Policy</a> ';
					$body .="<br> &#169; Zaikart 2016. All rights reserved";
					
					$from="noreply@zaikart.com";
					$mail_password="ew@~Fvz[+5SB";
					$to= $email_id;
					$subject = "Zaikart Order Confirmation";
					$headers = "MIME-Version: 1.0\r\n";
					$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
					$headers  .= "From: $from\r\n"; 
					mail($to,$subject,$body,$headers);
?>
						