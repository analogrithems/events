<div id="signupForm">
<?php
	echo $form->create('User',array('action'=>'add'))."\n";

	echo $form->input('givenname', array('label'=>'First Name', 'title'=> 'The account Holders first name.'))."\n";

	echo $form->input('sn', array('label'=>'Last Name', 'div'=> 'required', 'title'=> 'The account Holders last/family name.'))."\n";

	echo $form->input('uid', array('label'=>'User Name', 'div'=> 'required',  'title'=>'Account login name, ex: jdoe'))."\n";

	echo $form->input('mail', array('label'=>'Email Address', 'div'=> 'required',  'title'=>'Peoples contact email address.'))."\n";

	echo $form->input('password', array('label'=>'Password',  'type'=>'password', 'div'=> 'required',  'title'=>'Super Secret People Password'))."\n";

	echo $form->input('password_confirm', array('label'=>'Re-Type Password', 'type'=>'password', 'div'=> 'required',  'title'=>'Super Secret People Password'))."\n";
	echo $form->end('Create User')."\n";
?>
</div>
