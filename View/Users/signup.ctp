<div id="signupForm">
<script>
jQuery(document).ready(function() {

	jQuery("#UserUsername").keyup(function(){
			userNameLookUp();
	});

	function userNameLookUp(){
		jQuery.get("<?php echo $this->Html->url(array('controller'=>'users', 'action' => 'usernameExists'));?>/"+jQuery("#UserUsername").val(), function(data){
			if(data>1){
				//Block form submission, disable submit button
				jQuery('#UserSignupForm').submit(function(){
				    jQuery('input[type=submit]', this).attr('disabled', 'disabled');
				});
				jQuery("#usernameLookup").html("<span class='warn'><?php echo __("Username already exsits, please choose another!");?></span>");
			}else{
				jQuery('#UserSignupForm').submit(function(){
				    jQuery('input[type=submit]', this).attr('disabled', '');
				});
				jQuery("#usernameLookup").html("<span class='status_msg'><?php echo __("Username is available.");?></span>");
			}
		});
	}

});
</script>
<?php echo $this->Form->create('User', array('class'=>'form'));?>

<?php echo __('Please complete the form below. ');
echo $this->Form->input('firstname', array( 'label' => __('First Name'), 'div'=>'formfield', 'error' => array( 'wrap' => 'div', 'class' => 'formerror' ) )); 
echo $this->Form->input('lastname', array( 'label' => __('Last Name'), 'div'=>'formfield', 'error' => array( 'wrap' => 'div', 'class' => 'formerror' ) )); 
echo $this->Form->input('email', array( 'label' => __('E-mail'), 'div'=>'formfield', 'error' => array( 'wrap' => 'div', 'class' => 'formerror' ) )); 
echo "<div id='usernameLookup'></div>\n";
echo $this->Form->input('username', array( 'label' => __('Login'), 'div'=>'formfield', 'error' => array( 'wrap' => 'div', 'class' => 'formerror' ) )); 
	
echo $this->Form->input('password', array( 'label' => __('Password'), 'div'=>'formfield', 'error' => array( 'wrap' => 'div', 'class' => 'formerror' ) )); 
echo $this->Form->input('password_confirm', array( 'label' => __('Confirm password'), 'type'=>'password', 'div'=>'formfield required', 'error' => array( 'wrap' => 'div', 'class' => 'formerror' ) )); 
	
//echo $this->Form->end(__('Signup'));
echo $this->Js->submit(__('Sign Up'), array('update' => '#signupForm'));
?>

</div>
