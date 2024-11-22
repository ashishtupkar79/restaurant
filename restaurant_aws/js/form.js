$(document).ready(function () {
$('#exm1').validate({}); // For Validation should be there

	var options = { 
        target:        '#result',   // target element(s) to be updated with server response 
      	beforeSubmit:  showRequest,  // pre-submit callback 
        success:       showResponse  // post-submit callback 
    }; 
     // bind form using 'ajaxForm' 
    $('#exm1').ajaxForm(options); 
	// pre-submit callback 
	function showRequest(formData, jqForm, options) 
		{ 
			var queryString = $.param(formData); 
			return true; 
		} 
	// post-submit callback 
	function showResponse(responseText, statusText, xhr, $form)  
	{ 
		$('#selector').css('cursor', 'default');
		var response = responseText.trim();
	    //alert(responseText);
	}	 
});
