<?php
	define('PAYTM_ENVIRONMENT', 'PROD'); // PROD
	define('PAYTM_MERCHANT_KEY', 'BDgIX3NjO1dDP6_w'); //Change this constant's value with Merchant key downloaded from portal
	define('PAYTM_MERCHANT_MID', 'zaikar07799764019618'); //Change this constant's value with MID (Merchant ID) received from Paytm
	define('PAYTM_MERCHANT_WEBSITE', 'zaikartweb'); //Change this constant's value with Website name received from Paytm
	$PAYTM_DOMAIN = "pguat.paytm.com";
	if (PAYTM_ENVIRONMENT == 'PROD') 
		{
			$PAYTM_DOMAIN = 'secure.paytm.in';
		}
	define('PAYTM_REFUND_URL', 'https://'.$PAYTM_DOMAIN.'/oltp/HANDLER_INTERNAL/REFUND');
	define('PAYTM_STATUS_QUERY_URL', 'https://'.$PAYTM_DOMAIN.'/oltp/HANDLER_INTERNAL/TXNSTATUS');
	define('PAYTM_TXN_URL', 'https://'.$PAYTM_DOMAIN.'/oltp-web/processTransaction');

	$apiURL=PAYTM_STATUS_QUERY_URL;
	$requestParamList["MID"] = 'zaikar07799764019618';
	$requestParamList["ORDERID"] = '10000736';
	function callAPI($apiURL, $requestParamList) 
	{
		$jsonResponse = "";
		$responseParamList = array();
		$JsonData =json_encode($requestParamList);
		$postData = 'JsonData='.urlencode($JsonData);
		$ch = curl_init($apiURL);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                         
		'Content-Type: application/json', 
		'Content-Length: ' . strlen($postData))                                                                       
		);  
		$jsonResponse = curl_exec($ch);   
		$responseParamList = json_decode($jsonResponse,true);
		return $responseParamList;
	}

	$response = callAPI(PAYTM_STATUS_QUERY_URL, $requestParamList);
	print_r($response);
?>