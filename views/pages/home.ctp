<div>
<h2><?php __('Up and Coming, Event Notifier & Guest Tracker'); ?></h2>

<p><?php __('Have an upcoming event you need to tell everyone about?  Need have your guest R.S.V.P. so you know how many people will be attending ahead of time?  Up and Coming Event Notifier will email your guest and inform them about the event, allow them to R.S.V.P. and give you detailed records on who has R.S.V.P. and how many gues they will be bringing. Download your guest list, for your event allow your guest to opt out of your event invites etc.'); ?></p>

<p><?php __('Ready to get started?  Click Below to get Started.'); ?></p>
</div>

<br />
<span class="actions">
<?php
	$usage = Configure::read('Usage');
	if(isset($usage) && $usage == 'Public'){
		if(isset($auth['LdapAuth'])){
			echo $this->Html->link(__('Create Event',true), '/admin/events/add', array('class'=>'blue_button'));
		}else{
			echo $this->Html->link(__('Sign Up',true), '/users/signup', array('class'=>'blue_button'));
			echo __(' Or ',true);
			echo $this->Html->link(__('Sign In',true), '/users/login', array('class'=>'blue_button'));
		}
	}elseif(isset($usage) && $usage == 'Private'){
		if(isset($auth['LdapAuth'])){
			echo $this->Html->link(__('Create Event',true), '/admin/events/add', array('class'=>'blue_button'));
		}else{
			echo $this->Html->link(__('Sign In',true), '/users/login', array('class'=>'blue_button'));
		}
	}
?>
</span>

<!--<?php print_r($auth); ?>-->
