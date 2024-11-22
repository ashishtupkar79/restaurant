<?php

 /*   $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'
      ? 'https://'
      : 'http://';
echo $currentUrl = $protocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']).'/facebook_login.php';
echo '<br>';
echo $currentUrl = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'].'/facebook_login.php';
echo '<br>';
echo $currentUrl = $protocol . $_SERVER['HTTP_HOST'] . '/facebook_login.php';
echo '<br>';
echo $_SERVER['REQUEST_URI'];
echo '<br>';
echo $protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/";*/

//print_r($_SERVER);
//echo'<br>';

include 'header.php';
require 'facebook_lib/facebook.php';
require 'facebook_lib/config.php';

/*echo $sitepath;
echo'<br>';
echo $facebook->getLoginUrl();*/

	if(isset($_SESSION['xxaass']))
	{
		unset($_SESSION['xxaass']);
	}

$user = $facebook->getUser();



if($user)
{
	$url="www.google.com";
	header("Location: $url"); 
	try {
	//$userData = $facebook->api('/me');
	$userData = $facebook->api('/me?fields=id,name,email');
	//$userData['email']=$userData['id'];
	$userData['email']=$userData['email'];

	} catch (FacebookApiException $e) {
	error_log($e);
	$user = null;
	}

	$result=$OauthLogin->userSignup($userData,'facebook');
	$login_tag ='facebook';
$_SESSION['facebook_logout'] = $facebook->getLogoutUrl();


}
else
{

	if(isset($_SESSION['xxaass']))
	{
		echo 'here';
		die;
	}

	//$loginUrl = $facebook->getLoginUrl(array( 'scope' => $facebook_scope,"redirect_uri" => "https://www.zaikart.com/OauthLogin/facebook_login.php"));
//echo	$loginUrl = $facebook->getLoginUrl(array( 'scope' => $facebook_scope,"redirect_uri" => "localhost:81/php/restaurant/OauthLogin/facebook_login.php"));

//echo $loginUrl ;
//	$loginUrl = $facebook->getLoginUrl(array( 'scope' => $facebook_scope));
	//echo $loginUrl;

	//header("Location:$loginUrl");

	 # There's no active session, let's generate one 
    $url = $facebook->getLoginUrl(array( 
        "response_type"=>"token", //Can also be "code" if you need to
        "scope" => 'email' ,
        //"redirect_uri"=> "https://www.zaikart.com/OauthLogin/facebook_login.php" //Your app callback url
		//"redirect_uri"=> "http://www.zaikart.com/OauthLogin/facebook_login.php" //Your app callback url
		//"redirect_uri"=> "http://www.zaikart.com/OauthLogin/fb_logout.php" //Your app callback url
		"redirect_uri"=> "http://www.zaikart.com/" //Your app callback url
    )); 

	$_SESSION['xxaass']='aaa';

    header("Location: $url"); 
    exit; 

}
exit;
//echo $facebook->getLoginStatusUrl();
//die;

/*echo $loginUrl = $facebook->getLogoutUrl(array( 'scope' => $facebook_scope));
die;
header("Location:$loginUrl");
die;*/

print_r($userData);
//die;
//$result=$OauthLogin->userSignup($userData,'facebook');

//$login_tag="facebook";

if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') 
		$protocol = 'https://';
else
		$protocol = 'http://';

 $sitepath2 = $protocol . $_SERVER['HTTP_HOST'] .dirname($_SERVER['PHP_SELF'])."";

//$login_tag=$_SESSION['login_tag'];

if($login_tag=="facebook")
{
	$sitepath2=$_SESSION['facebook_logout'].'&next='.$sitepath2;
}

echo $sitepath2;

die;




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

$sitepath2;

header("Location:$sitepath2");



?>
<script type="text/javascript">

//   alert("<?php echo  $sitepath2  ?>");
	//window.location.href="https://www.facebook.com/logout.php?next=[YourAppURL]&access_token=[ValidAccessToken]";
	//window.location.href="https://www.facebook.com/logout.php?next=<?php echo  $sitepath2  ?>";
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