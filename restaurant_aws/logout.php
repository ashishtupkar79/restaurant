<?php
	session_start();
	

if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') 
		$protocol = 'https://';
else
		$protocol = 'http://';

 $sitepath2 = $protocol . $_SERVER['HTTP_HOST'] .dirname($_SERVER['PHP_SELF'])."";

$login_tag=$_SESSION['login_tag'];

if($login_tag=="facebook")
{
	 $sitepath2=$_SESSION['facebook_logout'].'&next='.$sitepath2;
	
}

if (ini_get("session.use_cookies")) 
{
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
    $params["path"], $params["domain"],
     $params["secure"], $params["httponly"]
    );
}
// Finally, destroy the session.
unset($_SESSION['email_id']);
unset($_SESSION['mobile_number']);
session_unset();
session_destroy();


unset ($_SESSION['token']);
unset($_SESSION['google_data']);
$_SESSION['userSession']=''; 
unset($_SESSION['userSession']);

unset($_SESSION['login_tag']);
unset($_SESSION['facebook_logout']);
session_unset();
session_destroy();




if($login_tag == 'google')
{
	unset($_SESSION['login_tag']);

?>
<script type="text/javascript">
	window.location.href="https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=<?php echo  $sitepath2  ?>";
</script>
<?php
}
else if($login_tag == 'facebook')
{

 
?>
<script type="text/javascript">


	window.location.href="<?php echo  $sitepath2  ?>";
</script>
<?php
}
else
{

?>
<script type="text/javascript">
	window.location.href="index.php";
</script>
<?php
}
?>