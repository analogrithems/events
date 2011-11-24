<div class="reservations form">
<?php echo $this->Form->create('Reservation');?>
	<fieldset>
		<legend><?php __('Edit Reservation'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('event_id');
		echo $this->Form->input('guest_count');
		echo $this->Form->input('name');
		echo $this->Form->input('email');
		echo $this->Form->input('created_date');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Reservation.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Reservation.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Reservations', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Events', true), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event', true), array('controller' => 'events', 'action' => 'add')); ?> </li>
	</ul>
</div>