<?php
//Facebook Application Configuration.

/*$facebook_appid='398773160319439';
$facebook_app_secret='e928c1a7309cff1ef483626bb371f071';*/

//$facebook_appid='161816184159989';
//$facebook_app_secret='437227898b07306c4d63bb3406a73d49'; //naresh

//$facebook_appid='530512577132719';
//$facebook_app_secret='718b4a0b29c2413aecf672c281312e52'; // Ashish

$facebook_appid='839048939534015';
$facebook_app_secret='234e13237ba4eb0b4c99eb261f11d199';

$facebook_scope='email,user_birthday'; // Don't modify this
$facebook = new Facebook(array(
'appId'  => $facebook_appid,
'secret' => $facebook_app_secret,
));
?>
	
