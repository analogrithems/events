<div class="pages form">
<?php
	if(!isset($this->data['Page']['slug']) || empty($this->data['Page']['slug'])){
		$this->data['Page']['slug'] = String::uuid();
	}
?>
<?php echo $this->Form->create('Page');?>
	<fieldset>
		<legend><?php __('Create Page'); ?></legend>
		<div class="widget right">
	<?php
		echo $this->Form->input('access',array('type'=>'select', 'options'=>array('Private','My Groups', 'Public')));
	?></div><div class="trippleWide">
	<?php
		echo $this->Form->input('title');
		$proto = (isset($_SERVER['HTTPS'])) ? 'https://' : 'http://';
		$siteprefix = $proto.$_SERVER['SERVER_NAME'].'/'.APP_DIR.'/pages/view/';
		$slugLabel = "<span id='urlSlug'><strong>".__('URL Slug: ',true)."</strong>".$siteprefix."</span>\n";
		echo $this->Form->input('slug',array('div'=>array('class'=>'pageSlug'), 'label'=>$slugLabel, 'value'=>$this->data['Page']['slug']));
		echo $cksource->ckeditor('content')."\n";
	?>
	</div>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Pages', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
