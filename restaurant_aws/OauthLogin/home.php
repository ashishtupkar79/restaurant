<?php
include 'header.php';
$userData='';
if(!empty($userSession))
{
$userData=$OauthLogin->userDetails($userSession);
//header("Location:home.php");
}
else
{
header("Location:index.php");
}
?>
<html>
<title>Home Page</title>
<head>
<style>
b{color:#006699}
img{border:none}
</style>
</head>
<body>
	
<h2>Results from Users Table</h2>	
<?php
if(!empty($userData))
{
	echo '<b>Name</b>: '.$userData['name'].'<br/>';
	echo '<b>Email</b>: '.$userData['email'].'<br/>';
	echo '<b>First Name</b>: '.$userData['first_name'].'<br/>';
	echo '<b>Last Name</b>: '.$userData['last_name'].'<br/>';
	echo '<b>Gender</b>: '.$userData['gender'].'<br/>';
	echo '<b>Birthday</b>: '.$userData['birthday'].'<br/>';
	echo '<b>Location</b>: '.$userData['location'].'<br/>';
	echo '<b>Hometown</b>: '.$userData['hometown'].'<br/>';
	echo '<b>Bio</b>: '.$userData['bio'].'<br/>';
	echo '<b>Relationship</b>: '.$userData['relationship'].'<br/>';
	echo '<b>Timezone</b>: '.$userData['timezone'].'<br/>';
	echo '<b>Date Provider</b>: '.$userData['provider'].'<br/>';
    echo '<b>Image Path</b>: '.$userData['picture'].'<br/>';
	
}
?>
<a href='logout.php' style='color:#cc0000'>Logout</a>
</body>
</html>

