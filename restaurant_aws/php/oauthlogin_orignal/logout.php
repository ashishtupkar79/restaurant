 <?php
error_reporting(0);
ob_start("ob_gzhandler");
session_start();
$_SESSION['userSession']=''; 
if(session_destroy())
{
unset($_SESSION['userSession']);
$index=$base_url.'index.php';
header("Location: $index");
//echo "<script>window.location='index.php'</script>";
}


?>
