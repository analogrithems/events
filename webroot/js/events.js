jQuery(function(){
        jQuery( "#leftnav" ).accordion({ autoHeight: false, navigation: true });

        jQuery('.clearMeFocus').focus(function(){
                if(jQuery(this).val()==this.defaultValue){
                        jQuery(this).val("");
                }
        });

        // if field is empty afterward, add text again
        jQuery('.clearMeFocus').blur(function(){
                if(jQuery(this).val()==""){
                        jQuery(this).val(this.defaultValue);
                }
        });
        jQuery('.clearMeFocus').focus(function(){
                if(jQuery(this).val()==this.defaultValue){
                        jQuery(this).val("");
                }
        });

        // if field is empty afterward, add text again
        jQuery('.clearMeFocus').blur(function(){
                if(jQuery(this).val()==""){
                        jQuery(this).val(this.defaultValue);
                }
        });
	jQuery('.ajaxLinkLoad').click(function(link){
		title = jQuery(this).attr('alt');
		url = jQuery(this).attr('href');
		jQuery( "#showDialog" ).dialog({
			width: 400,
			open: function (){
				jQuery(this).load(url);
			},
			title: title,
			modal: true
		});
		return false;
	});
});

function toggleChecked(status,cls) {
	$('.'+cls).each( function() {
		$(this).attr("checked",status);
	})
}
