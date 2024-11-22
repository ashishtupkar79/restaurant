<?php
ob_start("ob_gzhandler");
error_reporting(0);
session_start();
include 'db.php';
include 'OauthLogin.php';
$OauthLogin = new OauthLogin();
$userSession=$_SESSION['userSession'];

?>