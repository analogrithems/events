<div class="events form">
<?php
		echo $cksource->create('Event')."\n";
?>
	<fieldset>
		<legend><?php __('Add Event'); ?></legend>
		<div class="widget right">
	<?php
	
		
		$addLoc =  __(' Or Add ',true).$this->Html->link(__('New Location', true), array('controller' => 'locations', 'action' => 'add'),array('class'=>'ajaxLinkLoad','alt'=>__('Create new Location',true)));
		echo $this->Form->input('location_id',array('div'=>'flow', 'after'=>$addLoc))."\n";
	?>
		<div class="clear"></div>
		<div class="flow">  <input type='text'  class="clearMeFocus small" value="<?php echo (isset($this->data['Event']['date'])) ? $this->data['Event']['date'] : __('Date:',true);?>" id='date' name='data[Event][date]'></div>
	<?php
		echo $this->Ajax->datepicker('date',array('buttonImageOnly'=>true,'buttonImage'=>'/events/webroot/img/calendar.png','dateFormat'=>'yy-mm-dd'))."\n";
		?><div class="clear"></div><?php
		echo $this->Form->input('Invites.email',array('type'=>'textarea', 'label'=>__('Invite (one email per line)',true), 'div'=>'flow'));
		echo $this->Form->input('has_reservations',array('div'=>'flow','type'=>'checkbox'))."\n";

		?>
		</div>
		<div class="trippleWide"><?php
		echo $this->Form->input('name')."\n";
		//CKEditor
		echo $cksource->ckeditor('details')."\n";
	?>
		</div>
	</fieldset>
<?php
		echo $this->Form->end(array('label'=>'Add Event','class'=>'blue_button', 'div'=>array('class'=>'button')))."\n";
		echo $cksource->end()."\n";
?>
</div>
<div id='showDialog'></div>
