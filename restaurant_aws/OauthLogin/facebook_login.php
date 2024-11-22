<?php
include 'header.php';
require 'facebook_lib/facebook.php';
require 'facebook_lib/config.php';
// Connection...
$user = $facebook->getUser();

if ($user)
{
	$logoutUrl = $facebook->getLogoutUrl();
	try 
		{
			//$userData = $facebook->api('/me');
			$userData = $facebook->api('/me?fields=id,name,email');
			//$userData['email']=$userData['id'];
			$userData['email']=$userData['email'];
		}
	catch (FacebookApiException $e) 
		{
			error_log($e);
			$user = null;
		}
	//$_SESSION['facebook']=$_SESSION;
	$result=$OauthLogin->userSignup($userData,'facebook');
	$login_tag ='facebook';
	$_SESSION['facebook_logout'] = $facebook->getLogoutUrl();
	require 'redirect.php';
}
else
{ 
$loginUrl = $facebook->getLoginUrl(array( 'scope' => $facebook_scope));
header("Location:$loginUrl");
}
?>
