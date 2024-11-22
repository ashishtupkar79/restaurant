 $(window).load(function() {
                new $.popup({                
                    title       : '',
                    content         : '<a href="#"><img src="img/zaikart_logo.png" alt="" class="pop_img" height="100px;"><h3 id="pop_msg"><strong>Free Delivery</strong> on all Menu & Orders!</h3></a>', 
					html: true,
					autoclose   : true,
					closeOverlay:true,
					closeEsc: true,
					buttons     : false,
                    timeout     : 3000 
                });
            });