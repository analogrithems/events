<div class="pages form">
<?php echo $this->Form->create('Page');?>
	<fieldset>
		<legend><?php __('Edit Page'); ?></legend>
		<div class="widget right">
	<?php
		echo $this->Html->link(__('Preview Page', true), array('controller'=>'pages', 'action' => 'view', 'admin'=>false,$this->data['Page']['slug']));
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
<div id="pageHistory">
<?php  
echo '<h4>Revision history</h4><ul>'; 
echo '<pre>'.print_r($revisions,1).'</pre>';
?>
</ul>
</div>
