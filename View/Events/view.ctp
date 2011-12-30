        <script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery(".myrsvp").click(function(){
				jQuery( "#addRSVP" ).dialog({
					height: 460,
					width: 900,
					open: function (){
						jQuery(this).load('<?php echo $this->Html->url(array('controller'=>'Reservations','action'=>'add',$event['Event']['id']));?>');
					},
					title: '<?php echo __("R.S.V.P.");?>',
					modal: true
				});
			});
		});
        </script>
<div class="events view">
<div class="actions">
	<span>
	<ul>
		<li><?php echo $this->Html->link(__('List Events'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List Locations'), array('controller' => 'locations', 'action' => 'index')); ?> </li>
		<li><strong><?php echo __('Actions'); ?></strong></li>
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
