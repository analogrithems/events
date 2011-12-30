<div class="pages form">
<?php
	if(!isset($this->request->data['Page']['slug']) || empty($this->request->data['Page']['slug'])){
		$this->request->data['Page']['slug'] = String::uuid();
	}
?>
<?php echo $this->Form->create('Page');?>
	<fieldset>
		<legend><?php echo __('Create Page'); ?></legend>
		<div class="widget right">
	<?php
	?></div><div class="trippleWide">
	<?php
		echo $this->Form->input('title');
		$proto = (isset($_SERVER['HTTPS'])) ? 'https://' : 'http://';
		$siteprefix = $proto.$_SERVER['SERVER_NAME'].'/'.APP_DIR.'/pages/view/'.$user['User']['username'].'/';
		$slugLabel = "<span id='urlSlug'><strong>".__('URL Slug: ')."</strong>".$siteprefix."</span>\n";
		echo $this->Form->input('slug',array('div'=>array('class'=>'pageSlug'), 'label'=>$slugLabel, 'value'=>$this->request->data['Page']['slug']));
		echo $this->Cksource->ckeditor('content')."\n";
	?>
	</div>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Pages'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
