<?php
	session_start();
	unset($_SESSION['active_chk']);
	unset($_SESSION['email_id_chk']);
	unset($_SESSION['login_tag_chk']);

	unset ($_SESSION['token']);
	unset($_SESSION['google_data']);
	$_SESSION['userSession']=''; 
	unset($_SESSION['userSession']);
	//echo 'unset session';
?>