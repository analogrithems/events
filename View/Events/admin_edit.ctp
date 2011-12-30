<div class="events form">
<?php
		echo $this->Cksource->create('Event')."\n";
?>
	<fieldset>
		<legend><?php echo __('Add Event'); ?></legend>
		<div class="widget right">
	<?php
	
		
		$addLoc =  __(' Or Add ').$this->Html->link(__('New Location'), array('controller' => 'locations', 'action' => 'add'),array('class'=>'ajaxLinkLoad','alt'=>__('Create new Location')));
		echo $this->Form->input('location_id',array('div'=>'flow', 'after'=>$addLoc))."\n";
		echo $this->Form->input('id',array('type'=>'hidden'));
	?>
		<div class="clear"></div>
		<div class="flow">  <input type='text'  class="clearMeFocus small" value="<?php echo (isset($this->request->data['Event']['date'])) ? $this->request->data['Event']['date'] : __('Date:');?>" id='date' name='data[Event][date]'></div>
	<?php
		echo $this->Ajax->datepicker('date',array('buttonImageOnly'=>true,'buttonImage'=>'/events/webroot/img/calendar.png','dateFormat'=>'yy-mm-dd'))."\n";
		?><div class="clear"></div><?php
		echo $this->Form->input('Invites.email',array('type'=>'textarea', 'label'=>__('Invite (one email per line)'), 'div'=>'flow'));
		echo $this->Form->input('has_reservations',array('div'=>'flow','type'=>'checkbox'))."\n";

		?>
		</div>
		<div class="trippleWide"><?php
		echo $this->Form->input('name')."\n";
		//CKEditor
		echo $this->Cksource->ckeditor('details')."\n";
	?>
		</div>
	</fieldset>
<?php
		echo $this->Form->end(array('label'=>'Update Event','class'=>'blue_button', 'div'=>array('class'=>'button')))."\n";
		echo $this->Cksource->end()."\n";
?>
</div>
<div id='showDialog'></div>
<pre><?php echo print_r($revisions,1); ?></pre>
