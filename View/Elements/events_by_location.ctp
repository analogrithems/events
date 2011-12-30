<div id="eventsByLocation" class="widget_box fuller">
	<h3><?php echo __("Events By Location");?></h3>
<?php 
	$eventsByLocation = $this->requestAction('events/events_by_location/sort:created/direction:asc/limit:10');
	echo $this->Form->create('Event',array('action'=>'delete','controller'=>'events'));
	echo $this->Form->input('Bulk.Action',array('type'=>'select', 'empty'=>__('Bulk Actions'), 'options'=>array(__('Delete'))));
	if (!empty($eventsByLocation)):?>
        <table cellpadding = "0" cellspacing = "0">
        <thead>
                <th><input type="checkbox" class="eventsByLocation" id="myEventGlob" onclick="toggleChecked(this.checked,'eventsByLocation')"></th>
		<th><?php echo $this->Paginator->sort('name');?></th>
		<th><?php echo $this->Paginator->sort('location_id');?></th>
		<th><?php echo $this->Paginator->sort('date');?></th>
        </thead>
        <tfoot>
                <th><input type="checkbox" class="eventsByLocation" id="myEventGlob" onclick="toggleChecked(this.checked,'eventsByLocation')"></th>
		<th><?php echo $this->Paginator->sort('name');?></th>
		<th><?php echo $this->Paginator->sort('location_id');?></th>
		<th><?php echo $this->Paginator->sort('date');?></th>
        </tfoot>
        <tbody>
        <?php
                $i = 0;
                foreach ($eventsByLocation as $event):
                        $class = null;
                        if ($i++ % 2 == 0) {
                                $class = ' class="altrow"';
                        }
                ?>
                <tr<?php echo $class;?>>
                        <td><input type="checkbox" class="eventsByLocation" value="<?php echo $event['Event']['id'];?>" name="data[Event][id][]"></td>
                        <td><?php echo $this->Html->Link($event['Event']['name'],array('controller'=>'events','action'=>'view',$event['Event']['id']));?></td>
                        <td><?php echo $this->Html->Link($event['Location']['name'],array('controller'=>'locations','action'=>'view',$event['Event']['location_id']));?></td>
                        <td><?php echo $event['Event']['date'];?></td>
                </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
	
	<?php
		
		echo $this->Form->end('Update');
	?>
        <p>
        <?php
        echo $this->Paginator->counter(array(
        'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
        ));
        ?>      </p>

        <div class="paging">
                <?php echo $this->Paginator->prev('<< ' . __('previous'), array(), null, array('class'=>'disabled'));?>
         |      <?php echo $this->Paginator->numbers();?>
 |
                <?php echo $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled'));?>
        </div>
<?php 
	endif; 
	?>

</div>
