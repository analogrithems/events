<?php
App::import('Component', 'Email');

class EventShell extends Shell{
	public $uses = array('Invite');
	var $Email; 

	function __construct(){
		$this->emailFormat = 'html';
	}


	public function startup(){
		$this->Email = new EmailComponent();
		$this->Email->delivery = 'smtp';
		//$this->Email->smtpOptions = array(
		//	'host' => 'localhost'
		//);

	}


	function main(){
		$this->log('Sending Emails','debug');
		$pendingInvites = $this->Invite->find('all',array('conditions'=>array('Invite.sent'=>'No','Invite.opted_out'=>'No')));

		foreach($pendingInvites as $invitee){
			$this->Email->sendAs = $this->emailFormat;
			$this->Email->subject = $invitee['Event']['name'];
			$this->Email->from = $invitee['Event']['User']['email'];
			$this->Email->to = $invitee['Invite']['email'];

			//Lets send the email
			$sent = $this->Email->send($invitee['Event']['details']);
			if($sent){
				$this->log("Sent email to:".$invitee['Invite']['email'],'debug');
				$invitee['Invite']['sent'] = 'Yes';
				$this->Invite->save($invitee);
			}else{
				$error = !empty($this->Email->smtpError) ? $this->Email->smtpError : '';
				$this->log("Failed to send to:". $invitee['Invite']['email']. ":".print_r($error,1).":".print_r($invitee,1),'error');
			}
		}
	}
}
