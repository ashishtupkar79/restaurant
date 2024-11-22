<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <title>Document</title>
 </head>
 <body>
  <?php
	if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') 
			$protocol = 'https://';
		else
			$protocol = 'http://';
	$redirect_uri_path=$protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/google_login.php";
	$auth = $_GET['oauth'];
	if($auth == 'google')
	{
	?>
		<script type="text/javascript">
			window.location.href="https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=<?php echo  $redirect_uri_path ?>";
		</script>
	<?php
	}
?>
 </body>
</html>


