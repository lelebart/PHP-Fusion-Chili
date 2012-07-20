jQuery(document).ready(function() {	
	jQuery('.chili_button').show();
	jQuery('div[id^="chili_forum_code"]').hide();
	jQuery('div').find('a[id^="chili_open"]').css({ 
		cursor: 'pointer' 
	}).one('mouseover', function(){ 
		jQuery('#chili_forum_code_exec_'+this.name).toggle(); 
	}).one('click', function(){
		var chili_time1 = new Date();
		jQuery('#chili_forum_code_to_'+this.name).chili();
		var chili_time2 = new Date();
		var chili_delta = chili_time2 - chili_time1;
		var chili_height = jQuery('#forum_code_'+this.name).height();
		if (chili_height > 285) jQuery('#forum_code_'+this.name).height(285);
		jQuery('#chili_forum_code_exec_'+this.name).toggle();
		jQuery('#chili_forum_code_exec_'+this.name).text( chiliLocale_06 + chili_delta + chiliLocale_07 ); 
	} ).bind( 'click', function() {
		var chili_disp =  jQuery('#chili_forum_code_'+this.name).css("display");
		if (chili_disp != 'block') jQuery(this).parent().find('.chili_replace').text(chiliLocale_05);
		else jQuery(this).parent().find('.chili_replace').text(chiliLocale_04);
		jQuery('#chili_forum_code_'+this.name).slideToggle("slow");
		jQuery('#chili_forum_code_exec_'+this.name).toggle();
	});
});