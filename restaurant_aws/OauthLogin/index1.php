<?php
require 'header.php';

$userData='';
if(!empty($userSession))
{
header("Location:home.php");
}

?>
<html>
<title>Index Page</title>
<head>
<style>
b{color:#006699}
img{border:none}
</style>
</head>
<body>
<h2>OAuth Login System</h2>
<a href='facebook_login.php'><img src='images/FacebookLogin.png' /></a>
<br/>
<br/>
<a href='google_login.php'><img src='images/GoogleLogin.png' /></a>
<br/>
<br/>

</body>
</html>

