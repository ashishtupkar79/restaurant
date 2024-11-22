<?php
if($result)
{
	
	$sql="";
	$email= $userData['email'];
	if($login_tag == 'facebook')
		{
			$sql = "SELECT active,mobile_number FROM customer_master WHERE facebook_provider_email_id = '$email' ";
		}
	if($login_tag == 'google')
		{
			$sql = "SELECT active,mobile_number FROM customer_master WHERE google_provider_email_id = '$email' ";
		}
	$cust_master = mysql_query($sql);
	if(mysql_num_rows($cust_master) > 0)
		{
			$row = mysql_fetch_array($cust_master );
			if($row['active']=='y')
			{
				$_SESSION['userSession']=$result;
				//$home=$base_url.'home.php';
				$_SESSION['email_id'] = $userData['email'];
				$_SESSION['mobile_number'] = $userData['mobile_number'];
				$_SESSION['name'] = $userData['name'];
				$_SESSION['login_tag'] =$login_tag;
				$_SESSION['login_verified'] = 'y';
			}
			else
			{
				$_SESSION['active_chk']='n';
				$_SESSION['email_id_chk'] = $userData['email'];
				$_SESSION['login_tag_chk'] =$login_tag;
			}
		}
		else
		{
			$_SESSION['active_chk']='n';
			$_SESSION['email_id_chk'] = $userData['email'];
			$_SESSION['login_tag_chk'] =$login_tag;
		}


}

if(isset($_SESSION['link']))
{
	$home=$sitepath.$_SESSION['link'];
}
else
{
	$home=$sitepath."index.php";
}
echo "<script>window.location.href='".$home."'</script>";
//header("Location:$home");

?>