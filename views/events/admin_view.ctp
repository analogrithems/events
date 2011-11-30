        <script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery(".myrsvp").click(function(){
				jQuery( "#addRSVP" ).dialog({
					height: 460,
					width: 900,
					open: function (){
						jQuery(this).load('<?php echo $this->Html->url(array('controller'=>'Reservations','action'=>'add',$event['Event']['id']));?>');
					},
					title: '<?php __("R.S.V.P.");?>',
					modal: true
				});
			});
		});
        </script>
<div class="events view">
<div class="actions">
	<span>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Event', true), array('controller'=>'events', 'action' => 'edit',$event['Event']['id'])); ?> </li>
	</ul>
	</span>
</div>
	<fieldset>
	    <legend><?php  echo $event['Event']['name']; ?></legend>
		<div class="description">
		    <?php
			echo $event['Event']['details'];
		    ?>
		</div>
		<div class="eventDetails">
			<span class="eventDate"><strong><?php echo __('When: ');?></strong><?php  echo $event['Event']['date']; ?></span>
			<span class="eventLocation">
				<strong>
				<?php 
					echo __('Where: ');  
				?>
				</strong>
				<?php
					echo $this->Html->link($event['Location']['name'], array('controller' => 'locations', 'action' => 'view', $event['Location']['id']));
				?>
			</span>
			<span class="eventContact">
				<strong>
				<?php 
					echo __('Contact: ');  
				?>
				</strong>
				<?php
					echo '<a href="mailto:'.$event['User']['email'].'">'.$event['User']['displayname']."</a>\n";
				?>
			</span>
				
		</div>
		<?php
			if(isset($event['Reservation']) && !empty($event['Reservation']) ){ ?>
				<table cellpadding="0" cellspacing="0">
				<tr>
						<th><?php __('Name'); ?></th>
						<th><?php __('Email'); ?></th>
						<th><?php __('RSVP When?'); ?></th>
						<th><?php __('Guest Count'); ?></th>
				</tr>
		<?php
				$i = 0;
				$count = 0;
				foreach($event['Reservation'] as $guest){
					$class = null;
					if ($i++ % 2 == 0) {
						$class = ' class="altrow"';
					}
					$count = $count + (int)$guest['guest_count'];
				?>
				<tr<?php echo $class;?>>
					<td><?php echo $guest['name']; ?>&nbsp;</td>
					<td><?php echo $guest['email']; ?>&nbsp;</td>
					<td><?php echo $guest['created']; ?>&nbsp;</td>
					<td><?php echo $guest['guest_count']; ?>&nbsp;</td>
				</tr>
				<?php
				}
			}
		?>
				<tr><td colspan='3'><strong><?php __('Total Attending: ');?></strong></td><td><?php echo $count;?></td></tr>
				</table>
		<?php
			
			if(isset($event['Event']['has_reservations']) && $event['Event']['has_reservations'] == 'Yes'){
		?>
				<div class="eventReservation">
					<span class=" myrsvp blue_button"><?php echo __("I'm Coming!"); ?> </span>
				</div>
		<?php
			}
		?>
	</fieldset>
</div>
<div id='addRSVP'></div>
