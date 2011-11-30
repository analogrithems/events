<div class="invites form">
<?php echo $this->Form->create('Invite');?>
	<fieldset>
		<legend><?php __('Edit Invite Email'); ?></legend>
	<?php
		echo $this->Form->input('id',array('type'=>'hidden'));
		echo $this->Form->input('event_id', array('type'=>'hidden'));
		echo $this->Form->input('email');
		echo $this->Form->input('sent', array('type'=>'hidden'));
		echo $this->Form->input('opted_out', array('type'=>'hidden'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Update', true));?>
</div>
