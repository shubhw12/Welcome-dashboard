jQuery(document).ready(
    function() {
    	console.log('damn everywhere');
    	var wd_settings = template.wd_settings ;
    	var wd_role = template.user_role;
		if(wd_settings[wd_role]['dissmissable'] == 1){
			return;
		}
		else{
			if(jQuery('.welcome-panel-close').length == 1){
				jQuery('.welcome-panel-close').attr('style', 'display:none');
			}
			else{
				jQuery('.notice-dismiss').attr('style', 'display:none');
			}
		}
	
    });

