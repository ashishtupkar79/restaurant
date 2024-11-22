<?php
session_start();
$auth = $_GET['oauth'];
// Finally, destroy the session.
unset($_SESSION['email_id']);
unset($_SESSION['mobile_number']);

unset ($_SESSION['token']);
unset($_SESSION['google_data']);
$_SESSION['userSession']=''; 
unset($_SESSION['userSession']);

unset($_SESSION['login_tag']);


unset($_SESSION['active_chk']);
unset($_SESSION['email_id_chk']);
unset($_SESSION['login_tag_chk']);


if (ini_get("session.use_cookies")) 
{
    $params = session_get_cookie_params();
    /*setcookie(session_name(), '', time() - 42000,
    $params["path"], $params["domain"],
     $params["secure"], $params["httponly"]
    );*/
}



if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') 
		$protocol = 'https://';
	else
		$protocol = 'http://';
	$redirect_uri_path=$protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/google_login.php";

if($auth == 'facebook')
{
	if(isset($_SESSION['facebook_logout']))
	{
		$sitepath2 = $protocol . $_SERVER['HTTP_HOST'] .dirname($_SERVER['PHP_SELF'])."/google_logina.php?oauth=facebook";
		 $sitepath2=$_SESSION['facebook_logout'].'&next='.$sitepath2;
		 unset($_SESSION['facebook_logout']);
		?>
			<script type="text/javascript">	
			
			window.location.href="<?php echo  $sitepath2  ?>";
		</script>
		<?php
		exit;
	}
}



if($auth == 'google')
{
?>
	<script type="text/javascript">
		//window.location.assign("google_login.php");
		window.location.href="https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=<?php echo  $redirect_uri_path ?>";
	</script>
<?php
exit;
}
else
{
	
?>
	<script type="text/javascript">
		window.location.assign("facebook_login.php");
	</script>
<?php
}
?>


