<?php
session_start();
if(!isset($_SESSION['user_id']))
	header("Location:logout.php");

 include ('../db_connect.php');
	$connection = new createConnection(); //i created a new object
$item_id = $_GET['item_id'];
$where = "item_id='$item_id ' ";
$results=$connection->get_data("menu_items_master","status",$where,null);
foreach($results as $usrinfo)
{
	$status = $usrinfo['status'];
	if($status == 'y')
	{
		$rows = array('status' => 'n');
		$where = " item_id = '$item_id' ";
		$connection->update_data('menu_items_master',$rows,$where);
		
	}
	else if($status == 'n')
	{
		$rows = array('status' => 'y');
		$where = " item_id = '$item_id' ";
		$connection->update_data('menu_items_master',$rows,$where);
		
	}
}
?>