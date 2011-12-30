<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.view.templates.layouts.email.text
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>

<?php echo $content_for_layout;?>

<?php   
        if($invitee['Event']['has_reservations'] == 'Yes'){
		__('To R.S.V.P. for this event got to the following URL. ');
		echo $url.'/reservations/add/'.$id;
        }
?>
This email was sent using Event Notifier & Guest Tracker
If You no longer want to recieve emails from the Event Notifier & Guest Tracker
Use the following URL to opt out <?php echo $this->Html->Url(array('controller'=>'Invites', 'action'=>'optOut',$id));?>
