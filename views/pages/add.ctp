<div class="pages form">
<?php echo $this->Form->create('Page');?>
	<fieldset>
		<legend><?php __('Add Page'); ?></legend>
	<?php
		echo $this->Form->input('slug');
		echo $this->Form->input('title');
		echo $this->Form->input('content');
		echo $this->Form->input('revision');
		echo $this->Form->input('access');
		echo $this->Form->input('user_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Pages', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>