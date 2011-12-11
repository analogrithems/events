<script>
        $(function() {
                $( "#tabs" ).tabs({
                        collapsible: true
		});
	});
	function editInviteEmail(url){
		    $('<div>').dialog({
			modal: true,
			open: function ()
			{
			    $(this).load(url);
			},         
			height: 260,
			width: 400,
			title: '<?php __('Edit Invite Email');?>'
		    });
		return false;
	}
</script>

<style>
#myevents,#eventsByLocation,#eventsByUser{
}
</style>
<div id="tabs" class="trippleWide">
        <ul>
           <li><a href="#myinvites"><?php __('Invites');?></a></li>
           <li><?php echo $this->Html->link(__('R.S.V.P.',true),array('controller'=>'reservations', 'action'=>'view_event',$event['id']));?></li>
        </ul>

	echo $this->element('event_invites',array($invites,$event));
</div>
