<?php
					   $order_id = '10000200';
						
						$file = 'invoice/'.$order_id.'_invoice.pdf';
						
						$file_size = filesize($file);
						$handle = fopen($file, "r");
						$content = fread($handle, $file_size);
						fclose($handle);
						$content = chunk_split(base64_encode($content));
						$uid = md5(uniqid(time()));
						$name = basename($file);
						$body="";

						if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') 
							$protocol = 'https://';
						else
							$protocol = 'http://';

						$img_src=$protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/img/zaikart_logo.png";
						$site_link=$active_link =$protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/";
						$body.='<div  style="background: #fff none repeat scroll 0 0;border: 5px solid #ededed;border-radius: 3px;margin-bottom: 10px;padding: 2px;text-align:center"><h2 style="background-color: #78cfcf;border-top-left-radius: 3px;border-top-right-radius: 3px;color: #fff;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;font-size: 22pxpx;font-weight: 600;margin: -25px -25px 25px;padding: 12px 15px;">Thank you! Your order was placed at</h2><div id="confirm"><h3></h3><p><img src="'.$img_src.'" width="252" height="218"/></p><h3 style="color: #5d5d5d;font-size: 24px;margin-bottom: 10px;margin-top: 20px;font-family: inherit;font-weight: 500;line-height: 1.1;">Order Number: <b style="color: #78CFCF;font-size: 24px;margin-bottom: 10px;margin-top: 20px;font-family: inherit;font-weight: 500;line-height: 1.1;">'.$order_id.'</b></h3><h3 style="color: #5d5d5d;font-size: 24px;margin-bottom: 10px;margin-top: 20px;font-family: inherit;font-weight: 500;line-height: 1.1;">Time requested for : <b style="color: #78CFCF;font-size: 24px;margin-bottom: 10px;margin-top: 20px;font-family: inherit;font-weight: 500;line-height: 1.1;">'.$delivery_day.' - '.$delivery_time.'</b></h3><hr style=" -moz-border-bottom-colors: none;-moz-border-left-colors: none;-moz-border-right-colors: none;-moz-border-top-colors: none;border-color: #eee moz-use-text-color -moz-use-text-color;border-image: none;border-style: solid none none;border-width: 1px 0 0;margin-bottom: 10px;margin-top: 10px;"><h4 align="center">You will receive an SMS with an estimated time for delivery via SMS<br>Sit back, relax and your food will arrive at your door in no time.</h4><h4 align="center">This order will be delivered directly by</h4><h4 align="center"><b>Zaikart</b></h4><h4 align="center"><b>to Plot no 30 , Bajaj Nagar 440013</b></h4><h3 style="color: #78CFCF;font-size: 24px;font-family: inherit;font-weight: 500;line-height: 1.1;"><b>For any changes, please contact the restaurant directly on:</b></h3>	<h3><b>0712 23334444</b></h3><h4 align="center"><i>Please note: if you are paying by credit card, the description on your statement will appear as Zaikart PVT LTD Nagpur.</i></h4></div></div>';
									
						$body .="Warmest Regards,<br>The Team at Zaikart<br><br>";
						$body .='<a href="'.$site_link.'terms.php">Terms of Use</a> | ';
						$body .='<a href="'.$site_link.'aboutus.php">About Us</a> | ';
						$body .='<a href="'.$site_link.'privacy.php">Privacy Policy</a> ';
						$body .="<br> &#169; Zaikart 2016. All rights reserved";

						
									
						
						
						$to= $email_id;
						$to='ashishtupkar@gmail.com';
						$files[0]='invoice/'.$order_id.'_invoice.pdf';
						$from="noreply@zaikart.com";
						$sendermail=$from;
						$subject = "Congratulations...Your order was placed successfully at Zaikart";
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
						$ok = @mail($to, $subject, $message, $headers, $returnpath); 

    unlink($files[0]);


					?>