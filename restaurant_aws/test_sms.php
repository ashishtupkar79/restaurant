<?php
//function send_sms($mobile_no,$message)
$mobile_no = '8446448668';
$message = 'sms testing. ';

	
		//$authKey = "113439APDuLbbgFm573fde0f";
		$authKey = "113650AbRG1ZrYJ4SS574009fe";
		
		$mobileNumber =$mobile_no;
		$senderId = "zaikrt";
		$message = urlencode($message);
		$route="4";

		$postData = array(
			'authkey' => $authKey,
			'mobiles' => $mobileNumber,
			'message' => $message,
			'sender' => $senderId,
			'route' => $route
		);

		//API URL
		$url="http://api.msg91.com/api/sendhttp.php";

		// init the resource
		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $postData
			//,CURLOPT_FOLLOWLOCATION => true
		));


		//Ignore SSL certificate verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


		//get response
		$output = curl_exec($ch);
		//print_r($output);

		//Print error if any
		if(curl_errno($ch))
		{
			echo 'error:' . curl_error($ch);
		}

		curl_close($ch);

echo $output;
?>