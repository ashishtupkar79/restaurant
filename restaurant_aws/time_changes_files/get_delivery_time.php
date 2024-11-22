<?php
	session_start();
	include ('db_connect.php');
	$connection = new createConnection(); //i created a new object
	
		
		if(isset($_GET['my_delivery_date']) && $_GET['my_delivery_date'] !="")
		{
			if(isset($_GET['my_delivery_time']) && $_GET['my_delivery_time'] !="")
					$my_delivery_time = $_GET['my_delivery_time'];
			else
					$my_delivery_time="";
			

			$time =strtotime(date("h.i a"));
			$round = (15*60);
			$rounded = round($time / $round) * $round;

			
			if(isset($_GET['now']) && $_GET['now'] !="")
					$now = $_GET['now'];
			else
					$now="";
			if($now == 'y')
			{
				
				$my_delivery_time= date("h.i a", $rounded+1800);
				

			}

			$my_delivery_date = $_GET['my_delivery_date'];
			$my_delivery_date_val = explode("~",$my_delivery_date);
			$delivery_date = $my_delivery_date_val[0];

			$time_24 = array('12.00 am','12.15 am','12.30 am','12.45 am','01.00 am','01.15 am','01.30 am','01.45 am','02.00 am','02.15 am','02.30 am','02.45 am','03.00 am','03.15 am','03.30 am','03.45 am','04.00 am','04.15 am','04.30 am','04.45 am','05.00 am','05.15 am','05.30 am','05.45 am','06.00 am','06.15 am','06.30 am','06.45 am','07.00 am','07.15 am','07.30 am','07.45 am','08.00 am','08.15 am','08.30 am','08.45 am','09.00 am','09.15 am'	,'09.30 am','09.45 am','10.00 am','10.15 am','10.30 am','10.45 am','11.00 am','11.15 am','11.30 am','11.45 am','12.00 pm','12.15 pm','12.30 pm'	,'12.45 pm','01.00 pm','01.15 pm','01.30 pm','01.45 pm','02.00 pm','02.15 pm','02.30 pm','02.45 pm'	,'03.00 pm','03.15 pm','03.30 pm','03.45 pm'	,'04.00 pm','04.15 pm','04.30 pm','04.45 pm','05.00 pm','05.15 pm','05.30 pm','05.45 pm','06.00 pm','06.15 pm','06.30 pm','06.45 pm','07.00 pm','07.15 pm','07.30 pm','07.45 pm','08.00 pm','08.15 pm','08.30 pm','08.45 pm','09.00 pm','09.15 pm','09.30 pm','09.45 pm','10.00 pm','10.15 pm','10.30 pm','10.45 pm','11.00 pm','11.15 pm','11.30 pm','11.45 pm');
			
			/*$time_slots[] =  '12.00 am~02.00 am~n';
			$time_slots[] =  '12.00 pm~04.00 pm~y';
			$time_slots[] =  '07.00 pm~11.45 pm~y';*/

			$time_slots=$connection->get_time_slots();
			

			for($i=0;$i<count($time_slots);$i++)
			{

				$timeslots_val = explode('~',$time_slots[$i]);
				$from = $timeslots_val[0];
				$to = $timeslots_val[1];
				$is_cur_day = $timeslots_val[2];

				if($delivery_date == "1" && $now != 'y')
				{
					if($is_cur_day=='n')
						continue;
				}


				for($j=0;$j<count($time_24);$j++)
				{
					if(strtotime($time_24[$j])>=strtotime($from) && strtotime($time_24[$j])<=strtotime($to) )
					{
						$opening_time[]=$time_24[$j];
					}
				}

				if($i<(count($time_slots)-1))
					$opening_time[]='---------------';
			}

//print_r($opening_time);
			
//			die;


			
			/*if($now == 'y')
				$opening_time1=array('12.00 am','12.15 am','12.30 am','12.45 am','01.00 am','01.15 am','01.30 am','01.45 am','02.00 am','---------------','12.00 pm','12.15 pm','12.30 pm','12.45 pm','01.00 pm','01.15 pm','01.30 pm','01.45 pm','02.00 pm','02.15 pm','02.30 pm','02.45 pm','03.00 pm','03.15 pm','03.30 pm','03.45 pm','04.00 pm','---------------','07.00 pm','07.15 pm','07.30 pm','07.45 pm','08.00 pm','08.15 pm','08.30 pm','08.45 pm','09.00 pm','09.15 pm','09.30 pm','09.45 pm','10.00 pm','10.15 pm','10.30 pm','10.45 pm','11.00 pm','11.15 pm','11.30 pm','11.45 pm');
			else
				$opening_time1=array('12.00 pm','12.15 pm','12.30 pm','12.45 pm','01.00 pm','01.15 pm','01.30 pm','01.45 pm','02.00 pm','02.15 pm','02.30 pm','02.45 pm','03.00 pm','03.15 pm','03.30 pm','03.45 pm','04.00 pm','---------------','07.00 pm','07.15 pm','07.30 pm','07.45 pm','08.00 pm','08.15 pm','08.30 pm','08.45 pm','09.00 pm','09.15 pm','09.30 pm','09.45 pm','10.00 pm','10.15 pm','10.30 pm','10.45 pm','11.00 pm','11.15 pm','11.30 pm','11.45 pm');


			
			$opening_time2=array('12.00 am','12.15 am','12.30 am','12.45 am','01.00 am','01.15 am','01.30 am','01.45 am','02.00 am','---------------','12.00 pm','12.15 pm','12.30 pm','12.45 pm','01.00 pm','01.15 pm','01.30 pm','01.45 pm','02.00 pm','02.15 pm','02.30 pm','02.45 pm','03.00 pm','03.15 pm','03.30 pm','03.45 pm','04.00 pm','---------------','07.00 pm','07.15 pm','07.30 pm','07.45 pm','08.00 pm','08.15 pm','08.30 pm','08.45 pm','09.00 pm','09.15 pm','09.30 pm','09.45 pm','10.00 pm','10.15 pm','10.30 pm','10.45 pm','11.00 pm','11.15 pm','11.30 pm','11.45 pm');

				
			$opening_time3=array('12.00 am','12.15 am','12.30 am','12.45 am','01.00 am','01.15 am','01.30 am','01.45 am','02.00 am','---------------','12.00 pm','12.15 pm','12.30 pm','12.45 pm','01.00 pm','01.15 pm','01.30 pm','01.45 pm','02.00 pm','02.15 pm','02.30 pm','02.45 pm','03.00 pm','03.15 pm','03.30 pm','03.45 pm','04.00 pm','---------------','07.00 pm','07.15 pm','07.30 pm','07.45 pm','08.00 pm','08.15 pm','08.30 pm','08.45 pm','09.00 pm','09.15 pm','09.30 pm','09.45 pm','10.00 pm','10.15 pm','10.30 pm','10.45 pm','11.00 pm','11.15 pm','11.30 pm','11.45 pm');

			if($delivery_date == "1")
			{
				$opening_time = $opening_time1;
			}
			else if($delivery_date == "2")
			{
				$opening_time =$opening_time2;
			}
			else if($delivery_date == "3")
			{
				$opening_time = $opening_time3;
			}*/

			echo '<select class="form-control" id="delivery_time1" name="delivery_time" required="" title="Please select delivery time" onChange="set_date()">';
			echo '<option value="" selected>Select Time</option>';
			$curr_time= date("h.i a", $rounded+1800);
			foreach($opening_time as $value)
			{
				if($value =='---------------')
					echo '<option value="" '.$selected.'>'.$value.'</option>';
				else
				{
					if($delivery_date == "1")
					{
						if(strtotime($value)>=strtotime($curr_time))
						{
							if($my_delivery_time == $value)
								echo '<option value="'.$value.'" selected>'.$value.'</option>';
							else
								echo '<option value="'.$value.'" >'.$value.'</option>';
						}

					}
					else
					{

							if($my_delivery_time == $value)
								echo '<option value="'.$value.'" selected>'.$value.'</option>';
							else
								echo '<option value="'.$value.'" >'.$value.'</option>';
					}
				}
			}
			echo '</select>';
		}
		else
		{
			echo '<select class="form-control" id="delivery_time1" name="delivery_time" required="" title="Please select delivery time">';
			echo '<option value="" selected>Select Time</option>';
			echo '</select>';
		}
?>
