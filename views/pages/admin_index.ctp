<div class="trippleWide">
<?php
        echo $this->Form->create('Page',array('action'=>'admin_bulk','controller'=>'pages'));
        echo $this->Form->input('Bulk.Action',array('type'=>'select', 'empty'=>__('Bulk Actions',true), 'options'=>array(__('Delete',true))));
?>
	<h2><?php __('Pages');?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
			<th><input type="checkbox" class="mypages" id="myPagesGlob" onclick="toggleChecked(this.checked,'mypages')"></th>
			<th><?php echo $this->Paginator->sort('title');?></th>
			<th><?php echo $this->Paginator->sort(__('Author',true),'user_id');?></th>
			<th><?php echo $this->Paginator->sort('access');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
	</thead>
	<tfoot>
			<th><input type="checkbox" class="mypages" id="myPagesGlob" onclick="toggleChecked(this.checked,'mypages')"></th>
			<th><?php echo $this->Paginator->sort('title');?></th>
			<th><?php echo $this->Paginator->sort(__('Author',true),'user_id');?></th>
			<th><?php echo $this->Paginator->sort('access');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
	</tfoot>
	<tbody>
	<?php
	$i = 0;
	foreach ($pages as $page):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><input type="checkbox" class="mypages" value="<?php echo $page['Page']['id'];?>" name="data[Page][id][]"></td>
		<td><?php echo $this->Html->link($page['Page']['title'],array('action'=>'admin_edit','controller'=>'pages', $page['Page']['id']));?></td>
		<td>
			<?php echo $this->Html->link($page['User']['username'], array('controller' => 'users', 'action' => 'view', $page['User']['id'])); ?>
		</td>
		<td><?php echo $page['Page']['access']; ?>&nbsp;</td>
		<td><?php echo $page['Page']['created']; ?>&nbsp;</td>
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
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
