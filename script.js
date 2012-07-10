function hideAllMessages() {
	var messageHeight = jQuery('.jqnm_message').outerHeight();
	jQuery('.jqnm_message').css('top', -messageHeight); //move element outside viewport	  
}

function showMessage() {
	hideAllMessages();
	jQuery('.jqnm_message').delay(parseInt(jqnm_script_vars.delay)).animate({top: parseInt(jqnm_script_vars.offset)}, parseInt(jqnm_script_vars.speed));
}

jQuery(document).ready(function() {

	// Show message
	showMessage();
	
	// When message is clicked, hide it
	jQuery('.jqnm_message').click(function() {			  
		jQuery(this).animate({top: -jQuery(this).outerHeight()}, parseInt(jqnm_script_vars.speed));
	});		 		 
});