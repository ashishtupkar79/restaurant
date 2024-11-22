<?php
date_default_timezone_set('Asia/Kolkata');
class createConnection //create a class for make connection
{
	var $hashkey="resTaurant@zaikart.com";

	var $host="192.9.5.34";
	var $username="root";    // specify the sever details for mysql
	Var $password="root";
	var $database="zaikavk3_restaurant";

	/*var $host="103.195.185.104";
	var $username="zaikavk3_root";    
	Var $password="zaikart123";
	var $database="zaikavk3_restaurant";*/

	function logEvent($message) 
	{
		if ($message != '') 
		{
			// Add a timestamp to the start of the $message
			$message = date("Y/m/d H:i:s").'~ '.$message;
			$fp = fopen('log.txt', 'a');
			fwrite($fp, $message."\n");
			fclose($fp);
		}
	}

	
    function connectToDatabase() // create a function for connect database
    {
        $conn= mysql_connect($this->host,$this->username,$this->password);
        if(!$conn)// testing the connection
        {
            die ("Cannot connect to the database");
        }
        else
        {
            $this->myconn = $conn;
            //echo "Connection established";
			mysql_select_db($this->database);
        }
        return $this->myconn;
    }

    function selectDatabase() // selecting the database.
    {
        mysql_select_db($this->database);  //use php inbuild functions for select database

        if(mysql_error()) // if error occured display the error message
        {
            echo "Cannot find the database ".$this->database;
        }
         echo "Database selected..";       
    }

    function closeConnection() // close the connection
    {
        mysql_close($this->myconn);
        //echo "Connection closed";
    }

	private function tableExists($table)
    {
      
		$tables = strpos($table, ',');
		if ($tables !== false)
		{
			$tables_val = explode(",",$table);
			foreach($tables_val as $key=> $value)
			{
				$table_alias=$value;
				$new_table = explode(" ",$table_alias);
				$tablesInDb = @mysql_query('SHOW TABLES FROM '.$this->database.' LIKE "'.trim($new_table[0]).'"');
				if($tablesInDb)
				{
					if(mysql_num_rows($tablesInDb)==1)
					{
						return true; 
					}
					else
					{ 
						return false; 
					}
				}
			}
		}
		else
		{
				
				$tablesInDb = @mysql_query('SHOW TABLES FROM '.$this->database.' LIKE "'.$table.'"');
				if($tablesInDb)
				{
					if(mysql_num_rows($tablesInDb)==1)
					{
						return true; 
					}
					else
					{ 
						return false; 
					}
				}
		 }
	}

	function get_data($table, $cols = '*', $where = null, $order = null)
	{
		$conn=$this->connectToDatabase();
		$rows = array();
		$sql = 'SELECT '.$cols.' FROM '.$table;
        if($where != null)
            $sql .= ' WHERE '.$where;
        if($order != null)
            $sql .= ' ORDER BY '.$order;

		//echo '<br>'.$sql.'<br>';

		if($this->tableExists($table))
		{
			$sql_res=mysql_query($sql);

			while($row=mysql_fetch_array($sql_res))
				$rows[] = $row;

			//while ($row_user = mysql_fetch_assoc($sql))
			//$userinfo[] = $row_user;

		}
		$this->closeConnection();
		return $rows;
	}



	function insert_data($table,$values,$rows = null)
    {
		$conn=$this->connectToDatabase();
        if($this->tableExists($table))
        {
            $insert = 'INSERT INTO '.$table;
            if($rows != null)
            {
                $insert .= ' ('.$rows.')'; 
            }
            for($i = 0; $i < count($values); $i++)
            {
                if(is_string($values[$i]) || $values[$i] == null)
				{
					if($values[$i] !='NOW()')
						$values[$i] = "'".$values[$i]."'";
				}
				
				
            }
            $values = implode(',',$values);
            $insert .= ' VALUES ('.$values.')';
			//echo $insert;
            $ins = @mysql_query($insert);  
			//echo $ins;
            if($ins)
            {
                return true; 
            }
            else
            {
                return false; 
            }
        }
		$this->closeConnection();
    }


	public function update_data($table,$rows,$where)
    {
		$conn=$this->connectToDatabase();
        if($this->tableExists($table))
        {
			
            $update = 'UPDATE '.$table.' SET ';

            $keys = array_keys($rows); 
            for($i = 0; $i < count($rows); $i++)
           {
                if(is_string($rows[$keys[$i]]))
                {
					//if($rows[$keys[$i]]=='NOW()' || $rows[$keys[$i]]==' DATE_ADD(NOW(), INTERVAL 5 MINUTE)')
					//strpos($rows[$keys[$i]], 'DATE_ADD(')
					if($rows[$keys[$i]]=='NOW()' || strpos($rows[$keys[$i]], 'DATE_ADD(') !== false)
	                    $update .= $keys[$i].'='.$rows[$keys[$i]];
					else
						$update .= $keys[$i]."='".$rows[$keys[$i]]."'";
                }
                else
                {
                    $update .= $keys[$i].'='.$rows[$keys[$i]];
                }
                 
                // Parse to add commas
                if($i != count($rows)-1)
                {
                    $update .= ','; 
                }
            }
            $update .= ' WHERE '.$where;
			//echo $update;

            $query = @mysql_query($update);
            if($query)
            {
                return true; 
            }
            else
            {
                return false; 
            }
        }
        else
        {
            return false; 
        }
		$this->closeConnection();
    }


	function getCartContent($sid)
		{
			$conn=$this->connectToDatabase();
			$cartContent = array();
			$sql = "SELECT ct_id, ct.pd_id, ct_qty, m.item_name, d.detail_description, d.item_price  FROM cart ct, menu_items_master m , menu_items_master_details d	WHERE ct_session_id = '$sid' AND ct.pd_id = d.detail_id AND d.item_id = m.item_id";
			$result = mysql_query($sql);
			while ($row =mysql_fetch_array($result)) 
			{		
				$cartContent[] = $row;
			}
			$this->closeConnection();
			return $cartContent;
	  }



		function getMyOrder_exist($OrderId)
		{
			$conn=$this->connectToDatabase();
			$cartContent = array();
			$sql = "select om.order_amt,om.order_discount,om.order_amt_payable,om.extra_charges,od.ProductID,od.Qty,od.SaleRate,mnu_mast.item_name,
						mnu_dt.detail_description 	
						from order_master om,order_detail od,menu_items_master_details mnu_dt,menu_items_master mnu_mast
						where
						om.orderid = od.orderid and om.orderid = '$OrderId'  
						and od.ProductID =mnu_dt.detail_id
						and mnu_dt.item_id =mnu_mast.item_id";
			$result = mysql_query($sql);
			while ($row =mysql_fetch_array($result)) 
			{		
				$myOrderContent[] = $row;
			}
			$this->closeConnection();
			return $myOrderContent;
	  }


	  function getMyOrders($OrderId)
		{
			$conn=$this->connectToDatabase();
			$cartContent = array();
			$sql = "select om.order_amt,om.order_discount,om.order_amt_payable,om.extra_charges,od.ProductID,od.Qty,od.SaleRate,mnu_mast.item_name,
						mnu_dt.detail_description 	
						from order_master om,order_detail od,menu_items_master_details mnu_dt,menu_items_master mnu_mast
						where
						om.orderid = od.orderid and om.orderid = '$OrderId' and om.order_status='ORPOTV' 
						and od.ProductID =mnu_dt.detail_id
						and mnu_dt.item_id =mnu_mast.item_id";
			$result = mysql_query($sql);
			while ($row =mysql_fetch_array($result)) 
			{		
				$myOrderContent[] = $row;
			}
			$this->closeConnection();
			return $myOrderContent;
	  }


	   function getMyOrder_details($OrderId)
		{
			$conn=$this->connectToDatabase();
			$cartContent = array();
			$sql = "select om.order_amt,om.order_discount,om.order_amt_payable,om.extra_charges,od.ProductID,od.Qty,od.SaleRate,mnu_mast.item_name,
						mnu_dt.detail_description,om.free_meal,om.free_credit_remain 	
						from order_master om,order_detail od,menu_items_master_details mnu_dt,menu_items_master mnu_mast
						where
						om.orderid = od.orderid and om.orderid = '$OrderId' and om.order_status='ORPSC' 
						and od.ProductID =mnu_dt.detail_id
						and mnu_dt.item_id =mnu_mast.item_id";
			$result = mysql_query($sql);
			while ($row =mysql_fetch_array($result)) 
			{		
				$myOrderContent[] = $row;
			}
			$this->closeConnection();
			return $myOrderContent;
	  }



	  function getMyOrders2($OrderId)
		{
			$conn=$this->connectToDatabase();
			$cartContent = array();
			$sql = "select om.order_amt,om.order_discount,om.order_amt_payable,om.extra_charges,od.ProductID,od.Qty,od.SaleRate,mnu_mast.item_name,
						mnu_dt.detail_description 	
						from order_master om,order_detail od,menu_items_master_details mnu_dt,menu_items_master mnu_mast
						where
						om.orderid = od.orderid and om.orderid = '$OrderId' and om.order_status='ORP' 
						and od.ProductID =mnu_dt.detail_id
						and mnu_dt.item_id =mnu_mast.item_id";
			$result = mysql_query($sql);
			while ($row =mysql_fetch_array($result)) 
			{		
				$myOrderContent[] = $row;
			}
			$this->closeConnection();
			return $myOrderContent;
	  }


	   function getMyOrders3($OrderId)
		{
			$conn=$this->connectToDatabase();
			$cartContent = array();
			$sql = "select om.order_amt,om.order_discount,om.order_amt_payable,om.extra_charges,od.ProductID,od.Qty,od.SaleRate,mnu_mast.item_name,
						mnu_dt.detail_description 	
						from order_master om,order_detail od,menu_items_master_details mnu_dt,menu_items_master mnu_mast
						where
						om.orderid = od.orderid and om.orderid = '$OrderId' and om.order_status='ORPOPG' 
						and od.ProductID =mnu_dt.detail_id
						and mnu_dt.item_id =mnu_mast.item_id";
			$result = mysql_query($sql);
			while ($row =mysql_fetch_array($result)) 
			{		
				$myOrderContent[] = $row;
			}
			$this->closeConnection();
			return $myOrderContent;
	  }


	   function ReOrder($orderid)
		{
			$conn=$this->connectToDatabase();
			$ReOrderContent = array();
			$sql = "select ord_dt.orderid,ord_dt.productid,ord_dt.qty, mnu_itm_dt.qty_in_hand,mnu_itm_dt.item_price ,mnu_itm_dt.status
							from order_detail ord_dt, menu_items_master_details mnu_itm_dt
							where
							orderid ='$orderid' and ord_dt.productid=mnu_itm_dt.detail_id";
			$result = mysql_query($sql);
			while ($row =mysql_fetch_array($result)) 
			{		
				$ReOrderContent[] = $row;
			}
			$this->closeConnection();
			return $ReOrderContent;
	  }
	
	
	  function get_menu_list()
		{
			$conn=$this->connectToDatabase();
			$rows = array();
			$sql = "SELECT category_id,category_name from menu_category_master where   status='y' order by display_position";

			$sql_res=mysql_query($sql);

			while($row=mysql_fetch_array($sql_res))
				$rows[] = $row;

			$lines=array();


			foreach($rows as $usrinfo)
			{
				$category_id=$usrinfo['category_id'];
				$category_name=$usrinfo['category_name'];
				$line=$category_name.'~';
				
				$sql = "SELECT item_id, sub_category_code,item_name,item_description,item_image,status from menu_items_master where   category_id=".$category_id."  order by sub_category_code,item_id";
				$sql_res=mysql_query($sql);

				unset($menu_items);
				while($menu_item=mysql_fetch_array($sql_res))
				$menu_items[] = $menu_item;

				$old_sub_category_code='';
				foreach($menu_items as $usrinfo2)
				{
					$item_id=$usrinfo2['item_id'];
					$sub_category_code=$usrinfo2['sub_category_code'];
					$item_name=$usrinfo2['item_name'];
					$item_description=$usrinfo2['item_description'];
					$item_image =$usrinfo2['item_image'];
					$item_status =$usrinfo2['status'];


					$sql = "SELECT detail_id,detail_description,format(item_price,2) as item_price,qty_in_hand,max_order_qty from menu_items_master_details where status='y' and item_id=".$item_id."  order by detail_id";
					$sql_res=mysql_query($sql);

					unset($menu_item_details);
					while($menu_item_detail=mysql_fetch_array($sql_res))
					$menu_item_details[] = $menu_item_detail;
				
					$menu_item_details_line='';
					foreach($menu_item_details as $usrinfo3)
					{
							$detail_id=$usrinfo3['detail_id'];
							$detail_description=$usrinfo3['detail_description'];
							$item_price=$usrinfo3['item_price'];
							$qty_in_hand=$usrinfo3['qty_in_hand'];
							$max_order_qty=$usrinfo3['max_order_qty'];
							$menu_item_details_line.=$detail_id.'@'.$detail_description.'@'.$item_price.'@'.$qty_in_hand.'@'.$max_order_qty.'#';
					}
					if(strlen($menu_item_details_line) <=0)
						continue;
					
					$menu_item_details_line.='$';

					if(strlen($menu_item_details_line)>0)
					{
						//$menu_item_details_line=substr($menu_item_details_line,0,strlen($menu_item_details_line)-1);


						
					}



					if($old_sub_category_code=='')
					{
						$old_sub_category_code=$sub_category_code;
						$line.=$sub_category_code.'|';
					}

					if($old_sub_category_code!=$sub_category_code)
					{

							$line.='^';
							//$lines[]=($line);
							$line.=$sub_category_code.'|';
							$line.=$item_name.'!'.$item_description.'!'.$item_image.'!'.$item_status.'!'.$menu_item_details_line;
							$old_sub_category_code=$sub_category_code;
							$menu_item_details_line='';
					}
					else
					{
						
						$line.=$item_name.'!'.$item_description.'!'.$item_image.'!'.$item_status.'!'.$menu_item_details_line;
					}
				}
				$lines[]=($line);
					
			}


			$this->closeConnection();
			return $lines;
	}

	 function getOpOrders()
		{
			$conn=$this->connectToDatabase();
			$cartContent = array();


		 date_default_timezone_set('Asia/Kolkata');
		$date1=date('Y-m-d');
		$date2 = date('Y-m-d',strtotime( "-1 days"));
		//$date3 = date('Y-m-d',strtotime( "-2 days"));

			$date=" and date(order_verify_date) in('".$date1."','".$date2."','".$date3."') ";


			$sql = "select om.orderid,om.mobileno, om.email_id,om.payment_type,om.order_amt_payable,om.order_verify_date,concat(cm.fname, ' ',cm.lname)  as name , om.order_status,om.delivery_day,om.delivery_time,om.order_delivery_date,om.free_meal
			from order_master om,customer_master cm 		
			where	(om.order_status='ORPS' or om.order_status='ORPSA' or om.order_status='ORPSR' or om.order_status='ORPSC')  and  om.mobileno=cm.mobile_number $date  order by order_verify_date desc ";
			$result = mysql_query($sql);
			while ($row =mysql_fetch_array($result)) 
			{		
				$OpOrders[] = $row;
			}
			$this->closeConnection();
			return $OpOrders;
	  }

	  function getOpOrder_detail($order_id)
		{
			$conn=$this->connectToDatabase();
			$cartContent = array();
			$sql = "SELECT  om.paytm_respmsg,om.comments,om.ofname,om.olname,om.free_meal,om.free_credit_remain,om.delivery_day,om.delivery_time,om.mobileno,om.email_id,om.delivery_day,om.delivery_time,om.area,om.pincode,om.order_amt,om.order_discount
						,om.order_amt_payable,om.extra_charges,om.payment_type,om.order_entry_date,om.order_verify_date,om.order_accept_reject_date,om.order_delivery_date,om.order_complete_date,om.order_cancel_reason,om.reject_to_accept,om.reject_to_accept_date
						,om.paytm_txnid,om.paytm_banktxnid,om.paytm_txndate,om.paytm_bankname,om.paytm_paymentmode,om.paytm_status
						,om.delivery_address1,om.delivery_address2,om.delivery_address3,om.order_status,om.order_cancel_reason,ord_dt.SaleRate,ord_dt.Qty, m.item_name, d.detail_description
						FROM order_master om, order_detail ord_dt , menu_items_master m , menu_items_master_details d
						WHERE  ord_dt.ProductID = d.detail_id AND d.item_id = m.item_id AND ord_dt.orderid=om.orderid AND ord_dt.orderid='$order_id' ";

			$result = mysql_query($sql);
			while ($row =mysql_fetch_array($result)) 
			{		
				$OpOrder_deatail[] = $row;
			}
			$this->closeConnection();
			return $OpOrder_deatail;
	  }



	   function getAllOrders($from_date)
		{
			$conn=$this->connectToDatabase();
			$cartContent = array();
			$default_limit="";

			$default_limit = 'limit 50';
			$order_by ='order by order_entry_date desc,orderid desc';
			
			

			$sql = "select om.orderid,om.mobileno, om.email_id,om.payment_type,om.order_amt_payable,om.order_verify_date,concat(cm.fname, ' ',cm.lname)  as name , om.order_status,om.order_entry_date,om.free_meal 	from order_master om,customer_master cm  where om.mobileno=cm.mobile_number $date_from  $order_by $default_limit ";

			$result = mysql_query($sql);
			while ($row =mysql_fetch_array($result)) 
			{		
				$OpOrders[] = $row;
			}
			$this->closeConnection();
			return $OpOrders;
	  }

	   function getAll_history_Orders($from_date,$to_date,$name)
		{
			$conn=$this->connectToDatabase();
			$cartContent = array();
			$default_limit = 'limit 50';
			if($from_date == $to_date)
				$date_from = " and date(order_entry_date) = '$from_date'  ";
			else
				$date_from = " and date(order_entry_date) >= '$from_date'  and date(order_entry_date) <= '$to_date'";

			if(strlen($name) > 0)
				$where = ' and concat(cm.fname, cm.lname) like'."'%".$name."%' ";

			$order_by ='order by order_entry_date desc,orderid desc';
			
			$sql = "select om.orderid,om.mobileno, om.email_id,om.payment_type,om.order_amt_payable,om.order_verify_date,concat(cm.fname, ' ',cm.lname)  as name , om.order_status,om.order_entry_date, om.free_meal 	from order_master om,customer_master cm  where om.mobileno=cm.mobile_number $date_from $where  $order_by $default_limit ";

			$result = mysql_query($sql);
			while ($row =mysql_fetch_array($result)) 
			{		
				$OpOrders[] = $row;
			}
			$this->closeConnection();
			return $OpOrders;
	  }
		
		function getTenthOrderNumber($mobile_number)
		{
			$conn=$this->connectToDatabase();
			$Order_Number = array();
			$sql = "select count(distinct orderid) +1 as orderid  from order_master om,customer_master cm where om.mobileno = cm.mobile_number  and
						order_status = 'ORPSC' and om.mobileno ='$mobile_number'  ";
			$result = mysql_query($sql);
			while ($row =mysql_fetch_array($result)) 
			{		
				$Order_Number[] = $row;
			}
			
			$this->closeConnection();

			
			return $Order_Number;

		}
		function getItems()
				{
					$conn=$this->connectToDatabase();
					$cartContent = array();
					$sql = "select item_name,status,item_id from menu_items_master ";
					$result = mysql_query($sql);
					while ($row =mysql_fetch_array($result)) 
					{		
						$OpOrders[] = $row;
					}
					$this->closeConnection();
					return $OpOrders;
			  }

			  function getPopularProducts($month)
				{
					$conn=$this->connectToDatabase();
					$popular_items = array();
					$sql="select mim.item_name,mim.item_id,ProductID, count_product from 
							(
								select ProductID, count(ProductID) AS count_product from order_detail od , order_master om
								where
								od.orderid = om.orderid
								and
								om.order_status = 'ORPSC'
								and
								MONTHNAME(om.order_complete_date) = '$month'
								GROUP BY ProductID
								ORDER BY count_product DESC
								Limit 5
						) as tmp_products , menu_items_master mim,menu_items_master_details mimd
						where
						mimd.item_id = mim.item_id
						and
						mimd.detail_id =tmp_products.ProductID
						group by mim.item_name,ProductID
						ORDER BY count_product DESC limit 5";
					$result = mysql_query($sql);
					while ($row =mysql_fetch_array($result)) 
					{		
						$popular_items[] = $row;
					}
					$this->closeConnection();
					return $popular_items;
				}

				function  valuable_customer($month)
				{

					$conn=$this->connectToDatabase();
					$customers = array();

					$sql="select ofname,olname,email_id,mobileno,count(mobileno) as max_users
					from
					order_master o
					where
					o.order_status = 'ORPSC'
					and
					 MONTHNAME(o.order_complete_date) = '$month'
					 AND
					mobileno not in ('8446448668' , '9423112203')
					AND
					email_id not in('ashishtupkar@gmail.com','ashishtupkar@hotmail.com')
					Group by ofname,olname,email_id,mobileno order by max_users desc, ofname  limit 5 ";

					$result = mysql_query($sql);
					while ($row =mysql_fetch_array($result)) 
					{		
						$customers[] = $row;
					}
					$this->closeConnection();
					return $customers;
				}

				

				function  getPopularAreas($month)
				{

					$conn=$this->connectToDatabase();
					$popularAreas = array();

					$sql="select area,pincode,count(area) as count_area
					from
					order_master o
					where
					o.order_status = 'ORPSC'
					and
					MONTHNAME(o.order_complete_date) = '$month'
					Group by area,pincode order by count_area desc limit 5 ";

					$result = mysql_query($sql);
					while ($row =mysql_fetch_array($result)) 
					{		
						$popularAreas[] = $row;
					}
					$this->closeConnection();
					return $popularAreas;
				}


	 /* function chkItemStatus($session_id)
		{
			$conn=$this->connectToDatabase();
			$item_status = array();

			$sql="select distinct itm_mstr.item_name, ct.ct_id,ct.pd_id,ct_id   from cart ct,  menu_items_master_details  itm_dtls, menu_items_master itm_mstr where
					ct_session_id = '$session_id' and itm_mstr.status = 'n' and itm_mstr.item_id = itm_dtls.item_id and itm_dtls.detail_id = ct.pd_id ";
			
			$result = mysql_query($sql);
			while ($row =mysql_fetch_array($result)) 
			{		
				$itemStatus[] = $row;
			}
			$this->closeConnection();
			return $itemStatus;

		}*/

	  function getOauthUsersData($email_provider_id,$provider)
		{
		   $conn=$this->connectToDatabase();
			$getOauthUsersData = array();
			$sql="select fname,lname,email_id,address1,address2,address3,mobile_number,active,password from customer_master c, users u where u.email = c.provider_email_id and u.provider = c.provider and u.email='$email_provider_id' and u.provider='$provider' ";
			
			$result = mysql_query($sql);
			while ($row =mysql_fetch_array($result)) 
			{		
				$getOauthUsersData[] = $row;
			}

		

			$this->closeConnection();
			return $getOauthUsersData;
		}



	function send_sms($mobile_no,$message)
	{
		//$authKey = "113439APDuLbbgFm573fde0f";
		$authKey = "113650AbRG1ZrYJ4SS574009fe";
		
		$mobileNumber =$mobile_no;
		$senderId = "zaikrt";
		$message = urlencode($message);
		$route="4";

		$postData = array(
			'authkey' => $authKey,
			'mobiles' => $mobileNumber,
			'message' => $message,
			'sender' => $senderId,
			'route' => $route
		);

		//API URL
		$url="http://api.msg91.com/api/sendhttp.php";

		// init the resource
		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $postData
			//,CURLOPT_FOLLOWLOCATION => true
		));


		//Ignore SSL certificate verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


		//get response
		$output = curl_exec($ch);

		//Print error if any
		if(curl_errno($ch))
		{
			echo 'error:' . curl_error($ch);
		}

		curl_close($ch);
}

	


	
	function delete_data($table,  $where = null)
	{
		$conn=$this->connectToDatabase();
		$rows = array();
		$sql = 'delete  FROM '.$table;
        if($where != null)
            $sql .= ' WHERE '.$where;

        //echo '<br>'.$sql.'<br>';

		if($this->tableExists($table))
		{
			$sql_res=mysql_query($sql);
		}
		$this->closeConnection();
		return $sql_res;
	}

	public function get_date(){
     date_default_timezone_set('Asia/Kolkata');
	 $date=date('Y-m-d H:i:s');
    return $date;
    }

	public function createRandomVal($val){
      $chars="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789,-";
      srand((double)microtime()*1000000);
      $i = 0;
      $pass = '' ;
      while ($i<$val) 
    {
        $num  = rand() % 33;
        $tmp  = substr($chars, $num, 1);
        $pass = $pass . $tmp;
        $i++;
      }
    return $pass;
    }

	function enc_data($val)
	{
		$val_enc = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256,md5($hashkey),$val,MCRYPT_MODE_CBC,md5(md5($hashkey))));
		return $val_enc;
	}

	function dec_data($val)
	{
		$val_dec =rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($hashkey), base64_decode($val), MCRYPT_MODE_CBC, md5(md5($hashkey))), "\0");
		return $val_dec;
	}

	function get_time_slots()
	{
		$conn=$this->connectToDatabase();
		$time_slots = array();
		$sql="select start_time,end_time,is_curday from delivery_timings where status='y' order by slot_id";
		$result = mysql_query($sql);
		while ($row =mysql_fetch_array($result)) 
			{		
			   $time_slots[]= $row['start_time'].'~'.$row['end_time'].'~'.$row['is_curday'];
			}

			
		$this->closeConnection();
		return $time_slots;

		/*$time_slots[] =  '12.00 am~02.00 am~n';
		$time_slots[] =  '12.00 pm~04.00 pm~y';
		$time_slots[] =  '07.00 pm~11.45 pm~y';
		return $time_slots;*/
	}




	function get_cart($add_more_items)
	{
		$conn=$this->connectToDatabase();
		$remaining_total="";
		$free_credit_remain="";
		$extra_charge="";
		
		$current_order_number=0;
	if(isset($_SESSION['email_id']) && isset($_SESSION['mobile_number']))
	{
		$mobile_number = $_SESSION['mobile_number'];
		$sql = "select count(distinct orderid) +1 as orderid  from order_master om,customer_master cm where om.mobileno = cm.mobile_number  and
		order_status = 'ORPSC' and om.mobileno ='$mobile_number'  ";
		$sql_query = mysql_query($sql);
		$row_order_number = mysql_fetch_array($sql_query);
		$current_order_number=$row_order_number['orderid'];
		//echo '<h3>Current Order No. '.$current_order_number.'</h3>';
	}
	$sid = session_id();
	$sql = "SELECT ct_id, ct.pd_id, ct_qty, m.item_name, d.detail_description, d.item_price  FROM cart ct, menu_items_master m , menu_items_master_details d	WHERE ct_session_id = '$sid' AND ct.pd_id = d.detail_id AND d.item_id = m.item_id   ";
	$sql_query = mysql_query($sql);
	$count_rows = mysql_num_rows($sql_query);


	if($count_rows > 0)
	{
		$i=1;
		echo '<table class="table table_summary"><tbody>';
		$Total = 0;
		$subTotal = 0;
		$minimum_total=200;
		$total_discount_per=10;
		$free_credit_amount = 0;
		$free_meal ='n';
		if(isset($_SESSION['email_id']) && isset($_SESSION['mobile_number']))
		{
			if(($current_order_number % 10) ==0)
			{
				$minimum_total=0;
				$free_credit_amount = 230;
				$free_meal ='y';
			}
		}
		while ($row = mysql_fetch_array($sql_query))
		{
			$subTotal += number_format(($row['item_price'] * $row['ct_qty']), 2, '.', '');
			?>
					<tr>
						<td class="col-md-6" style="padding:2px">
							 <?php echo '<b>'.ucwords($row['item_name']).'</b><br>'.$row['detail_description']; ?></td>
							<td>
							<?php
								if($add_more_items == true)
								{
							 ?>
							 <td style="padding:2px"><a  class="remove_item" <?php echo 'onClick="cart('." '".$row['pd_id']."','update',"."'spin_".$i."'".')"' ?> style="cursor:pointer;color:red"><i class="icon_minus_alt"></i></a></td><td style="padding:2px"> <strong><?php echo $row['ct_qty'];  ?>&nbsp;</strong></td><td style="padding:2px"><a <?php echo 'onClick="cart('."'".$row['pd_id']."','add',"."'spin_".$i."'".')"' ?> class="remove_item"  style="cursor:pointer;color:red"><i class="icon_plus_alt"></i></a>&nbsp;<?php echo '<i id="spin_'.$i.'" class="icon-spin6 animate-spin" style="display:none"></i>';?></td>
							 <?php
								}
							  else
								{
								  ?>
									<td><strong><?php echo $row['ct_qty'];  ?>&nbsp;</strong></td>
								<?php
								}

							 ?>
						<!-- </td> -->
						<td style="padding:2px">
							<strong class="pull-right"><?php echo number_format(($row['item_price'] * $row['ct_qty']), 2, '.', '');?></strong>
							
						</td>
					</tr>
				<?php
					$i++;
				}
				
				$discount_total=($subTotal*$total_discount_per)/100;
				$order_total_amount=$subTotal-$discount_total;
				$remaining_total=$minimum_total-$order_total_amount;
				
				?>
		</tbody>
	</table>
	<table class="table table_summary">
		<tbody>
		<tr>
			<td><hr class="hr2">	
				 Subtotal <span class="pull-right"><i class="fa fa-inr"></i> <?php echo $subTotal; ?></span>
				 <hr class="hr2">
			</td>
		</tr>
		<tr>
			<td>
				 Discount (10%) <span class="pull-right"><i class="fa fa-inr"></i> <?php echo $discount_total; ?></span>
			</td>
		</tr>
		<?php
				if($remaining_total> 0 && $extra_charge!='y')
					{
		?>
		<tr>
			<td>
				<b style="color:#D50681"> Rs. 200 Minimum, Remaining</b> <span class="pull-right"><i class="fa fa-inr"></i> <?php echo $remaining_total; ?></span><hr class="hr2">
			</td>
		</tr>
		<?php } ?>

		<?php
			if($extra_charge == 'y' && $free_meal == 'n')
					{
		?>
		<tr>
			<td>
				<b style="color:#D50681">Extra Charges</b> <span class="pull-right"><i class="fa fa-inr"></i> <?php echo $remaining_total; ?></span><hr class="hr2">
			</td>
		</tr>
		<?php
			$order_total_amount = $order_total_amount+$remaining_total;
			}
			if($free_meal == 'y')
				{
					$free_credit_remain = $free_credit_amount - $order_total_amount;
					if($free_credit_remain <=0)
						$free_credit_remain=0;

						if($order_total_amount <=$free_credit_amount)
							$order_total_amount_v=0;
						else
							$order_total_amount_v=$order_total_amount-$free_credit_amount;
				}
						else
							$order_total_amount_v=$order_total_amount
		?>
<tr>
			<td class="total">
				 TOTAL <span class="pull-right"><i class="fa fa-inr"></i> <?php echo $order_total_amount_v; ?></span>
			</td>
		</tr>
<?php
 if($free_meal == 'y') 	{  ?>
<tr>
			<td class="total">
				 Free Credit Remains <?php //echo  $current_order_number.'Here'.var_dump($current_order_number); ?> <span class="pull-right"><i class="fa fa-inr"></i> <?php echo $free_credit_remain; ?></span>
			</td>
		</tr>

<?php 	} 	?>

		</tbody>
	</table>
		<hr class="hr2">
	<?php
				$from = date('2016-08-01 06:00:00');
				$to = date('2016-08-02 06:00:00');
				if(strtotime(date('Y-m-d H:i:s')) >= strtotime($from) && strtotime(date('Y-m-d H:i:s')) <= strtotime($to))
				{
					
				}
				else
				{
					if($add_more_items == true)
					{
						echo '<input type="hidden" name="remaining_total" id="remaining_total" value="'.$remaining_total.'">';
						echo '<input type="hidden" name="order_total_amount" id="order_total_amount" value="'.$order_total_amount_v.'">';
						echo '<input type="submit" name="crt_submit" value="Checkout" class="btn_full" >';
						echo '<div class="error"><span class="error" style="color: red;  display: inline-block;font-weight: 700;margin-bottom: 5px;max-width:100%;line-height: 15px;"></span></div>';
					}
					else
					{
						echo '<a class="btn_full_outline" href="detail_page.php"><i class="icon-right"></i> Add more items</a>';
					}
				}
				echo '<input type="hidden" name="free_meal" id="free_meal" value="'.$free_meal.'">';
				echo '<input type="hidden" name="free_credit_remain" id="free_credit_remain" value="'.$free_credit_remain.'">';
				echo '<input type="hidden" name="free_credit_amount" id="free_credit_remain" value="'.$free_credit_amount.'">';
		}
	}



	
}


?>