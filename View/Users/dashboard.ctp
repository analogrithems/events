<script>
	$(function() {
		$( "#tabs" ).tabs({
			collapsible: true
		});
	});
</script>

<style>
#myevents,#eventsByLocation,#eventsByUser{
}
</style>
<div id="tabs" class="trippleWide">
	<ul>
	   <li><a href="#myevents"><?php echo __('My Events');?></a></li>
	   <li><a href="#eventsByLocation"><?php echo __('Events By Location');?></a></li>
	   <li><a href="#eventsByUser"><?php echo __('Events By User');?></a></li>
	</ul>
<?php
	//Load Events I created
        echo $this->element('my_events');
	//See Events Near Me
        //echo $this->element('events_near');
	//See Events By Location
        echo $this->element('events_by_location');
        echo $this->element('events_by_user');
?>
</div>
