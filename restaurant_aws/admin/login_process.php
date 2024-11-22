<?php
session_start();
 require_once ('../db_connect.php');
 $connection = new createConnection(); //i created a new object
// print_r($_POST);

$user_id = $_POST['user_id'];
$password = $_POST['password1'];
//$user_type = $_POST['user_type'];

$type="";
$rec_exists = false;
$where = " user_id = '$user_id' and status='y' ";
$results=$connection->get_data("admin_users","name,user_password,user_type",$where,null);
foreach($results as $usrinfo)
{
	if(strlen(trim($usrinfo['name']))>0)
	$rec_exist= true;
	$password_dec = $connection->dec_data($usrinfo['user_password']);
}
if($rec_exist)
{
	if($password_dec == $password)
	{
		$type="success";
		$_SESSION['user_id'] = $user_id;
		$_SESSION['name'] = $usrinfo['name'];
		$_SESSION['user_type'] = $usrinfo['user_type'];
	}
	else
	{
		$msg='invalid user id or password';
		$type="error";
	}
}
else
{
	$msg='invalid user id or password';
	$type="error";
}

if($type == 'success')
{
	?>
		<script type="text/javascript">
				window.location.assign("orders.php");
		</script>
<?php
}
else
	echo 'error';


 ?>
 