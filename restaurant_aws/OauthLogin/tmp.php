<?php
$url  = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$url .= $_SERVER['SERVER_NAME'];
$url .= htmlspecialchars($_SERVER['REQUEST_URI']);
echo $themeurl = dirname(dirname($url)) ;
echo '<br>';
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') 
				$protocol = 'https://';
			else
				$protocol = 'http://';

//echo $site_link=dirname(dirname($protocol.$_SERVER['SERVER_NAME'].htmlspecialchars($_SERVER['REQUEST_URI'])."/"))."/";

//echo $site_link=dirname(dirname($protocol.$_SERVER['SERVER_NAME'].htmlspecialchars($_SERVER['REQUEST_URI'])))."/";
	echo $protocol.$_SERVER['HTTP_HOST'].dirname(dirname($_SERVER['PHP_SELF']));
echo '<br>';			

		echo 	$img_src=$site_link."images/logo.jpg";
echo '<br>';	
		echo $_SERVER['HTTP_HOST'];echo '<br>';	
		echo $_SERVER['SERVER_NAME'];echo '<br>';	
		echo $_SERVER['REQUEST_URI'];echo '<br>';	
		echo dirname(dirname($_SERVER['PHP_SELF']));
?>