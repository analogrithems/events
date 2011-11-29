<script>
        $(function() {
                $( "#tabs" ).tabs({
                        collapsible: true
		});
	});
	function editInviteEmail(url){
		alert(url);
		    $('<div>').dialog({
			modal: true,
			open: function ()
			{
			    $(this).load(url);
			},         
			height: 400,
			width: 600,
			title: '<?php __('Edit Email Invite');?>';
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
           <li><?php echo $this->Html->link(__('R.S.V.P.',true),array('controller'=>'reservations', 'action'=>'view_event',$event['uuid']));?></li>
        </ul>

	<div id="myinvites" class="widget_box trippleWide">
		<h2><?php __('Invites');?></h2>
		<?php
			echo $this->Form->create('Invite');
			echo $this->Form->input(__('Bulk Action',true), array('type'=>'select', 'options'=>array('resend'=>__('Resend Invites',true),'delete'=>__('Delete Invites',true))));
		?>
		<table cellpadding="0" cellspacing="0">
		<thead>
				<th><input type="checkbox" class="myinvites" id="myInviteGlob" onclick="toggleChecked(this.checked,'myinvites')"></td> 
				<th><?php echo $this->Paginator->sort('email');?></th>
				<th><?php echo $this->Paginator->sort('sent');?></th>
				<th class="actions"><?php __('Actions');?></th>
		</thead>
		<tfoot>
				<th><input type="checkbox" class="myinvites" id="myInviteGlob" onclick="toggleChecked(this.checked,'myinvites')"></td> 
				<th><?php echo $this->Paginator->sort('email');?></th>
				<th><?php echo $this->Paginator->sort('sent');?></th>
				<th class="actions"><?php __('Actions');?></th>
		</tfoot>
		<tbody>
		<?php
		$i = 0;
		foreach ($invites as $invite):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = 'altrow';
			}
			if($invite['Invite']['opted_out'] == 'Yes'){
				$class .= ' optedOut';
			}
			$sent = null;
			$sentClass = null;
			if($invite['Invite']['sent'] == 'Yes'){
				$sentClass = 'inviteSent';
				$sent = $invite['Invite']['modified'];
			}else{
				$sent = __('Not Yet Sent',true);
				$sentClass = 'inviteNoteSent';
			}
		?>
		<tr class="<?php echo $class;?>">
			<td><input type="checkbox" class="myinvites" name="data[invite][uuid][]" value="<?php echo $invite['Invite']['uuid']; ?>"></td>
			<td><?php echo $this->Html->link($invite['Invite']['email'], '#', array('onclick'=>"editInviteEmail('".$this->Html->url(array('controller'=>'Invite', 'action' => 'edit', $invite['Invite']['uuid']))."'"));?></td>
			
			
			<td class='<?php echo $sentClass;?>'><?php echo $sent;?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('Resend', true), array('controller'=>'Invite', 'action' => 'resend', $invite['Invite']['uuid']));?>
				<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $invite['Invite']['uuid']), null, sprintf(__('Are you sure you want to delete # %s?', true), $invite['Invite']['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
		</tbody>
		</table>
		<p>
		<?php
		echo $this->Paginator->counter(array(
		'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
		));
		?>	</p>

		<div class="paging">
			<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
		 | 	<?php echo $this->Paginator->numbers();?>
	 |
			<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
		</div>
	</div>

</div>
