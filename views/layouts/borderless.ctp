<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');
                echo $this->Html->script('jquery-1.4.2.min');
                echo $this->Html->script('jquery-ui-1.8.4.custom.min');
                echo $this->Html->css('jquery-ui-1.8.4.custom.css');
		echo $this->Html->script('ckeditor/ckeditor');

		echo $scripts_for_layout;
	?>
</head>
<body>
	<div id="container">
		<?php echo $content_for_layout; ?>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
