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
print_r($revisions);
	$i=0;
	foreach($revisions as $date=>$rev){
		echo "<span id='rev-{$i}' class='revisions'>{$date}</span>\n";
		echo "<div id='rev-show-{$i}'>\n";
		echo "<dl>\n";
		echo "<dt>".__('URL',1)."</dt>\n";
		echo "<dd>{$rev['Page']['slug']}</dd>\n";
		echo "<dt>".__('Author',1)."</dt>\n";
		echo "<dd>{$rev['User']['username']}</dd>\n";
		echo "<dt>".__('Title',1)."</dt>\n";
		echo "<dd>{$rev['Page']['title']}</dd>\n";
		echo "<dt>".__('Body',1)."</dt>\n";
		echo "<dd>{$rev['Page']['content']}</dd>\n";
		echo "</dl>\n";
		echo "</div>\n";
		$i++;
	}	
?>
</div>
