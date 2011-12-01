<?php
class EventShell extends Shell{
	public $uses = array('Invite');

	public function startup(){
		Configure::write('debug', 0);// and forget debug messages
	}


	function main(){
		$this->log('Sending Emails','debug');
		$pendingInvites = $this->Invite->find('all',array('conditions'=>array('Invite.sent'=>'No','Invite.opted_out'=>'No')));

		foreach($pendingInvites as $invitee){
			if($error = $this->requestAction('/invites/sendInvite/'.$invitee['Invite']['id'])) $this->log("Success",'debug');
			else $this->log("Failed to send to:". $invitee['Invite']['email']. ":".print_r($error,1).":".print_r($invitee,1),'error');
		}
	}
}
