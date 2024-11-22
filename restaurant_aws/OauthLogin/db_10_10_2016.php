<?php

/*$mysql_hostname = "192.9.5.34";
$mysql_user = "root";
$mysql_password = "root";
$mysql_database = "zaikavk3_restaurant";*/

$mysql_hostname = "103.195.185.104";
$mysql_user = "zaikavk3_root";
$mysql_password = "zaikart123";
$mysql_database = "zaikavk3_restaurant";


$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
mysql_select_db($mysql_database, $bd) or die("Could not select database");

if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') 
	$protocol = 'https://';
else
	$protocol = 'http://';


//$base_url=$protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/";
//$sitepath=$protocol.$_SERVER['HTTP_HOST']."/";//

$base_url=$protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/";
$sitepath=$protocol.$_SERVER['HTTP_HOST']."/test/";




//$base_url='http://localhost/schooliz2/OauthLogin/';
//$sitepath='http://localhost/schooliz2/';

?>