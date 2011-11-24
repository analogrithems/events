<div class="invites form">
<?php echo $this->Form->create('Invite');?>
	<fieldset>
		<legend><?php __('Add Invite'); ?></legend>
	<?php
		echo $this->Form->input('event_id');
		echo $this->Form->input('email');
		echo $this->Form->input('sent');
		echo $this->Form->input('opted_out');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Invites', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Events', true), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event', true), array('controller' => 'events', 'action' => 'add')); ?> </li>
	</ul>
</div>