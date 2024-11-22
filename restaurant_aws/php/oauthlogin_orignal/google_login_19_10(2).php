<?php
error_reporting(1);
include 'header.php';
require_once 'google_lib/apiClient.php';
require_once 'google_lib/contrib/apiOauth2Service.php';


$client = new apiClient();
$client->setApplicationName("Google Account Login");
$client->setApprovalPrompt("auto");
//$client->setApprovalPrompt("force");
$oauth2 = new apiOauth2Service($client);

if (isset($_GET['code'])) {
  $client->authenticate();
  $_SESSION['token'] = $client->getAccessToken();

	if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') 
		$protocol = 'https://';
	else
		$protocol = 'http://';

	$redirect =$protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);

	$redirect=$protocol.$_SERVER['HTTP_HOST']."/";


  //$redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  //header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}



if (isset($_SESSION['token'])) {
 $client->setAccessToken($_SESSION['token']);
}



if (isset($_REQUEST['logout'])) {
  unset($_SESSION['token']);
  unset($_SESSION['google_data']); //Google session data unset
  $client->revokeToken();
}

//print_r($_GET);
//DIE;

if ($client->getAccessToken()) {






  $userData = $oauth2->userinfo->get();
  $result=$OauthLogin->userSignup($userData,'google');
  $login_tag ='google';
  //print_r($userData);



  include 'redirect.php';

  $_SESSION['token'] = $client->getAccessToken();
} else 
{
	 $userData = $oauth2->userinfo->get();
	 print_r($userData);
	 echo 'Hello';
	 die;
	 $authUrl = $client->createAuthUrl();
	 //$authUrl.='&login_hint=aa@bb.com'; 
	//$authUrl.='&max_auth_age=0'; 
	//$authUrl.='&max_age=0'; 
	//$authUrl.='&include_granted_scopes=true'; 
}
?>

<?php if(isset($personMarkup)): ?>
<?php print $personMarkup ?>
<?php endif ?>
<?php

//print_r($_GET);
//ECHO '<BR>'.$authUrl;
//DIE;


  if(isset($authUrl)) {
header("Location:$authUrl");
  }
 
?>
