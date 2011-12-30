<script>
	function editReservationEmail(url){
		    $('<div>').dialog({
			modal: true,
			open: function ()
			{
			    $(this).load(url);
			},         
			height: 260,
			width: 400,
			title: '<?php echo __('Edit Reservation Email');?>'
		    });
		return false;
	}
</script>

	<div id="myreservations" class="widget_box trippleWide">
		<h2><?php echo __('Reservations');?></h2>
		<?php
			echo $this->Form->create('Reservation',array('action'=>'bulkUpdate'));
			echo $this->Form->input('event.id', array('type'=>'hidden', 'value'=>$event['id']));
			echo $this->Form->input('cmd', array('label'=>__('Bulk Update'), 'type'=>'select', 'options'=>array('0'=>__('Bulk Update'),
				'resend'=>__('Resend Reservations'),'delete'=>__('Delete Reservations'))));
		?>
		<table cellpadding="0" cellspacing="0">
		<thead>
				<th><input type="checkbox" class="myreservations" id="myReservationGlob" onclick="toggleChecked(this.checked,'myreservations')"></td> 
				<th><?php echo $this->Paginator->sort('name');?></th>
				<th><?php echo $this->Paginator->sort('email');?></th>
				<th><?php echo $this->Paginator->sort('guest_count');?></th>
				<th><?php echo $this->Paginator->sort('created');?></th>
		</thead>
		<tfoot>
				<th><input type="checkbox" class="myreservations" id="myReservationGlob" onclick="toggleChecked(this.checked,'myreservations')"></td> 
				<th><?php echo $this->Paginator->sort('name');?></th>
				<th><?php echo $this->Paginator->sort('email');?></th>
				<th><?php echo $this->Paginator->sort('guest_count');?></th>
				<th><?php echo $this->Paginator->sort('created');?></th>
		</tfoot>
		<tbody>
		<?php
		$i = 0;
		foreach ($reservations as $reservation):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = 'altrow';
			}
		?>
		<tr class="<?php echo $class;?>">
			<td><input type="checkbox" class="myreservations" name="data[Reservation][id][]" value="<?php echo $reservation['Reservation']['id']; ?>"></td>
			<td><?php echo $this->Html->link($reservation['Reservation']['name'], '#', array('onclick'=>"editReservationEmail('".
				$this->Html->url(array('controller'=>'Reservations', 'action' => 'edit', $reservation['Reservation']['id'],$event['id']))."')"));?></td>
			<td><?php echo $this->Html->link($reservation['Reservation']['email'], '#', array('onclick'=>"editReservationEmail('".
				$this->Html->url(array('controller'=>'Reservations', 'action' => 'edit', $reservation['Reservation']['id'],$event['id']))."')"));?></td>
			<td><?php echo $this->Html->link($reservation['Reservation']['guest_count'], '#', array('onclick'=>"editReservationEmail('".
				$this->Html->url(array('controller'=>'Reservations', 'action' => 'edit', $reservation['Reservation']['id'],$event['id']))."')"));?></td>
			<td class='<?php echo $sentClass;?>'><?php echo $$reservation['Reservation']['created'];?></td>
		</tr>
	<?php endforeach; ?>
		</tbody>
		</table>
		<div class="bulkOptions">
			<span>
			<?php
			echo $this->Form->end(__('Update'));?>
			</span>
		</div>
		<p>
		<?php
		echo $this->Paginator->counter(array(
		'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
		));
		?>	</p>

		<div class="paging">
			<?php echo $this->Paginator->prev('<< ' . __('previous'), array(), null, array('class'=>'disabled'));?>
		 | 	<?php echo $this->Paginator->numbers();?>
	 |
			<?php echo $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled'));?>
		</div>
	</div>

