<div class="locations form widget">
<?php echo $this->Form->create('Location');?>
	<fieldset>
		<legend class="box_head_widget"><?php echo __('Add Location'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('address');
		echo $this->Form->input('address2');
		echo $this->Form->input('city');
		echo $this->Form->input('state');
		echo $this->Form->input('zip');
		echo $this->Form->input('country');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Add Location'));?>
</div>
