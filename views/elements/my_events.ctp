<div id="myevents" class="widget_box fuller">
	<h3><?php __("Events I'm Hosting");?></h3>
<?php 
	$myevents = $this->requestAction('events/my_events/sort:created/direction:asc/limit:10');
	//echo "<pre>".print_r($myevents,1)."</pre>";
	echo $this->Form->create('Event',array('action'=>'delete','controller'=>'events'));
	echo $this->Form->input('Bulk.Action',array('type'=>'select', 'empty'=>__('Bulk Actions',true), 'options'=>array(__('Delete',true))));
	if (!empty($myevents)):?>
        <table cellpadding = "0" cellspacing = "0">
        <thead>
                <th><input type="checkbox" class="myevents" id="myEventGlob" onclick="toggleChecked(this.checked,'myevents')"></th>
		<th><?php echo $this->Paginator->sort('name');?></th>
		<th><?php echo $this->Paginator->sort('location_id');?></th>
		<th><?php echo $this->Paginator->sort(__('Invites / R.S.V.P.',true));?></th>
		<th><?php echo $this->Paginator->sort('date');?></th>
        </thead>
        <tfoot>
                <th><input type="checkbox" class="myevents" id="myEventGlob" onclick="toggleChecked(this.checked,'myevents')"></th>
		<th><?php echo $this->Paginator->sort('name');?></th>
		<th><?php echo $this->Paginator->sort('location_id');?></th>
		<th><?php echo $this->Paginator->sort(__('Invites / R.S.V.P.',true));?></th>
		<th><?php echo $this->Paginator->sort('date');?></th>
        </tfoot>
        <tbody>
        <?php
                $i = 0;
                foreach ($myevents as $event):
                        $class = null;
                        if ($i++ % 2 == 0) {
                                $class = ' class="altrow"';
                        }
                ?>
                <tr<?php echo $class;?>>
                        <td><input type="checkbox" class="myevents" value="<?php echo $event['Event']['id'];?>" name="data[Event][id][]"></td>
                        <td><?php echo $this->Html->Link($event['Event']['name'],array('controller'=>'events','action'=>'view',$event['Event']['id']));?></td>
                        <td><?php echo $this->Html->Link($event['Location']['name'],array('controller'=>'locations','action'=>'view',$event['Event']['location_id']));?></td>
                        <td><?php 
				if($event['Invite']['count'] > 0){		
					echo $this->Html->Link($event['Invite']['count'],array('controller'=>'invites','action'=>'view_event',$event['Event']['id']));
				}else{
					echo 0;
				}
			?>
			/
                        <?php 
				if($event['Reservation']['count']){
					echo $this->Html->Link($event['Reservation']['count'],array('controller'=>'reservations','action'=>'view_event',$event['Event']['id']));
				}else{
					echo 0;
				}
	
			?></td>
			
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
        'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
        ));
        ?>      </p>

        <div class="paging">
                <?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
         |      <?php echo $this->Paginator->numbers();?>
 |
                <?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
        </div>
<?php 
	endif; 
	echo "<!--dump".print_r($myevents,1)."-->\n";
	?>

</div>
