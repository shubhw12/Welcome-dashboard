jQuery(document).ready(
    function() {
    	var wd_settings = template.wd_settings ;
    	var wd_role = template.user_role;
    	console.log(wd_settings[wd_role]['dissmissable']);
		if(wd_settings[wd_role]['dissmissable'] == 1){
			return;
		}
		else{
			console.log('yepsdbf');
			if(jQuery('.welcome-panel-close').length == 1){

				jQuery('.welcome-panel-close').attr('style', 'display:none');
			}
			else{
				console.log('else part different user roles');
				jQuery('.notice-dismiss').attr('style', 'display:none');
			}
		}
	
    });

