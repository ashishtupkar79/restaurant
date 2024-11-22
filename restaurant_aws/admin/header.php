<style type="text/css">
	.blink {
	
  animation: blink-animation 1s steps(5, start) infinite;
  -webkit-animation: blink-animation 1s steps(5, start) infinite;
}
@keyframes blink-animation {
  to {
    visibility: hidden;
  }
}
@-webkit-keyframes blink-animation {
  to {
    visibility: hidden;
  }
}
 </style>
<div class="navbar navbar-inverse navbar-fixed-top bs-docs-nav" role="banner">
			<div class="container">
				<!-- Menu button for smallar screens -->
				<div class="navbar-header">
					<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="#" class="navbar-brand"><span class="bold">Zaikart</span></a> 
					
					
				</div>
				<!-- Site name for smallar screens -->
				<!-- Navigation starts -->
				<nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">     
					<!-- Links -->
					<ul class="nav navbar-nav navbar-right">

						<li id="time-box2"><a href="#"><?php echo date('d-M-Y').'&nbsp;&nbsp;&nbsp;&nbsp;'.date('h').'<span class="blink">:</span>'.date('i').' '.date('a'); ?></a></li>

						<li class="dropdown">            
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<!-- <img src="img/user.jpg" alt="" class="nav-user-pic img-responsive" /> --> Welcome <?php echo $_SESSION['name'] ?> [<?php echo $_SESSION['user_type']; ?>] <b class="caret"></b>  
							</a>
							<!-- Dropdown menu -->
							<ul class="dropdown-menu">
							
							<li><a href="logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
							</ul>
						</li>
					</ul>
					<!-- Notifications -->
					<!-- <ul class="nav navbar-nav navbar-right">
						
						<li class="dropdown dropdown-big">
							<a class="dropdown-toggle" href="#" data-toggle="dropdown">
								<i class="fa fa-comments"></i> Chats <span   class="badge badge-info">6</span> 
							</a>
							<ul class="dropdown-menu">
								<li>
						
									<h5><i class="fa fa-comments"></i> Chats</h5>
						
									<hr />
								</li>
								<li>
						
									<a href="#">Hi :)</a> <span class="label label-warning pull-right">10:42</span>
									<div class="clearfix"></div>
									<hr />
								</li>
								<li>
									<a href="#">How are you?</a> <span class="label label-warning pull-right">20:42</span>
									<div class="clearfix"></div>
									<hr />
								</li>
								<li>
									<a href="#">What are you doing?</a> <span class="label label-warning pull-right">14:42</span>
									<div class="clearfix"></div>
									<hr />
								</li>                  
								<li>
									<div class="drop-foot">
										<a href="#">View All</a>
									</div>
								</li>                                    
							</ul>
						</li>
						
						<li class="dropdown dropdown-big">
							<a class="dropdown-toggle" href="#" data-toggle="dropdown">
								<i class="fa fa-envelope-o"></i> Inbox <span class="badge badge-important">6</span> 
							</a>
							<ul class="dropdown-menu">
								<li>
						
									<h5><i class="fa fa-envelope-o"></i> Messages</h5>
						
									<hr />
								</li>
								<li>
						
									<a href="#">Hello how are you?</a>
						
									<p>Quisque eu consectetur erat eget  semper...</p>
									<hr />
								</li>
								<li>
									<a href="#">Today is wonderful?</a>
									<p>Quisque eu consectetur erat eget  semper...</p>
									<hr />
								</li>
								<li>
									<div class="drop-foot">
										<a href="#">View All</a>
									</div>
								</li>                                    
							</ul>
						</li>
						
						<li class="dropdown dropdown-big">
							<a class="dropdown-toggle" href="#" data-toggle="dropdown">
								<i class="fa fa-user"></i> Users <span   class="badge badge-success">6</span> 
							</a>
							<ul class="dropdown-menu">
								<li>
						
									<h5><i class="fa fa-user"></i> Users</h5>
						
									<hr />
								</li>
								<li>
						
									<a href="#">Ravi Kumar</a> <span class="label label-warning pull-right">Free</span>
									<div class="clearfix"></div>
									<hr />
								</li>
								<li>
									<a href="#">Balaji</a> <span class="label label-important pull-right">Premium</span>
									<div class="clearfix"></div>
									<hr />
								</li>
								<li>
									<a href="#">Kumarasamy</a> <span class="label label-warning pull-right">Free</span>
									<div class="clearfix"></div>
									<hr />
								</li>                  
								<li>
									<div class="drop-foot">
										<a href="#">View All</a>
									</div>
								</li>                                    
							</ul> -->
						</li> 
					</ul>
				</nav>
			</div>
		</div>

		 <script type="text/javascript">

			var auto_refresh = setInterval(
			function ()
			{
				//alert("Hello");
				$('#time-box2').load('timer_refresh.php').fadeIn("slow");
			}, 30000); // refresh every 10000 milliseconds
			</script>