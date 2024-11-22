<?php
$auth = $_GET['oauth'];
if($auth == 'google')
{
?>
	<script type="text/javascript">
		window.location.assign("google_login.php");
	</script>
<?php
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


