<?php
	 if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
	$sid = session_id();
	$total = "";
	$login_tag="";
	$free_meal="";

	$ip =$_SERVER['REMOTE_ADDR'];
	include ('db_connect.php');
	$connection = new createConnection(); //i created a new object
	$cartContent=$connection->getCartContent($sid);
	$numItem     = count($cartContent);
	if($numItem == 0)
	{
	?>
		<script type="text/javascript">
			window.location.href="detail_page.php";
		</script>
	<?php	
	}
	
	for ($i = 0; $i < $numItem; $i++) 
	{
		$price = $cartContent[$i]['item_price'];
		$qty = $cartContent[$i]['ct_qty'];
		$total += $price * $qty;
	}
	
	$extra_charge_amount	= $_POST['extra_charge_amount'];
	if($extra_charge_amount =="")
		$extra_charge_amount=0;

	$free_meal = $_POST['free_meal'];
	$free_credit_remain = $_POST['free_credit_remain'];
	$free_credit_amount = $_POST['free_credit_amount'];

	if($free_meal == 'y' )
		$extra_charge_amount=0;
	
	$total_discount_per=10;
	$discount_total=($total*$total_discount_per)/100;
	$order_total_amount=$total-$discount_total;
	$order_total_amount = $order_total_amount+ $extra_charge_amount;
	
	/*$free_meal = $_POST['free_meal'];
	$free_credit_remain = $_POST['free_credit_remain'];
	$free_credit_amount = $_POST['free_credit_amount'];*/


	if($free_meal == 'y' )
	{
		$free_credit_remain=$free_credit_amount-$order_total_amount;
		if($free_credit_remain<=0)
			$free_credit_remain=0;


		$order_total_amount = $order_total_amount-$free_credit_amount;
		if($order_total_amount<=0)
			$order_total_amount=0;

	}
	else
		$free_credit_remain=0;

	
		if($_POST['delivery_day'] == "" && $_POST['delivery_time'] == "")
		{
			$delivery_day_val =explode("~",$_POST['delivery_day_selected']);
			$delivery_day=$delivery_day_val[1];
			$delivery_time	= $_POST['delivery_time_selected'];
		}
		else
		{
			$delivery_day_val =explode("~",$_POST['delivery_day']);
			$delivery_day=$delivery_day_val[1];
			$delivery_time	=$_POST['delivery_time'];
		}
		
	
		$firstname				= $_POST['firstname_order'];
		$lastname				= $_POST['lastname_order'];
		$mobile					= $_POST['mob_order'];
		$email						= $_POST['email_order'];
		$delivery_address1		= $_POST['delivery_address1'];
		$delivery_address2		= $_POST['delivery_address2'];
		$delivery_address3		= $_POST['delivery_address3'];
		$area				= $_POST['area_order'];
		$pincode			= $_POST['pincode_order'];
		$free_meal = $_POST['free_meal'];
		$provider_email_id = $_POST['provider_email_id'];
		$comments					= $_POST['comments'];

		if(isset($_SESSION['login_tag']) && $_SESSION['login_tag'] !="")
			$login_tag = $_SESSION['login_tag'];
		
		$blank_data=false;
		if(strlen($firstname)<=0 || strlen($lastname)<=0 || strlen($mobile)<=0 || strlen($email)<=0 || strlen($delivery_address1)<=0 || strlen($delivery_address2)<=0 || strlen($delivery_address3)<=0 || strlen($area)<=0 || strlen($pincode)<=0 || strlen($free_meal)<=0 || strlen($delivery_day)<=0 || strlen($delivery_time)<=0  )
			$blank_data=true;
	
	

	if($free_meal == 'n'  && $order_total_amount < 200)
		$blank_data=true;

	if(!$blank_data)
	{
		$firstname = str_replace("'"," ",$firstname);
		$firstname = str_replace("\""," ",$firstname);

		$lastname = str_replace("'"," ",$lastname);
		$lastname = str_replace("\""," ",$lastname);

		$delivery_address1 = str_replace("'"," ",$delivery_address1);
		$delivery_address1 = str_replace("\""," ",$delivery_address1);

		$delivery_address2 = str_replace("'"," ",$delivery_address2);
		$delivery_address2 = str_replace("\""," ",$delivery_address2);

		$delivery_address3 = str_replace("'"," ",$delivery_address3);
		$delivery_address3 = str_replace("\""," ",$delivery_address3);

		$comments = str_replace("'"," ",$comments);
		$comments = str_replace("\""," ",$comments);


		/* Customer Master */


		$where = " mobile_number =".trim($mobile);
		$results=$connection->get_data("customer_master","mobile_number",$where,null);
		$exist = false;
		foreach($results as $usrinfo)
		{
			if(strlen($usrinfo['mobile_number'])>0)
				$exist= true;
		}
		if($exist == false)
		{
			

			if($login_tag == "google")
			{
				$values=array($mobile,$email,$firstname,$lastname,$delivery_address1,$delivery_address2,$delivery_address3,$provider_email_id);
				$insertCustMast = $connection->insert_data("customer_master",$values,"mobile_number,email_id,fname,lname,address1,address2,address3,google_provider_email_id");
			}
			elseif($login_tag == "facebook")
			{
				$values=array($mobile,$email,$firstname,$lastname,$delivery_address1,$delivery_address2,$delivery_address3,$provider_email_id);
				$insertCustMast = $connection->insert_data("customer_master",$values,"mobile_number,email_id,fname,lname,address1,address2,address3,facebook_provider_email_id");
			}
			else
			{
				$values=array($mobile,$email,$firstname,$lastname,$delivery_address1,$delivery_address2,$delivery_address3);
				$insertCustMast = $connection->insert_data("customer_master",$values,"mobile_number,email_id,fname,lname,address1,address2,address3");
			}

		}
		else
		{
			if($login_tag == "google")
			{

				$rows = array('google_provider_email_id'=>$provider_email_id);
				$where = " mobile_number =".trim($mobile)." and (google_provider_email_id is null or google_provider_email_id ='') ";
				$connection->update_data('customer_master',$rows,$where);
			}
			elseif($login_tag == "facebook")
			{
				$rows = array('facebook_provider_email_id'=>$provider_email_id);
				$where = " mobile_number =".trim($mobile)." and (facebook_provider_email_id is null or facebook_provider_email_id='')";
				$connection->update_data('customer_master',$rows,$where);
			}
		}
		/* Customer Master Ends*/

		

		/* Order Master*/

			
			$where="";
			$order_id_constant="";
			$order_id_constant="100";
			$n=5;
			$results_maxOrder=$connection->get_data("order_master","max(orderId) as orderId",$where,null);
			foreach($results_maxOrder as $results_maxOrder_val)
			{
				$max_order_id = $results_maxOrder_val['orderId'];
			}
			$number = $max_order_id+1;
			$order_adding_zeros = str_pad((int) $number,$n,"0",STR_PAD_LEFT);
			
			if($max_order_id =="")
				$order_id = $order_id_constant.$order_adding_zeros;
			else
				$order_id = $order_adding_zeros;
			


			$values=array($order_id,$mobile,$delivery_day,$delivery_time,$delivery_address1,$delivery_address2,$delivery_address3,$comments,$area,$pincode,'ORP',$total,$order_total_amount,$discount_total,$connection->get_date(),$extra_charge_amount,$email,$free_meal,$free_credit_remain,$ip,$login_tag,$provider_email_id,$firstname,$lastname);

			$OrdertMast=$connection->insert_data("order_master",$values,"orderid,mobileno,delivery_day,delivery_time,delivery_address1,delivery_address2,delivery_address3,comments,area,pincode,order_status,order_amt,order_amt_payable,order_discount,order_entry_date,extra_charges,email_id,free_meal,free_credit_remain,ip,provider,provider_email_id,ofname,olname");


			
		/* Order master Ends */

		/* Order Details*/

		if(strlen($order_id)>0 && $OrdertMast) 
		{
			for ($i = 0; $i < $numItem; $i++) 
			{
				$cartContent[$i]['item_price'] = number_format($cartContent[$i]['item_price'], 2, '.', '');
				$values = array($order_id,$cartContent[$i]['pd_id'],$cartContent[$i]['ct_qty'],$cartContent[$i]['item_price']);
				$insertOrdtDet = $connection->insert_data("order_detail",$values,"OrderId,ProductID,Qty,SaleRate");
			}
		}
		/* Order Details Ends*/
	}
	else
	{
		header("Location:cart_order.php");
		exit;
	}


?>
