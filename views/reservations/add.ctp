<div class="reservations form">
<script>
    jQuery(function(){
      jQuery(".arrow-up").click(function(){
        jQuery("#ReservationGuestCount").val( Number(jQuery("#ReservationGuestCount").val()) + 1 );
      });
      jQuery(".arrow-down").click(function(){
        jQuery("#ReservationGuestCount").val( Number(jQuery("#ReservationGuestCount").val()) - 1 );
      });
    });
</script>
<?php echo $this->Form->create('Reservation');?>
	<fieldset>
		<legend><?php echo $event['Event']['name']; ?></legend>
		<div id="content"><?php echo $event['Event']['details'];?></div>
		<div class="eventDetails">
			<span class="eventLocation"><strong><?php __('Where: ');?></strong> <?php echo $event['Location']['name'];?></span>
			<span class="eventDate"><strong><?php __('When: ');?></strong> <?php echo $event['Event']['date'];?></span>
			<?php
				if(isset($reservation_count) && (int)$reservation_count > 0){
					echo '<span class="eventGuestCount"><strong>'.__('Already Attending: ',true).'</strong>'.$reservation_count.'</span>';
				}
			?>
		</div>
		<div class="eventForm">
		<?php
			echo $this->Form->hidden('event_id',array('value'=>$id));
			echo $this->Form->input('guest_count', array('div'=>'guestCount', 'value'=>1, 'after'=>'<div class="arrow-up"></div><div class="arrow-down"></div>'));
			echo $this->Form->input('name');
			echo $this->Form->input('email');
		?>
		</div>
	</fieldset>
<?php echo $this->Form->end(array('label'=>__('R.S.V.P.',true),'class'=>'blue_button', 'div'=>array('class'=>'button')));?>
</div>
