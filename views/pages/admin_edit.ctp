<div class="pages form">
<?php echo $this->Form->create('Page');?>
	<fieldset>
		<legend><?php __('Edit Page'); ?></legend>
		<div class="widget right">
	<?php
		echo $this->Html->link(__('Preview Page', true), array('controller'=>'pages', 'action' => 'view', 'admin'=>false,$this->data['Page']['slug']));
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
<div id="pageHistory">
<?php  
echo "<!--History:".print_r($history,1)."-->\n";
echo '<h4>Revision history</h4><ul>'; 
$nr_of_revs = sizeof($history); 
foreach ($history as $k => $rev) { 
echo '<li>'.($nr_of_revs-$k).' '.$rev['Post']['version_created'].' '.$html->link('load revision', array('action'=>'edit',$rev['Post']['id'],$rev['Post']['version_id']))."</li>\n";
} 
?>
</ul>
</div>
