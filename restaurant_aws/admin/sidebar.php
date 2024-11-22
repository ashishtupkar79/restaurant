<?php  //echo basename($_SERVER['PHP_SELF']); ?>
<!-- Sidebar -->
			<div class="sidebar">
				<div class="sidebar-dropdown"><a href="#">Navigation</a></div>
				<div class="sidebar-inner">
					<!-- Search form -->
					<!-- <div class="sidebar-widget">
						<form >
							<input type="text" class="form-control" placeholder="Search"> 
						</form>
					</div>-->
					
					<!--- Sidebar navigation -->
					<!-- If the main navigation has sub navigation, then add the class "has_submenu" to "li" of main navigation. -->
					<?php	
							
							//$tmp ='Orders!orders.php@view_orders~order_detail.php@order Detail^Users!users.php@View Users~users_add.php@Add Users';

							$user_id		= $_SESSION['user_id'];
							$user_type	=$_SESSION['user_type'];
							$where = " user_id = '$user_id' and user_type='$user_type' ";
							$results=$connection->get_data("admin_users","user_rights",$where,null);
							foreach($results as  $usrinfo)
							{
								$user_rights = $usrinfo['user_rights'];
							}
							$user_rights_val= explode("^",$user_rights);
							
							foreach($user_rights_val as  $key=>$value1)
							{
								if(strlen($value1) > 0)
								{
									$menu= explode("!",$value1);
									$menu_heading = $menu[0];
									$menu_listing = $menu[1];
									$menu_listing_val = explode("~",$menu_listing);
									
									//print_r($menu_listing_val);
									
									/* Get File Name From Url*/
									$myurl = strlen($_SERVER['QUERY_STRING']) ? basename($_SERVER['PHP_SELF'])."?".$_SERVER['QUERY_STRING'] : basename($_SERVER['PHP_SELF']);
									if(strpos($myurl,'?') !== false)
									{
										$myurl_val = explode("?",$myurl);
										$basename = $myurl_val[0];
									}
									else
									{
										$basename = $myurl;
									}


									
									/* Get File Name From Url Ends*/

									$selected_tab="";
									foreach($menu_listing_val as $key=>$value)
									{
										if(strpos($value,$basename) !== false )
										{
											$selected_tab="current open";
										}

										/* For invoice Page selected tab*/
										if($basename == 'invoice.php' && $menu_heading == 'Orders')
										{
											$selected_tab="current open";
										}

										/* For invoice Page selected tab ends here*/

									}


									echo '<ul class="navi">';
										
										echo '<li class="has_submenu nblue '.$selected_tab.'  ">';
											echo '<a href="#"><i class="fa fa-file-o"></i> '.$menu_heading.'<span class="pull-right"><i class="fa fa-angle-right"></i></span></a>';
												echo '<ul>';
													foreach($menu_listing_val as $key=>$value)
													{
														$active="";
														$value_val = explode("@",$value);
														$filename=$value_val[0];
														$caption=$value_val[1];
														if($filename == $basename)
															$active = 'active';
														echo  '<li class="'.$active.'"><a href="'.$filename.'">'.$caption.'</a></li>';
													}
											echo '</ul>';
										echo '</li> ';
									 echo '</ul>';
								}
							}
					?>

					

				<div class="sidebar-widget"><div id="todaydate"></div></div>	

				 <embed src="success.wav" autostart="false" width="0" height="0" id="sound1" enablejavascript="true">
			 <script type="text/javascript">
			var auto_refresh = setInterval(
			function ()
			{
				$('#slide-box2').load('notifications.php').fadeIn("slow");
			}, 30000); // refresh every 10000 milliseconds
			</script>

		<!-- Notification box starts --><div  id="slide-box2"></div> <!-- Notification box ends here -->
					
				</div>



			</div>
			<!-- Sidebar ends -->

