<?php
//echo $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
//echo '***';
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') 
	$protocol= 'https://';
else
		$protocol= 'http://';


/*echo $base_url=$protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/";
echo $sitepath=$protocol.$_SERVER['HTTP_HOST'];*/

echo $base_url=$protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/";
echo '<br>';
echo $sitepath=$protocol.$_SERVER['HTTP_HOST']."/";
echo '<br>';
echo $base_url=$protocol.$_SERVER['HTTP_HOST'].dirname(dirname($_SERVER['PHP_SELF']));
echo '<br>';
echo $sitepath=$protocol.$_SERVER['HTTP_HOST'].dirname(dirname($_SERVER['PHP_SELF']))."/";
echo '<br>';
echo $sitepath=$protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/";
?>