<?php
App::import('Core', 'Controller');
//App::import('Controller', 'Invites');

class SendInvitesTask extends Shell{

	public $uses = array('Invite');

	function execute(){
		
		$invitesToSend = $this->Invite->find('all',
			array(
				'conditions'=> array('Invite.sent'=>'No', 'Invite.opted_out'=>'no'),
				'fields'=>array('id', 'uuid','email','event_id')
			)
		);
		foreach($invitesToSend as $invitee){
			$this->log("Sending invite to ".$invitee['Invite']['email'],'debug');
		}
	}

}
