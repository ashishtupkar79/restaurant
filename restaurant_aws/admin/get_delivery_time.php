<?php
		
		
		//print_r($_GET);
		if(isset($_GET['my_delivery_date_accept']) && $_GET['my_delivery_date_accept'] !="" && isset($_GET['my_delivery_time_accept']) && $_GET['my_delivery_time_accept'] !="")
		{
			
			$my_delivery_time_accept			= $_GET['my_delivery_time_accept'];

			$time =strtotime($my_delivery_time_accept);
			$round = (15*60);
			$rounded = round($time / $round) * $round;
			$curr_time= date("h.i a", $rounded+0);


		$my_delivery_date = $_GET['my_delivery_date_accept'];
			$my_delivery_date_val = explode("~",$my_delivery_date);
			$delivery_date = $my_delivery_date_val[0];
			$delivery_date_val = $my_delivery_date_val[1];


				$opening_time1=array('12.00 am','12.15 am','12.30 am','12.45 am','01.00 am','01.15 am','01.30 am','01.45 am','02.00 am','---------------','07.00 pm','07.15 pm','07.30 pm','07.45 pm','08.00 pm','08.15 pm','08.30 pm','08.45 pm','09.00 pm','09.15 pm','09.30 pm','09.45 pm','10.00 pm','10.15 pm','10.30 pm','10.45 pm','11.00 pm','11.15 pm','11.30 pm','11.45 pm');
			
			$opening_time2=array('12.00 am','12.15 am','12.30 am','12.45 am','01.00 am','01.15 am','01.30 am','01.45 am','02.00 am','---------------','07.00 pm','07.15 pm','07.30 pm','07.45 pm','08.00 pm','08.15 pm','08.30 pm','08.45 pm','09.00 pm','09.15 pm','09.30 pm','09.45 pm','10.00 pm','10.15 pm','10.30 pm','10.45 pm','11.00 pm','11.15 pm','11.30 pm','11.45 pm');

			
			if($delivery_date == "1")
			{
				$opening_time = $opening_time1;
			}
			else if($delivery_date == "2")
			{
				$opening_time =$opening_time2;
			}
			

			
			
			

			echo '<select class="form-control" id="order_time" name="order_time" required="" title="Please select order delivery time">';
			echo '<option value="" selected>Select Time</option>';

		
			//$curr_time= date("h.i a");

			foreach($opening_time as $value)
			{
				if($value =='---------------')
					echo '<option value="" '.$selected.'>'.$value.'</option>';
				else
				{
					$from_time = strtotime("06:30 pm");
					if($delivery_date == "1" && strtotime(date("h.i a"))>=$from_time)
					{
						if($delivery_date_val==date("d-m-Y"))
						{
							if(strtotime($value)>=strtotime($curr_time) && strtotime($value)>=strtotime(date("h.i a")))
							{
								echo '<option value="'.$value.'" >'.$value.'</option>';
							}
						}
						else
							echo '<option value="'.$value.'" >'.$value.'</option>';
					}
					else
					{
							echo '<option value="'.$value.'" >'.$value.'</option>';
					}
				}
			}
			echo '</select>';

		}
		else
		{
			echo '<select class="form-control" id="order_time" name="order_time" required="" title="Please select order delivery time">';
			echo '<option value="" selected>Select Time</option>';
			
			echo '</select>';
		}

?>
