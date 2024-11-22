<?php
	session_start();
	include ('db_connect.php');
	$orderid = $_GET['orderid'];
    $connection = new createConnection(); //i created a new object
	

	$getMyOrders=$connection->getMyOrder_details($orderid);
	$numItem = count($getMyOrders);
?>
<br>
<div  class="box_style_2"> 
<h2 class="inner">My Orders</h2>

	<div class="table-responsive">
	  <?php

	echo '<table class="table table-striped">';
	echo '	<thead> <tr><th>Item Nmae</th><th>Quantity</th><th>Itrm Price</th><th>Amount</th></tr></thead>';
	for ($i = 0; $i < $numItem; $i++) 
	{
?>
		<tr>
			<td  align="left"><?php echo '<b>'.ucwords($getMyOrders[$i]['item_name']).'</b><br>'.$getMyOrders[$i]['detail_description']; ?></td>
			<td><strong><?php echo $getMyOrders[$i]['Qty'];  ?>&nbsp;</strong></td>
			<td><strong><?php echo $getMyOrders[$i]['SaleRate'];  ?>&nbsp;</strong></td>
			<td><strong><?php echo number_format(($getMyOrders[$i]['SaleRate'] * $getMyOrders[$i]['Qty']), 2, '.', '');?></strong></td>
		</tr>
<?php
	}
?>



	<?php $i = 0;	?>

	
		<tr>
			
			<td colspan="03" align="right"><b>Total </b></td><td ><strong><i class="fa fa-inr"></i> <?php echo $getMyOrders[$i]['order_amt']; ?></strong></td>
		</tr>
		<tr>
			
			<td colspan="03" align="right"><b>Discount (<?php $connection->get_order_settings('order_discount')?> %)</b></td><td ><strong><i class="fa fa-inr"></i> <?php echo $getMyOrders[$i]['order_discount']; ?></strong></td>
		</tr>
	
		<?php
			if($getMyOrders[$i]['extra_charges'] >0)
					{
		?>
		<tr>
			<td colspan="03" align="right"><b style="color:#D50681"><i class="fa fa-inr"></i> <b><?php echo $connection->get_order_settings('minuimum_order_amount') ?> Minimum, Remaining Charges</b> </td><td ><strong><i class="fa fa-inr"></i> <?php echo $getMyOrders[$i]['extra_charges']; ?>
			</strong></td>
		</tr>
		<?php
					
					}
		?>


		

		<?php
			$free_credit_remain=$getMyOrders[0]['free_credit_remain'];
			$free_meal_discount= ($connection->get_order_settings('free_meal_credit_amount'))-$free_credit_remain;

			 if($getMyOrders[0]['free_meal'] =='y')
			 {
		?>
				<tr>
					<td colspan="03" align="right"><b style="color:#D50681"><b>Free Meal Discount</b> </td><td ><strong><i class="fa fa-inr"></i> <?php echo $free_meal_discount; ?>
					</strong></td>
				</tr>
		<?php
			 }
		?>

	<?php
		 if($getMyOrders[0]['delivery_charges']  > 0)
		 {
				$delivery_charges=$getMyOrders[0]['delivery_charges'];
			
				 echo '<tr><td class="total" colspan="03" align="right"><b>Total Amount</b> </td><td ><strong><i class="fa fa-inr"></i>  '.($getMyOrders[0]['order_amt_payable'] - $delivery_charges).'</strong></td></tr>';

				 echo '<tr><td class="total" colspan="03" align="right"><b>Delivery Charges</b> </td><td ><strong><i class="fa fa-inr"></i>  '.($delivery_charges).'</strong></td></tr>';

				  echo '<tr><td class="total" colspan="03" align="right"><b>Grand Total</b> </td><td ><strong><i class="fa fa-inr"></i>  '.$getMyOrders[$i]['order_amt_payable'].'</strong></td></tr>';
		 }
		 else
		 {

		  echo '<tr><td class="total" colspan="03" align="right"><b>Total Amount</b> </td><td ><strong><i class="fa fa-inr"></i>  '.$getMyOrders[$i]['order_amt_payable'].'</strong></td></tr>';
		 }
		 ?>
		
		
	</table>
</div>
</div>
