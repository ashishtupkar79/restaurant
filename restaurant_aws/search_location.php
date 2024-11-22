<?php
	session_start();
	include ('db_connect.php');
    $connection = new createConnection(); //i created a new object

	

	$location_search = trim($_POST['autocomplete2']);
	$location_search_split = explode(",",$location_search);
	$location_search=$location_search_split[0];
	if(trim($location_search) !="")
	{
		$cols="location,pincode";
		$where=" location = '$location_search'  ";
		$results=$connection->get_data("location_master",$cols,$where,null);
		if(count($results) > 0)
		{
			foreach($results as $addressinfo)
			{
				$location=$addressinfo['location'];
				$pincode=$addressinfo['pincode'];
			}
			$link ="detail_page.php?delivery_address=".$pincode.'~'.$location;
			//header("Location:$link");
			?>
				<script type="text/javascript">
					window.location.href="<?php echo $link ?>";
				</script>
			<?php
		}
		else
		{
			echo 'error~<h4>Sorry We do not deliver to '.$location_search.' area</h4>';
			exit;
		}
	}
?>